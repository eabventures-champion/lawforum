<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post1992Article;
use App\RegulationArticle;
use App\ConstitutionalArticle;
use App\ExecutiveArticle;
use App\FooterNote;
use App\AmendedArticle;
use App\AmendRegulationArticle;
use App\AllConstitution;
use App\GhanaArticle;
use App\GhAmendedArticle;
use App\GhLawJudgment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\SearchHistory;
use App\Services\SearchSuggestionService;

class HomeSearchController extends Controller
{
    /**
     * Unified search controller: handles HTML views and instant AJAX requests
     */
    public function main_home_search(Request $request)
    {
        $rawSearchText = $request->get('search_text', '');
        $originalQuery = trim(urldecode($rawSearchText));
        $category = $request->get('category', 'All');
        $subcategory = $request->get('subcategory', 'All');
        $yearFilter = $request->get('year', 'All');
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 15);
        
        $footer_notes = FooterNote::all();

        // Log search history for non-empty queries
        if (!empty($originalQuery)) {
            $this->logSearchHistory($request, $originalQuery, $category);
        }

        // Execute unified search
        $searchData = $this->executeSearch($originalQuery, $category, $subcategory, $yearFilter, $page, $perPage);

        // If it's a standard non-AJAX browser navigation request, render HTML page with preloaded data
        if (!$request->ajax() && !$request->wantsJson()) {
            return view('extenders.home_search_page_index', [
                'query' => $originalQuery,
                'did_you_mean' => $searchData['did_you_mean'] ?? null,
                'footer_notes' => $footer_notes,
                'initialSearchData' => $searchData,
                'all_total_count' => $searchData['total'] ?? 0,
                'total_constitution_articles_count' => $searchData['facets']['categories']['Constitution_Ghana'] ?? 0,
                'total_constitution_countries' => $searchData['facets']['categories']['Constitution_Others'] ?? 0,
                'pre_total_count' => $searchData['facets']['categories']['Pre_4th_Republic'] ?? 0,
                'posts_total_count' => $searchData['facets']['categories']['4th_Republic'] ?? 0,
                'cases_total_count' => $searchData['facets']['categories']['Case_Laws'] ?? 0
            ]);
        }

