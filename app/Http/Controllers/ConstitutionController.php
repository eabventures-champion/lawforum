<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AllConstitution;
use App\Country;
use App\GhanaAct;
use App\GhanaArticle;
use App\GhAmendedAct;
use App\GhAmendedArticle;
use App\FooterNote;
use PDF;

class ConstitutionController extends Controller
{
    //GHANA'S CONSTITUTION
    public function ghana_constitution_table($id){
        $ghana_act                = GhanaAct::find(['id' => $id])->toArray()[0];
        $constitutionContent1     = GhanaArticle::all();  
        $unique                   = $constitutionContent1->sortBy('chapter')->sortBy('priority');
        $constitutionContents     = $unique;
        $allCountriesConstitutions = AllConstitution::all();
        $footer_notes           = FooterNote::all();

        return view('constitution.new_ghana_constitution_table', compact('footer_notes','ghana_act', 'constitutionContents', 'allCountriesConstitutions'));
        // return view('constitution.ghana_constitution_table', compact('footer_notes','ghana_act', 'constitutionContents'));
    }

    //Display print section Content for article print
    public function print_constitution_content($id){
        $country_act = AllConstitution::find(['id' => $id])->toArray()[0];
        return view('constitution.country_constitution_print_article_content_view', compact('country_act'));
    }

    //Display Plain Content for articles
    public function plain_constitution_content($id){
        $country_act = AllConstitution::find(['id' => $id])->toArray()[0];
        return view('constitution.country_constitution_plain_article_content_view', compact('country_act'));
    }

    //Display Pdf View for article Content view
    public function pdf_constitution_content($id, $title){
        // dd($id, $title);
        $country_act              = AllConstitution::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('constitution.country_constitution_pdf_article_content_view', compact('country_act'));
        return $pdf->download($id.'.lawsghana.pdf');
    }

    public function ghana_constitution_preamble($id){
        $ghana_act = GhanaAct::find(['id' => $id])->toArray()[0]; 
        return view('constitution.ghana_constitution_preamble', compact('ghana_act'));
    }

    public function ghana_constitution_content($id){
        $constitutionContent = GhanaArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_content', compact('constitutionContent'));
    }

    public function ghana_constitution_content_plain_view($id){
        $constitutionContent = GhanaArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_content_plain_view', compact('constitutionContent'));
    }

    public function ghana_expanded_view($id){
        $ghana_act          = GhanaAct::find(['id' => $id])->toArray()[0];
        $ghanaArticles1     = GhanaArticle::all();  
        $unique            = $ghanaArticles1->sortBy('priority');
        $ghanaArticles    = $unique;
        return view('constitution.ghana_constitution_expandedView', compact('ghana_act', 'ghanaArticles'));
    }

    public function ghana_plain_view($id){
        $ghana_act          = GhanaAct::find(['id' => $id])->toArray()[0];
        $ghanaArticles1     = GhanaArticle::all();  
        $unique            = $ghanaArticles1->sortBy('priority');
        $ghanaArticles    = $unique;
        return view('constitution.ghana_constitution_plainView', compact('ghana_act', 'ghanaArticles'));
    }

    //Display print section Content for preamble print
    public function print_preamble_content($id){
        $ghana_act = GhanaAct::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_print_preamble_content_view', compact('ghana_act'));
    }

     //Display print section Content for article print
     public function print_article_content($id){
        $ghana_act = GhanaArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_print_article_content_view', compact('ghana_act'));
    }

    //Display Print View for Expanded view
    public function print_expanded_article_content($id, $title, $group){
        //dd($id, $title, $group);
        
        $ghana_act              = GhanaAct::find(
            [
                'id' => $id,
                'gh_group' => $group
            ])->toArray()[0];
            
        $ghana_acts1            = GhanaArticle::where(['gh_title' => $title])->get();
        $unique                     = $ghana_acts1->unique()->sortBy('chapter')->sortBy('priority'); 
        $ghana_acts         = $unique;
        return view('constitution.ghana_constitution_print_article_content_expanded_view', compact('ghana_act','ghana_acts'));
    }

    //Display Plain Content for preamble
    public function plain_preamble_content($id){
        $ghana_act = GhanaAct::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_plain_preamble_content_view', compact('ghana_act'));
    }

    //Display Plain Content for articles
    public function plain_article_content($id){
        $ghana_act = GhanaArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_plain_article_content_view', compact('ghana_act'));
    }

