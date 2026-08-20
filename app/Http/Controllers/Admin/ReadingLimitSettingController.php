<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ReadingLimitSetting;
use Illuminate\Http\Request;

class ReadingLimitSettingController extends Controller
{
    /**
     * Display the reading limits management page.
     */
    public function index()
    {
        $reading_limit_enabled = ReadingLimitSetting::get('reading_limit_enabled', '1');
        $default_scroll_percentage = (int) ReadingLimitSetting::get('default_scroll_percentage', 10);
        $constitution_scroll_percentage = (int) ReadingLimitSetting::get('constitution_scroll_percentage', 50);
        $case_law_scroll_percentage = (int) ReadingLimitSetting::get('case_law_scroll_percentage', 20);
        $free_preview_sections_count = (int) ReadingLimitSetting::get('free_preview_sections_count', 3);

        return view('admin.reading_limits.index', compact(
            'reading_limit_enabled',
            'default_scroll_percentage',
            'constitution_scroll_percentage',
            'case_law_scroll_percentage',
            'free_preview_sections_count'
        ));
    }

    /**
     * Update the reading limit settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'default_scroll_percentage' => 'required|numeric|min:1|max:100',
            'constitution_scroll_percentage' => 'required|numeric|min:1|max:100',
            'case_law_scroll_percentage' => 'required|numeric|min:1|max:100',
            'free_preview_sections_count' => 'required|numeric|min:0|max:100',
        ]);

        $enabled = $request->has('reading_limit_enabled') && $request->input('reading_limit_enabled') == '1' ? '1' : '0';

        ReadingLimitSetting::set('reading_limit_enabled', $enabled);
        ReadingLimitSetting::set('default_scroll_percentage', $request->input('default_scroll_percentage'));
        ReadingLimitSetting::set('constitution_scroll_percentage', $request->input('constitution_scroll_percentage'));
        ReadingLimitSetting::set('case_law_scroll_percentage', $request->input('case_law_scroll_percentage'));
        ReadingLimitSetting::set('free_preview_sections_count', $request->input('free_preview_sections_count'));

        return redirect()->route('admin.reading-limits.index')
            ->with('success', 'Reading limit & scroll gate percentages updated successfully!');
    }
}
