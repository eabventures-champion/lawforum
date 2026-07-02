<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GhLawJudgment;
use App\GhLawJudgmentCategory;
use App\GhLawJudgmentGroup;
use App\ForeignLawJudgment;
use App\Country;
use PDF;
use App\FooterNote;
use Carbon\Carbon;

class JudgementController extends Controller
{
    //ALL GHANA LAW JUDGMENT
    public function index(){
        $ghlawjudgments = GhLawJudgment::all();
        $ghcategories   = GhLawJudgmentCategory::all();
        $footer_notes           = FooterNote::all();
        // return view('law_judgment.ghana_law_judgments', compact('footer_notes','ghlawjudgments', 'ghcategories'));
        // return view('law_judgment.ghana_law_judgments_b4', compact('footer_notes','ghlawjudgments', 'ghcategories'));
        return view('layouts.app_main_header', compact('footer_notes','ghlawjudgments', 'ghcategories'));
    }
    
    //ALL GHANA LAW JUDGMENT FILTERING
    public function all_judgment_filter($year, $category){
        
        $bool = false;
        $where = array();
        
        if($year != "0"){   
            $where['year'] = $year;
            $bool = true;
        }
        if($category != "0"){   
            $where['gh_law_judgment_category_name'] = $category;
            $bool = true;
        }

        $ghlawjudgments  = ($bool)?GhLawJudgment::where($where)->get():GhLawJudgment::all();
        $ghcategories    = GhLawJudgmentCategory::all();
        return view('law_judgment.ghana_law_judgments', compact('ghlawjudgments', 'ghcategories'));
    }
    
    
    // public function index(){
    //     $ghlawjudgments = GhLawJudgment::all();
    //         return view('law_judgment.ghana_law_judgments', compact('ghlawjudgments'));
    // }
    
    //ALL GHANA LAW JUDGMENT FILTERING
    // public function all_judgment_filter(){
        
    //     $bool = false;
    //     $where = array();
        
    //     if($year != "0"){   
    //         $where['year'] = $year;
    //         $bool = true;
    //     }

    //     $ghlawjudgments  = ($bool)?GhLawJudgment::where($where)->get():GhLawJudgment::all();
    //     return view('law_judgment.ghana_law_judgments', compact('ghlawjudgments'));
    // }

