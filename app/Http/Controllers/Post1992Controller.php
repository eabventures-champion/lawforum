<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post1992Act;
use App\Post1992Article;
use App\Post1992Category;
use App\AmendedTitle;
use App\AmendedArticle;
use App\RegulationTitle;
use App\RegulationArticle;
use App\AmendRegulationAct;
use App\AmendRegulationArticle;
use App\ConstitutionalAct;
use App\ExecutiveAct;
use PDF;
use App\FooterNote;
use App\FooterContent;
use Illuminate\Support\Str;


class Post1992Controller extends Controller
{

    public function keyword_search(Request $request){
        $footer_notes   = FooterNote::all();
        $query          = $request->get('q');

        $posts          = Post1992Article::where('part', 'LIKE', "%$query%")->orWhere('section','LIKE', "%$query%")->orWhere('content','LIKE', "%$query%")->orWhere('post_act','LIKE', "%$query%")
                                ->orderBy('post_act', 'ASC')->get();
        
        $regulations    = RegulationArticle::where('part', 'LIKE', "%$query%")->orWhere('section','LIKE', "%$query%")->orWhere('content','LIKE', "%$query%")->orWhere('regulation_title','LIKE', "%$query%")
                                ->orderBy('regulation_title', 'ASC')->get();
        $amends         = AmendedArticle::where('section', 'LIKE', "%$query%")->orWhere('content','LIKE', "%$query%")->orWhere('act_title','LIKE', "%$query%")
                                ->orderBy('act_title', 'ASC')->get();
        $amends_regs    = AmendRegulationArticle::where('part', 'LIKE', "%$query%")->orWhere('section','LIKE', "%$query%")->orWhere('content','LIKE', "%$query%")->orWhere('title','LIKE', "%$query%")
                                ->orderBy('title', 'ASC')->get();

        if(count($posts) > 0 or count($regulations) > 0 or count($amends) > 0 or count($amends_regs) > 0 )
            return view('extenders.search_page_index', compact('posts','regulations', 'amends','amends_regs','footer_notes'));
        else 
            return view ('extenders.search_page_not_found', compact('footer_notes'));
    }

    //Footer
    public function footer_content($caption, $id){
        // dd($caption, $id);
        $footer_notes           = FooterNote::all();
        $footer_note            = FooterContent::find(
            [
                'id' => $id,
                'footer_note' => $caption
            ])->toArray()[0];

        return view('extenders.displayed_footer', compact('footer_note', 'footer_notes'));
    }

    //Display all Acts
    public function index(){
        $allPost1992Acts                = Post1992Act::all();
        $allConstitutionalActs          = ConstitutionalAct::all();
        $allExecutiveActs               = ExecutiveAct::all();
        $allPostsAmends                 = AmendedTitle::all();
        $allPostsAmendsOnRegulations    = AmendRegulationAct::all();
        $allPostRegulations             = RegulationTitle::all();
        $allPost1992ategories           = Post1992Category::all();
        $footer_notes                   = FooterNote::all();
        return view('post_1992_legislation.new_displayed_all_acts_view', compact('footer_notes','allPost1992Acts', 'allConstitutionalActs', 'allExecutiveActs', 'allPost1992ategories','allPostsAmends', 'allPostRegulations', 'allPostsAmendsOnRegulations'));
        // return view('post_1992_legislation.displayed_all_acts_view', compact('footer_notes','allPost1992Acts', 'allConstitutionalActs', 'allExecutiveActs', 'allPost1992ategories','allPostsAmends', 'allPostRegulations', 'allPostsAmendsOnRegulations'));
    }

    //ALL POST 1992 LEGISLATION FILTERING
    public function all_post_1992_legislation_filter($year, $category){
        
        $bool = false;
        $where = array();
        
        if($year != "0"){   
            $where['year'] = $year;
            $bool = true;
        }
        if($category != "0"){   
            $where['post_category'] = $category;
            $bool = true;
        }

        $allPost1992Acts         = ($bool)?Post1992Act::where($where)->get():Post1992Act::all();
        $allPost1992ategories    = Post1992Category::all();
        return view('post_1992_legislation.displayed_all_acts_view', compact('allPost1992Acts','allPost1992ategories'));
    }

    //Display Table of Content for Acts of Parliament,ie Legislation
    public function post_1992_legislation_table_of_content($id, $title, $group){
        //dd($id, $title, $group);
        
        $allPost1992Act    = Post1992Act::find(
            [
                'id' => $id,
                'post_group' => $group

            ])->toArray()[0];

        $allPostArticles1      = Post1992Article::where(['post_act' => $title])->get();
        $unique               = $allPostArticles1->sortBy('part')->sortBy('priority');
        $allPost1992Articles   = $unique;
        $actsOfParliaments     = Post1992Act::all();
        
        //Amendments and Regulations under an act
        $amendedcount             = AmendedTitle::where(['act_title' => "$title"])->count();
        $regulationcount          = RegulationTitle::where(['act_title' => "$title"])->count();
        $footer_notes           = FooterNote::all();
        return view('post_1992_legislation.new_act_table_of_content', compact('footer_notes','actsOfParliaments','allPost1992Act', 'allPost1992Articles', 'amendedcount', 'regulationcount'));
        // return view('post_1992_legislation.displayed_act_table_of_content_view', compact('footer_notes','allPost1992Act', 'allPost1992Articles', 'amendedcount', 'regulationcount'));
    }

    //Display Preamble
    public function post_1992_legislation_preamble($id){
        // $allPost1992Act = Post1992Act::find(['id' => $id])->toArray()[0];
        //alternatively to find();
        $allPost1992Act = Post1992Act::find($id);
        return view('post_1992_legislation.new_displayed_preamble_view', compact('allPost1992Act'));   
        // return view('post_1992_legislation.displayed_preamble_view', compact('allPost1992Act'));   
     }

