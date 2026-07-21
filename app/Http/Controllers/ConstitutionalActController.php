<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ConstitutionalAct;
use App\ConstitutionalArticle;
use App\FooterNote;
use PDF;


class ConstitutionalActController extends Controller
{
    //All Constitutional Acts
    public function only_constitutional_acts(){
        $allPost1992Acts                = \App\Post1992Act::all();
        $allConstitutionalActs          = ConstitutionalAct::all();
        $allExecutiveActs               = \App\ExecutiveAct::all();
        $allPostsAmends                 = \App\AmendedTitle::all();
        $allPostsAmendsOnRegulations    = \App\AmendRegulationAct::all();
        $allPostRegulations             = \App\RegulationTitle::all();
        $allPost1992ategories           = \App\Post1992Category::all();
        $footer_notes                   = \App\FooterNote::all();
        $activeTab                      = 'constitutional_instruments';
        return view('post_1992_legislation.new_displayed_all_acts_view', compact('footer_notes','allPost1992Acts', 'allConstitutionalActs', 'allExecutiveActs', 'allPost1992ategories','allPostsAmends', 'allPostRegulations', 'allPostsAmendsOnRegulations', 'activeTab'));
    }
    
    //Display Table of Content for Constitutional Acts
    public function table_of_content($id, $title, $group){
        $allConstitutionalAct        = ConstitutionalAct::find(
            [
                'id' => $id,
                'constitutional_group' => $group

            ])->toArray()[0];
    

        $allConstitutionalArticles1      = ConstitutionalArticle::where(['constitutional_act' => $title])->get();
        $unique                      = $allConstitutionalArticles1->sortBy('part')->sortBy('priority');
        $allConstitutionalArticles       = $unique;
        
        $footer_notes                = FooterNote::all();
        return view('post_1992_legislation.new_displayed_table_of_content_view', compact('footer_notes', 'allConstitutionalAct', 'allConstitutionalArticles'));
    }

    //Display preamble content
    public function preamble_content($id){
        $allConstitutionalAct        = ConstitutionalAct::find($id);
        return view('post_1992_legislation.displayed_constitutional_act_preamble', compact('allConstitutionalAct'));   

    }

    //Display section content
    public function section_content($id){
        $allConstitutionalAct       = ConstitutionalArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_constitutional_act_content', compact('allConstitutionalAct'));
    }
    
    //For expanded view
    public function expanded_view($group, $title, $id){
        // dd($group, $title, $id);
        $allConstitutionalAct                  = ConstitutionalAct::find(
            [
                'id' => $id,
                'constitutional_group' => $group
            ])->toArray()[0];
            
        $allConstitutionalArticles1            = ConstitutionalArticle::where(['constitutional_act' => $title])->get();
        $unique                                = $allConstitutionalArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allConstitutionalArticles             = $unique;
        return view('post_1992_legislation.displayed_constitutional_act_expanded_view', compact('allConstitutionalAct','allConstitutionalArticles'));
    }

    //Display Plain-View for full act
    public function plain_view($group, $title, $id){
        //  dd($group, $title, $id);
        $allConstitutionalAct                  = ConstitutionalAct::find(
            [
                'id' => $id,
                'constitutional_group' => $group
            ])->toArray()[0];
            
        $allConstitutionalArticles1            = ConstitutionalArticle::where(['constitutional_act' => $title])->get();
        $unique                                = $allConstitutionalArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allConstitutionalArticles             = $unique;
        return view('post_1992_legislation.displayed_constitutional_act_plain_view_full_act', compact('allConstitutionalAct','allConstitutionalArticles'));
    }

    //Display print section Content for preamble print
    public function print_preamble_content($id){
        $allConstitutionalAct = ConstitutionalAct::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_constitutional_act_print_preamble_content', compact('allConstitutionalAct'));
    }

    //Display print section
    public function print_content($id){
        //  dd($id);
        $allConstitutionalArticle = ConstitutionalArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_constitutional_act_print_section_content', compact('allConstitutionalArticle'));
    }

    //Display Print View for Expanded view
    public function print_full_act($group, $title, $id){
        // dd($group, $title, $id);
        $allConstitutionalAct              = ConstitutionalAct::find(
            [
                'id' => $id,
                'constitutional_group' => $group
            ])->toArray()[0];
            
        $allConstitutionalArticles1            = ConstitutionalArticle::where(['constitutional_act' => $title])->get();
        $unique                                = $allConstitutionalArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allConstitutionalArticles             = $unique;
        return view('post_1992_legislation.displayed_constitutional_act_print_full_act', compact('allConstitutionalAct','allConstitutionalArticles'));
    }

    //Display Pdf View for preamble Content view
    public function pdf_preamble_content($title, $id){
        // dd($title, $id);
        $allConstitutionalAct              = ConstitutionalAct::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_constitutional_act_pdf_preamble_content', compact('allConstitutionalAct'));
        return $pdf->download($title.'.preamble.pdf');
    }

    //Display Pdf View for section Content view
    public function pdf_section_content($title, $id){
        //dd($title, $id);
        $allConstitutionalArticle              = ConstitutionalArticle::find(
            [
                'id' => $id,
                'constitutional_act' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_constitutional_act_pdf_section_content', compact('allConstitutionalArticle'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

    //Display Pdf View for Expanded view
    public function pdf_full_act_content($id, $title, $group){
        $allConstitutionalAct              = ConstitutionalAct::find(
            [
                'id' => $id,
                'constitutional_group' => $group
            ])->toArray()[0];
            
        $allConstitutionalArticles1            = ConstitutionalArticle::where(['constitutional_act' => $title])->get();
        $unique                     = $allConstitutionalArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allConstitutionalArticles         = $unique;
        $pdf = PDF::loadView('post_1992_legislation.displayed_constitutional_act_pdf_full_act_content', compact('allConstitutionalAct','allConstitutionalArticles'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

}