    public function all_ghana_court_cases($name, $id){
        //dd($name);
        $allGhanaLaw = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
            ])->toArray()[0];

        $allGhanaLaws = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $footer_notes           = FooterNote::all();
        
        // return view('law_judgment.ghana_all_court_case', compact('footer_notes','allGhanaLaws', 'allGhanaLaw'));
        return view('law_judgment.all_ghana_court_case', compact('footer_notes','allGhanaLaws', 'allGhanaLaw'));

    }


    // public function all_ghana_court_cases_view($id, $name){
    //     $allGhanaLaw = GhLawJudgment::find(
    //         ['
    //             id' => $id,
    //             'gh_law_judgment_group_name' => $name
    //         ])->toArray()[0];
    //     return view('law_judgment.ghana_all_court_case_view', compact('allGhanaLaw'));
    // }

    //Display print section Content for Ghana
    public function Ghana_all_print_preview($id){
        $allGhanaLawprint = GhLawJudgment::find(['id' => $id])->toArray()[0];
        return view('law_judgment.displayed_print_content_view', compact('allGhanaLawprint'));
    }

    //Display Plain Content for Ghana
    public function Ghana_all_plain_view($id){
        $allGhanaLawPlainView = GhLawJudgment::find(['id' => $id])->toArray()[0];
        return view('law_judgment.displayed_plain_content_view', compact('allGhanaLawPlainView'));
    }

    //Display Pdf View for Content view for Ghana
    public function Ghana_all_pdf_view($name, $id){
        // dd($name);
        $allGhanaLawpdf = GhLawJudgment::find(
            [
                'id' => $id,
                'case_title' => $name
            ])->toArray()[0];
        $pdf = PDF::loadView('law_judgment.displayed_pdf_content_view', compact('allGhanaLawpdf'));        
        return $pdf->download($name.'.case_law.pdf');
    }


    //------------------------------------------------------------------------------------------
    //SUPREME COURT
    public function supreme_court($name){
        $supremeCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $supremecategories   = GhLawJudgmentCategory::all();
        $footer_notes           = FooterNote::all();
        // return view('law_judgment.law_supreme_court', compact('footer_notes','supremeCourts', 'supremecategories'));
        return view('law_judgment.law_supreme_court_b4', compact('footer_notes','supremeCourts', 'supremecategories'));
    }

    //SUPREME COURT FILTERING
    public function supreme_court_filter($year, $category){

         $name = "Supreme-Court";
         $bool = false;
         $where = array();

         if($year != "0"){   
            $where['year'] = $year;
            $bool = true;
        }
        if($category != "0"){   
            $where['gh_law_judgment_category_name'] = $category;
            $bool = true;
        }

         $supremeCourts       = ($bool)?GhLawJudgment::where($where)->where(['gh_law_judgment_group_name' => $name])->get():GhLawJudgment::all();
         $supremecategories   = GhLawJudgmentCategory::all();
         return view('law_judgment.law_supreme_court', compact('supremeCourts', 'supremecategories'));
    }

    public function supreme_court_cases($id, $name){
        $supremeCourt = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
            ])->toArray()[0];

        $supremeCourts = GhLawJudgment::where(['gh_law_judgment_group_name'=> $id])->get();
        $footer_notes           = FooterNote::all();
        return view('law_judgment.law_supreme_court_view', compact('footer_notes','supremeCourt', 'supremeCourts'));
    }

    // public function supreme_court_cases_view($id){
    //     $supremeCourt = GhLawJudgment::find(['id' => $id])->toArray()[0];
    //     return view('law_judgment.law_supreme_court_case_view_2', compact('supremeCourt'));
    // }


    //-------------------------------------------------------------------------------------------
    //HIGH COURT
    public function high_court($name){
        $highCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $highcategories   = GhLawJudgmentCategory::all();
        $footer_notes           = FooterNote::all();
        // return view('law_judgment.law_high_court', compact('footer_notes','highCourts', 'highcategories'));
        return view('law_judgment.law_high_court_b4', compact('footer_notes','highCourts', 'highcategories'));
    }

    //HIGH COURT FILTERING
    public function high_court_filter($year, $category){

        $name = "High-Court";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['gh_law_judgment_category_name'] = $category;
           $bool = true;
       }

        $highCourts       = ($bool)?GhLawJudgment::where($where)->where(['gh_law_judgment_group_name' => $name])->get():GhLawJudgment::all();
        $highcategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_high_court', compact('highCourts', 'highcategories'));
       }

    public function high_court_cases($id, $name){
        $highCourt = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
            ])->toArray()[0];

        $highCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $id])->get();
        $footer_notes           = FooterNote::all();
        return view('law_judgment.law_high_court_view', compact('footer_notes','highCourt', 'highCourts'));
    }

    // public function high_court_cases_view($id){
    //     $highCourt = GhLawJudgment::find(['id' => $id])->toArray()[0];
    //     return view('law_judgment.law_high_court_view_2', compact('highCourt'));
    // }


    //--------------------------------------------------------------------------------------------------
    //COURT OF APPEAL
    public function court_of_appeal($name){
        $courtOfAppeals = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $courtOfAppealcategories   = GhLawJudgmentCategory::all();
        $footer_notes           = FooterNote::all();
        // return view('law_judgment.law_court_of_appeal', compact('footer_notes','courtOfAppeals', 'courtOfAppealcategories'));
        return view('law_judgment.law_court_of_appeal_b4', compact('footer_notes','courtOfAppeals', 'courtOfAppealcategories'));
    }

    //COURT OF APPEAL FILTERING
    public function court_of_appeal_filter($year, $category){

        $name = "Court-of-Appeal";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['gh_law_judgment_category_name'] = $category;
           $bool = true;
       }

        $courtOfAppeals       = ($bool)?GhLawJudgment::where($where)->where(['gh_law_judgment_group_name' => $name])->get():GhLawJudgment::all();
        $courtOfAppealcategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_court_of_appeal', compact('courtOfAppeals', 'courtOfAppealcategories'));
       }

    public function court_of_appeal_cases($id, $name){
        $courtOfAppeal = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
                ])->toArray()[0];

        $courtOfAppeals = GhLawJudgment::where(['gh_law_judgment_group_name' => $id])->get();
        $footer_notes           = FooterNote::all();
        return view('law_judgment.law_court_of_appeal_view', compact('footer_notes','courtOfAppeal', 'courtOfAppeals'));
    }

    // public function court_of_appeal_cases_view($id){
    //     $courtOfAppeal = GhLawJudgment::find(['id' => $id])->toArray()[0];
    //     return view('law_judgment.law_court_of_appeal_view_2', compact('courtOfAppeal'));
    // }



    //-------------------------------------------------------------------------------------------
    //CIRCUIT COURT
    public function circuit_court($name){
        $circuitCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $circuitCourtcategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_circuit_court', compact('circuitCourts', 'circuitCourtcategories'));
    }

    //CIRCUIT COURT FILTERING
    public function circuit_court_filter($year, $category){

        $name = "Circuit-Court";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['gh_law_judgment_category_name'] = $category;
           $bool = true;
       }

        $circuitCourts       = ($bool)?GhLawJudgment::where($where)->where(['gh_law_judgment_group_name' => $name])->get():GhLawJudgment::all();
        $circuitCourtcategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_circuit_court', compact('circuitCourts', 'circuitCourtcategories'));
       }

    public function circuit_court_cases($id, $name){
        $circuitCourt = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
                ])->toArray()[0];

        $circuitCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $id])->get();
        return view('law_judgment.law_circuit_court_view', compact('circuitCourt', 'circuitCourts'));
    }

    // public function circuit_court_cases_view($id){
    //     $circuitCourt = GhLawJudgment::find(['id' => $id])->toArray()[0];
    //     return view('law_judgment.law_circuit_court_view_2', compact('circuitCourt'));
    // }

    
    //--------------------------------------------------------------------------------------------
    //DISTRICT COURT
    public function district_court($name){
        $districtCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $districtCourtcategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_district_court', compact('districtCourts', 'districtCourtcategories'));
    }

    //DISTRICT COURT FILTERING
    public function district_court_filter($year, $category){

        $name = "District-Court";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['gh_law_judgment_category_name'] = $category;
           $bool = true;
       }

        $districtCourts       = ($bool)?GhLawJudgment::where($where)->where(['gh_law_judgment_group_name' => $name])->get():GhLawJudgment::all();
        $districtCourtcategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_district_court', compact('districtCourts', 'districtCourtcategories'));
       }
       
    public function district_court_cases($id, $name){
        $districtCourt = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
            ])->toArray()[0];

        $districtCourts = GhLawJudgment::where(['gh_law_judgment_group_name' => $id])->get();
        return view('law_judgment.law_district_court_view', compact('districtCourt', 'districtCourts'));
    }

     //HIGH COURT TEMA
     public function high_court_tema($name){
        $high_Tema_Courts = GhLawJudgment::where(['gh_law_judgment_group_name' => $name])->get();
        $hightCourtTemacategories   = GhLawJudgmentCategory::all();
        return view('law_judgment.law_high_court_Tema', compact('high_Tema_Courts', 'hightCourtTemacategories'));
    }

    public function high_court_tema_cases($id, $name){
        $highCourtTema = GhLawJudgment::find(
            [
                'id' => $id,
                'gh_law_judgment_group_name' => $name
            ])->toArray()[0];

        $highCourtTemas = GhLawJudgment::where(['gh_law_judgment_group_name' => $id])->get();
        return view('law_judgment.law_high_court_Tema_view', compact('highCourtTemas', 'highCourtTema'));
    }


    //------------------------------------------------------------------------------------------------------------------------
    //FOREIGN LAW JUDGMENTS
    public function all_countries_laws(){
        $allCountriesJudgementLaws = ForeignLawJudgment::all();
        $foreigncountries   = Country::all();

        return view('law_judgment_foreign.all_countries', compact('allCountriesJudgementLaws', 'foreigncountries'));
    }

    //Display print section Content for Foreign
    public function Foreign_all_print_preview($id){
        $allForeignLawprint = ForeignLawJudgment::find(['id' => $id])->toArray()[0];
        return view('law_judgment_foreign.displayed_foreign_print_content_view', compact('allForeignLawprint'));
    }

    //Display Plain Content for Foreign
    public function Foreign_all_plain_preview($id){
        $allForeignLawplain = ForeignLawJudgment::find(['id' => $id])->toArray()[0];
        return view('law_judgment_foreign.displayed_foreign_plain_content_view', compact('allForeignLawplain'));
    }

    //Display Pdf View for Content view for Foreign
    public function Foreign_all_pdf_preview($country, $id){
        // dd($name);
        $allForeignLawpdf = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $country
            ])->toArray()[0];
        $pdf = PDF::loadView('law_judgment_foreign.displayed_foreign_pdf_content_view', compact('allForeignLawpdf'));
        return $pdf->download($country.'.case_law.pdf');
    }

    //ALL FOREIGN LAW JUDGMENT FILTERING
    public function all_foreign_judgment_filter($year, $country){
        
        $bool = false;
        $where = array();
        
        if($year != "0"){   
            $where['year'] = $year;
            $bool = true;
        }
        if($country != "0"){   
            $where['country_name'] = $country;
            $bool = true;
        }

        $allCountriesJudgementLaws  = ($bool)?ForeignLawJudgment::where($where)->get():ForeignLawJudgment::all();
        $foreigncountries   = Country::all();
        return view('law_judgment_foreign.all_countries', compact('allCountriesJudgementLaws', 'foreigncountries'));
    }

    public function all_countries_court_case($id, $country){
        $allCountriesJudgementLaw = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $country
            ])->toArray()[0];

        $allCountriesJudgementLaws = ForeignLawJudgment::all();
        return view('law_judgment_foreign.all_countries_court_case', compact('allCountriesJudgementLaw', 'allCountriesJudgementLaws'));
    }

    public function all_countries_court_cases_view($id, $country){
        $allCountriesJudgementLaw = ForeignLawJudgment::find(
            ['
                id' => $id,
                'country_name' => $country
            ])->toArray()[0];
        return view('law_judgment_foreign.all_countries_court_case_view', compact('allCountriesJudgementLaw'));
    }


    //-------------------------------------------------------------------------------------------------------------------------
    //AFRICA
    public function africa_court($name){
        $africaJudgements = ForeignLawJudgment::where(['continent_name' => $name])->get();
        $africanCountries   = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.africa_court', compact('africaJudgements', 'africanCountries'));
    }

    //AFRICA COURT FILTERING
    public function africa_court_filter($year, $country){

        $name = "Africa";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country_name'] = $country;
           $bool = true;
       }

        $africaJudgements       = ($bool)?ForeignLawJudgment::where($where)->where(['continent_name' => $name])->get():ForeignLawJudgment::all();
        $africanCountries       = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.africa_court', compact('africaJudgements', 'africanCountries'));
       }

    public function africa_court_cases($id, $name){
        $africaJudgement = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $name
            ])->toArray()[0];

        $africaJudgements = ForeignLawJudgment::where(['country_name' => $id])->get();
        return view('law_judgment_foreign.africa_court_view', compact('africaJudgement', 'africaJudgements'));
    }

    //----------------------------------------------------------------------------------------------------------------
    //ASIA
    public function asia_court($name){
        $asiaJudgements     = ForeignLawJudgment::where(['continent_name' => $name])->get();
        $asiaCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.asia_court', compact('asiaJudgements', 'asiaCountries'));
    }

    //ASIA COURT FILTERING
    public function asia_court_filter($year, $country){

        $name = "Asia";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country_name'] = $country;
           $bool = true;
       }

        $asiaJudgements       = ($bool)?ForeignLawJudgment::where($where)->where(['continent_name' => $name])->get():ForeignLawJudgment::all();
        $asiaCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.asia_court', compact('asiaJudgements', 'asiaCountries'));
       }

    public function asia_court_cases($id, $name){
        $asiaJudgement = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $name
            ])->toArray()[0];

        $asiaJudgements = ForeignLawJudgment::where(['country_name' => $id])->get();
        return view('law_judgment_foreign.asia_court_view', compact('asiaJudgement', 'asiaJudgements'));
    }

    //-------------------------------------------------------------------------------------------------------------
    //EUROPE
    public function europe_court($name){
        $europeJudgements = ForeignLawJudgment::where(['continent_name' => $name])->get();
        $europeCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.europe_court', compact('europeJudgements', 'europeCountries'));
    }

    //EUROPE COURT FILTERING
    public function europe_court_filter($year, $country){

        $name = "Europe";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country_name'] = $country;
           $bool = true;
       }

        $europeJudgements       = ($bool)?ForeignLawJudgment::where($where)->where(['continent_name' => $name])->get():ForeignLawJudgment::all();
        $europeCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.europe_court', compact('europeJudgements', 'europeCountries'));
       }

    public function europe_court_cases($id, $name){
        $europeJudgement = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $name
            ])->toArray()[0];

        $europeJudgements = ForeignLawJudgment::where(['country_name' => $id])->get();
        return view('law_judgment_foreign.europe_court_view', compact('europeJudgements', 'europeJudgement'));
    }

    //------------------------------------------------------------------------------------------------------------------------
    //NORTH AMERICA
    public function north_america_court($name){
        $northAmericaJudgements = ForeignLawJudgment::where(['continent_name' => $name])->get();
        $northAmericaCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.north_america_court', compact('northAmericaJudgements', 'northAmericaCountries'));
    }

    //NORTH AMERICA COURT FILTERING
    public function north_america_court_filter($year, $country){

        $name = "North America";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country_name'] = $country;
           $bool = true;
       }

        $northAmericaJudgements       = ($bool)?ForeignLawJudgment::where($where)->where(['continent_name' => $name])->get():ForeignLawJudgment::all();
        $northAmericaCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.north_america_court', compact('northAmericaJudgements', 'northAmericaCountries'));
       }

    public function north_america_court_cases($id, $name){
        $northAmericaJudgement = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $name
            ])->toArray()[0];

        $northAmericaJudgements = ForeignLawJudgment::where(['country_name' => $id])->get();
        return view('law_judgment_foreign.north_america_court_view', compact('northAmericaJudgements', 'northAmericaJudgement'));
    }

    //-----------------------------------------------------------------------------------------------------------------------------
    //SOUTH AMERICA
    public function south_america_court($name){
        $southAmericaJudgements = ForeignLawJudgment::where(['continent_name' => $name])->get();
        $southAmericaCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.south_america_court', compact('southAmericaJudgements', 'southAmericaCountries'));
    }

    //SOUTH AMERICA COURT FILTERING
    public function south_america_court_filter($year, $country){

        $name = "South America";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country_name'] = $country;
           $bool = true;
       }

        $southAmericaJudgements       = ($bool)?ForeignLawJudgment::where($where)->where(['continent_name' => $name])->get():ForeignLawJudgment::all();
        $southAmericaCountries      = Country::where(['continent_name' => $name])->get();
        return view('law_judgment_foreign.south_america_court', compact('southAmericaJudgements', 'southAmericaCountries'));
       }

    public function south_america_court_cases($id, $name){
        $southAmericaJudgement = ForeignLawJudgment::find(
            [
                'id' => $id,
                'country_name' => $name
            ])->toArray()[0];

        $southAmericaJudgements = ForeignLawJudgment::where(['country_name' => $id])->get();
        return view('law_judgment_foreign.south_america_court_view', compact('southAmericaJudgements', 'southAmericaJudgement'));
    }
}