    //Display Plain Content for section
     public function post_1992_legislation_plain_content($title, $content_id){
        // dd($title, $content_id);
        // $allPost1992Act    = Post1992Act::find(
        //     [
        //         'id' => $id,
        //         'title' => $title

        //     ])->toArray()[0];

        $allPostArticles1      = Post1992Article::where(['post_act' => $title])->get();

        $unique                = $allPostArticles1->sortBy('part')->sortBy('priority');
        $allPost1992Articles   = $unique;    

        $allPost1992Article    = Post1992Article::find(['id' => $content_id])->toArray()[0];

        return view('post_1992_legislation.displayed_plain_content_view', compact('allPost1992Article','allPost1992Articles'));
    }

    //Display Plain Content for preamble
    public function post_1992_legislation_plain_preamble_content($id){
        $allPost1992Act = Post1992Act::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_plain_preamble_content_view', compact('allPost1992Act'));
    }

    //Display print section Content for section print
    public function post_1992_legislation_print_content($id){
        $allPost1992Article = Post1992Article::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_print_content_view', compact('allPost1992Article'));
    }

    //Display print section Content for preamble print
    public function post_1992_legislation_print_preamble_content($id){
        $allPost1992Act = Post1992Act::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_print_preamble_content_view', compact('allPost1992Act'));
    }

    //Display Expanded-View
    public function expanded_view($id, $title, $group){
        $allPost1992Act              = Post1992Act::find(
            [
                'id' => $id,
                'post_group' => $group
            ])->toArray()[0];
            
        $allPostArticles1            = Post1992Article::where(['post_act' => $title])->get();
        $unique                     = $allPostArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPost1992Articles         = $unique;
        return view('post_1992_legislation.new_displayed_expandedView', compact('allPost1992Act','allPost1992Articles'));
        // return view('post_1992_legislation.displayed_expandedView', compact('allPost1992Act','allPost1992Articles'));
    }

    //Display Content
    public function post_1992_legislation_content($id){
        // dd($act_id, $title, $id);

        // $allPost1992Act    = Post1992Act::find(
        //     [
        //         'id' => $act_id,
        //         'title' => $title
        // <a href="/post_1992_legislation/{{ $allPost1992Act['title'] }}/{{ $allPost1992Act['id'] }}/plain_content/{{ $allPost1992Article['id'] }}" target="_blank">Plain View</a>&nbsp;&nbsp;||&nbsp; -->

        //     ])->toArray()[0];
        // $add_section_user = DB::table('user_bookmarks')->select("*", DB::raw("CONCAT(user_bookmarks.user_id,' ',user_bookmarks.act_section) AS user_section"))
        // ->get();

        $allPost1992Article = Post1992Article::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.new_displayed_content_view', compact('allPost1992Article'));
        // return view('post_1992_legislation.displayed_content_view', compact('allPost1992Article'));
    }

    public function post_1992_legislation_p_pre_next_content($id){
        // dd($title, $id);
        $allPost1992Article = Post1992Article::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_p_pre_next_content_view', compact('allPost1992Article','allPost1992Act'));
    }
   
     //Display Plain-View
    public function plain_view($id, $title, $group){
        $allPost1992Act              = Post1992Act::find(
            [
                'id' => $id,
                'post_group' => $group
            ])->toArray()[0];
            
        $allPostArticles1            = Post1992Article::where(['post_act' => $title])->get();
        $unique                     = $allPostArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPost1992Articles         = $unique;
        return view('post_1992_legislation.displayed_plainView', compact('allPost1992Act','allPost1992Articles'));
    }

    //Display Print View for Expanded view
    public function print_view($id, $title, $group){
        // dd($id, $title, $group);
        $allPost1992Act              = Post1992Act::find(
            [
                'id' => $id,
                'post_group' => $group
            ])->toArray()[0];
            
        $allPostArticles1            = Post1992Article::where(['post_act' => $title])->get();
        $unique                     = $allPostArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPost1992Articles         = $unique;
        return view('post_1992_legislation.displayed_printView', compact('allPost1992Act','allPost1992Articles'));
    }