    //Display Plain-View for expanded view
    public function plain_expanded_article_content($id, $title, $group){
        $ghana_act              = GhanaAct::find(
            [
                'id' => $id,
                'gh_group' => $group
            ])->toArray()[0];
            
        $ghana_acts1            = GhanaArticle::where(['gh_title' => $title])->get();
        $unique                     = $ghana_acts1->unique()->sortBy('chapter')->sortBy('priority'); 
        $ghana_acts         = $unique;
        return view('constitution.ghana_constitution_plain_article_expanded_view', compact('ghana_act','ghana_acts'));
    }

    //Display Pdf View for preamble Content view
    public function pdf_preamble_content($id, $title){
        // dd($id);
        $ghana_act              = GhanaAct::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('constitution.ghana_constitution_pdf_preamble_content_view', compact('ghana_act'));
        return $pdf->download($id.'.preamble.pdf');
    }

    //Display Pdf View for article Content view
    public function pdf_article_content($id, $title){
        // dd($id);
        $ghana_act              = GhanaArticle::find(
            [
                'id' => $id,
                'chapter' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('constitution.ghana_constitution_pdf_article_content_view', compact('ghana_act'));
        return $pdf->download($id.'.lawsghana.pdf');
    }

    //Display Pdf View for Expanded view
    public function pdf_expanded_article_content($id, $title, $group){
        $ghana_act              = GhanaAct::find(
            [
                'id' => $id,
                'gh_group' => $group
            ])->toArray()[0];
            
        $ghana_acts1            = GhanaArticle::where(['gh_title' => $title])->get();
        $unique                 = $ghana_acts1->unique()->sortBy('chapter')->sortBy('priority'); 
        $ghana_acts             = $unique;
        $pdf = PDF::loadView('constitution.ghana_constitution_pdf_article_expanded_view', compact('ghana_act','ghana_acts'));
        return $pdf->download($title.'.lawsghana.pdf');
    }


    //GHANA'S CONSTITUTION AMENDED
    public function ghana_constitution_table_amended($id){
        $ghana_act_amended               = GhAmendedAct::find(['id' => $id])->toArray()[0];
        $constitutionContentAmended1     = GhAmendedArticle::all();  
        $unique                          = $constitutionContentAmended1->sortBy('chapter')->sortBy('priority');
        $constitutionContentAmendeds      = $unique;
        $footer_notes           = FooterNote::all();
        return view('constitution.ghana_constitution_amended_table', compact('footer_notes','ghana_act_amended', 'constitutionContentAmendeds'));
    }

    //Display print section Content for amended preamble print
    public function print_preamble_content_amended($id){
        $ghana_act_amended = GhAmendedAct::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_print_preamble_content_view_amended', compact('ghana_act_amended'));
    }

     //Display print section Content for article print
     public function print_article_content_amended($id){
        $ghana_act_amended = GhAmendedArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_print_article_content_view_amended', compact('ghana_act_amended'));
    }

    //Display Print View for Expanded view
    public function print_expanded_article_content_amended($id, $title, $group){
        // ($id, $title, $group);
        
        $ghana_act_amended              = GhAmendedAct::find(
            [
                'id' => $id,
                'gh_group' => $group
            ])->toArray()[0];
            
        $ghana_acts1            = GhAmendedArticle::where(['gh_title' => $title])->get();
        $unique                     = $ghana_acts1->unique()->sortBy('chapter')->sortBy('priority'); 
        $ghana_act_amendeds         = $unique;
        return view('constitution.ghana_constitution_print_article_content_expanded_view_amended', compact('ghana_act_amended','ghana_act_amendeds'));
    }

     

    //Display Plain Content for amended preamble
    public function plain_preamble_content_amended($id){
        $ghana_act_amended = GhAmendedAct::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_plain_preamble_content_view_amended', compact('ghana_act_amended'));
    }

     //Display Plain Content for articles
     public function plain_article_content_amended($id){
        $ghana_act_amended = GhAmendedArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_plain_article_content_view_amended', compact('ghana_act_amended'));
    }

     //Display Plain-View for expanded view
     public function plain_expanded_article_content_amended($id, $title, $group){
        $ghana_act_amended              = GhAmendedAct::find(
            [
                'id' => $id,
                'gh_group' => $group
            ])->toArray()[0];
            
        $ghana_acts1            = GhAmendedArticle::where(['gh_title' => $title])->get();
        $unique                     = $ghana_acts1->unique()->sortBy('chapter')->sortBy('priority'); 
        $ghana_act_amendeds         = $unique;
        return view('constitution.ghana_constitution_plain_article_expanded_view_amended', compact('ghana_act_amended','ghana_act_amendeds'));
    }

     //Display Pdf View for amended preamble Content view
     public function pdf_preamble_content_amended($id, $title){
        // dd($id);
        $ghana_act_amended              = GhAmendedAct::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('constitution.ghana_constitution_pdf_preamble_content_view_amended', compact('ghana_act_amended'));
        return $pdf->download($id.'.preamble.pdf');
    }

    //Display Pdf View for article Content view
    public function pdf_article_content_amended($id, $title){
        // dd($id, $title);
        $ghana_act_amended              = GhAmendedArticle::find(
            [
                'id' => $id,
                'chapter' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('constitution.ghana_constitution_pdf_article_content_view_amended', compact('ghana_act_amended'));
        return $pdf->download($id.'.lawsghana.pdf');
    }

    //Display Pdf View for Expanded view
    public function pdf_expanded_article_content_amended($id, $title, $group){
        $ghana_act_amended              = GhAmendedAct::find(
            [
                'id' => $id,
                'gh_group' => $group
            ])->toArray()[0];
            
        $ghana_acts1            = GhAmendedArticle::where(['gh_title' => $title])->get();
        $unique                 = $ghana_acts1->unique()->sortBy('chapter')->sortBy('priority'); 
        $ghana_act_amendeds             = $unique;
        $pdf = PDF::loadView('constitution.ghana_constitution_pdf_article_expanded_view_amended', compact('ghana_act_amended','ghana_act_amendeds'));
        return $pdf->download($title.'.lawsghana.pdf');
    }

    public function ghana_constitution_preamble_amended($id){
        $ghana_act_amended = GhAmendedAct::find(['id' => $id])->toArray()[0]; 
        return view('constitution.ghana_constitution_amended_preamble', compact('ghana_act_amended'));
    }

    public function ghana_constitution_content_amended($id){
        $constitutionContentAmended = GhAmendedArticle::find(['id' => $id])->toArray()[0];
        return view('constitution.ghana_constitution_amended_content', compact('constitutionContentAmended'));
    }

    public function ghana_expanded_view_amended($id){
        $ghana_act_amended          = GhAmendedAct::find(['id' => $id])->toArray()[0];
        $ghanaArticlesAmended1     = GhAmendedArticle::all();  
        $unique            = $ghanaArticlesAmended1->sortBy('priority');
        $ghanaArticlesAmendeds    = $unique;
        return view('constitution.ghana_constitution_amended_expandedView', compact('ghana_act_amended', 'ghanaArticlesAmendeds'));
    }

    //------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
    //ALL COUNTRIES CONSTITUTION
    public function all_countries_constitution(){
        $allCountriesConstitutions = AllConstitution::all();
        //$allCountries   = Country::all();
        $footer_notes           = FooterNote::all();
        
        return view('constitution.new_all_countries', compact('footer_notes','allCountriesConstitutions'));
        // return view('constitution.all_countries', compact('footer_notes','allCountriesConstitutions'));
    }

     //ALL COUNTRIES CONSTITUTION FILTERING
     public function all_countries_constitution_filter($year, $country){
        
        $bool = false;
        $where = array();
        
        if($year != "0"){   
            $where['year'] = $year;
            $bool = true;
        }
        if($country != "0"){   
            $where['country'] = $country;
            $bool = true;
        }

        $allCountriesConstitutions  = ($bool)?AllConstitution::where($where)->get():AllConstitution::all();
        $allCountries   = Country::all();
        return view('constitution.all_countries', compact('allCountriesConstitutions', 'allCountries'));
    }

    public function display_country_constitution($continent, $country, $id){
        // dd($continent, $country, $id);
        $allCountriesConstitution = AllConstitution::find(
            [
                'id' => $id,
                'country' => $country
            ])->toArray()[0];

        $allCountriesConstitutions = AllConstitution::where(['continent' => $continent])->get();
        $footer_notes           = FooterNote::all();
        
        return view('constitution.new_display_country_constitution', compact('footer_notes','allCountriesConstitutions', 'allCountriesConstitution'));
        // return view('constitution.display_country_constitution', compact('footer_notes','allCountriesConstitutions', 'allCountriesConstitution'));
    }

    //AFRICA
    public function africa_constitution($continent){
        $africaConstitutions = AllConstitution::where(['continent' => $continent])->get();
        $footer_notes           = FooterNote::all();
        //$africanCountries   = Country::where(['continent_name' => $continent])->get();
        return view('constitution.new_display_only_african_countries', compact('footer_notes','africaConstitutions'));
        // return view('constitution.display_only_african_countries', compact('footer_notes','africaConstitutions'));
    }

    //AFRICA FILTERING
    public function africa_constitution_filter($year, $country){

        $name = "Africa";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country'] = $country;
           $bool = true;
       }

        $africaConstitutions       = ($bool)?AllConstitution::where($where)->where(['continent' => $name])->get():AllConstitution::where(['continent' => $name])->get();
        return view('constitution.new_display_only_african_countries', compact('africaConstitutions'));
       }

    //ASIA
    public function asia_constitution($continent){
        $asiaConstitutions = AllConstitution::where(['continent' => $continent])->get();
        $footer_notes           = FooterNote::all();
        //$asiaCountries   = Country::where(['continent_name' => $continent])->get();
        return view('constitution.new_display_only_asia_countries', compact('footer_notes','asiaConstitutions'));
        // return view('constitution.display_only_asia_countries', compact('footer_notes','asiaConstitutions'));
    }

    //ASIA FILTERING
    public function asia_constitution_filter($year, $country){

        $name = "Asia";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country'] = $country;
           $bool = true;
       }

        $asiaConstitutions       = ($bool)?AllConstitution::where($where)->where(['continent' => $name])->get():AllConstitution::where(['continent' => $name])->get();
        return view('constitution.new_display_only_asia_countries', compact('asiaConstitutions'));
       }

    //EUROPE
    public function europe_constitution($continent){
        $europeConstitutions = AllConstitution::where(['continent' => $continent])->get();
        $footer_notes           = FooterNote::all();
        //$europeCountries   = Country::where(['continent_name' => $continent])->get();
        return view('constitution.new_display_only_europe_countries', compact('footer_notes','europeConstitutions'));
        // return view('constitution.display_only_europe_countries', compact('footer_notes','europeConstitutions'));
    }

    //EUROPE FILTERING
    public function europe_constitution_filter($year, $country){

        $name = "Europe";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country'] = $country;
           $bool = true;
       }

        $europeConstitutions       = ($bool)?AllConstitution::where($where)->where(['continent' => $name])->get():AllConstitution::where(['continent' => $name])->get();
        return view('constitution.new_display_only_europe_countries', compact('europeConstitutions'));
       }

    //NORTH AMERICA
    public function north_america_constitution($continent){
        $north_americaConstitutions = AllConstitution::where(['continent' => $continent])->get();
        $footer_notes           = FooterNote::all();
        //$north_americaCountries   = Country::where(['continent_name' => $continent])->get();
        return view('constitution.new_display_only_north_america_countries', compact('footer_notes','north_americaConstitutions'));
        // return view('constitution.display_only_north_america_countries', compact('footer_notes','north_americaConstitutions'));
    }

    //NORTH AMERICA FILTERING
    public function north_america_constitution_filter($year, $country){

        $name = "North America";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country'] = $country;
           $bool = true;
       }

        $north_americaConstitutions       = ($bool)?AllConstitution::where($where)->where(['continent' => $name])->get():AllConstitution::where(['continent' => $name])->get();
        return view('constitution.new_display_only_north_america_countries', compact('north_americaConstitutions'));
       }

    //SOUTH AMERICA
    public function south_america_constitution($continent){
        $south_americaConstitutions = AllConstitution::where(['continent' => $continent])->get();
        $footer_notes           = FooterNote::all();
        //$south_americaCountries   = Country::where(['continent_name' => $continent])->get();
        return view('constitution.new_display_only_south_america_countries', compact('footer_notes','south_americaConstitutions'));
        // return view('constitution.display_only_south_america_countries', compact('footer_notes','south_americaConstitutions'));
    }

    //SOUTH AMERICA FILTERING
    public function south_america_constitution_filter($year, $country){

        $name = "South America";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($country != "0"){   
           $where['country'] = $country;
           $bool = true;
       }

        $south_americaConstitutions       = ($bool)?AllConstitution::where($where)->where(['continent' => $name])->get():AllConstitution::where(['continent' => $name])->get();
        return view('constitution.new_display_only_south_america_countries', compact('south_americaConstitutions'));
       }
}
