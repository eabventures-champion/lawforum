<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pre1992LegislationAct;
use App\Pre1992LegislationArticle;
use App\Pre1992LegislationCategory;
use PDF;
use App\FooterNote;
use App\Pre1992LegislationGroup;


class Pre1992Controller extends Controller
{
    //Display all Acts
    public function index(){
        $allPre1992Acts        = Pre1992LegislationAct::all();
        $allPre1992ategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        // return view('pre_1992_legislation.displayed_all_acts_view', compact('footer_notes','allPre1992Acts','allPre1992ategories'));
        return view('pre_1992_legislation.new_displayed_all_acts_view', compact('footer_notes','allPre1992Acts','allPre1992ategories'));
    }

    //ALL PRE 1992 LEGISLATION FILTERING
    public function all_pre_1992_legislation_filter($year, $category){
        
        $bool = false;
        $where = array();
        
        if($year != "0"){   
            $where['year'] = $year;
            $bool = true;
        }
        if($category != "0"){   
            $where['pre_1992_category'] = $category;
            $bool = true;
        }

        $allPre1992Acts         = ($bool)?Pre1992LegislationAct::where($where)->get():Pre1992LegislationAct::all();
        $allPre1992ategories    = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_all_acts_view', compact('allPre1992Acts','allPre1992ategories'));
    }

    //Display Table of Content
    public function pre_1992_legislation_table_of_content($id, $title, $group){
        $allPre1992Act    = Pre1992LegislationAct::find(
            [
                'id' => $id,
                'pre_1992_group' => $group
            ])->toArray()[0];

        $allPreArticles1      = Pre1992LegislationArticle::where(['pre_1992_act' => $title])->get();
        $unique               = $allPreArticles1->sortBy('part')->sortBy('priority');
        $allPre1992Articles   = $unique;

        $allPre1992Acts = Pre1992LegislationAct::all();
        $footer_notes           = FooterNote::all();

        return view('pre_1992_legislation.new_displayed_table_of_content_view', compact('footer_notes','allPre1992Act', 'allPre1992Acts', 'allPre1992Articles'));
        // return view('pre_1992_legislation.displayed_table_of_content_view', compact('footer_notes','allPre1992Act', 'allPre1992Articles'));
    }

    //Display Preamble
    public function pre_1992_legislation_preamble($id){
        $allPre1992Act = Pre1992LegislationAct::find(['id' => $id])->toArray()[0];
        return view('pre_1992_legislation.displayed_preamble_view', compact('allPre1992Act'));   
     }

     //Display print section Content for preamble print
    public function pre_1992_legislation_print_preamble_content($id){
        $allPre1992Act = Pre1992LegislationAct::find(['id' => $id])->toArray()[0];
        return view('pre_1992_legislation.displayed_print_preamble_content_view', compact('allPre1992Act'));
    }

    //Display print section Content for section print
    public function pre_1992_legislation_print_content($id){
        $allPre1992Act = Pre1992LegislationArticle::find(['id' => $id])->toArray()[0];
        return view('pre_1992_legislation.displayed_print_content_view', compact('allPre1992Act'));
    }

    //Display Pdf View for preamble Content view
     public function pre_1992_legislation_pdf_preamble_content($id, $title){
        // dd($id, $title);
        $allPre1992Act              = Pre1992LegislationAct::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('pre_1992_legislation.displayed_pdf_preamble_content_view', compact('allPre1992Act'));
        return $pdf->download($id.'.preamble.pdf');
    }