    //Display Pdf View for Expanded view
    public function pdf_view($id, $title, $group){
        $allPost1992Act              = Post1992Act::find(
            [
                'id' => $id,
                'post_group' => $group
            ])->toArray()[0];
            
        $allPostArticles1            = Post1992Article::where(['post_act' => $title])->get();
        $unique                     = $allPostArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allPost1992Articles         = $unique;
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdfView', compact('allPost1992Act','allPost1992Articles'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

    //Display Pdf View for section Content view
    public function post_1992_legislation_pdf_content($title, $id){
        // dd($title, $id);
        $allPost1992Article              = Post1992Article::find(
            [
                'id' => $id,
                'post_act' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_content_view', compact('allPost1992Article'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

     //Display Pdf View for preamble Content view
     public function post_1992_legislation_pdf_preamble_content($id, $title){
        // dd($id);
        $allPost1992Act              = Post1992Act::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_preamble_content_view', compact('allPost1992Act'));
        return $pdf->download($id.'.preamble.pdf');
    }

    //Display Acts of Parliament
    public function acts_of_parliament_tab($group){
        $actsOfParliaments         = Post1992Act::where(['post_group' => $group])->get();
        $actsOfParliamentCategories   = Post1992Category::all();
        $footer_notes           = FooterNote::all();
        // return view('post_1992_legislation.displayed_acts_of_parliament_view', compact('footer_notes','actsOfParliaments', 'actsOfParliamentCategories'));
        return view('post_1992_legislation.new_only_acts_of_parliament', compact('footer_notes','actsOfParliaments', 'actsOfParliamentCategories'));
    }

                        //ALL AMENDMENTS FOR A SPECIFIC ACT

                        //Display Amended Act table of content
                        public function amended_act_table_of_content($id, $title, $category){
                            $amendedAct             = AmendedTitle::find(
                                [
                                    'id' => $id,
                                    'post_category' => $category
                                ])->toArray()[0];

                            $amendedContents1       = AmendedArticle::where(['act_title' => $title])->get();  
                            $unique                 = $amendedContents1->sortBy('part')->sortBy('priority');
                            $amendedContents        = $unique;
                            return view('post_1992_legislation.displayed_amended_act_table_of_content', compact('amendedAct','amendedContents'));
                        }

                        //Display All amendments under an act
                        public function all_amendedments_for_an_acts($id, $title, $group){
                            $allPost1992Act              = Post1992Act::find(
                                [
                                    'id' => $id,
                                    'post_group' => $group
                                ])->toArray()[0];

                            $amendedActs                 = AmendedTitle::where(['act_title' => $title])->get();

                            return view('post_1992_legislation.displayed_all_amended_titles', compact('allPost1992Act','amendedActs'));
                        }

                        //Display Amended Act preamble
                        public function amended_act_preamble($id){
                            $amendedPreamble = AmendedTitle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_amended_act_preamble', compact('amendedPreamble'));
                        }

                        //Display Amended Act content
                        public function amended_act_content($id){
                            $amendedContent = AmendedArticle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_amended_act_content', compact('amendedContent'));
                        }

                        //Display Amended section container
                        public function display_amended_sections_container($title){
                            $amendedContents1       = AmendedArticle::where(['act_title' => $title])->get();
                            $unique                 = $amendedContents1->sortBy('part')->sortBy('priority');
                            $amendedContents        = $unique;
                            return view('post_1992_legislation.displayed_amended_sections_container', compact('amendedContents'));
                        }

                         //Display print section Content for amended preamble print
                        public function post_1992_legislation_print_amended_preamble_content($id){
                            $amendedAct = AmendedTitle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_print_amended_preamble_content_view', compact('amendedAct'));
                        }

                        //Display print section Content for amended section print
                        public function post_1992_legislation_print_amended_content_section($id){
                            $amendedAct = AmendedArticle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_print_amended_content_view', compact('amendedAct'));
                        }

                        //Display Plain Content for amended preamble
                        public function post_1992_legislation_plain_amended_preamble_content($id){
                            $amendedAct = AmendedTitle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_plain_amended_preamble_content_view', compact('amendedAct'));
                        }

                        //Display Plain Content for section
                        public function post_1992_legislation_plain_amended_content_section($id){
                            $amendedAct = AmendedArticle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_plain_amended_content_view', compact('amendedAct'));
                        }

                        //Display Pdf View for preamble Content view
                        public function post_1992_legislation_pdf_amended_preamble_content($id, $title){
                            // dd($id, $title);
                            $amendedAct              = AmendedTitle::find(
                                [
                                    'id' => $id,
                                    'title' => $title
                                ])->toArray()[0];
                            $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_amended_preamble_content_view', compact('amendedAct'));
                            return $pdf->download($id.'.preamble.pdf');
                        }

                        //Display Pdf View for section Content view
                        public function post_1992_legislation_pdf_amended_content_section($id, $title){
                            // dd($id, $title);
                            $amendedAct              = AmendedArticle::find(
                                [
                                    'id' => $id,
                                    'act_title' => $title
                                ])->toArray()[0];
                            $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_amended_content_view', compact('amendedAct'));
                            return $pdf->download($id.'.legalsforum.pdf');
                        }
                        //------------------------------------------------------------------------------------------------------------------------------------------
                        //ALL REGULATIONS FOR A SPECIFIC ACT

                        //Display All amendments under an act
                        public function all_regulations_for_an_act($id, $title, $group){
                            $allPost1992Act              = Post1992Act::find(
                                [
                                    'id' => $id,
                                    'post_group' => $group
                                ])->toArray()[0];

                            $regulationsActs                 = RegulationTitle::where(['act_title' => $title])->get();
                            return view('post_1992_legislation.displayed_all_regulations_titles', compact('allPost1992Act','regulationsActs'));
                        }

                        //Display Regulations table of content
                        public function regulations_table_of_content($id, $title, $category){
                            $regulationsAct             = RegulationTitle::find(
                                [
                                    'id' => $id,
                                    'act_category' => $category
                                ])->toArray()[0];

                            $regulationsContents1   = RegulationArticle::where(['regulation_title' => $title])->get();  
                            $unique                 = $regulationsContents1->sortBy('part')->sortBy('priority');
                            $regulationsContents        = $unique;
                            return view('post_1992_legislation.displayed_regulations_table_of_content', compact('regulationsAct','regulationsContents'));
                        }

                        //Display Amended Act preamble
                        public function regulations_preamble($id){
                            $regulationsPreamble = RegulationTitle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_regulations_preamble', compact('regulationsPreamble'));
                        }

                        //Display Amended Act content
                        public function regulations_content($id){
                            $regulationContent = RegulationArticle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_regulations_content', compact('regulationContent'));
                        }

                        //Display regulations section container
                        public function display_regulations_sections_container($title){
                            $regulationsContents1       = RegulationArticle::where(['regulation_title' => $title])->get();
                            $unique                 = $regulationsContents1->sortBy('part')->sortBy('priority');
                            $regulationsContents        = $unique;
                            return view('post_1992_legislation.displayed_regulations_sections_container', compact('regulationsContents'));
                        }

                        //Display amended regulation preamble print
                        public function post_1992_legislation_print_regulation_act_preamble_content($id){
                            // dd($id);
                            $ActsRegulationPreamble = RegulationTitle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_regulation_act_print_preamble_content_view', compact('ActsRegulationPreamble'));
                        }

                        //Display print section Content for section print
                        public function post_1992_legislation_print_regulation_act_content_section($id){
                            $ActsRegulationArticle = RegulationArticle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_print_regulation_act_content_view', compact('ActsRegulationArticle'));
                        }

                        //Display Print View for Expanded view
                        public function post_1992_legislation_print_regulation_expanded($id, $title, $category){
                            // dd($id, $title, $category);
                            $regulationtitle              = RegulationTitle::find(
                                [
                                    'id' => $id,
                                    'act_category' => $category
                                ])->toArray()[0];
                                
                            $ActsRegulationArticles1            = RegulationArticle::where(['regulation_title' => $title])->get();
                            $unique                     = $ActsRegulationArticles1->unique()->sortBy('part')->sortBy('priority'); 
                            $ActsRegulationArticles         = $unique;
                            return view('post_1992_legislation.displayed_regulation_printView', compact('regulationtitle','ActsRegulationArticles'));
                        }

                        //Display Plain Content for preamble
                        public function post_1992_legislation_plain_regulation_act_preamble_content($id){
                            $ActsRegulationPreamble = RegulationTitle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_regulation_act_plain_preamble_content_view', compact('ActsRegulationPreamble'));
                        }

                        //Display Plain Content for section
                        public function post_1992_legislation_plain_regulation_act_content_section($id){
                            $ActsRegulationArticle = RegulationArticle::find(['id' => $id])->toArray()[0];
                            return view('post_1992_legislation.displayed_regulation_act_plain_content_view', compact('ActsRegulationArticle'));
                        }

                        //Display Plain-View
                        public function post_1992_legislation_plain_regulation_expanded($id, $title, $category){
                            $regulationtitle              = RegulationTitle::find(
                                [
                                    'id' => $id,
                                    'act_category' => $category
                                ])->toArray()[0];
                                
                            $ActsRegulationArticles1            = RegulationArticle::where(['regulation_title' => $title])->get();
                            $unique                     = $ActsRegulationArticles1->unique()->sortBy('part')->sortBy('priority'); 
                            $ActsRegulationArticles         = $unique;
                            return view('post_1992_legislation.displayed_regulation_plainView', compact('regulationtitle','ActsRegulationArticles'));
                        }

                         //Display Pdf View for preamble Content view
                        public function post_1992_legislation_pdf_regulation_act_preamble_content($id, $title){
                            // dd($id,$title);
                            $ActsRegulationPreamble              = RegulationTitle::find(
                                [
                                    'id' => $id,
                                    'title' => $title
                                ])->toArray()[0];
                            $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_regulation_act_preamble_content_view', compact('ActsRegulationPreamble'));
                            return $pdf->download($id.'.preamble.pdf');
                        }

                        //Display Pdf View for section Content view
                        public function post_1992_legislation_pdf_regulation_act_content_section($id, $title){
                            // dd($id);
                            $ActsRegulationArticle              = RegulationArticle::find(
                                [
                                    'id' => $id,
                                    'regulation_title' => $title
                                ])->toArray()[0];
                            $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_regulation_act_content_view', compact('ActsRegulationArticle'));
                            return $pdf->download($id.'.legalsforum.pdf');
                        }

                         //Display Pdf View for Expanded view
                        public function post_1992_legislation_pdf_regulation_expanded($id, $title, $group){
                            $regulationtitle              = RegulationTitle::find(
                                [
                                    'id' => $id,
                                    'group' => $group
                                ])->toArray()[0];
                                
                            $ActsRegulationArticles1            = RegulationArticle::where(['regulation_title' => $title])->get();
                            $unique                     = $ActsRegulationArticles1->unique()->sortBy('part')->sortBy('priority'); 
                            $ActsRegulationArticles         = $unique;
                            $pdf = PDF::loadView('post_1992_legislation.displayed_regulation_pdfView', compact('regulationtitle','ActsRegulationArticles'));
                            return $pdf->download($title.'.legalsforum.pdf');
                        }

                       


     //ACTS OF PARLIAMENT FILTERING
     public function acts_of_parliament_filter($year, $category){

        $name = "Acts of Parliament";
        $bool = false;
        $where = array();

        if($year != "0"){   
           $where['year'] = $year;
           $bool = true;
       }
       if($category != "0"){   
           $where['post_category'] = $category;
           $bool = true;
       }

        $actsOfParliaments       = ($bool)?Post1992Act::where($where)->where(['post_group' => $name])->get():Post1992Act::all();
        $actsOfParliamentCategories   = Post1992Category::all();
        return view('post_1992_legislation.displayed_acts_of_parliament_view', compact('actsOfParliaments', 'actsOfParliamentCategories'));
    }

    //------------------------------------------------------------------------------------------------------------------------------

                                                                // FOR  ACTS AMENDMENTS

    //NEW DISPLAY OF AMENDMENTS UNDER ALL POST-LEGISLATION--------------------------------------------------------------------------
    //Amendment Act Table of Content
    public function amended_acts_display_table_of_content($id, $title, $category){
        $amendedAct             = AmendedTitle::find(
            [
                'id' => $id,
                'post_category' => $category
            ])->toArray()[0];

        $allAmendedArticles1      = AmendedArticle::where(['act_title' => $title])->get();
        $unique               = $allAmendedArticles1->sortBy('part')->sortBy('priority');
        $allAmendedArticles   = $unique;
        $footer_notes           = FooterNote::all();

        $allAmendments     = AmendedTitle::all();

        
        return view('post_1992_legislation.new_amended_table_of_content_view', compact('footer_notes','amendedAct', 'allAmendedArticles','allAmendments'));
        // return view('post_1992_legislation.displayed_amended_table_of_content_view', compact('footer_notes','amendedAct', 'allAmendedArticles'));
    }

    //Amendment Act Preamble
    public function amended_acts_preamble($id){
        $amendedAct = AmendedTitle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_amended_preamble', compact('amendedAct'));
    }


    //Amendment Act Content
    public function amended_acts_content($id){
        $amendedAct = AmendedArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_amended_content', compact('amendedAct'));
    }
    
    //Amendment Act Expanded-View
    public function amended_act_expanded_view($id, $title, $category){
        $amendedAct                 = AmendedTitle::find(
            [
                'id' => $id,
                'post_category' =>$category
            ])->toArray()[0];

        $allAmendedArticles1        = AmendedArticle::where(['act_title' => $title])->get();
        $unique                     = $allAmendedArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allAmendedArticles         = $unique;
        return view('post_1992_legislation.displayed_amended_act_expanded_view', compact('amendedAct','allAmendedArticles'));
    }

    //FOR AMENDMENTS TAB ONLY
    //Display all Amended Acts only 

    public function only_amendments_acts_tab(){
        $allAmendments         = AmendedTitle::all();
        $allAmendmentsForRegulations = AmendRegulationAct::all();
        $footer_notes           = FooterNote::all();
        // $allPost1992ategories   = Post1992Category::all();
        return view('post_1992_legislation.new_all_amendments_only', compact('footer_notes','allAmendments', 'allAmendmentsForRegulations'));
        // return view('post_1992_legislation.displayed_all_amendments_only', compact('footer_notes','allAmendments', 'allAmendmentsForRegulations'));
    }

    //-------------------------REGULATION AMENDMENTS--------------------------------------------
    //Display print section Content for preamble print
    public function post_1992_legislation_print_regulation_amends_act_preamble_content($id){
        $allregAmendment = AmendRegulationAct::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_print_regulation_amends_preamble_content_view', compact('allregAmendment'));
    }

    //Display print section Content for section print
    public function post_1992_legislation_print_regulation_amends_act_content_section($id){
        $allregAmendment = AmendRegulationArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_print_regulation_amends_content_view', compact('allregAmendment'));
    }

    //Display Print View for Expanded view
    public function post_1992_legislation_print_expanded_regulation_amended_act_content($id, $title, $category){
        // dd($id, $title, $category);
        $allregAmendment              = AmendRegulationAct::find(
            [
                'id' => $id,
                'act_category' => $category
            ])->toArray()[0];
            
        $allRegAmendmentArticles1            = AmendRegulationArticle::where(['title' => $title])->get();
        $unique                     = $allRegAmendmentArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allRegAmendmentArticles         = $unique;
        return view('post_1992_legislation.displayed_regulation_amends_expanded_printView', compact('allregAmendment','allRegAmendmentArticles'));
    }

    //Display Plain Content for preamble
    public function post_1992_legislation_plain_regulation_amends_act_preamble_content($id){
        $allregAmendment = AmendRegulationAct::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_plain_regulation_amends_preamble_content_view', compact('allregAmendment'));
    }

    //Display Plain Content for section
    public function post_1992_legislation_plain_regulation_amends_act_content_section($id){
        $allregAmendment = AmendRegulationArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_plain_regulation_amends_content_view', compact('allregAmendment'));
    }

    //Display Plain-View
    public function post_1992_legislation_plain_expanded_regulation_amended_act_content($id, $title, $category){
        $allregAmendment              = AmendRegulationAct::find(
            [
                'id' => $id,
                'act_category' => $category
            ])->toArray()[0];
            
        $allregAmendments1            = AmendRegulationArticle::where(['title' => $title])->get();
        $unique                     = $allregAmendments1->unique()->sortBy('part')->sortBy('priority'); 
        $allregAmendments         = $unique;
        return view('post_1992_legislation.displayed_regulation_amends_expanded_plainView', compact('allregAmendment','allregAmendments'));
    }

     //Display Pdf View for preamble Content view
     public function post_1992_legislation_pdf_regulation_amends_act_preamble_content($id, $title){
        // dd($id);
        $allregAmendment              = AmendRegulationAct::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_regulation_amends_preamble_content_view', compact('allregAmendment'));
        return $pdf->download($id.'.preamble.pdf');
    }

     //Display Pdf View for section Content view
     public function post_1992_legislation_pdf_regulation_amends_act_content_section($id, $title){
        // dd($id);
        $allregAmendment              = AmendRegulationArticle::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_regulation_amends_content_view', compact('allregAmendment'));
        return $pdf->download($id.'.legalsforum.pdf');
    }

    //Display Pdf View for Expanded view
    public function post_1992_legislation_pdf_expanded_regulation_amended_act_content($id, $title, $category){
        $allAmendment              = AmendRegulationAct::find(
            [
                'id' => $id,
                'act_category' => $category
            ])->toArray()[0];
            
        $allAmendedArticles1            = AmendRegulationArticle::where(['title' => $title])->get();
        $unique                     = $allAmendedArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allAmendedArticles         = $unique;
        $pdf = PDF::loadView('post_1992_legislation.displayed_regulation_amends_expanded_pdfView', compact('allAmendment','allAmendedArticles'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

    //---------------------------ACTS AMENDMENTS-------------------------------------------------
     //Display print section Content for preamble print
     public function post_1992_legislation_print_amended_act_preamble_content($id){
        $allAmendment = AmendedTitle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_print_amendments_preamble_content_view', compact('allAmendment'));
    }

    //Display print section Content for section print
    public function post_1992_legislation_print_amended_act_content_section($id){
        $allAmendment = AmendedArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_print_amendments_content_view', compact('allAmendment'));
    }

     //Display Print View for Expanded view
     public function post_1992_legislation_print_expanded_amended_act_content($id, $title, $category){
        // dd($id, $title, $category);
        $allAmendment              = AmendedTitle::find(
            [
                'id' => $id,
                'post_category' => $category
            ])->toArray()[0];
            
        $allAmendedArticles1            = AmendedArticle::where(['act_title' => $title])->get();
        $unique                     = $allAmendedArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allAmendedArticles         = $unique;
        return view('post_1992_legislation.displayed_expanded_printView', compact('allAmendment','allAmendedArticles'));
    }

    //Display Plain Content for preamble
    public function post_1992_legislation_plain_amended_act_preamble_content($id){
        $allAmendment = AmendedTitle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_plain_amendments_preamble_content_view', compact('allAmendment'));
    }

    //Display Plain Content for section
    public function post_1992_legislation_plain_amended_act_content_section($id){
        $allAmendment = AmendedArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_plain_amendments_content_view', compact('allAmendment'));
    }

    //Display Plain-View
    public function post_1992_legislation_plain_expanded_amended_act_content($id, $title, $category){
        $allAmendment              = AmendedTitle::find(
            [
                'id' => $id,
                'post_category' => $category
            ])->toArray()[0];
            
        $allAmendedArticles1            = AmendedArticle::where(['act_title' => $title])->get();
        $unique                     = $allAmendedArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allAmendedArticles         = $unique;
        return view('post_1992_legislation.displayed_expanded_plainView', compact('allAmendment','allAmendedArticles'));
    }

     //Display Pdf View for preamble Content view
     public function post_1992_legislation_pdf_amended_act_preamble_content($id, $title){
        // dd($id);
        $allAmendment              = AmendedTitle::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_amendments_preamble_content_view', compact('allAmendment'));
        return $pdf->download($id.'.preamble.pdf');
    }

     //Display Pdf View for section Content view
     public function post_1992_legislation_pdf_amended_act_content_section($id, $title){
        // dd($id);
        $allAmendment              = AmendedArticle::find(
            [
                'id' => $id,
                'post_act' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_amendments_content_view', compact('allAmendment'));
        return $pdf->download($id.'.legalsforum.pdf');
    }

    //Display Pdf View for Expanded view
    public function post_1992_legislation_pdf_expanded_amended_act_content($id, $title, $category){
        $allAmendment              = AmendedTitle::find(
            [
                'id' => $id,
                'post_category' => $category
            ])->toArray()[0];
            
        $allAmendedArticles1            = AmendedArticle::where(['act_title' => $title])->get();
        $unique                     = $allAmendedArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allAmendedArticles         = $unique;
        $pdf = PDF::loadView('post_1992_legislation.displayed_expanded_pdfView', compact('allAmendment','allAmendedArticles'));
        return $pdf->download($title.'.legalsforum.pdf');
    }

    //------------------------------------------------------------------------------------------------------------------------------

                                                                // FOR  REGULATIONS AMENDMENTS

    //NEW DISPLAY OF AMENDMENTS UNDER ALL POST-LEGISLATION--------------------------------------------------------------------------
    //Amendment Act Table of Content
    public function amended_regulation_display_table_of_content($id, $title, $category){
        $amendedRegulationAct             = AmendRegulationAct::find(
            [
                'id' => $id,
                'act_category' => $category
            ])->toArray()[0];

        $allAmendedRegulationArticles1      = AmendRegulationArticle::where(['title' => $title])->get();
        $unique               = $allAmendedRegulationArticles1->sortBy('part')->sortBy('priority');
        $allAmendedRegulationArticles   = $unique;
        $footer_notes           = FooterNote::all();

        return view('post_1992_legislation.displayed_amended_regulation_table_of_content_view', compact('footer_notes','amendedRegulationAct', 'allAmendedRegulationArticles'));
    }

     //Amendment Act Preamble
     public function amended_regulation_acts_preamble($id){
        $amendedRegulationAct = AmendRegulationAct::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_amended_regulation_preamble', compact('amendedRegulationAct'));
    }

    //Amendment Act Content
    public function amended_regulation_acts_content($id){
        $amendedRegulationArticle = AmendRegulationArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_amended_regulation_content', compact('amendedRegulationArticle'));
    }

    //Amendment Act Expanded-View
    public function amended_regulation_act_expanded_view($id, $title, $category){
        $amendedRegulationAct                 = AmendRegulationAct::find(
            [
                'id' => $id,
                'act_category' =>$category
            ])->toArray()[0];

        $allAmendedRegulationArticles1        = AmendRegulationArticle::where(['title' => $title])->get();
        $unique                               = $allAmendedRegulationArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allAmendedRegulationArticles         = $unique;
        return view('post_1992_legislation.displayed_amended_regulation_act_expanded_view', compact('amendedRegulationAct','allAmendedRegulationArticles'));
    }


    //---------------------------------------------------------------------------------------------------------------------------


                                                                //FOR REGULATION
    //---------------------------------------------------------------------------------------------------------------------------
    //NEW DISPLAY OF REGULATIONS UNDER ALL POST-LEGISLATION
    //Regulation Act Table of Content
    public function regulation_acts_display_table_of_content($id, $title, $group){
        $regulationAct             = RegulationTitle::find(
            [
                'id' => $id,
                'group' => $group
            ])->toArray()[0];

        $allRegulationArticles1      = RegulationArticle::where(['regulation_title' => $title])->get();
        $unique                      = $allRegulationArticles1->sortBy('part')->sortBy('priority');
        $allRegulationArticles       = $unique;

        $allRegulations             = RegulationTitle::all();

        //All Amendments on Regulation
        $amendedregulationcount             = AmendRegulationAct::where(['regulation_title' => "$title"])->count();
        $footer_notes           = FooterNote::all();
        
        return view('post_1992_legislation.new_regulation_table_of_content', compact('footer_notes','allRegulations','regulationAct', 'allRegulationArticles', 'amendedregulationcount'));
        // return view('post_1992_legislation.displayed_regulation_table_of_content_view', compact('footer_notes','regulationAct', 'allRegulationArticles', 'amendedregulationcount'));
    }

    //Display print section Content for preamble print
    public function post_1992_legislation_print_regulation_preamble($id){
        $regulationAct = RegulationTitle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_regulation_print_preamble_content_view', compact('regulationAct'));
    }

    //Display print section Content for section print
    public function post_1992_legislation_print_regulation_content_section($id){
        $regulationAct = RegulationArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_regulation_print_content_view', compact('regulationAct'));
    }

    //Display Plain Content for preamble
    public function post_1992_legislation_plain_regulation_preamble($id){
        $regulationAct = RegulationTitle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_regulation_plain_preamble_content_view', compact('regulationAct'));
    }

     //Display Plain Content for section
     public function post_1992_legislation_plain_regulation_content_section($id){
        $regulationAct = RegulationArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_regulation_plain_content_view', compact('regulationAct'));
    }

    //Display Pdf View for preamble Content view
    public function post_1992_legislation_pdf_regulation_preamble($id, $title){
        // dd($id);
        $regulationAct              = RegulationTitle::find(
            [
                'id' => $id,
                'title' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_regulation_pdf_preamble_content_view', compact('regulationAct'));
        return $pdf->download($id.'.preamble.pdf');
    }

    //Display Pdf View for section Content view
    public function post_1992_legislation_pdf_regulation_content_section($id, $title){
        // dd($id);
        $regulationAct              = RegulationArticle::find(
            [
                'id' => $id,
                'post_act' => $title
            ])->toArray()[0];
        $pdf = PDF::loadView('post_1992_legislation.displayed_regulation_pdf_content_view', compact('regulationAct'));
        return $pdf->download($id.'.legalsforum.pdf');
    }

    //Regulation Act Preamble
    public function regulation_acts_preamble($id){
        $regulationAct = RegulationTitle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_regulation_preamble', compact('regulationAct'));
    }

    //Regulation Act Content
    public function regulation_acts_content($id){
        $regulationAct = RegulationArticle::find(['id' => $id])->toArray()[0];
        return view('post_1992_legislation.displayed_regulation_act_content', compact('regulationAct'));
    }

    //Regulation Act Expanded-View
    public function regulation_act_expanded_view($id, $title, $category){
        $regulationAct                 = RegulationTitle::find(
            [
                'id' => $id,
                'act_category' =>$category
            ])->toArray()[0];

        $allRegulationArticles1        = RegulationArticle::where(['regulation_title' => $title])->get();
        $unique                     = $allRegulationArticles1->unique()->sortBy('part')->sortBy('priority'); 
        $allRegulationArticles         = $unique;
        return view('post_1992_legislation.displayed_regulation_act_expanded_view', compact('regulationAct','allRegulationArticles'));
    }

    //FOR REGULATION TAB ONLY
    //Display all Regulation Acts only 

    public function only_regulations_acts_tab(){
        $allRegulations         = RegulationTitle::all();
        $footer_notes           = FooterNote::all();
        // $allPost1992ategories   = Post1992Category::all();
        // return view('post_1992_legislation.displayed_all_regulations_only', compact('footer_notes','allRegulations'));
        return view('post_1992_legislation.new_all_regulations_only', compact('footer_notes','allRegulations'));
    }

                    //-----------------------------------------------DISPLAY AMENDMENTS UNDER A REGULATIOIN---------------------------------
                    //----------------------------------------------------------------------------------------------------------------------
                    //Display All amendments under a regulation
                    public function all_amendedments_for_a_regulation($id, $title, $category){
                        $allRegulation              = RegulationTitle::find(
                            [
                                'id' => $id,
                                'act_category' => $category
                            ])->toArray()[0];

                        $amendedRegulationActs      = AmendRegulationAct::where(['regulation_title' => $title])->get();

                        return view('post_1992_legislation.displayed_all_amended_regulation_titles', compact('allRegulation','amendedRegulationActs'));
                    }

                    // //Display Amended Regulation Act table of content
                    public function amended_regulation_act_table_of_content($id, $title, $category){
                        $amendedRegulationAct             = AmendRegulationAct::find(
                            [
                                'id' => $id,
                                'act_category' => $category
                            ])->toArray()[0];

                        $amendedRegulationContents1       = AmendRegulationArticle::where(['title' => $title])->get();  
                        $unique                 = $amendedRegulationContents1->sortBy('part')->sortBy('priority');
                        $amendedRegulationContents        = $unique;
                        return view('post_1992_legislation.displayed_amended_regulation_act_table_of_content', compact('amendedRegulationAct','amendedRegulationContents'));
                    }

                    //Display Amended Regulation section container
                    public function display_amended_regulation_sections_container($title){
                        $amendedRegulationContents1       = AmendRegulationArticle::where(['title' => $title])->get();
                        $unique                 = $amendedRegulationContents1->sortBy('part')->sortBy('priority');
                        $amendedRegulationContents        = $unique;
                        return view('post_1992_legislation.displayed_amended_regulation_sections_container', compact('amendedRegulationContents'));
                    }

                    //Display Amended Regulation Act content
                    public function amended_act_regulation_content($id){
                        $amendedRegulationContent = AmendRegulationArticle::find(['id' => $id])->toArray()[0];
                        return view('post_1992_legislation.displayed_amended_regulation_act_content', compact('amendedRegulationContent'));
                    }

                    //Display Amended Act preamble
                    public function amended_regulation_act_preamble($id){
                        $amendedRegulationPreamble = AmendRegulationAct::find(['id' => $id])->toArray()[0];
                        return view('post_1992_legislation.displayed_amended_regulation_act_preamble', compact('amendedRegulationPreamble'));
                    }

                    //Display print section Content for amended preamble print
                    public function post_1992_legislation_print_amended_regulation_act_preamble_content($id){
                        $amendedRegulationPreamble = AmendRegulationAct::find(['id' => $id])->toArray()[0];
                        return view('post_1992_legislation.displayed_print_amended_regulation_preamble_content_view', compact('amendedRegulationPreamble'));
                    }

                    //Display print section Content for amended section print
                    public function post_1992_legislation_print_amended_regulation_act_content_section($id){
                        $amendedRegulationContent = AmendRegulationArticle::find(['id' => $id])->toArray()[0];
                        return view('post_1992_legislation.displayed_print_amended_regulation_content_view', compact('amendedRegulationContent'));
                    }

                    //Display Plain Content for amended preamble
                    public function post_1992_legislation_plain_amended_regulation_act_preamble_content($id){
                        $amendedRegulationPreamble = AmendRegulationAct::find(['id' => $id])->toArray()[0];
                        return view('post_1992_legislation.displayed_plain_amended_regulation_preamble_content_view', compact('amendedRegulationPreamble'));
                    }

                     //Display Plain Content for section
                     public function post_1992_legislation_plain_amended_regulation_act_content_section($id){
                        $amendedRegulationContent = AmendRegulationArticle::find(['id' => $id])->toArray()[0];
                        return view('post_1992_legislation.displayed_plain_amended_regulation_content_view', compact('amendedRegulationContent'));
                    }

                    //Display Pdf View for preamble Content view
                    public function post_1992_legislation_pdf_amended_regulation_act_preamble_content($id, $title){
                        // dd($id, $title);
                        $amendedRegulationPreamble              = AmendRegulationAct::find(
                            [
                                'id' => $id,
                                'title' => $title
                            ])->toArray()[0];
                        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_amended_regulation_preamble_content_view', compact('amendedRegulationPreamble'));
                        return $pdf->download($id.'.preamble.pdf');
                    }

                    //Display Pdf View for section Content view
                    public function post_1992_legislation_pdf_amended_regulation_act_content_section($id, $title){
                        // dd($id, $title);
                        $amendedRegulationContent              = AmendRegulationArticle::find(
                            [
                                'id' => $id,
                                'title' => $title
                            ])->toArray()[0];
                        $pdf = PDF::loadView('post_1992_legislation.displayed_pdf_amended_regulation_content_view', compact('amendedRegulationContent'));
                        return $pdf->download($id.'.legalsforum.pdf');
                    }
    //-----------------------------------------------------------------------------------------------------------------------------------------
    
    /**
     * AJAX endpoint: Return JSON data for a given post-1992 tab group.
     * Used for client-side tab switching without page refresh.
     */
    public function post1992_ajax_data(Request $request)
    {
        $group = $request->query('group', 'all');

        $data = collect();

        if ($group === 'all' || $group === 'acts_of_parliament') {
            $acts = Post1992Act::all();
            $data = $data->concat($acts->map(function ($act) {
                return [
                    'title' => $act->title,
                    'year'  => $act->year,
                    'url'   => '/post-1992-legislation/table-of-content/' . $act->post_group . '/' . $act->title . '/' . $act->id,
                ];
            }));
        }

        if ($group === 'all' || $group === 'constitutional_instruments') {
            $acts = ConstitutionalAct::all();
            $data = $data->concat($acts->map(function ($act) {
                return [
                    'title' => $act->title,
                    'year'  => $act->year,
                    'url'   => '/post-1992-legislation/constitutional-acts-table-of-content/' . $act->constitutional_group . '/' . $act->title . '/' . $act->id,
                ];
            }));
        }

        if ($group === 'all' || $group === 'executive_instruments') {
            $acts = ExecutiveAct::all();
            $data = $data->concat($acts->map(function ($act) {
                return [
                    'title' => $act->title,
                    'year'  => $act->year,
                    'url'   => '/post-1992-legislation/table-of-content/' . $act->executive_group . '/' . $act->title . '/' . $act->id,
                ];
            }));
        }

        if ($group === 'all' || $group === 'legislative_instruments') {
            $acts = RegulationTitle::all();
            $data = $data->concat($acts->map(function ($act) {
                return [
                    'title' => $act->title,
                    'year'  => $act->year,
                    'url'   => '/post_1992_legislation/regulation_acts_table_of_content/' . $act->act_category . '/' . $act->title . '/' . $act->id,
                ];
            }));
        }

        if ($group === 'all' || $group === 'amendments') {
            // Amendments on Acts
            $acts = AmendedTitle::all();
            $data = $data->concat($acts->map(function ($act) {
                return [
                    'title' => $act->title,
                    'year'  => $act->year,
                    'url'   => '/post_1992_legislation/amended_acts_table_of_content/' . $act->post_category . '/' . $act->title . '/' . $act->id,
                ];
            }));

            // Amendments on Regulations
            $acts = AmendRegulationAct::all();
            $data = $data->concat($acts->map(function ($act) {
                return [
                    'title' => $act->title,
                    'year'  => $act->year,
                    'url'   => '/post_1992_legislation/amended_regulation_acts_table_of_content/' . $act->act_category . '/' . $act->title . '/' . $act->id,
                ];
            }));
        }

        // Sort by title alphabetically
        $sortedData = $data->sortBy('title')->values();

        return response()->json(['data' => $sortedData]);
    }
}