        // AJAX search response
        return response()->json($searchData);
    }

    /**
     * Executes the high-performance search pipeline
     */
    public function executeSearch($originalQuery, $category = 'All', $subcategory = 'All', $yearFilter = 'All', $page = 1, $perPage = 15)
    {
        $startTime = microtime(true);
        $cleanOriginal = trim(urldecode($originalQuery));
        $query = preg_replace('/[\s\-+]+/', '_', $cleanOriginal);
        $fuzzyQuery = preg_replace('/[^\p{L}\p{N}]+/u', '%', $cleanOriginal);

        // Build boolean mode query for FULLTEXT: wrap each word with + for AND logic
        // Filter out words shorter than InnoDB ft_min_token_size (3) and default stopwords
        $ftStopwords = ['a','about','an','are','as','at','be','by','com','de','en','for','from','how','i','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','www'];
        $words = preg_split('/[^\p{L}\p{N}]+/u', $cleanOriginal, -1, PREG_SPLIT_NO_EMPTY);
        $ftWords = array_filter($words, function($w) use ($ftStopwords) {
            return mb_strlen($w) >= 3 && !in_array(mb_strtolower($w), $ftStopwords);
        });
        $booleanQuery = implode(' ', array_map(function($w) { return '+' . $w . '*'; }, $ftWords));
        // Use FULLTEXT when we have at least one indexable word
        $useFulltext = !empty($booleanQuery);

        if (empty($query)) {
            return [
                'query' => $originalQuery,
                'did_you_mean' => null,
                'category' => $category,
                'subcategory' => $subcategory,
                'total' => 0,
                'time_ms' => 0,
                'results' => [],
                'facets' => $this->emptyFacets(),
                'page' => 1,
                'per_page' => $perPage,
                'total_pages' => 1
            ];
        }

        // Full result caching: cache the entire search response for 5 minutes
        $resultCacheKey = 'search_results_v1_' . md5($originalQuery . '_' . $category . '_' . $subcategory . '_' . $yearFilter . '_' . $page . '_' . $perPage);
        $cachedResult = Cache::get($resultCacheKey);
        if ($cachedResult) {
            return $cachedResult;
        }

        $mergedCollection = collect();
        $counts = null;

        if ($category === 'All') {
            // --- SINGLE PASS SEARCH FOR 'ALL' CATEGORIES (FULLTEXT INDEXED) ---
            // 1. Ghana Constitution
            $ghana_articles = GhanaArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                    if ($useFulltext) {
                        $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                    } else {
                        $q->where('articles', 'LIKE', "%$originalQuery%")
                          ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                    }
                })
                ->select('id', 'chapter', 'section', 'articles as content', 'gh_title as parent_title', 'priority')
                ->get()
                ->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Ghana Constitution',
                        'category' => 'constitution_ghana',
                        'parent_title' => $row->parent_title,
                        'subtitle' => $row->chapter . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/constitution/Republic/constitution_content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => 1992
                    ];
                });

            $ghana_amended = GhAmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                    if ($useFulltext) {
                        $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                    } else {
                        $q->where('articles', 'LIKE', "%$originalQuery%")
                          ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                    }
                })
                ->select('id', 'chapter', 'section', 'articles as content', 'gh_title as parent_title', 'priority')
                ->get()
                ->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Ghana Constitution (Amended)',
                        'category' => 'constitution_ghana',
                        'parent_title' => $row->parent_title,
                        'subtitle' => $row->chapter . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/constitution_amended/Republic/constitution_content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => 1992
                    ];
                });

            $constitution_ghana_total = $ghana_articles->count() + $ghana_amended->count();
            $mergedCollection = $mergedCollection->concat($ghana_articles)->concat($ghana_amended);

            // 2. Others Constitution
            $others = AllConstitution::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                    if ($useFulltext) {
                        $q->whereRaw("MATCH(content, title, country, continent) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                    } else {
                        $q->where('content', 'LIKE', "%$originalQuery%")
                          ->orWhere('title', 'LIKE', "%$originalQuery%");
                    }
                })
                ->select('id', 'title', 'content', 'year', 'country', 'continent')
                ->get()
                ->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Constitution (' . $row->country . ')',
                        'category' => 'constitution_others',
                        'parent_title' => $row->title,
                        'subtitle' => $row->continent . ' | ' . $row->country,
                        'content' => $row->content,
                        'link' => "/constitution/1/{$row->continent}/{$row->country}/{$row->id}",
                        'priority' => 999,
                        'year' => $row->year
                    ];
                });
            $constitution_others_total = $others->count();
            $mergedCollection = $mergedCollection->concat($others);

            // 3. Pre 4th Republic
            $pre4thQuery = DB::table('pre1992_legislation_articles');
            if ($useFulltext) {
                $pre4thQuery->whereRaw("MATCH(pre1992_legislation_articles.content, pre1992_legislation_articles.section, pre1992_legislation_articles.pre_1992_act) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
            } else {
                $pre4thQuery->where(function($q) use ($originalQuery) {
                    $q->where('pre1992_legislation_articles.content', 'LIKE', "%$originalQuery%")
                      ->orWhere('pre1992_legislation_articles.pre_1992_act', 'LIKE', "%$originalQuery%");
                });
            }
            $pre4th = $pre4thQuery
                ->leftJoin('pre1992_legislation_acts', 'pre1992_legislation_acts.title', '=', 'pre1992_legislation_articles.pre_1992_act')
                ->select('pre1992_legislation_articles.id', 'pre1992_legislation_acts.title as parent_title', 'pre1992_legislation_articles.section', 'pre1992_legislation_articles.content', 'pre_1992_group', 'year', 'priority')
                ->get()
                ->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Existing Laws (' . $row->pre_1992_group . ')',
                        'category' => 'pre_4th_republic',
                        'parent_title' => $row->parent_title,
                        'subtitle' => $row->section,
                        'content' => $row->content,
                        'link' => "/existing-laws/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => $row->year
                    ];
                });
            $pre_4th_total = $pre4th->count();
            $mergedCollection = $mergedCollection->concat($pre4th);

            // 4. 4th Republic
            $posts = Post1992Article::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, post_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('post_act', 'LIKE', "%$originalQuery%");
                }
            })->get()->map(function($row) {
                return [
                    'id' => $row->id,
                    'type' => 'Acts of Parliament',
                    'category' => '4th_republic',
                    'parent_title' => $row->post_act,
                    'subtitle' => $row->part . ' | ' . $row->section,
                    'content' => $row->content,
                    'link' => "/new-laws/content/{$row->id}",
                    'priority' => $row->priority ?? 999,
                    'year' => null
                ];
            });

            $regs = RegulationArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, regulation_title, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('regulation_title', 'LIKE', "%$originalQuery%");
                }
            })->get()->map(function($row) {
                return [
                    'id' => $row->id,
                    'type' => 'Legislative Instruments',
                    'category' => '4th_republic',
                    'parent_title' => $row->regulation_title,
                    'subtitle' => $row->part . ' | ' . $row->section,
                    'content' => $row->content,
                    'link' => "/new-laws/content/{$row->id}",
                    'priority' => $row->priority ?? 999,
                    'year' => null
                ];
            });

            $consts = ConstitutionalArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, constitutional_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('constitutional_act', 'LIKE', "%$originalQuery%");
                }
            })->get()->map(function($row) {
                return [
                    'id' => $row->id,
                    'type' => 'Constitutional Instruments',
                    'category' => '4th_republic',
                    'parent_title' => $row->constitutional_act,
                    'subtitle' => $row->part . ' | ' . $row->section,
                    'content' => $row->content,
                    'link' => "/new-laws/content/{$row->id}",
                    'priority' => $row->priority ?? 999,
                    'year' => null
                ];
            });

            $exes = ExecutiveArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, executive_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('executive_act', 'LIKE', "%$originalQuery%");
                }
            })->get()->map(function($row) {
                return [
                    'id' => $row->id,
                    'type' => 'Executive Instruments',
                    'category' => '4th_republic',
                    'parent_title' => $row->executive_act,
                    'subtitle' => $row->part . ' | ' . $row->section,
                    'content' => $row->content,
                    'link' => "/new-laws/content/{$row->id}",
                    'priority' => $row->priority ?? 999,
                    'year' => null
                ];
            });

            $amends = AmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, act_title, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('act_title', 'LIKE', "%$originalQuery%");
                }
            })->get()->map(function($row) {
                return [
                    'id' => $row->id,
                    'type' => 'Amended Acts',
                    'category' => '4th_republic',
                    'parent_title' => $row->act_title,
                    'subtitle' => $row->section,
                    'content' => $row->content,
                    'link' => "/new-laws/amended_acts/content/{$row->id}",
                    'priority' => $row->priority ?? 999,
                    'year' => null
                ];
            });

            $amends_regs = AmendRegulationArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, title, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('title', 'LIKE', "%$originalQuery%");
                }
            })->get()->map(function($row) {
                return [
                    'id' => $row->id,
                    'type' => 'Amended Regulations',
                    'category' => '4th_republic',
                    'parent_title' => $row->title,
                    'subtitle' => $row->part . ' | ' . $row->section,
                    'content' => $row->content,
                    'link' => "/new-laws/amended_regulation_acts/content/{$row->id}",
                    'priority' => $row->priority ?? 999,
                    'year' => null
                ];
            });

            $post1992_count = $posts->count();
            $regulation_count = $regs->count();
            $constitutional_count = $consts->count();
            $executive_count = $exes->count();
            $amends_count = $amends->count();
            $amends_regs_count = $amends_regs->count();
            $post_4th_total = $post1992_count + $regulation_count + $constitutional_count + $executive_count + $amends_count + $amends_regs_count;
            $mergedCollection = $mergedCollection->concat($posts)->concat($regs)->concat($consts)->concat($exes)->concat($amends)->concat($amends_regs);

            // 5. Case Laws
            $cases = GhLawJudgment::where(function($q) use ($booleanQuery, $originalQuery, $fuzzyQuery, $useFulltext) {
                    if ($useFulltext) {
                        $q->whereRaw("MATCH(case_title, content, case_title_1, case_title_2, reference_number, court_name, coram, counsellors) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                    } else {
                        $q->where('case_title', 'LIKE', "%$originalQuery%")
                          ->orWhere('case_title', 'LIKE', "%$fuzzyQuery%")
                          ->orWhere('content', 'LIKE', "%$originalQuery%");
                    }
                })
                ->select('id', 'case_title', 'content', 'year', 'gh_law_judgment_group_name', 'reference_number', 'court_name')
                ->get()
                ->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Case Laws (' . $row->gh_law_judgment_group_name . ')',
                        'category' => 'case_laws',
                        'parent_title' => $row->case_title,
                        'subtitle' => $row->gh_law_judgment_group_name . ' | ' . $row->reference_number . ($row->court_name ? ' | ' . $row->court_name : ''),
                        'content' => $row->content,
                        'link' => "/judgement/Ghana/{$row->gh_law_judgment_group_name}/{$row->id}",
                        'priority' => 999,
                        'year' => $row->year
                    ];
                });
            $cases_total = $cases->count();
            $mergedCollection = $mergedCollection->concat($cases);

            $all_total_count = $constitution_ghana_total + $constitution_others_total + $pre_4th_total + $post_4th_total + $cases_total;

            $counts = [
                'constitution_ghana_total' => $constitution_ghana_total,
                'constitution_others_total' => $constitution_others_total,
                'pre_4th_total' => $pre_4th_total,
                'post1992_count' => $post1992_count,
                'regulation_count' => $regulation_count,
                'constitutional_count' => $constitutional_count,
                'executive_count' => $executive_count,
                'amends_count' => $amends_count,
                'amends_regs_count' => $amends_regs_count,
                'post_4th_total' => $post_4th_total,
                'cases_total' => $cases_total,
                'all_total_count' => $all_total_count
            ];

            // Cache counts for fast sub-facet requests
            Cache::put('search_counts_v2_' . md5($query), $counts, 300);

        } else {
            // --- FILTERED CATEGORY SEARCH ---
            $counts = $this->calculateCounts($query, $originalQuery, $fuzzyQuery);

            if ($category === 'Constitution_Ghana') {
                if ($subcategory === 'All' || $subcategory === 'Ghana Constitution') {
                    $ghana_articles = GhanaArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                            if ($useFulltext) {
                                $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                            } else {
                                $q->where('articles', 'LIKE', "%$originalQuery%")
                                  ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                            }
                        })
                        ->select('id', 'chapter', 'section', 'articles as content', 'gh_title as parent_title', 'priority')
                        ->get()->map(function($row) {
                            return [
                                'id' => $row->id,
                                'type' => 'Ghana Constitution',
                                'category' => 'constitution_ghana',
                                'parent_title' => $row->parent_title,
                                'subtitle' => $row->chapter . ' | ' . $row->section,
                                'content' => $row->content,
                                'link' => "/constitution/Republic/constitution_content/{$row->id}",
                                'priority' => $row->priority ?? 999,
                                'year' => 1992
                            ];
                        });
                    $mergedCollection = $mergedCollection->concat($ghana_articles);
                }

                if ($subcategory === 'All' || $subcategory === 'Ghana Constitution (Amended)') {
                    $ghana_amended = GhAmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                            if ($useFulltext) {
                                $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                            } else {
                                $q->where('articles', 'LIKE', "%$originalQuery%")
                                  ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                            }
                        })
                        ->select('id', 'chapter', 'section', 'articles as content', 'gh_title as parent_title', 'priority')
                        ->get()->map(function($row) {
                            return [
                                'id' => $row->id,
                                'type' => 'Ghana Constitution (Amended)',
                                'category' => 'constitution_ghana',
                                'parent_title' => $row->parent_title,
                                'subtitle' => $row->chapter . ' | ' . $row->section,
                                'content' => $row->content,
                                'link' => "/constitution_amended/Republic/constitution_content/{$row->id}",
                                'priority' => $row->priority ?? 999,
                                'year' => 1992
                            ];
                        });
                    $mergedCollection = $mergedCollection->concat($ghana_amended);
                }
            } elseif ($category === 'Constitution_Others') {
                $othersQuery = AllConstitution::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                    if ($useFulltext) {
                        $q->whereRaw("MATCH(content, title, country, continent) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                    } else {
                        $q->where('content', 'LIKE', "%$originalQuery%")
                          ->orWhere('title', 'LIKE', "%$originalQuery%");
                    }
                });
                if ($subcategory !== 'All') {
                    $othersQuery->where('continent', $subcategory);
                }
                $others = $othersQuery->select('id', 'title', 'content', 'year', 'country', 'continent')->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Constitution (' . $row->country . ')',
                        'category' => 'constitution_others',
                        'parent_title' => $row->title,
                        'subtitle' => $row->continent . ' | ' . $row->country,
                        'content' => $row->content,
                        'link' => "/constitution/1/{$row->continent}/{$row->country}/{$row->id}",
                        'priority' => 999,
                        'year' => $row->year
                    ];
                });
                $mergedCollection = $mergedCollection->concat($others);
            } elseif ($category === 'Pre_4th_Republic') {
                $preQuery = DB::table('pre1992_legislation_articles');
                if ($useFulltext) {
                    $preQuery->whereRaw("MATCH(pre1992_legislation_articles.content, pre1992_legislation_articles.section, pre1992_legislation_articles.pre_1992_act) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $preQuery->where(function($q) use ($originalQuery) {
                        $q->where('pre1992_legislation_articles.content', 'LIKE', "%$originalQuery%")
                          ->orWhere('pre1992_legislation_articles.pre_1992_act', 'LIKE', "%$originalQuery%");
                    });
                }
                $preQuery->leftJoin('pre1992_legislation_acts', 'pre1992_legislation_acts.title', '=', 'pre1992_legislation_articles.pre_1992_act');
                if ($subcategory !== 'All') {
                    $preQuery->where('pre_1992_group', $subcategory);
                }
                $pre4th = $preQuery->select('pre1992_legislation_articles.id', 'pre1992_legislation_acts.title as parent_title', 'pre1992_legislation_articles.section', 'pre1992_legislation_articles.content', 'pre_1992_group', 'year', 'priority')
                    ->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Existing Laws (' . $row->pre_1992_group . ')',
                            'category' => 'pre_4th_republic',
                            'parent_title' => $row->parent_title,
                            'subtitle' => $row->section,
                            'content' => $row->content,
                            'link' => "/existing-laws/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => $row->year
                        ];
                    });
                $mergedCollection = $mergedCollection->concat($pre4th);
            } elseif ($category === '4th_Republic') {
                if ($subcategory === 'All' || $subcategory === 'Acts of Parliament') {
                    $posts = Post1992Article::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, post_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('post_act', 'LIKE', "%$originalQuery%");
                        }
                    })->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Acts of Parliament',
                            'category' => '4th_republic',
                            'parent_title' => $row->post_act,
                            'subtitle' => $row->part . ' | ' . $row->section,
                            'content' => $row->content,
                            'link' => "/new-laws/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => null
                        ];
                    });
                    $mergedCollection = $mergedCollection->concat($posts);
                }

                if ($subcategory === 'All' || $subcategory === 'Legislative Instruments') {
                    $regs = RegulationArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, regulation_title, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('regulation_title', 'LIKE', "%$originalQuery%");
                        }
                    })->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Legislative Instruments',
                            'category' => '4th_republic',
                            'parent_title' => $row->regulation_title,
                            'subtitle' => $row->part . ' | ' . $row->section,
                            'content' => $row->content,
                            'link' => "/new-laws/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => null
                        ];
                    });
                    $mergedCollection = $mergedCollection->concat($regs);
                }

                if ($subcategory === 'All' || $subcategory === 'Constitutional Instruments') {
                    $consts = ConstitutionalArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, constitutional_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('constitutional_act', 'LIKE', "%$originalQuery%");
                        }
                    })->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Constitutional Instruments',
                            'category' => '4th_republic',
                            'parent_title' => $row->constitutional_act,
                            'subtitle' => $row->part . ' | ' . $row->section,
                            'content' => $row->content,
                            'link' => "/new-laws/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => null
                        ];
                    });
                    $mergedCollection = $mergedCollection->concat($consts);
                }

                if ($subcategory === 'All' || $subcategory === 'Executive Instruments') {
                    $exes = ExecutiveArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, executive_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('executive_act', 'LIKE', "%$originalQuery%");
                        }
                    })->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Executive Instruments',
                            'category' => '4th_republic',
                            'parent_title' => $row->executive_act,
                            'subtitle' => $row->part . ' | ' . $row->section,
                            'content' => $row->content,
                            'link' => "/new-laws/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => null
                        ];
                    });
                    $mergedCollection = $mergedCollection->concat($exes);
                }

                if ($subcategory === 'All' || $subcategory === 'Amended Acts') {
                    $amends = AmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, act_title, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('act_title', 'LIKE', "%$originalQuery%");
                        }
                    })->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Amended Acts',
                            'category' => '4th_republic',
                            'parent_title' => $row->act_title,
                            'subtitle' => $row->section,
                            'content' => $row->content,
                            'link' => "/new-laws/amended_acts/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => null
                        ];
                    });
                    $mergedCollection = $mergedCollection->concat($amends);
                }

                if ($subcategory === 'All' || $subcategory === 'Amended Regulations') {
                    $amends_regs = AmendRegulationArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, title, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('title', 'LIKE', "%$originalQuery%");
                        }
                    })->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Amended Regulations',
                            'category' => '4th_republic',
                            'parent_title' => $row->title,
                            'subtitle' => $row->part . ' | ' . $row->section,
                            'content' => $row->content,
                            'link' => "/new-laws/amended_regulation_acts/content/{$row->id}",
                            'priority' => $row->priority ?? 999,
                            'year' => null
                        ];
                    });
                    $mergedCollection = $mergedCollection->concat($amends_regs);
                }
            } elseif ($category === 'Case_Laws') {
                $casesQuery = GhLawJudgment::where(function($q) use ($booleanQuery, $originalQuery, $fuzzyQuery, $useFulltext) {
                    if ($useFulltext) {
                        $q->whereRaw("MATCH(case_title, content, case_title_1, case_title_2, reference_number, court_name, coram, counsellors) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                    } else {
                        $q->where('case_title', 'LIKE', "%$originalQuery%")
                          ->orWhere('case_title', 'LIKE', "%$fuzzyQuery%")
                          ->orWhere('content', 'LIKE', "%$originalQuery%");
                    }
                });
                if ($subcategory !== 'All') {
                    $casesQuery->where('gh_law_judgment_group_name', $subcategory);
                }
                $cases = $casesQuery->select('id', 'case_title', 'content', 'year', 'gh_law_judgment_group_name', 'reference_number', 'court_name')
                    ->get()->map(function($row) {
                        return [
                            'id' => $row->id,
                            'type' => 'Case Laws (' . $row->gh_law_judgment_group_name . ')',
                            'category' => 'case_laws',
                            'parent_title' => $row->case_title,
                            'subtitle' => $row->gh_law_judgment_group_name . ' | ' . $row->reference_number . ($row->court_name ? ' | ' . $row->court_name : ''),
                            'content' => $row->content,
                            'link' => "/judgement/Ghana/{$row->gh_law_judgment_group_name}/{$row->id}",
                            'priority' => 999,
                            'year' => $row->year
                        ];
                    });
                $mergedCollection = $mergedCollection->concat($cases);
            }
        }

        // Apply Year Filter if specified and not 'All'
        if ($yearFilter !== 'All') {
            $mergedCollection = $mergedCollection->filter(function ($item) use ($yearFilter) {
                return (string) $item['year'] === (string) $yearFilter;
            });
        }

        // Calculate Year Facets for the active set
        $yearFacets = $mergedCollection->whereNotNull('year')
            ->groupBy('year')
            ->map(function ($items) {
                return $items->count();
            })
            ->toArray();
        arsort($yearFacets);

        // Dynamic Subcategory Facet calculations based on current Category
        $subFacets = [];
        $lastSubQuery = session()->get('last_sub_query');
        $lastSubCategory = session()->get('last_sub_category');
        if ($lastSubQuery === $query && $lastSubCategory === $category && session()->has('last_sub_facets')) {
            $subFacets = session()->get('last_sub_facets');
        } else {
            if ($category === 'Constitution_Ghana') {
                $subFacets = [
                    'Ghana Constitution' => GhanaArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('articles', 'LIKE', "%$originalQuery%")
                              ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                        }
                    })->count(),
                    'Ghana Constitution (Amended)' => GhAmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('articles', 'LIKE', "%$originalQuery%")
                              ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                        }
                    })->count()
                ];
            } elseif ($category === 'Constitution_Others') {
                $subFacetsQuery = AllConstitution::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(content, title, country, continent) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('content', 'LIKE', "%$originalQuery%")
                              ->orWhere('title', 'LIKE', "%$originalQuery%");
                        }
                    });
                $subFacets = $subFacetsQuery
                    ->groupBy('continent')
                    ->selectRaw('continent, count(*) as count')
                    ->pluck('count', 'continent')
                    ->toArray();
            } elseif ($category === 'Pre_4th_Republic') {
                $preSubQuery = DB::table('pre1992_legislation_articles');
                if ($useFulltext) {
                    $preSubQuery->whereRaw("MATCH(pre1992_legislation_articles.content, pre1992_legislation_articles.section, pre1992_legislation_articles.pre_1992_act) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $preSubQuery->where(function($q) use ($originalQuery) {
                        $q->where('pre1992_legislation_articles.content', 'LIKE', "%$originalQuery%")
                          ->orWhere('pre1992_legislation_articles.pre_1992_act', 'LIKE', "%$originalQuery%");
                    });
                }
                $subFacets = $preSubQuery
                    ->leftJoin('pre1992_legislation_acts', 'pre1992_legislation_acts.title', '=', 'pre1992_legislation_articles.pre_1992_act')
                    ->groupBy('pre_1992_group')
                    ->selectRaw('pre_1992_group, count(*) as count')
                    ->pluck('count', 'pre_1992_group')
                    ->toArray();
            } elseif ($category === '4th_Republic') {
                $subFacets = [
                    'Acts of Parliament' => $counts['post1992_count'] ?? 0,
                    'Legislative Instruments' => $counts['regulation_count'] ?? 0,
                    'Constitutional Instruments' => $counts['constitutional_count'] ?? 0,
                    'Executive Instruments' => $counts['executive_count'] ?? 0,
                    'Amended Acts' => $counts['amends_count'] ?? 0,
                    'Amended Regulations' => $counts['amends_regs_count'] ?? 0
                ];
            } elseif ($category === 'Case_Laws') {
                $caseSubQuery = GhLawJudgment::where(function($q) use ($booleanQuery, $originalQuery, $fuzzyQuery, $useFulltext) {
                        if ($useFulltext) {
                            $q->whereRaw("MATCH(case_title, content, case_title_1, case_title_2, reference_number, court_name, coram, counsellors) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                        } else {
                            $q->where('case_title', 'LIKE', "%$originalQuery%")
                              ->orWhere('case_title', 'LIKE', "%$fuzzyQuery%")
                              ->orWhere('content', 'LIKE', "%$originalQuery%");
                        }
                    });
                $subFacets = $caseSubQuery
                    ->groupBy('gh_law_judgment_group_name')
                    ->selectRaw('gh_law_judgment_group_name, count(*) as count')
                    ->pluck('count', 'gh_law_judgment_group_name')
                    ->toArray();
            }
            session()->put('last_sub_query', $query);
            session()->put('last_sub_category', $category);
            session()->put('last_sub_facets', $subFacets);
        }

        // Paginate the merged collection
        $offset = ($page - 1) * $perPage;
        $totalItems = $mergedCollection->count();
        $sortedCollection = $mergedCollection->sortBy('priority');
        $paginatedItems = $sortedCollection->slice($offset, $perPage)->values();

        // Generate snippets only for the 15 paginated items
        $formattedItems = $paginatedItems->map(function ($item) use ($originalQuery) {
            $item['snippet'] = $this->getSnippet($item['content'], $originalQuery);
            unset($item['content']); // Keep payload small and lightning fast
            return $item;
        });

        $endTime = microtime(true);
        $executionTimeMs = round(($endTime - $startTime) * 1000, 1);

        // Spell check: Suggest closest correction if 0 results or query is at least 3 chars
        $didYouMean = null;
        if ($totalItems === 0 || mb_strlen($originalQuery) >= 3) {
            $didYouMean = SearchSuggestionService::suggestCorrection($originalQuery);
        }

        $searchResult = [
            'query' => $originalQuery,
            'did_you_mean' => $didYouMean,
            'category' => $category,
            'subcategory' => $subcategory,
            'total' => $totalItems,
            'time_ms' => $executionTimeMs,
            'results' => $formattedItems->toArray(),
            'facets' => [
                'categories' => [
                    'All' => $counts['all_total_count'] ?? $totalItems,
                    'Constitution_Ghana' => $counts['constitution_ghana_total'] ?? 0,
                    'Constitution_Others' => $counts['constitution_others_total'] ?? 0,
                    'Pre_4th_Republic' => $counts['pre_4th_total'] ?? 0,
                    '4th_Republic' => $counts['post_4th_total'] ?? 0,
                    'Case_Laws' => $counts['cases_total'] ?? 0
                ],
                'subcategories' => $subFacets,
                'years' => $yearFacets
            ],
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($totalItems / $perPage) ?: 1
        ];

        // Cache the full result for 5 minutes
        Cache::put($resultCacheKey, $searchResult, 300);

        return $searchResult;
    }

    /**
     * Helper to compute table counts efficiently (Cached for 5 minutes)
     */
    private function calculateCounts($query, $originalQuery = '', $fuzzyQuery = '')
    {
        $cacheKey = 'search_counts_v6_' . md5($query . '_' . $originalQuery . '_' . $fuzzyQuery);

        return Cache::remember($cacheKey, 300, function() use ($query, $originalQuery, $fuzzyQuery) {
            // Build boolean query for FULLTEXT (filter stopwords and short words)
            $cleanOriginal = trim(urldecode($originalQuery));
            $ftStopwords = ['a','about','an','are','as','at','be','by','com','de','en','for','from','how','i','in','is','it','la','of','on','or','that','the','this','to','was','what','when','where','who','will','with','und','www'];
            $words = preg_split('/[^\p{L}\p{N}]+/u', $cleanOriginal, -1, PREG_SPLIT_NO_EMPTY);
            $ftWords = array_filter($words, function($w) use ($ftStopwords) {
                return mb_strlen($w) >= 3 && !in_array(mb_strtolower($w), $ftStopwords);
            });
            $booleanQuery = implode(' ', array_map(function($w) { return '+' . $w . '*'; }, $ftWords));
            $useFulltext = !empty($booleanQuery);

            $ghana_const_count = GhanaArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('articles', 'LIKE', "%$originalQuery%")
                      ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $ghana_const_amended_count = GhAmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(articles, gh_title, chapter, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('articles', 'LIKE', "%$originalQuery%")
                      ->orWhere('gh_title', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $constitution_ghana_total = $ghana_const_count + $ghana_const_amended_count;

            $constitution_others_total = AllConstitution::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, title, country, continent) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('title', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $pre4thCountQuery = DB::table('pre1992_legislation_articles');
            if ($useFulltext) {
                $pre4thCountQuery->whereRaw("MATCH(pre1992_legislation_articles.content, pre1992_legislation_articles.section, pre1992_legislation_articles.pre_1992_act) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
            } else {
                $pre4thCountQuery->where(function($q) use ($originalQuery) {
                    $q->where('pre1992_legislation_articles.content', 'LIKE', "%$originalQuery%")
                      ->orWhere('pre1992_legislation_articles.pre_1992_act', 'LIKE', "%$originalQuery%");
                });
            }
            $pre_4th_total = $pre4thCountQuery
                ->leftJoin('pre1992_legislation_acts', 'pre1992_legislation_acts.title', '=', 'pre1992_legislation_articles.pre_1992_act')
                ->count();

            $post1992_count = Post1992Article::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, post_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('post_act', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $regulation_count = RegulationArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, regulation_title, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('regulation_title', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $constitutional_count = ConstitutionalArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, constitutional_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('constitutional_act', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $executive_count = ExecutiveArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, executive_act, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('executive_act', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $amends_count = AmendedArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, act_title, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('act_title', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $amends_regs_count = AmendRegulationArticle::where(function($q) use ($booleanQuery, $originalQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(content, title, part, section) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('content', 'LIKE', "%$originalQuery%")
                      ->orWhere('title', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $post_4th_total = $post1992_count + $regulation_count + $constitutional_count + $executive_count + $amends_count + $amends_regs_count;

            $cases_total = GhLawJudgment::where(function($q) use ($booleanQuery, $originalQuery, $fuzzyQuery, $useFulltext) {
                if ($useFulltext) {
                    $q->whereRaw("MATCH(case_title, content, case_title_1, case_title_2, reference_number, court_name, coram, counsellors) AGAINST(? IN BOOLEAN MODE)", [$booleanQuery]);
                } else {
                    $q->where('case_title', 'LIKE', "%$originalQuery%")
                      ->orWhere('case_title', 'LIKE', "%$fuzzyQuery%")
                      ->orWhere('content', 'LIKE', "%$originalQuery%");
                }
            })->count();

            $all_total_count = $constitution_ghana_total + $constitution_others_total + $pre_4th_total + $post_4th_total + $cases_total;

            return [
                'constitution_ghana_total' => $constitution_ghana_total,
                'constitution_others_total' => $constitution_others_total,
                'pre_4th_total' => $pre_4th_total,
                'post1992_count' => $post1992_count,
                'regulation_count' => $regulation_count,
                'constitutional_count' => $constitutional_count,
                'executive_count' => $executive_count,
                'amends_count' => $amends_count,
                'amends_regs_count' => $amends_regs_count,
                'post_4th_total' => $post_4th_total,
                'cases_total' => $cases_total,
                'all_total_count' => $all_total_count
            ];
        });
    }

    /**
     * Default empty facets JSON
     */
    private function emptyFacets()
    {
        return [
            'categories' => [
                'All' => 0,
                'Constitution_Ghana' => 0,
                'Constitution_Others' => 0,
                'Pre_4th_Republic' => 0,
                '4th_Republic' => 0,
                'Case_Laws' => 0
            ],
            'subcategories' => [],
            'years' => []
        ];
    }

    /**
     * Extracts a search snippet around the query and highlights it
     */
    private function getSnippet($content, $query)
    {
        if (empty($content)) {
            return '';
        }
        
        // Clean and decode query
        $cleanQuery = trim(urldecode($query));
        $cleanQuery = str_replace(['+', '_'], ' ', $cleanQuery);
        
        // Strip HTML tags for clean text extraction
        $cleanText = html_entity_decode(strip_tags($content), ENT_QUOTES, 'UTF-8');
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);
        
        // Find position of match
        $normalizedText = preg_replace('/[\s\-+]+/', ' ', $cleanText);
        $normalizedQuery = preg_replace('/[\s\-+]+/', ' ', $cleanQuery);
        $pos = mb_stripos($normalizedText, $normalizedQuery);
        
        $length = 260; // snippet size
        
        if ($pos === false) {
            $snippet = mb_substr($cleanText, 0, $length);
            if (mb_strlen($cleanText) > $length) {
                $snippet .= '...';
            }
        } else {
            $start = max(0, $pos - 80);
            
            if ($start > 0) {
                $spacePos = mb_strpos($cleanText, ' ', $start);
                if ($spacePos !== false && $spacePos < $start + 20) {
                    $start = $spacePos + 1;
                }
            }
            
            $snippet = mb_substr($cleanText, $start, $length);
            
            if ($start > 0) {
                $snippet = '...' . $snippet;
            }
            if ($start + $length < mb_strlen($cleanText)) {
                $snippet .= '...';
            }
        }
        
        // Escape for safe HTML
        $snippet = htmlspecialchars($snippet, ENT_QUOTES, 'UTF-8');
        
        // Highlight matched phrase / words (allowing variable whitespace and hyphens)
        if (!empty($cleanQuery)) {
            $words = preg_split('/[\s\-+]+/', $cleanQuery, -1, PREG_SPLIT_NO_EMPTY);
            if (!empty($words)) {
                $escapedWords = array_map(function($w) {
                    return preg_quote(htmlspecialchars($w, ENT_QUOTES, 'UTF-8'), '#');
                }, $words);
                $pattern = implode('[ \-]+', $escapedWords);
                $snippet = preg_replace('#(' . $pattern . ')#iu', '<mark class="search-highlight">$1</mark>', $snippet);
            }
        }
        
        return $snippet;
    }

    /**
     * Get recent search history for the current user/session
     */
    public function searchHistory(Request $request)
    {
        $limit = (int) $request->get('limit', 20);
        $limit = min($limit, 50);

        $searches = SearchHistory::forCurrentUser()
            ->orderBy('searched_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'search_text' => $item->search_text,
                    'category'    => $item->category,
                    'searched_at' => $item->searched_at->diffForHumans(),
                    'timestamp'   => $item->searched_at->toISOString(),
                ];
            });

        return response()->json([
            'success' => true,
            'data'    => $searches,
        ]);
    }

    /**
     * Autocomplete endpoint for live suggestions & spelling correction
     */
    public function autocomplete(Request $request)
    {
        $query = $request->get('q', $request->get('query', ''));
        $limit = min(12, max(1, (int) $request->get('limit', 8)));

        $results = SearchSuggestionService::autocomplete($query, $limit);
        $didYouMean = SearchSuggestionService::suggestCorrection($query);

        return response()->json([
            'success' => true,
            'query' => $query,
            'did_you_mean' => $didYouMean,
            'suggestions' => $results
        ]);
    }

    /**
     * Delete a single search history entry
     */
    public function deleteSearchHistory($id)
    {
        $entry = SearchHistory::forCurrentUser()->where('id', $id)->first();

        if ($entry) {
            $entry->delete();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'message' => 'Not found'], 404);
    }

    /**
     * Clear all search history for the current user/session
     */
    public function clearSearchHistory()
    {
        SearchHistory::forCurrentUser()->delete();

        return response()->json(['success' => true]);
    }

    /**
     * Helper to log search queries cleanly
     */
    private function logSearchHistory(Request $request, $query, $category = 'All', $resultsCount = null)
    {
        $clean = trim($query);
        if (empty($clean) || mb_strlen($clean) < 2) return;

        try {
            $userId = auth()->check() ? auth()->id() : null;
            $sessionId = session()->getId();
            $ip = $request->ip();

            // Find any very recent query by the same user/guest within 15 seconds
            $recentEntry = SearchHistory::where(function ($q) use ($userId, $sessionId, $ip) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        if (!empty($sessionId)) {
                            $q->where('session_id', $sessionId);
                        }
                        if (!empty($ip)) {
                            $q->orWhere(function($sub) use ($ip) {
                                $sub->whereNull('user_id')->where('ip_address', $ip);
                            });
                        }
                    }
                })
                ->where('searched_at', '>=', now()->subSeconds(15))
                ->latest('searched_at')
                ->first();

            if ($recentEntry) {
                // If the new query is an extension or replacement of the keystroke within 15 seconds, update it
                $recentEntry->update([
                    'search_text'   => $clean,
                    'category'      => $category,
                    'results_count' => $resultsCount,
                    'searched_at'   => now(),
                ]);
                return;
            }

            // Check for identical duplicate within last 60 seconds
            $duplicate = SearchHistory::where(function ($q) use ($userId, $sessionId, $ip) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        if (!empty($sessionId)) {
                            $q->where('session_id', $sessionId);
                        }
                        if (!empty($ip)) {
                            $q->orWhere(function($sub) use ($ip) {
                                $sub->whereNull('user_id')->where('ip_address', $ip);
                            });
                        }
                    }
                })
                ->where('search_text', $clean)
                ->where('searched_at', '>=', now()->subSeconds(60))
                ->first();

            if ($duplicate) {
                $duplicate->update(['searched_at' => now()]);
                return;
            }

            SearchHistory::create([
                'user_id'       => $userId,
                'session_id'    => $sessionId,
                'search_text'   => $clean,
                'results_count' => $resultsCount,
                'category'      => $category,
                'ip_address'    => $ip,
                'searched_at'   => now(),
            ]);
        } catch (\Exception $e) {}
    }
}
