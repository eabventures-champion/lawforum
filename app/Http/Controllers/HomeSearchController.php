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

class HomeSearchController extends Controller
{
    /**
     * Main Search Endpoint for Legals Forum
     */
    public function main_home_search(Request $request)
    {
        $startTime = microtime(true);
        $originalQuery = trim($request->get('search_text', ''));
        // Normalize space/hyphen to SQL single character wildcard '_' for inclusive search
        $query = str_replace([' ', '-'], '_', $originalQuery);
        
        $category = $request->get('category', 'All');
        $subcategory = $request->get('subcategory', 'All');
        $yearFilter = $request->get('year', 'All');
        
        $footer_notes = FooterNote::all();

        // If it's a standard non-AJAX request, just render the SPA shell view.
        if (!$request->ajax() && !$request->wantsJson()) {
            $all_total_count = 0;
            $total_constitution_articles_count = 0;
            $total_constitution_countries = 0;
            $pre_total_count = 0;
            $posts_total_count = 0;
            $cases_total = 0;
            $cases_total_count = 0;
            
            // If query is present, we bootstrap counts so sidebar is populated on initial page load
            if (!empty($originalQuery)) {
                $counts = $this->calculateCounts($query);
                $all_total_count = $counts['all_total_count'];
                $total_constitution_articles_count = $counts['constitution_ghana_total'];
                $total_constitution_countries = $counts['constitution_others_total'];
                $pre_total_count = $counts['pre_4th_total'];
                $posts_total_count = $counts['post_4th_total'];
                $cases_total_count = $counts['cases_total'];
            }

            return view('extenders.home_search_page_index', [
                'query' => $originalQuery,
                'footer_notes' => $footer_notes,
                'all_total_count' => $all_total_count,
                'total_constitution_articles_count' => $total_constitution_articles_count,
                'total_constitution_countries' => $total_constitution_countries,
                'pre_total_count' => $pre_total_count,
                'posts_total_count' => $posts_total_count,
                'cases_total_count' => $cases_total_count
            ]);
        }

        // --- AJAX SEARCH LOGIC ---
        if (empty($query)) {
            return response()->json([
                'query' => $query,
                'total' => 0,
                'time_ms' => 0,
                'results' => [],
                'facets' => $this->emptyFacets(),
                'page' => 1,
                'total_pages' => 1
            ]);
        }

        // 1. Calculate facet counts for the sidebar
        $counts = $this->calculateCounts($query);

        // 2. Fetch matched rows for the active category
        $mergedCollection = collect();

        if ($category === 'All' || $category === 'Constitution_Ghana') {
            if ($subcategory === 'All' || $subcategory === 'Ghana Constitution') {
                $ghana_articles = GhanaArticle::where('articles', 'LIKE', "%$query%")
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
                $mergedCollection = $mergedCollection->concat($ghana_articles);
            }

            if ($subcategory === 'All' || $subcategory === 'Ghana Constitution (Amended)') {
                $ghana_amended = GhAmendedArticle::where('articles', 'LIKE', "%$query%")
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
                $mergedCollection = $mergedCollection->concat($ghana_amended);
            }
        }

        if ($category === 'All' || $category === 'Constitution_Others') {
            $othersQuery = AllConstitution::where('content', 'LIKE', "%$query%");
            
            if ($subcategory !== 'All') {
                $othersQuery->where('continent', $subcategory);
            }
            
            $others = $othersQuery->select('id', 'title', 'content', 'year', 'country', 'continent')
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
            $mergedCollection = $mergedCollection->concat($others);
        }

        if ($category === 'All' || $category === 'Pre_4th_Republic') {
            $preQuery = DB::table('pre1992_legislation_acts')
                ->leftJoin('pre1992_legislation_articles', 'pre1992_legislation_acts.title', '=', 'pre1992_legislation_articles.pre_1992_act')
                ->where('content', 'LIKE', "%$query%");
                
            if ($subcategory !== 'All') {
                $preQuery->where('pre_1992_group', $subcategory);
            }
            
            $pre4th = $preQuery->select('pre1992_legislation_articles.id', 'pre1992_legislation_acts.title as parent_title', 'pre1992_legislation_articles.section', 'pre1992_legislation_articles.content', 'pre_1992_group', 'year', 'priority')
                ->get()
                ->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Pre 4th Republic (' . $row->pre_1992_group . ')',
                        'category' => 'pre_4th_republic',
                        'parent_title' => $row->parent_title,
                        'subtitle' => $row->section,
                        'content' => $row->content,
                        'link' => "/pre_1992_legislation/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => $row->year
                    ];
                });
            $mergedCollection = $mergedCollection->concat($pre4th);
        }

        if ($category === 'All' || $category === '4th_Republic') {
            if ($subcategory === 'All' || $subcategory === 'Acts of Parliament') {
                $posts = Post1992Article::where(function($q) use ($query) {
                    $q->where('part', 'LIKE', "%$query%")
                      ->orWhere('section', 'LIKE', "%$query%")
                      ->orWhere('content', 'LIKE', "%$query%")
                      ->orWhere('post_act', 'LIKE', "%$query%");
                })->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Acts of Parliament',
                        'category' => '4th_republic',
                        'parent_title' => $row->post_act,
                        'subtitle' => $row->part . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/post_1992_legislation/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => null
                    ];
                });
                $mergedCollection = $mergedCollection->concat($posts);
            }

            if ($subcategory === 'All' || $subcategory === 'Legislative Instruments') {
                $regs = RegulationArticle::where(function($q) use ($query) {
                    $q->where('part', 'LIKE', "%$query%")
                      ->orWhere('section', 'LIKE', "%$query%")
                      ->orWhere('content', 'LIKE', "%$query%")
                      ->orWhere('regulation_title', 'LIKE', "%$query%");
                })->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Legislative Instruments',
                        'category' => '4th_republic',
                        'parent_title' => $row->regulation_title,
                        'subtitle' => $row->part . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/post_1992_legislation/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => null
                    ];
                });
                $mergedCollection = $mergedCollection->concat($regs);
            }

            if ($subcategory === 'All' || $subcategory === 'Constitutional Instruments') {
                $consts = ConstitutionalArticle::where(function($q) use ($query) {
                    $q->where('part', 'LIKE', "%$query%")
                      ->orWhere('section', 'LIKE', "%$query%")
                      ->orWhere('content', 'LIKE', "%$query%")
                      ->orWhere('constitutional_act', 'LIKE', "%$query%");
                })->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Constitutional Instruments',
                        'category' => '4th_republic',
                        'parent_title' => $row->constitutional_act,
                        'subtitle' => $row->part . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/post_1992_legislation/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => null
                    ];
                });
                $mergedCollection = $mergedCollection->concat($consts);
            }

            if ($subcategory === 'All' || $subcategory === 'Executive Instruments') {
                $exes = ExecutiveArticle::where(function($q) use ($query) {
                    $q->where('part', 'LIKE', "%$query%")
                      ->orWhere('section', 'LIKE', "%$query%")
                      ->orWhere('content', 'LIKE', "%$query%")
                      ->orWhere('executive_act', 'LIKE', "%$query%");
                })->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Executive Instruments',
                        'category' => '4th_republic',
                        'parent_title' => $row->executive_act,
                        'subtitle' => $row->part . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/post_1992_legislation/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => null
                    ];
                });
                $mergedCollection = $mergedCollection->concat($exes);
            }

            if ($subcategory === 'All' || $subcategory === 'Amended Acts') {
                $amends = AmendedArticle::where(function($q) use ($query) {
                    $q->where('section', 'LIKE', "%$query%")
                      ->orWhere('content', 'LIKE', "%$query%")
                      ->orWhere('act_title', 'LIKE', "%$query%");
                })->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Amended Acts',
                        'category' => '4th_republic',
                        'parent_title' => $row->act_title,
                        'subtitle' => $row->section,
                        'content' => $row->content,
                        'link' => "/post_1992_legislation/amended_acts/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => null
                    ];
                });
                $mergedCollection = $mergedCollection->concat($amends);
            }

            if ($subcategory === 'All' || $subcategory === 'Amended Regulations') {
                $amends_regs = AmendRegulationArticle::where(function($q) use ($query) {
                    $q->where('part', 'LIKE', "%$query%")
                      ->orWhere('section', 'LIKE', "%$query%")
                      ->orWhere('content', 'LIKE', "%$query%")
                      ->orWhere('title', 'LIKE', "%$query%");
                })->get()->map(function($row) {
                    return [
                        'id' => $row->id,
                        'type' => 'Amended Regulations',
                        'category' => '4th_republic',
                        'parent_title' => $row->title,
                        'subtitle' => $row->part . ' | ' . $row->section,
                        'content' => $row->content,
                        'link' => "/post_1992_legislation/amended_regulation_acts/content/{$row->id}",
                        'priority' => $row->priority ?? 999,
                        'year' => null
                    ];
                });
                $mergedCollection = $mergedCollection->concat($amends_regs);
            }
        }

        if ($category === 'All' || $category === 'Case_Laws') {
            $casesQuery = GhLawJudgment::where('content', 'LIKE', "%$query%");
            
            if ($subcategory !== 'All') {
                $casesQuery->where('gh_law_judgment_group_name', $subcategory);
            }
            
            $cases = $casesQuery->select('id', 'case_title', 'content', 'year', 'gh_law_judgment_group_name', 'reference_number', 'court_name')
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
            $mergedCollection = $mergedCollection->concat($cases);
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
                    'Ghana Constitution' => GhanaArticle::where('articles', 'LIKE', "%$query%")->count(),
                    'Ghana Constitution (Amended)' => GhAmendedArticle::where('articles', 'LIKE', "%$query%")->count()
                ];
            } elseif ($category === 'Constitution_Others') {
                $subFacets = AllConstitution::where('content', 'LIKE', "%$query%")
                    ->groupBy('continent')
                    ->selectRaw('continent, count(*) as count')
                    ->pluck('count', 'continent')
                    ->toArray();
            } elseif ($category === 'Pre_4th_Republic') {
                $subFacets = DB::table('pre1992_legislation_acts')
                    ->leftJoin('pre1992_legislation_articles', 'pre1992_legislation_acts.title', '=', 'pre1992_legislation_articles.pre_1992_act')
                    ->where('content', 'LIKE', "%$query%")
                    ->groupBy('pre_19_group') // Wait, was it pre_19_group or pre_1992_group? In previous view it was pre_1992_group, let me make sure it is pre_1992_group!
                    ->groupBy('pre_1992_group')
                    ->selectRaw('pre_1992_group, count(*) as count')
                    ->pluck('count', 'pre_1992_group')
                    ->toArray();
            } elseif ($category === '4th_Republic') {
                $subFacets = [
                    'Acts of Parliament' => $counts['post1992_count'],
                    'Legislative Instruments' => $counts['regulation_count'],
                    'Constitutional Instruments' => $counts['constitutional_count'],
                    'Executive Instruments' => $counts['executive_count'],
                    'Amended Acts' => $counts['amends_count'],
                    'Amended Regulations' => $counts['amends_regs_count']
                ];
            } elseif ($category === 'Case_Laws') {
                $subFacets = GhLawJudgment::where('content', 'LIKE', "%$query%")
                    ->groupBy('gh_law_judgment_group_name')
                    ->selectRaw('gh_law_judgment_group_name, count(*) as count')
                    ->pluck('count', 'gh_law_judgment_group_name')
                    ->toArray();
            }
            session()->put('last_sub_query', $query);
            session()->put('last_sub_category', $category);
            session()->put('last_sub_facets', $subFacets);
        }

        // 3. Paginate the merged collection
        $page = (int) $request->get('page', 1);
        $perPage = (int) $request->get('per_page', 15);
        $offset = ($page - 1) * $perPage;

        $totalItems = $mergedCollection->count();
        $sortedCollection = $mergedCollection->sortBy('priority');
        
        $paginatedItems = $sortedCollection->slice($offset, $perPage)->values();

        // 4. Generate snippets for each paginated item
        $formattedItems = $paginatedItems->map(function ($item) use ($originalQuery) {
            $item['snippet'] = $this->getSnippet($item['content'], $originalQuery);
            unset($item['content']); // Don't send massive content fields in JSON
            return $item;
        });

        $endTime = microtime(true);
        $executionTimeMs = round(($endTime - $startTime) * 1000, 1);

        return response()->json([
            'query' => $originalQuery,
            'category' => $category,
            'subcategory' => $subcategory,
            'total' => $totalItems,
            'time_ms' => $executionTimeMs,
            'results' => $formattedItems,
            'facets' => [
                'categories' => [
                    'All' => $counts['all_total_count'],
                    'Constitution_Ghana' => $counts['constitution_ghana_total'],
                    'Constitution_Others' => $counts['constitution_others_total'],
                    'Pre_4th_Republic' => $counts['pre_4th_total'],
                    '4th_Republic' => $counts['post_4th_total'],
                    'Case_Laws' => $counts['cases_total']
                ],
                'subcategories' => $subFacets,
                'years' => $yearFacets
            ],
            'page' => $page,
            'per_page' => $perPage,
            'total_pages' => ceil($totalItems / $perPage) ?: 1
        ]);
    }

    /**
     * Helper to compute table counts efficiently
     */
    private function calculateCounts($query)
    {
        $lastQuery = session()->get('last_search_query');
        if ($lastQuery === $query && session()->has('last_search_counts')) {
            return session()->get('last_search_counts');
        }

        $ghana_const_count = GhanaArticle::where('articles', 'LIKE', "%$query%")->count();
        $ghana_const_amended_count = GhAmendedArticle::where('articles', 'LIKE', "%$query%")->count();
        $constitution_ghana_total = $ghana_const_count + $ghana_const_amended_count;

        $constitution_others_total = AllConstitution::where('content', 'LIKE', "%$query%")->count();

        $pre_4th_total = DB::table('pre1992_legislation_articles')
            ->where('content', 'LIKE', "%$query%")
            ->count();

        $post1992_count = Post1992Article::where(function($q) use ($query) {
            $q->where('part', 'LIKE', "%$query%")
              ->orWhere('section', 'LIKE', "%$query%")
              ->orWhere('content', 'LIKE', "%$query%")
              ->orWhere('post_act', 'LIKE', "%$query%");
        })->count();

        $regulation_count = RegulationArticle::where(function($q) use ($query) {
            $q->where('part', 'LIKE', "%$query%")
              ->orWhere('section', 'LIKE', "%$query%")
              ->orWhere('content', 'LIKE', "%$query%")
              ->orWhere('regulation_title', 'LIKE', "%$query%");
        })->count();

        $constitutional_count = ConstitutionalArticle::where(function($q) use ($query) {
            $q->where('part', 'LIKE', "%$query%")
              ->orWhere('section', 'LIKE', "%$query%")
              ->orWhere('content', 'LIKE', "%$query%")
              ->orWhere('constitutional_act', 'LIKE', "%$query%");
        })->count();

        $executive_count = ExecutiveArticle::where(function($q) use ($query) {
            $q->where('part', 'LIKE', "%$query%")
              ->orWhere('section', 'LIKE', "%$query%")
              ->orWhere('content', 'LIKE', "%$query%")
              ->orWhere('executive_act', 'LIKE', "%$query%");
        })->count();

        $amends_count = AmendedArticle::where(function($q) use ($query) {
            $q->where('section', 'LIKE', "%$query%")
              ->orWhere('content', 'LIKE', "%$query%")
              ->orWhere('act_title', 'LIKE', "%$query%");
        })->count();

        $amends_regs_count = AmendRegulationArticle::where(function($q) use ($query) {
            $q->where('part', 'LIKE', "%$query%")
              ->orWhere('section', 'LIKE', "%$query%")
              ->orWhere('content', 'LIKE', "%$query%")
              ->orWhere('title', 'LIKE', "%$query%");
        })->count();

        $post_4th_total = $post1992_count + $regulation_count + $constitutional_count + $executive_count + $amends_count + $amends_regs_count;

        $cases_total = GhLawJudgment::where('content', 'LIKE', "%$query%")->count();

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

        session()->put('last_search_query', $query);
        session()->put('last_search_counts', $counts);

        return $counts;
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
        
        // Strip HTML tags for clean text extraction
        $cleanText = html_entity_decode(strip_tags($content), ENT_QUOTES, 'UTF-8');
        $cleanText = preg_replace('/\s+/', ' ', $cleanText);
        
        // Find position of match (normalizing spaces/hyphens for accurate offset search)
        $normalizedText = str_replace('-', ' ', $cleanText);
        $normalizedQuery = str_replace('-', ' ', $query);
        $pos = mb_stripos($normalizedText, $normalizedQuery);
        
        $length = 260; // snippet size
        
        if ($pos === false) {
            $snippet = mb_substr($cleanText, 0, $length);
            if (mb_strlen($cleanText) > $length) {
                $snippet .= '...';
            }
        } else {
            $start = max(0, $pos - 80);
            
            // Adjust start to beginning of word
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
        
        // Highlight terms (allowing space/hyphen variations)
        $escapedQuery = preg_quote(htmlspecialchars($query, ENT_QUOTES, 'UTF-8'), '/');
        $regexPattern = str_replace([' ', '\\-'], '[ \-]', $escapedQuery);
        if (!empty($regexPattern)) {
            $snippet = preg_replace('/(' . $regexPattern . ')/i', '<mark class="search-highlight">$1</mark>', $snippet);
        }
        
        return $snippet;
    }
}
