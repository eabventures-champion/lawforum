<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExecutiveAct;
use App\ExecutiveArticle;
use App\FooterNote;
use PDF;

class ExecutiveActController extends Controller
{
    //
    public function only_executive_acts(){
        $allPost1992Acts                = \App\Post1992Act::all();
        $allConstitutionalActs          = \App\ConstitutionalAct::all();
        $allExecutiveActs               = ExecutiveAct::all();
        $allPostsAmends                 = \App\AmendedTitle::all();
        $allPostsAmendsOnRegulations    = \App\AmendRegulationAct::all();
        $allPostRegulations             = \App\RegulationTitle::all();
        $allPost1992ategories           = \App\Post1992Category::all();
        $footer_notes                   = \App\FooterNote::all();
        $activeTab                      = 'executive_instruments';
        return view('post_1992_legislation.new_displayed_all_acts_view', compact('footer_notes','allPost1992Acts', 'allConstitutionalActs', 'allExecutiveActs', 'allPost1992ategories','allPostsAmends', 'allPostRegulations', 'allPostsAmendsOnRegulations', 'activeTab'));
    }

     //Display Table of Content for Executive Acts
     public function table_of_content($id, $title, $group){
        //  dd($id, $title, $group);
        $allExecutiveAct        = ExecutiveAct::find(
            [
                'id' => $id,
                'executive_group' => $group

            ])->toArray()[0];
    

        $allExecutiveArticles1      = ExecutiveArticle::where(['executive_act' => $title])->get();
        $unique                      = $allExecutiveArticles1->sortBy('part')->sortBy('priority');
        $allExecutiveArticles       = $unique;
        
        $footer_notes                = FooterNote::all();
        return view('post_1992_legislation.new_displayed_table_of_content_view', compact('footer_notes', 'allExecutiveAct', 'allExecutiveArticles'));
    }

    //Display preamble content
    public function preamble_content($id){
        $allExecutiveAct        = ExecutiveAct::find($id);
        return view('post_1992_legislation.displayed_executive_act_preamble', compact('allExecutiveAct'));   

    }

    //Display section content
    public function section_content($id){
        $allExecutiveAct       = ExecutiveArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_executive_act_content', compact('allExecutiveAct'));
    }

     //For expanded view
     public function expanded_view($group, $title, $id){
        // dd($group, $title, $id);
        $allExecutiveAct                  = ExecutiveAct::find(
            [
                'id' => $id,
                'executive_group' => $group
            ])->toArray()[0];
            
        $allExecutiveArticles1            = ExecutiveArticle::where(['executive_act' => $title])->get();
        $unique                           = $allExecutiveArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allExecutiveArticles             = $unique;
        return view('post_1992_legislation.displayed_executive_act_expanded_view', compact('allExecutiveAct','allExecutiveArticles'));
    }

    //Display Plain-View for full act
    public function plain_view($group, $title, $id){
        //  dd($group, $title, $id);
        $allExecutiveAct                  = ExecutiveAct::find(
            [
                'id' => $id,
                'executive_group' => $group
            ])->toArray()[0];
            
        $allExecutiveArticles1            = ExecutiveArticle::where(['executive_act' => $title])->get();
        $unique                                = $allExecutiveArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allExecutiveArticles             = $unique;
        return view('post_1992_legislation.displayed_executive_act_plain_view_full_act', compact('allExecutiveAct','allExecutiveArticles'));
    }

    //Display print section Content for preamble print
    public function print_preamble_content($id){
        $allExecutiveAct = ExecutiveAct::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_executive_act_print_preamble_content', compact('allExecutiveAct'));
    }

    //Display print section
    public function print_content($id){
        //  dd($id);
        $allExecutiveArticle = ExecutiveArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_executive_act_print_section_content', compact('allExecutiveArticle'));
    }

    //Display Print View for Expanded view
    public function print_full_act($group, $title, $id){
        // dd($group, $title, $id);
        $allExecutiveAct              = ExecutiveAct::find(
            [
                'id' => $id,
                'executive_group' => $group
            ])->toArray()[0];
            
        $allExecutiveArticles1            = ExecutiveArticle::where(['executive_act' => $title])->get();
        $unique                                = $allExecutiveArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allExecutiveArticles             = $unique;
        return view('post_1992_legislation.displayed_executive_act_print_full_act', compact('allExecutiveAct','allExecutiveArticles'));
    }

    //Display Pdf View for preamble Content view
    public function pdf_preamble_content($title, $id){
        // dd($title, $id);
        $allExecutiveAct              = ExecutiveAct::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_executive_act_pdf_preamble_content', compact('allExecutiveAct'));
        return $pdf->download($title.'.preamble.pdf');
    }

     //Display Pdf View for section Content view
     public function pdf_section_content($title, $id){
        //dd($title, $id);
        $allExecutiveArticle              = ExecutiveArticle::find(
            [
                'id' => $id,
                'executive_act' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_executive_act_pdf_section_content', compact('allExecutiveArticle'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

    //Display Pdf View for Expanded view
    public function pdf_full_act_content($id, $title, $group){
        // dd($id, $title, $group);
        $allExecutiveAct              = ExecutiveAct::find(
            [
                'id' => $id,
                'executive_group' => $group
            ])->toArray()[0];
            
        $allExecutiveArticles1            = ExecutiveArticle::where(['executive_act' => $title])->get();
        $unique                     = $allExecutiveArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allExecutiveArticles         = $unique;
        $pdf = PDF::loadView('post_1992_legislation.displayed_executive_act_pdf_full_act_content', compact('allExecutiveAct','allExecutiveArticles'));
        return $pdf->download($title.'.legalsforum.pdf');
    }
}
