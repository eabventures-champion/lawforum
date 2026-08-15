<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ResearcherType;
use Illuminate\Http\Request;

class ResearcherTypeController extends Controller
{
    public function index()
    {
        $researcherTypes = ResearcherType::orderBy('sort_order')->get();
        return view('admin.researcher_types.index', compact('researcherTypes'));
    }

    public function create()
    {
        return view('admin.researcher_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        ResearcherType::create($request->all());

        return redirect()->route('admin.researcher-types.index')
            ->with('success', 'Researcher type created successfully.');
    }

    public function edit($id)
    {
        $researcherType = ResearcherType::findOrFail($id);
        return view('admin.researcher_types.edit', compact('researcherType'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $researcherType = ResearcherType::findOrFail($id);
        $data = $request->all();
        $data['is_active'] = $request->has('is_active');
        $researcherType->update($data);

        return redirect()->route('admin.researcher-types.index')
            ->with('success', 'Researcher type updated successfully.');
    }

    public function destroy($id)
    {
        $researcherType = ResearcherType::findOrFail($id);
        $researcherType->delete();

        return redirect()->route('admin.researcher-types.index')
            ->with('success', 'Researcher type deleted successfully.');
    }
}