    //Display Pdf View for section Content view
    public function pre_1992_legislation_pdf_content($id, $title){
        // dd($id);
        $allPre1992Act              = Pre1992LegislationArticle::find(
            [
                'id' => $id,
                'pre_1992_act' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('pre_1992_legislation.displayed_pdf_content_view', compact('allPre1992Act'));
        return $pdf->download($id.'.legalsforum.pdf');
    }

    //Display Plain Content for preamble
    public function pre_1992_legislation_plain_preamble_content($id){
        $allPre1992Act = Pre1992LegislationAct::find(['id' => $id])->toArray()[0];
        return view('pre_1992_legislation.displayed_plain_preamble_content_view', compact('allPre1992Act'));
    }

    //Display Plain Content for section
    public function pre_1992_legislation_plain_content($title, $id){
        $allPreArticles1      = Pre1992LegislationArticle::where(
            [
                'pre_1992_act' => $title
                ])->get();

        $unique                = $allPreArticles1->sortBy('part')->sortBy('priority');
        $allPre1992Articles   = $unique; 

        $allPre1992Act = Pre1992LegislationArticle::find(['id' => $id])->toArray()[0];
        return view('pre_1992_legislation.displayed_plain_content_view', compact('allPre1992Act','allPre1992Articles'));
    }

    //Display Content
     public function pre_1992_legislation_content($id){
        $allPre1992Article = Pre1992LegislationArticle::find(['id' => $id])->toArray()[0];
        return view('pre_1992_legislation.displayed_content_view', compact('allPre1992Article'));
    }

    //Display Expanded-View
    public function expanded_view($id, $title, $group){
        $allPre1992Act              = Pre1992LegislationAct::find(
            [
                'id' => $id,
                'pre_1992_group' => $group
            ])->toArray()[0];
            
        $allPreArticles1            = Pre1992LegislationArticle::where(['pre_1992_act' => $title])->get();
        $unique                     = $allPreArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPre1992Articles         = $unique;
        return view('pre_1992_legislation.displayed_expandedView', compact('allPre1992Act','allPre1992Articles'));
    }

    //Display Print View for Expanded view
    public function pre_1992_legislation_print_expanded_content($id, $title, $group){
        // dd($id, $title, $group);
        $allPre1992Act              = Pre1992LegislationAct::find(
            [
                'id' => $id,
                'pre_1992_group' => $group
            ])->toArray()[0];
            
        $allPreArticles1            = Pre1992LegislationArticle::where(['pre_1992_act' => $title])->get();
        $unique                     = $allPreArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPre1992Articles         = $unique;
        return view('pre_1992_legislation.displayed_printView', compact('allPre1992Act','allPre1992Articles'));
    }

    //Display Plain-View
    public function pre_1992_legislation_plain_expanded_content($id, $title, $group){
        $allPre1992Act              = Pre1992LegislationAct::find(
            [
                'id' => $id,
                'pre_1992_group' => $group
            ])->toArray()[0];
            
        $allPreArticles1            = Pre1992LegislationArticle::where(['pre_1992_act' => $title])->get();
        $unique                     = $allPreArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPre1992Articles         = $unique;
        return view('pre_1992_legislation.displayed_plainView', compact('allPre1992Act','allPre1992Articles'));
    }

    //Display Pdf View for Expanded view
    public function pre_1992_legislation_pdf_expanded_content($id, $title, $group){
        $allPre1992Act              = Pre1992LegislationAct::find(
            [
                'id' => $id,
                'pre_1992_group' => $group
            ])->toArray()[0];
            
        $allPreArticles1            = Pre1992LegislationArticle::where(['pre_1992_act' => $title])->get();
        $unique                     = $allPreArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPre1992Articles         = $unique;
        $pdf = PDF::loadView('pre_1992_legislation.displayed_pdfView', compact('allPre1992Act','allPre1992Articles'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

    //Display First Republic Acts
    public function first_republic($group){
        $firstRepublicActs         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $firstRepublicCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        
        return view('pre_1992_legislation.new_displayed_first_republic_acts_view', compact('footer_notes','firstRepublicActs', 'firstRepublicCategories'));
        // return view('pre_1992_legislation.displayed_first_republic_acts_view', compact('footer_notes','firstRepublicActs', 'firstRepublicCategories'));
    }

    //FIRST REPUBLIC LEGISLATION FILTERING
    public function first_republic_filter($year, $category){

        $name = "First Republic";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $firstRepublicActs       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $firstRepublicCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_first_republic_acts_view', compact('firstRepublicActs', 'firstRepublicCategories'));
    }

    //Display Second Republic Acts
    public function second_republic($group){
        $secondRepublicActs         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $secondRepublicCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        
        return view('pre_1992_legislation.new_displayed_second_republic_acts_view', compact('footer_notes','secondRepublicActs', 'secondRepublicCategories'));
        // return view('pre_1992_legislation.displayed_second_republic_acts_view', compact('footer_notes','secondRepublicActs', 'secondRepublicCategories'));
    }

    //SECOND REPUBLIC LEGISLATION FILTERING
    public function second_republic_filter($year, $category){

        $name = "Second Republic";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $secondRepublicActs       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $secondRepublicCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_second_republic_acts_view', compact('secondRepublicActs', 'secondRepublicCategories'));
    }

    //Display Third Republic Acts
    public function third_republic($group){
        $thirdRepublicActs         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $thirdRepublicCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        return view('pre_1992_legislation.new_displayed_third_republic_acts_view', compact('footer_notes','thirdRepublicActs', 'thirdRepublicCategories'));
        // return view('pre_1992_legislation.displayed_third_republic_acts_view', compact('footer_notes','thirdRepublicActs', 'thirdRepublicCategories'));
    }

    //THIRD REPUBLIC LEGISLATION FILTERING
    public function third_republic_filter($year, $category){

        $name = "Third Republic";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $thirdRepublicActs       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $thirdRepublicCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_third_republic_acts_view', compact('thirdRepublicActs', 'thirdRepublicCategories'));
    }

    //Display PNDC Laws
    public function pndc_law($group){
        $pndcLaws         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $pndcCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        return view('pre_1992_legislation.new_displayed_pndc_law_view', compact('footer_notes','pndcLaws', 'pndcCategories'));
        // return view('pre_1992_legislation.displayed_pndc_law_view', compact('footer_notes','pndcLaws', 'pndcCategories'));
    }

    //PNDC FILTERING
    public function pndc_law_filter($year, $category){

        $name = "PNDC Law";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $pndcLaws       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $pndcCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_pndc_law_view', compact('pndcLaws', 'pndcCategories'));
    }

    //Display NLC Decree
    public function nlc_decree($group){
        $nlcDecrees         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $nlcCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        return view('pre_1992_legislation.new_displayed_nlc_decree_view', compact('footer_notes','nlcDecrees', 'nlcCategories'));
        // return view('pre_1992_legislation.displayed_nlc_decree_view', compact('footer_notes','nlcDecrees', 'nlcCategories'));
    }

    //NLC Decree FILTERING
    public function nlc_decree_filter($year, $category){

        $name = "NLC Decree";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $nlcDecrees       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $nlcCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_nlc_decree_view', compact('nlcDecrees', 'nlcCategories'));
    }

    //Display NRC Decree
    public function nrc_decree($group){
        $nrcDecrees         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $nrcCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        return view('pre_1992_legislation.new_displayed_nrc_decree_view', compact('footer_notes','nrcDecrees', 'nrcCategories'));
        // return view('pre_1992_legislation.displayed_nrc_decree_view', compact('footer_notes','nrcDecrees', 'nrcCategories'));
    }

    //NRC Decree FILTERING
    public function nrc_decree_filter($year, $category){

        $name = "NRC Decree";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $nrcDecrees       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $nrcCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_nrc_decree_view', compact('nrcDecrees', 'nrcCategories'));
    }


    //Display SMC Decree
    public function smc_decree($group){
        $smcDecrees         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $smcCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        return view('pre_1992_legislation.new_displayed_smc_decree_view', compact('footer_notes','smcDecrees', 'smcCategories'));
        // return view('pre_1992_legislation.displayed_smc_decree_view', compact('footer_notes','smcDecrees', 'smcCategories'));
    }

    //SMC Decree FILTERING
    public function smc_decree_filter($year, $category){

        $name = "SMC Decree";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['pre_1992_category'] = $category;
           $bool = true;
       }

        $smcDecrees       = ($bool)?Pre1992LegislationAct::where($where)->where(['pre_1992_group' => $name])->get():Pre1992LegislationAct::all();
        $smcCategories   = Pre1992LegislationCategory::all();
        return view('pre_1992_legislation.displayed_smc_decree_view', compact('smcDecrees', 'smcCategories'));
    }
    
    //Display SMC Decree
    public function afrc_decree($group){
        $afrcDecrees         = Pre1992LegislationAct::where(['pre_1992_group' => $group])->get();
        $afrcCategories   = Pre1992LegislationCategory::all();
        $footer_notes           = FooterNote::all();
        return view('pre_1992_legislation.new_displayed_afrc_decree_view', compact('footer_notes','afrcDecrees', 'afrcCategories'));
        // return view('pre_1992_legislation.displayed_afrc_decree_view', compact('footer_notes','afrcDecrees', 'afrcCategories'));
    }

    /**
     * AJAX endpoint: Return JSON data for a given pre-1992 tab group.
     * Used for client-side tab switching without page refresh.
     */
    public function pre1992_ajax_data(Request $request)
    {
        $group = $request->query('group', 'all');

        // Map group keys to their database pre_1992_group values
        $groupMap = [
            '1' => 'First Republic',
            '2' => 'Second Republic',
            '3' => 'Third Republic',
            '4' => 'PNDC Law',
            '5' => 'NLC Decree',
            '6' => 'NRC Decree',
            '7' => 'SMC Decree',
            '8' => 'AFRC Decree',
        ];

        if ($group === 'all') {
            $acts = Pre1992LegislationAct::all();
        } else {
            $groupName = isset($groupMap[$group]) ? $groupMap[$group] : $group;
            $acts = Pre1992LegislationAct::where(['pre_1992_group' => $groupName])->get();
        }

        $data = $acts->map(function ($act) {
            return [
                'title' => $act->title,
                'year'  => $act->year,
                'url'   => '/pre_1992_legislation/' . $act->pre_1992_group . '/' . $act->title . '/' . $act->id,
            ];
        });

        return response()->json(['data' => $data]);
    }
}
