<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Post1992Act;
use App\Pre1992LegislationAct;
use App\ConstitutionalAct;
use App\ExecutiveAct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    public function index(Request $request)
    {
        $type = $request->input('type', 'post1992');
        $model = $this->getModel($type);
        $query = $model->newQuery();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('preamble', 'like', "%{$search}%");
        }

        $laws = $query->orderBy('year', 'desc')->paginate(10)->withQueryString();

        return view('admin.laws.index', compact('laws', 'type'));
    }

    public function create($type)
    {
        return view('admin.laws.create', compact('type'));
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

        return view('admin.laws.edit', compact('law', 'type'));
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
                if ($law->upload_pdf) {
                    Storage::disk('public')->delete($law->upload_pdf);
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

        if ($type === 'post1992' && $law->upload_pdf) {
            Storage::disk('public')->delete($law->upload_pdf);
        }

        $law->delete();

        return redirect()->route('admin.laws.index', ['type' => $type])->with('success', 'Law deleted successfully.');
    }
}
