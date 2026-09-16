<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post1992Act;
use App\Post1992Group;
use App\Post1992Category;
use App\Pre1992LegislationAct;
use App\ConstitutionalAct;
use App\ExecutiveAct;
use App\Post1992Article;
use App\Pre1992LegislationArticle;
use App\ConstitutionalArticle;
use App\ExecutiveArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LawController extends Controller
{
    private function getModel($type)
    {
        switch ($type) {
            case 'post1992':
                return new Post1992Act();
            case 'pre1992':
                return new Pre1992LegislationAct();
            case 'constitutional':
                return new ConstitutionalAct();
            case 'executive':
                return new ExecutiveAct();
            default:
                abort(404, 'Invalid law type.');
        }
    }

    private function getArticleModel($type)
    {
        switch ($type) {
            case 'post1992':
                return new Post1992Article();
            case 'pre1992':
                return new Pre1992LegislationArticle();
            case 'constitutional':
                return new ConstitutionalArticle();
            case 'executive':
                return new ExecutiveArticle();
            default:
                abort(404, 'Invalid law type.');
        }
    }

    private function getArticlesForAct($act, $type)
    {
        $articleModel = $this->getArticleModel($type);
        switch ($type) {
            case 'post1992':
                return $articleModel->where(function($q) use ($act) {
                    $q->where('act_id', $act->id)->orWhere('post_act', $act->title);
                })->orderBy('part')->orderBy('priority')->get();
            case 'pre1992':
                return $articleModel->where(function($q) use ($act) {
                    $q->where('act_id', $act->id)->orWhere('pre_1992_act', $act->title);
                })->orderBy('part')->orderBy('priority')->get();
            case 'constitutional':
                return $articleModel->where(function($q) use ($act) {
                    $q->where('consti_act_id', $act->id)->orWhere('constitutional_act', $act->title);
                })->orderBy('part')->orderBy('priority')->get();
            case 'executive':
                return $articleModel->where(function($q) use ($act) {
                    $q->where('executive_act_id', $act->id)->orWhere('executive_act', $act->title);
                })->orderBy('part')->orderBy('priority')->get();
            default:
                return collect();
        }
    }

    public function index(Request $request)
    {
        $type = $request->input('type', 'post1992');
        $model = $this->getModel($type);
        $query = $model->newQuery();

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function($q) use ($search, $type) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('year', 'like', "%{$search}%")
                  ->orWhere('preamble', 'like', "%{$search}%");

                if ($type === 'post1992') {
                    $q->orWhere('post_group', 'like', "%{$search}%")
                      ->orWhere('post_category', 'like', "%{$search}%");
                } elseif ($type === 'pre1992') {
                    $q->orWhere('pre_1992_group', 'like', "%{$search}%");
                } elseif ($type === 'constitutional') {
                    $q->orWhere('constitutional_group', 'like', "%{$search}%");
                } elseif ($type === 'executive') {
                    $q->orWhere('executive_group', 'like', "%{$search}%");
                }
            });
        }

        $laws = $query->orderBy('year', 'desc')->paginate(10)->withQueryString();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'html' => view('admin.laws._table_rows', compact('laws', 'type'))->render(),
                'pagination' => view('admin.laws._pagination', compact('laws', 'type'))->render(),
                'total' => $laws->total(),
                'firstItem' => $laws->firstItem() ?? 0,
                'lastItem' => $laws->lastItem() ?? 0,
            ]);
        }

        return view('admin.laws.index', compact('laws', 'type'));
    }

    public function create($type)
    {
        $postGroups = ($type === 'post1992') ? Post1992Group::orderBy('name')->get() : collect();
        $postCategories = ($type === 'post1992') ? Post1992Category::orderBy('name')->get() : collect();

        return view('admin.laws.create', compact('type', 'postGroups', 'postCategories'));
    }

    public function store(Request $request, $type)
    {
        $model = $this->getModel($type);

        $rules = [
            'title' => 'required|string|max:225',
            'preamble' => 'nullable|string',
            'year' => 'required|string|max:4',
        ];

        if ($type === 'post1992') {
            $rules['post_category'] = 'required|string|max:50';
            $rules['post_group'] = 'required|string|max:50';
            $rules['upload_pdf'] = 'nullable|file|mimes:pdf|max:10240'; // max 10MB
        } elseif ($type === 'pre1992') {
            $rules['pre_1992_group'] = 'required|string|max:50';
        } elseif ($type === 'constitutional') {
            $rules['constitutional_group'] = 'required|string|max:50';
        } elseif ($type === 'executive') {
            $rules['executive_group'] = 'required|string|max:50';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'preamble' => $request->preamble,
            'year' => $request->year,
        ];

        if ($type === 'post1992') {
            $data['post_category'] = $request->post_category;
            $data['post_group'] = $request->post_group;
            if ($request->hasFile('upload_pdf')) {
                // Store path in DB
                $data['upload_pdf'] = $request->file('upload_pdf')->store('laws', 'public');
            }
        } elseif ($type === 'pre1992') {
            $data['pre_1992_group'] = $request->pre_1992_group;
        } elseif ($type === 'constitutional') {
            $data['constitutional_group'] = $request->constitutional_group;
        } elseif ($type === 'executive') {
            $data['executive_group'] = $request->executive_group;
        }

        $model->create($data);

        return redirect()->route('admin.laws.index', ['type' => $type])->with('success', 'Law created successfully.');
    }

    public function edit($id, $type)
    {
        $model = $this->getModel($type);
        $law = $model->findOrFail($id);

        $postGroups = ($type === 'post1992') ? Post1992Group::orderBy('name')->get() : collect();
        $postCategories = ($type === 'post1992') ? Post1992Category::orderBy('name')->get() : collect();
        $sectionsCount = $this->getArticlesForAct($law, $type)->count();

        return view('admin.laws.edit', compact('law', 'type', 'postGroups', 'postCategories', 'sectionsCount'));
    }

    public function update(Request $request, $id, $type)
    {
        $model = $this->getModel($type);
        $law = $model->findOrFail($id);

        $rules = [
            'title' => 'required|string|max:225',
            'preamble' => 'nullable|string',
            'year' => 'required|string|max:4',
        ];

        if ($type === 'post1992') {
            $rules['post_category'] = 'required|string|max:50';
            $rules['post_group'] = 'required|string|max:50';
            $rules['upload_pdf'] = 'nullable|file|mimes:pdf|max:10240';
        } elseif ($type === 'pre1992') {
            $rules['pre_1992_group'] = 'required|string|max:50';
        } elseif ($type === 'constitutional') {
            $rules['constitutional_group'] = 'required|string|max:50';
        } elseif ($type === 'executive') {
            $rules['executive_group'] = 'required|string|max:50';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->title,
            'preamble' => $request->preamble,
            'year' => $request->year,
        ];

        if ($type === 'post1992') {
            $data['post_category'] = $request->post_category;
            $data['post_group'] = $request->post_group;
            if ($request->hasFile('upload_pdf')) {
                // Delete old PDF if exists
                if ($law->upload_pdf && !in_array(trim($law->upload_pdf), ['', '[]', 'null', '[""]'])) {
                    $oldPath = trim($law->upload_pdf);
                    if (Str::startsWith($oldPath, '[')) {
                        $dec = json_decode($oldPath, true);
                        $oldPath = $dec[0]['download_link'] ?? ($dec[0] ?? null);
                    }
                    if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                $data['upload_pdf'] = $request->file('upload_pdf')->store('laws', 'public');
            }
        } elseif ($type === 'pre1992') {
            $data['pre_1992_group'] = $request->pre_1992_group;
        } elseif ($type === 'constitutional') {
            $data['constitutional_group'] = $request->constitutional_group;
        } elseif ($type === 'executive') {
            $data['executive_group'] = $request->executive_group;
        }

        $law->update($data);

        return redirect()->route('admin.laws.index', ['type' => $type])->with('success', 'Law updated successfully.');
    }

    public function destroy($id, $type)
    {
        $model = $this->getModel($type);
        $law = $model->findOrFail($id);

        if ($type === 'post1992' && $law->upload_pdf && !in_array(trim($law->upload_pdf), ['', '[]', 'null', '[""]'])) {
            $oldPath = trim($law->upload_pdf);
            if (Str::startsWith($oldPath, '[')) {
                $dec = json_decode($oldPath, true);
                $oldPath = $dec[0]['download_link'] ?? ($dec[0] ?? null);
            }
            if ($oldPath && Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $law->delete();

        return redirect()->route('admin.laws.index', ['type' => $type])->with('success', 'Law deleted successfully.');
    }

    public function taxonomies()
    {
        $groups = Post1992Group::orderBy('name')->get()->map(function($g) {
            $g->laws_count = Post1992Act::where('post_group', $g->name)->count();
            return $g;
        });

        $categories = Post1992Category::orderBy('name')->get()->map(function($c) {
            $c->laws_count = Post1992Act::where('post_category', $c->name)->count();
            return $c;
        });

        return view('admin.laws.taxonomies', compact('groups', 'categories'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:post1992_groups,name',
        ]);

        Post1992Group::create(['name' => trim($request->name)]);

        return redirect()->route('admin.laws.taxonomies')->with('success', 'Post 1992 Group added successfully.');
    }

    public function updateGroup(Request $request, $id)
    {
        $group = Post1992Group::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:post1992_groups,name,' . $group->id,
        ]);

        $oldName = $group->name;
        $newName = trim($request->name);

        $group->update(['name' => $newName]);

        // Sync existing laws with the new name if updated
        if ($oldName !== $newName) {
            Post1992Act::where('post_group', $oldName)->update(['post_group' => $newName]);
        }

        return redirect()->route('admin.laws.taxonomies')->with('success', 'Post 1992 Group updated successfully.');
    }

    public function destroyGroup($id)
    {
        $group = Post1992Group::findOrFail($id);
        $group->delete();

        return redirect()->route('admin.laws.taxonomies')->with('success', 'Post 1992 Group deleted successfully.');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:post1992_categories,name',
        ]);

        Post1992Category::create(['name' => trim($request->name)]);

        return redirect()->route('admin.laws.taxonomies')->with('success', 'Post Category added successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Post1992Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100|unique:post1992_categories,name,' . $category->id,
        ]);

        $oldName = $category->name;
        $newName = trim($request->name);

        $category->update(['name' => $newName]);

        // Sync existing laws with the new name if updated
        if ($oldName !== $newName) {
            Post1992Act::where('post_category', $oldName)->update(['post_category' => $newName]);
        }

        return redirect()->route('admin.laws.taxonomies')->with('success', 'Post Category updated successfully.');
    }

    public function destroyCategory($id)
    {
        $category = Post1992Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.laws.taxonomies')->with('success', 'Post Category deleted successfully.');
    }

    public function sections($id, $type)
    {
        $act = $this->getModel($type)->findOrFail($id);
        $allArticles = $this->getArticlesForAct($act, $type);

        $groupedParts = [];
        $schedules = [];
        $generalSections = [];
        $distinctParts = [];

        foreach ($allArticles as $art) {
            $p = trim($art->part ?? '');
            if (!empty($p) && !in_array($p, $distinctParts) && strtoupper($p) !== 'SCHEDULE') {
                $distinctParts[] = $p;
            }

            if (strtoupper($p) === 'SCHEDULE' || (stripos($art->section, 'schedule') !== false && empty($p))) {
                $schedules[] = $art;
            } elseif (empty($p)) {
                $generalSections[] = $art;
            } else {
                $groupedParts[$p][] = $art;
            }
        }

        // Natural sort parts so Part 1, Part 2, Part 3 ... Part 10 follow numerical order
        uksort($groupedParts, [$this, 'comparePartsNatural']);
        usort($distinctParts, [$this, 'comparePartsNatural']);

        // Sort sections within each part
        foreach ($groupedParts as &$secs) {
            usort($secs, function($a, $b) {
                if ($a->priority > 0 && $b->priority > 0 && $a->priority !== $b->priority) {
                    return $a->priority <=> $b->priority;
                }
                return strnatcasecmp($a->section, $b->section);
            });
        }
        unset($secs);

        // Sort schedules
        usort($schedules, function($a, $b) {
            if ($a->priority > 0 && $b->priority > 0 && $a->priority !== $b->priority) {
                return $a->priority <=> $b->priority;
            }
            return strnatcasecmp($a->section, $b->section);
        });

        // Sort general sections
        usort($generalSections, function($a, $b) {
            if ($a->priority > 0 && $b->priority > 0 && $a->priority !== $b->priority) {
                return $a->priority <=> $b->priority;
            }
            return strnatcasecmp($a->section, $b->section);
        });

        return view('admin.laws.sections', compact('act', 'type', 'allArticles', 'groupedParts', 'schedules', 'generalSections', 'distinctParts'));
    }

    public function previewAct($id, $type)
    {
        $act = $this->getModel($type)->findOrFail($id);
        $articles = $this->getArticlesForAct($act, $type);

        $partsCount = $articles->pluck('part')->filter(function($p) {
            return !empty(trim($p)) && strtoupper(trim($p)) !== 'SCHEDULE';
        })->unique()->count();

        $schedulesCount = $articles->filter(function($a) {
            return strtoupper(trim($a->part ?? '')) === 'SCHEDULE' || (stripos($a->section, 'schedule') !== false && empty(trim($a->part ?? '')));
        })->count();

        $sectionsCount = $articles->count() - $schedulesCount;

        // Construct front-end reading URL
        $previewUrl = null;
        if ($type === 'post1992') {
            $group = !empty($act->post_group) ? $act->post_group : 'Acts of Parliament';
            $previewUrl = url('/new-laws/table-of-content/' . rawurlencode($group) . '/' . rawurlencode($act->title) . '/' . $act->id);
        } elseif ($type === 'pre1992') {
            $group = !empty($act->pre_1992_group) ? $act->pre_1992_group : 'Pre 1992';
            $previewUrl = url('/existing-laws/' . rawurlencode($group) . '/' . rawurlencode($act->title) . '/' . $act->id);
        } elseif ($type === 'constitutional') {
            $group = !empty($act->constitutional_group) ? $act->constitutional_group : 'Constitutional';
            $previewUrl = url('/new-laws/constitutional-acts-table-of-content/' . rawurlencode($group) . '/' . rawurlencode($act->title) . '/' . $act->id);
        } elseif ($type === 'executive') {
            $group = !empty($act->executive_group) ? $act->executive_group : 'Executive';
            $previewUrl = url('/new-laws/executive-acts-table-of-content/' . rawurlencode($group) . '/' . rawurlencode($act->title) . '/' . $act->id);
        }

        // Distinct parts list with their section counts
        $partsSummary = [];
        foreach ($articles as $art) {
            $p = trim($art->part ?? '');
            if (!empty($p) && strtoupper($p) !== 'SCHEDULE') {
                if (!isset($partsSummary[$p])) {
                    $partsSummary[$p] = 0;
                }
                $partsSummary[$p]++;
            }
        }

        $partsSummaryList = [];
        foreach ($partsSummary as $pName => $count) {
            $partsSummaryList[] = [
                'name' => $pName,
                'count' => $count,
            ];
        }

        // Sort parts naturally in preview
        usort($partsSummaryList, function($a, $b) {
            return $this->comparePartsNatural($a['name'], $b['name']);
        });

        return response()->json([
            'id' => $act->id,
            'title' => $act->title,
            'year' => $act->year,
            'preamble' => $act->preamble ?: null,
            'type' => $type,
            'group' => $act->post_group ?? $act->pre_1992_group ?? $act->constitutional_group ?? $act->executive_group ?? null,
            'category' => $act->post_category ?? null,
            'sections_count' => $sectionsCount,
            'parts_count' => count($partsSummaryList),
            'schedules_count' => $schedulesCount,
            'parts_summary' => $partsSummaryList,
            'preview_url' => $previewUrl,
            'edit_url' => route('admin.laws.edit', ['id' => $act->id, 'type' => $type]),
            'sections_url' => route('admin.laws.sections', ['id' => $act->id, 'type' => $type]),
        ]);
    }

    public function comparePartsNatural($a, $b)
    {
        $numA = $this->extractPartSortKey($a);
        $numB = $this->extractPartSortKey($b);
        if ($numA !== 999999 || $numB !== 999999) {
            if ($numA !== $numB) {
                return $numA <=> $numB;
            }
        }
        return strnatcasecmp($a, $b);
    }

    private function extractPartSortKey($partString)
    {
        if (preg_match('/(?:part|chapter)\s*(\d+)/i', $partString, $m)) {
            return (int)$m[1];
        }
        if (preg_match('/(?:part|chapter)\s*([ivxlcdm]+)\b/i', $partString, $m)) {
            $roman = strtoupper($m[1]);
            $romans = [
                'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400,
                'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40,
                'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1
            ];
            $result = 0;
            foreach ($romans as $key => $val) {
                while (strpos($roman, $key) === 0) {
                    $result += $val;
                    $roman = substr($roman, strlen($key));
                }
            }
            if ($result > 0) return $result;
        }
        return 999999;
    }

    public function storeSection(Request $request, $id, $type)
    {
        $act = $this->getModel($type)->findOrFail($id);

        $request->validate([
            'section' => 'required|string|max:255',
            'part' => 'nullable|string|max:255',
            'content' => 'required|string',
            'priority' => 'nullable|integer',
        ]);

        $part = trim($request->input('part', ''));
        if ($request->input('is_schedule') == '1') {
            $part = 'SCHEDULE';
        }

        $data = [
            'part' => $part,
            'section' => trim($request->input('section')),
            'content' => $request->input('content', ''),
            'priority' => $request->input('priority', 0) ?: 0,
        ];

        switch ($type) {
            case 'post1992':
                $data['post_act'] = $act->title;
                $data['act_id'] = $act->id;
                $data['act_group'] = $act->post_group ?? '';
                break;
            case 'pre1992':
                $data['pre_1992_act'] = $act->title;
                $data['act_id'] = $act->id;
                $data['act_group'] = $act->pre_1992_group ?? '';
                break;
            case 'constitutional':
                $data['constitutional_act'] = $act->title;
                $data['consti_act_id'] = $act->id;
                $data['consti_group'] = $act->constitutional_group ?? '';
                break;
            case 'executive':
                $data['executive_act'] = $act->title;
                $data['executive_act_id'] = $act->id;
                $data['executive_group'] = $act->executive_group ?? '';
                break;
        }

        $articleModel = $this->getArticleModel($type);
        $articleModel->create($data);

        return redirect()->route('admin.laws.sections', ['id' => $id, 'type' => $type])
            ->with('success', ($part === 'SCHEDULE' ? 'Schedule' : 'Section') . ' added successfully.');
    }

    public function updateSection(Request $request, $id, $sectionId, $type)
    {
        $this->getModel($type)->findOrFail($id);
        $articleModel = $this->getArticleModel($type);
        $article = $articleModel->findOrFail($sectionId);

        $request->validate([
            'section' => 'required|string|max:255',
            'part' => 'nullable|string|max:255',
            'content' => 'required|string',
            'priority' => 'nullable|integer',
        ]);

        $part = trim($request->input('part', ''));
        if ($request->input('is_schedule') == '1') {
            $part = 'SCHEDULE';
        }

        $article->update([
            'part' => $part,
            'section' => trim($request->input('section')),
            'content' => $request->input('content', ''),
            'priority' => $request->input('priority', 0) ?: 0,
        ]);

        return redirect()->route('admin.laws.sections', ['id' => $id, 'type' => $type])
            ->with('success', ($part === 'SCHEDULE' ? 'Schedule' : 'Section') . ' updated successfully.');
    }

    public function destroySection($id, $sectionId, $type)
    {
        $this->getModel($type)->findOrFail($id);
        $articleModel = $this->getArticleModel($type);
        $article = $articleModel->findOrFail($sectionId);
        $isSchedule = (strtoupper(trim($article->part)) === 'SCHEDULE');
        $article->delete();

        return redirect()->route('admin.laws.sections', ['id' => $id, 'type' => $type])
            ->with('success', ($isSchedule ? 'Schedule' : 'Section') . ' deleted successfully.');
    }
}
