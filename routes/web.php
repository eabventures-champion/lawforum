<?php

use Illuminate\Support\Facades\URL;

//Route::get('/customer/print-pdf', [ 'as' => 'customer.printpdf, 'uses' => 'CustomerController@printPDF']);
//<a href="{{route('customer.printpdf')}}">Print PDF</a>

if (env('APP_ENV') === 'production') {
    URL::forceScheme('https');
}

//WELCOME PAGE
Route::get('/','WelcomePageController@index');

// GATEWAY PAGE (Get Started / Role Selection)
Route::get('/get-started', function (\Illuminate\Http\Request $request) {
    $redirectTo = $request->query('redirect_to')
        ?: $request->query('redirect')
        ?: session('url.intended');

    if (!$redirectTo && url()->previous() && url()->previous() !== url()->current()) {
        $prev = url()->previous();
        if (!\Illuminate\Support\Str::contains($prev, ['get-started', 'set-guest-access', 'login', 'register'])) {
            $redirectTo = $prev;
        }
    }

    // If user is already authenticated, redirect to intended or home
    if (auth()->check()) {
        return redirect($redirectTo ?: '/');
    }
    // If guest already has access cookie, redirect to intended or home
    if ($request->cookie('guest_access')) {
        return redirect($redirectTo ?: '/');
    }

    if ($redirectTo && !session()->has('url.intended')) {
        session(['url.intended' => $redirectTo]);
    }

    return view('get-started', ['redirectTo' => $redirectTo]);
})->name('get-started');

Route::post('/set-guest-access', function (\Illuminate\Http\Request $request) {
    $redirectTo = $request->input('redirect_to')
        ?: session()->pull('url.intended')
        ?: $request->query('redirect_to')
        ?: $request->query('redirect');

    if (!$redirectTo && url()->previous() && url()->previous() !== url()->current()) {
        $prev = url()->previous();
        if (!\Illuminate\Support\Str::contains($prev, ['get-started', 'set-guest-access', 'login', 'register'])) {
            $redirectTo = $prev;
        }
    }

    if (!$redirectTo || \Illuminate\Support\Str::contains($redirectTo, ['get-started', 'set-guest-access', 'login', 'register'])) {
        $redirectTo = '/';
    }

    return redirect($redirectTo)->withCookie(cookie('guest_access', '1', 60 * 24 * 30)); // 30 days
})->name('set-guest-access');

//----------------------------------------------------------------------------DASHBOARD------------------------------------------------------------------------------------------------------------
Route::get('/accounts/dashboard','UserDashBoardController@dashboard');

//testing
Route::get('/accounts/dashboardsss','UserDashBoardController@dashboard');

//-------------------------------------------------------PROFILE-------------------------------------
Route::get('/accounts/profile/{user_id}',  ['as' => 'users.edit', 'uses' => 'ProfileController@edit']);
// Route::get('/accounts/profile/{user_id}','UserDashBoardController@show_user_profile'); //Bookmarks page.........shows all list of bookmarks
Route::patch('profile/{user}/update',  ['as' => 'users.update', 'uses' => 'ProfileController@update']);

//------------------------------------------------------MANAGE ACCOUNTS-------------------------------------
Route::get('/accounts/manage-password', 'ChangePasswordController@index');
Route::post('/accounts/manage-password', 'ChangePasswordController@store')->name('change.password');

// -----------------------------------------------------BOOKMARKS-------------------------------------
Route::post('/bookmarks/toggle', 'UserDashBoardController@toggle_bookmark')->name('bookmarks.toggle');
Route::get('/bookmarks/check', 'UserDashBoardController@check_bookmarks')->name('bookmarks.check');
Route::get('/bookmarks/content/{id}', 'UserDashBoardController@get_bookmark_content')->name('bookmarks.content');
Route::delete('/bookmarks/{id}', 'UserDashBoardController@destroy_bookmark')->name('bookmarks.destroy');
Route::get('/accounts/bookmarks/{user_id}', 'UserDashBoardController@show_user_bookmarks')->name('accounts.bookmarks');

// -----------------------------------------------------DOWNLOADS-------------------------------------
Route::get('/section_downloads/{act}/{sections}/{section_id}/{user_name}/{user_id}/{user_section}/{group}/{act_id}','DownloadsController@save_download_section'); //To Download from section
Route::get('/acts-downloads/{act_title}/{user_name}/{user_id}/{act_group}/{act_id}/{user_title}','DownloadsController@save_download_act'); //To Download from section
Route::get('/accounts/downloads/{user_id}','DownloadsController@show_user_downloads'); //Download page.........shows all list of downloads
Route::resource('/downloads', 'DownloadsController'); //To delete a record of bookmark

// -----------------------------------------------------NOTES-------------------------------------
Route::post('/notes/save','UserDashBoardController@save_note'); //AJAX save note
Route::post('/notes','UserDashBoardController@save_note'); //AJAX save note alias
Route::get('/notes/document','UserDashBoardController@get_document_notes'); //AJAX get notes for current document
Route::get('/notes/content/{id}','UserDashBoardController@get_note_content')->name('notes.content');
Route::get('/accounts/notes/{user_id}','UserDashBoardController@show_user_notes'); //Dashboard notes page
Route::patch('/notes/{id}','UserDashBoardController@update_note'); //AJAX update note
Route::delete('/notes/{id}','UserDashBoardController@delete_note'); //AJAX delete note
Route::get('/notes/download-all/pdf','UserDashBoardController@download_all_notes_pdf')->name('notes.download_all.pdf');
Route::get('/notes/download-all/word','UserDashBoardController@download_all_notes_word')->name('notes.download_all.word');
Route::get('/notes/{id}/download/pdf','UserDashBoardController@download_note_pdf')->name('notes.download.pdf');
Route::get('/notes/{id}/download/word','UserDashBoardController@download_note_word')->name('notes.download.word');

//-------------------------------------------------------SUBSCRIPTION-------------------------------------
Route::get('/subscription','UserDashBoardController@subscription_index');
// Route::get('/process/subscription/{subscription}/check/{user_id}', 'UserDashBoardController@process')->name('process');
Route::get('/process/{subscription}', 'UserDashBoardController@process')->name('process');
Route::get('/accounts/subscription/{subscription}','UserDashBoardController@show_user_subscriptions');

//---------------------------------------------------------------------------END OF DASHBOARD---------------------------------------------------------------------------------------------------

//---------------------------------------------------------------------------SEARCH ENGINE------------------------------------------------------------------------------------------------------
//Search for Main Home Page
Route::get('main_home_search','HomeSearchController@main_home_search');
Route::get('search-history','HomeSearchController@searchHistory');
Route::get('search-autocomplete','HomeSearchController@autocomplete');
Route::delete('search-history/{id}','HomeSearchController@deleteSearchHistory');
Route::delete('search-history','HomeSearchController@clearSearchHistory');

//Search for Constitution
Route::get('search_ghana_constitution','ConstitutionGhanaSearchController@index_search');//for ghana
Route::get('search_ghana_amended_constitution','ConstitutionGhanaAmendedSearchController@index_search_amendment');//for ghana_amended
Route::get('all_constitution_index_search','ConstitutionCountriesSearchController@countries_index_search');//for countries
Route::get('africa_constitution_index_search','ConstitutionCountriesSearchController@africa_index_search');//for ghana
Route::get('asia_constitution_index_search','ConstitutionCountriesSearchController@asia_index_search');//for ghana
Route::get('europe_constitution_index_search','ConstitutionCountriesSearchController@europe_index_search');//for ghana
Route::get('north_america_constitution_index_search','ConstitutionCountriesSearchController@north_america_index_search');//for ghana
Route::get('south_america_constitution_index_search','ConstitutionCountriesSearchController@south_america_index_search');//for ghana

//Search for the Pre 4th Republic
Route::get('pre_4th_index_search','PreSearchController@pre_index_search');
Route::get('first_republic_index_search','PreSearchController@first_rep_index_search');
Route::get('second_republic_index_search','PreSearchController@second_rep_index_search');
Route::get('third_republic_index_search','PreSearchController@third_rep_index_search');
Route::get('nlc_decree_index_search','PreSearchController@nlc_decree_index_search');
Route::get('nrc_decree_index_search','PreSearchController@nrc_decree_index_search');
Route::get('smc_decree_index_search','PreSearchController@smc_decree_index_search');
Route::get('afrc_decree_index_search','PreSearchController@afrc_decree_index_search');
Route::get('pndc_law_index_search','PreSearchController@pndc_law_index_search');


//Search for 4th Republic
Route::get('post_index_search','PostSearchController@all_posts_search');//main search at the top
Route::get('acts_of_parliament_index_search','PostSearchController@only_acts_of_parliament_search');//main search at the top
Route::get('only_regulations_index_search','PostSearchController@only_regulations_index_search');//main search at the top
Route::get('constitutional_instruments_index_search','PostSearchController@only_constitutional_intruments_search');//main search at the top
Route::get('executive_instruments_index_search','PostSearchController@only_executive_intruments_search');//main search at the top

Route::get('only_amendments_index_search','PostSearchController@only_amendments_index_search');//main search at the top

Route::get('/acts-of-parliament-act-search/{title}/{id}','PostSearchController@acts_of_parliament_act_search');//search within an act
Route::get('/constitutional-instrument-act-search/{title}/{id}','PostSearchController@constitutional_instruments_act_search');//search within an act
Route::get('/executive-instrument-act-search/{title}/{id}','PostSearchController@executive_instruments_act_search');//search within an act

Route::get('/Search/Next/{query}/fetch_data','PostSearchController@acts_ajax_display');//pagination

//Search for Case Laws
Route::get('cases_index_search','CasesSearchController@cases_index_search');
Route::get('supreme_court_index_search','CasesSearchController@supreme_court_index_search');
Route::get('court_of_appeal_index_search','CasesSearchController@court_of_appeal_index_search');
Route::get('high_court_index_search','CasesSearchController@high_court_index_search');

//-------------------------------------------------------------------------------END OF SEARCH ENGINE-----------------------------------------------------------------------------------------------

// Route::get('/acts/search/{key}','SearchController@keyword_search');
Route::view('/scan', 'scan');


//-------------------------------------------------------------------------------CONSTITUTION-----------------------------------------------------------------------------------------------
    //All Countries Constitution
    Route::get('/constitution/all_countries','ConstitutionController@all_countries_constitution');//display all countries constitution
    Route::get('/constitution/ajax-data','ConstitutionController@constitution_ajax_data'); //AJAX JSON data for tab switching
        Route::get('/constitution/filter/{year}/{country}','ConstitutionController@all_countries_constitution_filter'); //all constitution filtering
        Route::get('/constitution/1/{continent}/{country}/{id}','ConstitutionController@display_country_constitution');
        Route::get('/constitution/print/content/{id}','ConstitutionController@print_constitution_content');//display plain act content
        Route::get('/constitution/plain/content/{id}','ConstitutionController@plain_constitution_content');//display plain act content
        Route::get('/constitution/pdf/content/{title}/{id}','ConstitutionController@pdf_constitution_content');//display plain act content


        //AFRICA
        Route::get('/constitution/all-countries/1/{continent}','ConstitutionController@africa_constitution');
            Route::get('/constitution/1/africa/filter/{year}/{country}','ConstitutionController@africa_constitution_filter'); //africa filtering

        //ASIA
        Route::get('/constitution/all-countries/2/{continent}','ConstitutionController@asia_constitution');
            Route::get('/constitution/2/asia/filter/{year}/{country}','ConstitutionController@asia_constitution_filter'); //asia filtering

        //EUROPE
        Route::get('/constitution/all-countries/3/{continent}','ConstitutionController@europe_constitution');
            Route::get('/constitution/3/europe/filter/{year}/{country}','ConstitutionController@europe_constitution_filter'); //europe filtering

        //NORTH AMERICA
        Route::get('/constitution/all-countries/4/{continent}','ConstitutionController@north_america_constitution');
            Route::get('/constitution/4/north_america/filter/{year}/{country}','ConstitutionController@north_america_constitution_filter'); //north-america filtering

        //SOUTH AMERICA
        Route::get('/constitution/all-countries/5/{continent}','ConstitutionController@south_america_constitution');
            Route::get('/constitution/5/south_america/filter/{year}/{country}','ConstitutionController@south_america_constitution_filter'); //south-america filtering

    // Ghana Constitution
    Route::get('/constitution/Republic/Ghana/{id}', 'ConstitutionController@ghana_constitution_table');
        Route::get('/constitution/Republic/constitution_preamble/{id}','ConstitutionController@ghana_constitution_preamble');
        Route::get('/constitution/Republic/constitution_content/{id}','ConstitutionController@ghana_constitution_content');
        Route::get('/constitution/Republic/plain_content/{id}','ConstitutionController@ghana_constitution_content_plain_view');
        Route::get('/constitution/Republic/expanded_view/{id}','ConstitutionController@ghana_expanded_view');
        Route::get('/constitution/Republic/plain_view/{id}','ConstitutionController@ghana_plain_view');

        Route::get('/constitution/Republic/print_preamble_content/{id}','ConstitutionController@print_preamble_content');//display plain act content
        Route::get('/constitution/Republic/print_article_content/{id}','ConstitutionController@print_article_content');//display plain act content
        Route::get('/constitution/Republic/{group}/{title}/print_view/{id}','ConstitutionController@print_expanded_article_content');//display in print view

        Route::get('/constitution/Republic/plain_preamble_content/{id}','ConstitutionController@plain_preamble_content');//display plain act content
        Route::get('/constitution/Republic/plain_article_content/{id}','ConstitutionController@plain_article_content');//display plain act content
        Route::get('/constitution/Republic/{group}/{title}/plain_view/{id}','ConstitutionController@plain_expanded_article_content');//display in print view

        Route::get('/constitution/Republic/pdf_preamble_content/{title}/{id}','ConstitutionController@pdf_preamble_content');//display plain act content
        Route::get('/constitution/Republic/pdf_article_content/{title}/{id}','ConstitutionController@pdf_article_content');//display plain act content
        Route::get('/constitution/Republic/{group}/{title}/pdf_view/{id}','ConstitutionController@pdf_expanded_article_content');//display in print view


    // Ghana Constitution(Amended)
    Route::get('/constitution_amended/Republic/Ghana/{id}', 'ConstitutionController@ghana_constitution_table_amended');
    Route::get('/constitution_amended/Republic/constitution_preamble/{id}','ConstitutionController@ghana_constitution_preamble_amended');
    Route::get('/constitution_amended/Republic/constitution_content/{id}','ConstitutionController@ghana_constitution_content_amended');
    Route::get('/constitution_amended/Republic/expanded_view/{id}','ConstitutionController@ghana_expanded_view_amended');

        Route::get('/constitution_amended/Republic/print_preamble_content/{id}','ConstitutionController@print_preamble_content_amended');//display plain act content
        Route::get('/constitution_amended/Republic/print_article_content/{id}','ConstitutionController@print_article_content_amended');//display plain act content
        Route::get('/constitution_amended/Republic/print/expanded_content/{group}/{title}/{id}','ConstitutionController@print_expanded_article_content_amended');//display in print view


        Route::get('/constitution_amended/Republic/plain_preamble_content/{id}','ConstitutionController@plain_preamble_content_amended');//display plain act content
        Route::get('/constitution_amended/Republic/plain_article_content/{id}','ConstitutionController@plain_article_content_amended');//display plain act content
        Route::get('/constitution_amended/Republic/plain/expanded_content/{group}/{title}/{id}','ConstitutionController@plain_expanded_article_content_amended');//display in print view

        Route::get('/constitution_amended/Republic/pdf_preamble_content/{title}/{id}','ConstitutionController@pdf_preamble_content_amended');//display plain act content
        Route::get('/constitution_amended/Republic/pdf_article_content/{title}/{id}','ConstitutionController@pdf_article_content_amended');//display plain act content
        Route::get('/constitution_amended/Republic/pdf/expanded_content/{group}/{title}/{id}','ConstitutionController@pdf_expanded_article_content_amended');//display in print view

//------------------------------------------------------------------------------------END OF CONSTITUTION------------------------------------------------------------------------------------

//------------------------------------------------------------------------------------PRE_1992_LEGISLATION------------------------------------------------------------------------------------

Route::get('/existing-laws','Pre1992Controller@index');//display all acts
Route::get('/pre-1992-legislation', function() { return redirect('/existing-laws'); });
Route::get('/pre_1992_legislation/all_pre_1992_acts/{id}', function($id) {
    if ($id && $id > 0) {
        $act = \App\Pre1992LegislationAct::find($id);
        if ($act) {
            return redirect('/existing-laws/' . rawurlencode($act->pre_1992_group) . '/' . rawurlencode($act->title) . '/' . $act->id);
        }
    }
    return redirect('/existing-laws');
});

foreach (['existing-laws', 'existing-law', 'existing_laws', 'pre_1992_legislation'] as $prefix) {
    Route::get('/'.$prefix.'/ajax-data','Pre1992Controller@pre1992_ajax_data');
    Route::get('/'.$prefix.'/filter/{year}/{category}','Pre1992Controller@all_pre_1992_legislation_filter');
    Route::get('/'.$prefix.'/{group}/{title}/{id}','Pre1992Controller@pre_1992_legislation_table_of_content');
    Route::get('/'.$prefix.'/preamble/{id}','Pre1992Controller@pre_1992_legislation_preamble');
    Route::get('/'.$prefix.'/content/{id}','Pre1992Controller@pre_1992_legislation_content');
    Route::get('/'.$prefix.'/1/{group}/{title}/expanded-view/{id}','Pre1992Controller@expanded_view');

    Route::get('/'.$prefix.'/print_preamble_content/{id}','Pre1992Controller@pre_1992_legislation_print_preamble_content');
    Route::get('/'.$prefix.'/print_section_content/{id}','Pre1992Controller@pre_1992_legislation_print_content');
    Route::get('/'.$prefix.'/1/{group}/{title}/print_view/{id}','Pre1992Controller@pre_1992_legislation_print_expanded_content');

    Route::get('/'.$prefix.'/plain_preamble_content/{id}','Pre1992Controller@pre_1992_legislation_plain_preamble_content');
    Route::get('/'.$prefix.'/plain/content/{title}/{id}','Pre1992Controller@pre_1992_legislation_plain_content');
    Route::get('/'.$prefix.'/1/{group}/{title}/plain_view/{id}','Pre1992Controller@pre_1992_legislation_plain_expanded_content');

    Route::get('/'.$prefix.'/pdf/preamble_content/{title}/{id}','Pre1992Controller@pre_1992_legislation_pdf_preamble_content');
    Route::get('/'.$prefix.'/pdf/content/{title}/{id}','Pre1992Controller@pre_1992_legislation_pdf_content');
    Route::get('/'.$prefix.'/1/{group}/{title}/pdf_view/{id}','Pre1992Controller@pre_1992_legislation_pdf_expanded_content');

    Route::get('/'.$prefix.'/1/{group}','Pre1992Controller@first_republic');
    Route::get('/'.$prefix.'/1/filter/{year}/{category}','Pre1992Controller@first_republic_filter');

    Route::get('/'.$prefix.'/2/{group}','Pre1992Controller@second_republic');
    Route::get('/'.$prefix.'/2/filter/{year}/{category}','Pre1992Controller@second_republic_filter');

    Route::get('/'.$prefix.'/3/{group}','Pre1992Controller@third_republic');
    Route::get('/'.$prefix.'/3/filter/{year}/{category}','Pre1992Controller@third_republic_filter');

    Route::get('/'.$prefix.'/4/{group}','Pre1992Controller@pndc_law');
    Route::get('/'.$prefix.'/4/filter/{year}/{category}','Pre1992Controller@pndc_law_filter');

    Route::get('/'.$prefix.'/5/{group}','Pre1992Controller@nlc_decree');
    Route::get('/'.$prefix.'/5/filter/{year}/{category}','Pre1992Controller@nlc_decree_filter');

    Route::get('/'.$prefix.'/6/{group}','Pre1992Controller@nrc_decree');
    Route::get('/'.$prefix.'/6/filter/{year}/{category}','Pre1992Controller@nrc_decree_filter');

    Route::get('/'.$prefix.'/7/{group}','Pre1992Controller@smc_decree');
    Route::get('/'.$prefix.'/7/filter/{year}/{category}','Pre1992Controller@smc_decree_filter');

    Route::get('/'.$prefix.'/8/{group}','Pre1992Controller@afrc_decree');
}
        // Route::get('/pre_1992_legislation/7/filter/{year}/{category}','Pre1992Controller@smc_decree_filter'); //smc filtering

//----------------------------------------------------------------------------END OF PRE-1992-LEGISLATION------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------CONSTITUTIONAL INSTRUMENTS-------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------NEW LAWS (POST 1992)-------------------------------------------------------------------------------------
Route::get('/new-laws','Post1992Controller@index');//display all acts
Route::get('/post-1992-legislation', function() { return redirect('/new-laws'); });
Route::get('/post_1992_legislation', function() { return redirect('/new-laws'); });

foreach (['new-laws', 'new_laws', 'new-law', 'post-1992-legislation', 'post_1992_legislation'] as $prefix) {
    // CONSTITUTIONAL INSTRUMENTS
    Route::get('/'.$prefix.'/Constitutional-Intruments','ConstitutionalActController@only_constitutional_acts');
    Route::get('/'.$prefix.'/constitutional-acts-table-of-content/{group}/{title}/{id}','ConstitutionalActController@table_of_content');
    Route::get('/'.$prefix.'/constitutional-acts/preamble/{id}','ConstitutionalActController@preamble_content');
    Route::get('/'.$prefix.'/constitutional-acts/content/{id}','ConstitutionalActController@section_content');
    Route::get('/'.$prefix.'/constitutional-acts/expanded-view/{group}/{title}/{id}','ConstitutionalActController@expanded_view');
    Route::get('/'.$prefix.'/constitutional-acts/plain-view-full-act-content/{group}/{title}/{id}','ConstitutionalActController@plain_view');
    Route::get('/'.$prefix.'/constitutional-acts/print_preamble_content/{id}','ConstitutionalActController@print_preamble_content');
    Route::get('/'.$prefix.'/constitutional-acts/print_section_content/{id}','ConstitutionalActController@print_content');
    Route::get('/'.$prefix.'/constitutional-acts/print_view/{group}/{title}/{id}','ConstitutionalActController@print_full_act');
    Route::get('/'.$prefix.'/constitutional-acts/pdf_preamble_content/{title}/{id}','ConstitutionalActController@pdf_preamble_content');
    Route::get('/'.$prefix.'/constitutional-acts/pdf-section-content/{title}/{id}','ConstitutionalActController@pdf_section_content');
    Route::get('/'.$prefix.'/constitutional-acts/pdf-full-act-content/{group}/{title}/{id}','ConstitutionalActController@pdf_full_act_content');

    // EXECUTIVE INSTRUMENTS
    Route::get('/'.$prefix.'/Executive-Intruments','ExecutiveActController@only_executive_acts');
    Route::get('/'.$prefix.'/executive-acts-table-of-content/{group}/{title}/{id}','ExecutiveActController@table_of_content');
    Route::get('/'.$prefix.'/executive-acts/preamble/{id}','ExecutiveActController@preamble_content');
    Route::get('/'.$prefix.'/executive-acts/content/{id}','ExecutiveActController@section_content');
    Route::get('/'.$prefix.'/executive-acts/expanded-view/{group}/{title}/{id}','ExecutiveActController@expanded_view');
    Route::get('/'.$prefix.'/executive-acts/plain-view-full-act-content/{group}/{title}/{id}','ExecutiveActController@plain_view');
    Route::get('/'.$prefix.'/executive-acts/print_preamble_content/{id}','ExecutiveActController@print_preamble_content');
    Route::get('/'.$prefix.'/executive-acts/print_section_content/{id}','ExecutiveActController@print_content');
    Route::get('/'.$prefix.'/executive-acts/print_view/{group}/{title}/{id}','ExecutiveActController@print_full_act');
    Route::get('/'.$prefix.'/executive-acts/pdf_preamble_content/{title}/{id}','ExecutiveActController@pdf_preamble_content');
    Route::get('/'.$prefix.'/executive-acts/pdf-section-content/{title}/{id}','ExecutiveActController@pdf_section_content');
    Route::get('/'.$prefix.'/executive-acts/pdf-full-act-content/{group}/{title}/{id}','ExecutiveActController@pdf_full_act_content');

Route::get('/post_1992_legislation/all_post_1992_acts/{id}', function($id) {
    if ($id && $id > 0) {
        $act = \App\Post1992Act::find($id);
        if ($act) {
            $group = !empty($act->post_group) ? $act->post_group : 'Acts of Parliament';
            return redirect('/new-laws/table-of-content/' . rawurlencode($group) . '/' . rawurlencode($act->title) . '/' . $act->id);
        }
    }
    return redirect('/all-new-laws/acts-of-parliament');
});

    // POST 1992 CORE
    Route::get('/'.$prefix.'/ajax-data','Post1992Controller@post1992_ajax_data');
    Route::get('/'.$prefix.'/filter/{year}/{category}','Post1992Controller@all_post_1992_legislation_filter');
    Route::get('/'.$prefix.'/preamble/{id}','Post1992Controller@post_1992_legislation_preamble');
    Route::get('/'.$prefix.'/content/{id}','Post1992Controller@post_1992_legislation_content');
    Route::get('/'.$prefix.'/plain-content/{id}','Post1992Controller@post_1992_legislation_p_pre_next_content');
    Route::get('/'.$prefix.'/plain-content/{title}/{content_id}','Post1992Controller@post_1992_legislation_plain_content');
    Route::get('/'.$prefix.'/plain_preamble_content/{id}','Post1992Controller@post_1992_legislation_plain_preamble_content');
    Route::get('/'.$prefix.'/1/{group}/{title}/expanded-view/{id}','Post1992Controller@expanded_view');
    Route::get('/'.$prefix.'/pdf-content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_content');
    Route::get('/'.$prefix.'/pdf_preamble_content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_preamble_content');
    Route::get('/'.$prefix.'/print_section_content/{id}','Post1992Controller@post_1992_legislation_print_content');
    Route::get('/'.$prefix.'/print_preamble_content/{id}','Post1992Controller@post_1992_legislation_print_preamble_content');
    Route::get('/'.$prefix.'/1/{group}/{title}/plain_view/{id}','Post1992Controller@plain_view');
    Route::get('/'.$prefix.'/1/{group}/{title}/pdf-view/{id}','Post1992Controller@pdf_view');
    Route::get('/'.$prefix.'/1/{group}/{title}/print_view/{id}','Post1992Controller@print_view');
    Route::get('/'.$prefix.'/table-of-content/{act_group}/{title}/{id}','Post1992Controller@post_1992_legislation_table_of_content');

    // ACTS OF PARLIAMENT
    Route::get('/'.$prefix.'/1/{group}','Post1992Controller@acts_of_parliament_tab');
    Route::get('/'.$prefix.'/1/filter/{year}/{category}','Post1992Controller@acts_of_parliament_filter');

    // AMENDMENTS
    Route::get('/'.$prefix.'/amended_acts_table_of_content/{category}/{title}/{id}','Post1992Controller@amended_acts_display_table_of_content');
    Route::get('/'.$prefix.'/amended_acts/preamble/{id}','Post1992Controller@amended_acts_preamble');
    Route::get('/'.$prefix.'/amended_acts/content/{id}','Post1992Controller@amended_acts_content');
    Route::get('/'.$prefix.'/amended_acts/expanded_view/{category}/{title}/{id}','Post1992Controller@amended_act_expanded_view');
    Route::get('/'.$prefix.'/only-amendments','Post1992Controller@only_amendments_acts_tab');

    Route::get('/'.$prefix.'/print_regulation_amends_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_print_regulation_amends_act_preamble_content');
    Route::get('/'.$prefix.'/print_regulation_amends_act/content_section/{id}','Post1992Controller@post_1992_legislation_print_regulation_amends_act_content_section');
    Route::get('/'.$prefix.'/print_expanded_regulation_amended_act/content/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_print_expanded_regulation_amended_act_content');

    Route::get('/'.$prefix.'/plain_regulation_amends_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_plain_regulation_amends_act_preamble_content');
    Route::get('/'.$prefix.'/plain_regulation_amends_act/content_section/{id}','Post1992Controller@post_1992_legislation_plain_regulation_amends_act_content_section');
    Route::get('/'.$prefix.'/plain_expanded_regulation_amended_act/content/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_plain_expanded_regulation_amended_act_content');

    Route::get('/'.$prefix.'/pdf/regulation_amends_act/preamble_content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_amends_act_preamble_content');
    Route::get('/'.$prefix.'/pdf/regulation_amends_act/content_section/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_amends_act_content_section');
    Route::get('/'.$prefix.'/pdf_expanded_regulation_amended_act/content/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_expanded_regulation_amended_act_content');

    Route::get('/'.$prefix.'/print_amended_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_print_amended_act_preamble_content');
    Route::get('/'.$prefix.'/print_amended_act/content_section/{id}','Post1992Controller@post_1992_legislation_print_amended_act_content_section');
    Route::get('/'.$prefix.'/print_expanded_amended_act/content/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_print_expanded_amended_act_content');

    Route::get('/'.$prefix.'/plain_amended_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_plain_amended_act_preamble_content');
    Route::get('/'.$prefix.'/plain_amended_act/content_section/{id}','Post1992Controller@post_1992_legislation_plain_amended_act_content_section');
    Route::get('/'.$prefix.'/plain_expanded_amended_act/content/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_plain_expanded_amended_act_content');

    Route::get('/'.$prefix.'/pdf/amended_act/preamble_content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_amended_act_preamble_content');
    Route::get('/'.$prefix.'/pdf/amended_act/content_section/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_amended_act_content_section');
    Route::get('/'.$prefix.'/pdf_expanded_amended_act/content/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_expanded_amended_act_content');

    // REGULATIONS
    Route::get('/'.$prefix.'/regulation_acts_table_of_content/{group}/{title}/{id}','Post1992Controller@regulation_acts_display_table_of_content');
    Route::get('/'.$prefix.'/regulation/preamble/{id}','Post1992Controller@regulation_acts_preamble');
    Route::get('/'.$prefix.'/regulation_act/content/{id}','Post1992Controller@regulation_acts_content');
    Route::get('/'.$prefix.'/regulation/expanded_view/{category}/{title}/{id}','Post1992Controller@regulation_act_expanded_view');
    Route::get('/'.$prefix.'/only-regulations','Post1992Controller@only_regulations_acts_tab');

    Route::get('/'.$prefix.'/print/regulation/preamble/{id}','Post1992Controller@post_1992_legislation_print_regulation_preamble');
    Route::get('/'.$prefix.'/print/regulation/content_section/{id}','Post1992Controller@post_1992_legislation_print_regulation_content_section');
    Route::get('/'.$prefix.'/print/regulation/expanded/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_print_regulation_expanded');

    Route::get('/'.$prefix.'/plain/regulation/preamble/{id}','Post1992Controller@post_1992_legislation_plain_regulation_preamble');
    Route::get('/'.$prefix.'/plain/regulation/content_section/{id}','Post1992Controller@post_1992_legislation_plain_regulation_content_section');
    Route::get('/'.$prefix.'/plain/regulation/expanded/{category}/{title}/{id}','Post1992Controller@post_1992_legislation_plain_regulation_expanded');

    Route::get('/'.$prefix.'/pdf/regulation/preamble/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_preamble');
    Route::get('/'.$prefix.'/pdf/regulation/content_section/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_content_section');
    Route::get('/'.$prefix.'/pdf/regulation/expanded/{group}/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_expanded');

    // AMENDMENTS UNDER AN ACT
    Route::get('/'.$prefix.'/{group}/all_amended_acts/{title}/{id}','Post1992Controller@all_amendedments_for_an_acts');
    Route::get('/'.$prefix.'/amended_act_table_of_content/{category}/{title}/{id}','Post1992Controller@amended_act_table_of_content');
    Route::get('/'.$prefix.'/amended_preamble/{id}','Post1992Controller@amended_act_preamble');
    Route::get('/'.$prefix.'/amended_act_content/{id}','Post1992Controller@amended_act_content');
    Route::get('/'.$prefix.'/display_amended_sections/{title}','Post1992Controller@display_amended_sections_container');
    Route::get('/'.$prefix.'/print_amended/preamble_content/{id}','Post1992Controller@post_1992_legislation_print_amended_preamble_content');
    Route::get('/'.$prefix.'/print_amended/content_section/{id}','Post1992Controller@post_1992_legislation_print_amended_content_section');
    Route::get('/'.$prefix.'/plain_amended/preamble_content/{id}','Post1992Controller@post_1992_legislation_plain_amended_preamble_content');
    Route::get('/'.$prefix.'/plain_amended/content_section/{id}','Post1992Controller@post_1992_legislation_plain_amended_content_section');
    Route::get('/'.$prefix.'/pdf/amended_preamble_content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_amended_preamble_content');
    Route::get('/'.$prefix.'/pdf/amended_content_section/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_amended_content_section');

    // AMENDMENTS UNDER A REGULATION
    Route::get('/'.$prefix.'/{category}/all_amended_regulation_acts/{title}/{id}','Post1992Controller@all_amendedments_for_a_regulation');
    Route::get('/'.$prefix.'/amended_regulation_act_table_of_content/{category}/{title}/{id}','Post1992Controller@amended_regulation_act_table_of_content');
    Route::get('/'.$prefix.'/amended_regulation_preamble/{id}','Post1992Controller@amended_regulation_act_preamble');
    Route::get('/'.$prefix.'/amended_act_regulation_content/{id}','Post1992Controller@amended_act_regulation_content');
    Route::get('/'.$prefix.'/display_amended_regulation_sections/{title}','Post1992Controller@display_amended_regulation_sections_container');
    Route::get('/'.$prefix.'/print_amended_regulation_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_print_amended_regulation_act_preamble_content');
    Route::get('/'.$prefix.'/print_amended_regulation_act/content_section/{id}','Post1992Controller@post_1992_legislation_print_amended_regulation_act_content_section');
    Route::get('/'.$prefix.'/plain_amended_regulation_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_plain_amended_regulation_act_preamble_content');
    Route::get('/'.$prefix.'/plain_amended_regulation_act/content_section/{id}','Post1992Controller@post_1992_legislation_plain_amended_regulation_act_content_section');
    Route::get('/'.$prefix.'/pdf/amended_regulation_preamble_content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_amended_regulation_act_preamble_content');
    Route::get('/'.$prefix.'/pdf/amended_regulation_act/content_section/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_amended_regulation_act_content_section');

    // REGULATIONS UNDER AN ACT
    Route::get('/'.$prefix.'/{group}/all_regulations_acts/{title}/{id}','Post1992Controller@all_regulations_for_an_act');
    Route::get('/'.$prefix.'/regulations_table_of_content/{category}/{title}/{id}','Post1992Controller@regulations_table_of_content');
    Route::get('/'.$prefix.'/regulations_preamble/{id}','Post1992Controller@regulations_preamble');
    Route::get('/'.$prefix.'/regulations_content/{id}','Post1992Controller@regulations_content');
    Route::get('/'.$prefix.'/display_regulations_sections/{title}','Post1992Controller@display_regulations_sections_container');
    Route::get('/'.$prefix.'/print_regulation_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_print_regulation_act_preamble_content');
    Route::get('/'.$prefix.'/print_regulation_act/content_section/{id}','Post1992Controller@post_1992_legislation_print_regulation_act_content_section');
    Route::get('/'.$prefix.'/plain_regulation_act/preamble_content/{id}','Post1992Controller@post_1992_legislation_plain_regulation_act_preamble_content');
    Route::get('/'.$prefix.'/plain_regulation_act/content_section/{id}','Post1992Controller@post_1992_legislation_plain_regulation_act_content_section');
    Route::get('/'.$prefix.'/pdf_regulation_act/preamble_content/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_act_preamble_content');
    Route::get('/'.$prefix.'/pdf_regulation_act/content_section/{title}/{id}','Post1992Controller@post_1992_legislation_pdf_regulation_act_content_section');

    // PDF
    Route::get('/'.$prefix.'/act_pdf/{id}', 'PDFController@post_act_pdf');
}

//-----------------------------------------------------------------------------------END OF POST-1992-LEGISLATION-------------------------------------------------------------------------------

//------------------------------------------------------------------------------------LAW JUDGMENTS--------------------------------------------------------------------------------------------
//Ghana Law Judgement routes
Route::get('/judgement/Ghana','JudgementController@index');
    Route::get('/judgement/ajax-data','JudgementController@judgement_ajax_data'); //AJAX JSON data for tab switching
    Route::get('/judgement/Ghana/filter/{year}/{category}','JudgementController@all_judgment_filter'); //all judgment filtering
    Route::get('/judgement/Ghana/{name}/{id}','JudgementController@all_ghana_court_cases');
    // Route::get('/judgement/Ghana/Case-view/{name}/{id}','JudgementController@all_ghana_court_cases_view');
    Route::get('/judgement/print/simple-preview/{id}','JudgementController@Ghana_all_print_preview');
    Route::get('/judgement/plain/simple-preview/{id}','JudgementController@Ghana_all_plain_view');
    Route::get('/judgement/1/case_law/pdf_view/{title}/{id}','JudgementController@Ghana_all_pdf_view');
    // Route::get('/judgement/pdf_view/{name}/{id}','JudgementController@Ghana_all_pdf_view');

    // Route::get('/judgement/all-cases/{id}','JudgementController@all_ghana_court_cases_view'); //former

    //Supreme Court
    Route::get('/judgement/1/{name}','JudgementController@supreme_court');
    Route::get('/judgement/1/supreme-court/filter/{year}/{category}','JudgementController@supreme_court_filter'); //supreme court filtering
    // Route::get('/judgement/view/1/{name}/{id}','JudgementController@supreme_court_cases');
    // Route::get('/judgement/supreme-court/case/{id}','JudgementController@supreme_court_cases_view'); //do same for the others

    //High Court
    Route::get('/judgement/2/{name}','JudgementController@high_court');
    Route::get('/judgement/2/high-court/filter/{year}/{category}','JudgementController@high_court_filter'); //high court filtering
    // Route::get('/judgement/view/2/{name}/{id}','JudgementController@high_court_cases');
    // Route::get('/judgement/high-court/case/{id}','JudgementController@high_court_cases_view');

    //Court of Appeal
    Route::get('/judgement/3/{name}','JudgementController@court_of_appeal');
    Route::get('/judgement/3/court-of-appeal/filter/{year}/{category}','JudgementController@court_of_appeal_filter'); //court of appeal filtering
    // Route::get('/judgement/view/3/{name}/{id}','JudgementController@court_of_appeal_cases');
    // Route::get('/judgement/court-of-appeal/case/{id}','JudgementController@court_of_appeal_cases_view');

    //Circuit Court
    Route::get('/judgement/4/{name}','JudgementController@circuit_court');
    Route::get('/judgement/4/circuit-court/filter/{year}/{category}','JudgementController@circuit_court_filter'); //circuit court filtering
    // Route::get('/judgement/view/4/{name}/{id}','JudgementController@circuit_court_cases');
    // Route::get('/judgement/circuit-court/case/{id}','JudgementController@circuit_court_cases_view');

    //District Court
    Route::get('/judgement/5/{name}','JudgementController@district_court');
    Route::get('/judgement/5/district-court/filter/{year}/{category}','JudgementController@district_court_filter'); //circuit court filtering
    // Route::get('/judgement/view/5/{name}/{id}','JudgementController@district_court_cases');
    // Route::get('/judgement/district-court/case/{id}','JudgementController@district_court_cases_view');

    //High Court (Tema)
    Route::get('/judgement/6/{name}','JudgementController@high_court_tema');
    // Route::get('/judgement/6/district-court/filter/{year}/{category}','JudgementController@district_court_filter'); //circuit court filtering
    // Route::get('/judgement/view/6/{name}/{id}','JudgementController@high_court_tema_cases');




// All Foreign Law Judgement routes
Route::get('/judgement/all-countries','JudgementController@all_countries_laws');
    Route::get('/judgement/Foreign/filter/{year}/{country}','JudgementController@all_foreign_judgment_filter'); //all judgment filtering
    Route::get('/judgement/{country}/{id}','JudgementController@all_countries_court_case');
    Route::get('/judgement/Case-view/{country}/{id}','JudgementController@all_countries_court_cases_view');
    Route::get('/judgement/print_preview/foreign/{id}','JudgementController@Foreign_all_print_preview');
    Route::get('/judgement/plain_view/foreign/{id}','JudgementController@Foreign_all_plain_preview');
    Route::get('/judgement/pdf_view/foreign/{country}/{id}','JudgementController@Foreign_all_pdf_preview');

    //Africa Law Judgements
    Route::get('/judgement/all-countries/1/{name}','JudgementController@africa_court');
    Route::get('/judgement/1/africa-court/filter/{year}/{country}','JudgementController@africa_court_filter'); //africa court filtering
    Route::get('/judgement/all-countries/1/{name}/{id}','JudgementController@africa_court_cases');

    //Asia Law Judgements
    Route::get('/judgement/all-countries/2/{name}','JudgementController@asia_court');
    Route::get('/judgement/2/asia-court/filter/{year}/{country}','JudgementController@asia_court_filter'); //asia court filtering
    Route::get('/judgement/all-countries/2/{name}/{id}','JudgementController@asia_court_cases');

    //Europe Law Judgements
    Route::get('/judgement/all-countries/3/{name}','JudgementController@europe_court');
    Route::get('/judgement/3/europe-court/filter/{year}/{country}','JudgementController@europe_court_filter'); //europe court filtering
    Route::get('/judgement/all-countries/3/{name}/{id}','JudgementController@europe_court_cases');

    //North America Law Judgements
    Route::get('/judgement/all-countries/4/{name}','JudgementController@north_america_court');
    Route::get('/judgement/4/north-america-court/filter/{year}/{country}','JudgementController@north_america_court_filter'); //north-america court filtering
    Route::get('/judgement/all-countries/4/{name}/{id}','JudgementController@north_america_court_cases');

    //South America Law Judgements
    Route::get('/judgement/all-countries/5/{name}','JudgementController@south_america_court');
    Route::get('/judgement/5/south-america-court/filter/{year}/{country}','JudgementController@south_america_court_filter'); //south-america court filtering
    Route::get('/judgement/all-countries/5/{name}/{id}','JudgementController@south_america_court_cases');


//---------------------------------------------------------------------------------END OF LAW JUDGEMENT-----------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------NEWS--------------------------------------------------------------------------------------------------------
Route::get('/News/{category}/{id}','NewsController@news_index');//display homepage of Ghana News
Route::get('/News/Next/{category}/fetch_data','NewsController@news_ajax_display');//display homepage of Ghana News
Route::get('/News/{category}/{title}/{id}','NewsController@news_content');//display homepage of Ghana News

//------------------------------------------------------------------------------------END OF NEWS----------------------------------------------------------------------------------------------


//FOOTER
Route::get('/caption/{caption_name}/{id}','Post1992Controller@footer_content');




Route::get('register/check-duplicate', 'Auth\RegisterController@checkDuplicate')->name('register.check-duplicate');
Route::post('complaints/submit', 'ComplaintController@store')->name('complaints.store');
Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

// Demo mode routes (authenticated, not yet verified)
Route::middleware('auth')->group(function () {
    Route::get('/register/choose-plan', 'DemoController@choosePlan')->name('register.choose-plan');
    Route::post('/register/activate-demo', 'DemoController@activateDemo')->name('register.activate-demo');
});

// CUSTOM ADMIN DASHBOARD ROUTES
Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
    
    // Notifications Dashboard & Replies
    Route::get('notifications', 'Admin\NotificationController@index')->name('admin.notifications.index');
    Route::post('notifications/{id}/read', 'Admin\NotificationController@markRead')->name('admin.notifications.read');
    Route::post('notifications/read-all', 'Admin\NotificationController@markAllRead')->name('admin.notifications.read-all');
    Route::delete('notifications/{id}', 'Admin\NotificationController@destroy')->name('admin.notifications.destroy');
    Route::delete('notifications', 'Admin\NotificationController@destroyAll')->name('admin.notifications.destroy-all');
    Route::post('complaints/{id}/reply', 'Admin\NotificationController@reply')->name('admin.complaints.reply');

    Route::get('users/continents-preview', 'Admin\UserController@continentsPreview')->name('admin.users.continents-preview');
    Route::get('users/export', 'Admin\UserController@export')->name('admin.users.export');
    Route::delete('users/bulk-destroy', 'Admin\UserController@bulkDestroy')->name('admin.users.bulk-destroy');
    Route::post('users/{id}/impersonate', 'Admin\UserController@impersonate')->name('admin.users.impersonate');
    Route::resource('users', 'Admin\UserController', ['as' => 'admin']);
    Route::resource('news', 'Admin\NewsController', ['as' => 'admin']);
    Route::get('laws', 'Admin\LawController@index')->name('admin.laws.index');
    Route::get('laws/create/{type}', 'Admin\LawController@create')->name('admin.laws.create');
    Route::post('laws/store/{type}', 'Admin\LawController@store')->name('admin.laws.store');
    Route::get('laws/{id}/edit/{type}', 'Admin\LawController@edit')->name('admin.laws.edit');
    Route::put('laws/{id}/update/{type}', 'Admin\LawController@update')->name('admin.laws.update');
    Route::delete('laws/{id}/delete/{type}', 'Admin\LawController@destroy')->name('admin.laws.destroy');

    // Homepage Settings Management
    Route::get('homepage-settings', 'Admin\HomepageSettingController@index')->name('admin.homepage-settings.index');
    Route::post('homepage-settings/update', 'Admin\HomepageSettingController@update')->name('admin.homepage-settings.update');

    // Homepage Custom Slides Management (Dynamic Panels)
    Route::resource('homepage-custom-slides', 'Admin\HomepageCustomSlideController', ['as' => 'admin']);

    // Maintenance Mode Settings
    Route::get('maintenance-settings', 'Admin\MaintenanceSettingController@index')->name('admin.maintenance-settings.index');
    Route::post('maintenance-settings/update', 'Admin\MaintenanceSettingController@update')->name('admin.maintenance-settings.update');

    // Header Navigation Menus CRUD Management
    Route::resource('navigation-menus', 'Admin\NavigationMenuController');

    // Sidebar Ads Management
    Route::resource('sidebar-ads', 'Admin\SidebarAdController', ['as' => 'admin'])->only(['index', 'edit', 'update']);

    // Researcher Types Management
    Route::resource('researcher-types', 'Admin\ResearcherTypeController', ['as' => 'admin']);

    // Demo Settings Management
    Route::get('demo-settings', 'Admin\DemoSettingController@index')->name('admin.demo-settings.index');
    Route::post('demo-settings/update', 'Admin\DemoSettingController@update')->name('admin.demo-settings.update');

    // Guest Reading Limits & Scroll Gate Management
    Route::get('reading-limits', 'Admin\ReadingLimitSettingController@index')->name('admin.reading-limits.index');
    Route::post('reading-limits/update', 'Admin\ReadingLimitSettingController@update')->name('admin.reading-limits.update');

    // Platform Feature Updates & Tours Management
    Route::resource('platform-updates', 'Admin\PlatformUpdateController', ['as' => 'admin']);
    Route::post('platform-updates/{id}/toggle-status', 'Admin\PlatformUpdateController@toggleStatus')->name('admin.platform-updates.toggle');

    // Onboarding Guided Tour Management
    Route::get('onboarding-tour', 'Admin\OnboardingTourController@index')->name('admin.onboarding-tour.index');
    Route::post('onboarding-tour/settings', 'Admin\OnboardingTourController@updateSettings')->name('admin.onboarding-tour.settings');
    Route::post('onboarding-tour/step', 'Admin\OnboardingTourController@storeStep')->name('admin.onboarding-tour.store_step');
    Route::put('onboarding-tour/step/{id}', 'Admin\OnboardingTourController@updateStep')->name('admin.onboarding-tour.update_step');
    Route::delete('onboarding-tour/step/{id}', 'Admin\OnboardingTourController@destroyStep')->name('admin.onboarding-tour.destroy_step');
    Route::post('onboarding-tour/reset-defaults', 'Admin\OnboardingTourController@resetDefaults')->name('admin.onboarding-tour.reset_defaults');

    // Admin Profile Management
    Route::get('profile', 'Admin\ProfileController@index')->name('admin.profile.index');
    Route::put('profile', 'Admin\ProfileController@updateProfile')->name('admin.profile.update');
    Route::put('profile/password', 'Admin\ProfileController@updatePassword')->name('admin.profile.password');
});

// Legacy User Role Upgrade Route
Route::group(['middleware' => ['auth']], function () {
    Route::get('/account/upgrade-role', 'AccountUpgradeController@show')->name('account.upgrade.role');
    Route::post('/account/upgrade-role', 'AccountUpgradeController@store')->name('account.upgrade.role.store');
});

// User Platform Updates & Tour API routes
Route::group(['prefix' => 'accounts', 'middleware' => ['auth']], function () {
    Route::get('platform-updates', 'UserPlatformUpdateController@getUpdates')->name('accounts.updates.list');
    Route::post('platform-updates/{id}/read', 'UserPlatformUpdateController@markAsRead')->name('accounts.updates.read');
    Route::post('platform-updates/read-all', 'UserPlatformUpdateController@markAllAsRead')->name('accounts.updates.read_all');
    Route::post('onboarding-tour/complete', 'UserPlatformUpdateController@completeOnboardingTour')->name('accounts.tour.complete');
});

// Leave Impersonation route
Route::post('/impersonate/leave', 'Admin\UserController@leaveImpersonation')->name('impersonate.leave');
Route::get('/impersonate/leave', 'Admin\UserController@leaveImpersonation')->name('impersonate.leave.get');

// Dedicated Admin Login Routes
Route::get('/admin/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin/login', 'Admin\LoginController@login')->name('admin.login.submit');

// Dynamic Page Routing
Route::get('page/{slug}', 'PageController@show')->name('dynamic.page');

// Maintenance Mode Public Routes
Route::get('maintenance', 'MaintenanceController@show')->name('maintenance.show');
Route::post('maintenance/verify', 'MaintenanceController@verify')->name('maintenance.verify');


/*
|--------------------------------------------------------------------------
| Adjustment and others to work on
|--------------------------------------------------------------------------
|1
|Remove Foreign Case Laws from the main tab
|->Africa /judgement/all-countries/1/Africa
|->Asia /judgement/all-countries/2/Asia
|->Europe /judgement/all-countries/3/Europe
|->North America /judgement/all-countries/4/North America
|->South America /judgement/all-countries/5/South America
|https://madewithlove.be/how-to-integrate-elasticsearch-in-your-laravel-app-2019-edition/
|https://www.pair.com/support/kb/how-to-use-jquery-to-generate-modal-pop-up-when-clicked/
|https://scotch.io/tutorials/build-search-functionality-with-laravel-scout-and-vue-js
https://www.expertsphp.com/highlight-keywords-in-search-results-with-laravel/
https://www.youtube.com/watch?v=JvFNpddspMM......sitemap

https://www.itsolutionstuff.com/post/jquery-highlight-search-text-in-div-using-highlight-js-with-exampleexample.html
|2.

https://www.jqueryscript.net/tags.php?/search/
|->High Court (Commerical) route: /judgement/2/High-Court
|->High Court (Fast Track) route: /judgement/4/Circuit-Court
|->High Court (Human Right) route: /judgement/5/District-Court
|->High Court (Tema) route: /judgement/6/High-Court-Tema
|
|<div class="row">
|           <div class="col-md-12">
|             <label>Downloads</label>
|             <div class="row">
|
|                <a class="col-md-6" href=""><img alt="Brand" src="{{ asset('/logo/pdf.png') }}" class="img-responsive" style="width:2em;">PDF</a>
|                <a class="col-md-6" href=""><img alt="Brand" src="{{ asset('/logo/word.png') }}" class="img-responsive" style="width:2em;">WORD</a>
|
|              </div>
|              <br>
|              <div class="row">
|                <div class="col-md-12">
|                  <!-- <label>Print</label> -->
|                  <button class="btn btn-primary btn-sm printLink"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;&nbsp;Print</button>
|                </div>
|              </div>
|            </div>
|</div>

|<label style="color: black;">View Options</label>
          <a class="expanded_link" id="expanded_link_toggle_all_pre1992_preview_1" href="/post_1992_legislation/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/expanded-view/{{ $allPost1992Act['id'] }}">
            <li style="list-style:none;">Expanded View</li>
          </a>
          <a href="/post_1992_legislation/1/{{$allPost1992Act['post_group']}}/{{$allPost1992Act['title']}}/plain_view/{{ $allPost1992Act['id'] }}" target="_blank"><li style="list-style:none;">Plain View</li></a>
|
|http://jsfiddle.net/tU8R5/4/ : It is an important note
*/

Route::get('/update-live-navigation-menu-secret', function() {
    try {
        // 1. Update Existing Laws URLs to /existing-laws/
        \Illuminate\Support\Facades\DB::statement("UPDATE navigation_menus SET url = '/existing-laws' WHERE title LIKE '%Existing%' OR title LIKE '%Pre-4th%' OR id = 2");
        \Illuminate\Support\Facades\DB::statement("UPDATE navigation_menus SET url = REPLACE(url, '/pre_1992_legislation', '/existing-laws') WHERE url LIKE '%pre_1992_legislation%'");
        \Illuminate\Support\Facades\DB::statement("UPDATE navigation_menus SET url = REPLACE(url, '/pre-1992-legislation', '/existing-laws') WHERE url LIKE '%pre-1992-legislation%'");

        // 2. Update New Laws URLs to /new-laws/
        \Illuminate\Support\Facades\DB::statement("UPDATE navigation_menus SET url = '/new-laws' WHERE title LIKE '%New Laws%' OR title LIKE '%4th Republic%' OR id = 3");
        \Illuminate\Support\Facades\DB::statement("UPDATE navigation_menus SET url = REPLACE(url, '/post_1992_legislation', '/new-laws') WHERE url LIKE '%post_1992_legislation%'");
        \Illuminate\Support\Facades\DB::statement("UPDATE navigation_menus SET url = REPLACE(url, '/post-1992-legislation', '/new-laws') WHERE url LIKE '%post-1992-legislation%'");

        // 2. Update sidebar_ads slots so slot_1 is ALWAYS advertise (top) and slot_2 is ALWAYS news_feed (bottom)
        \Illuminate\Support\Facades\DB::statement("UPDATE sidebar_ads SET placeholder_type = 'advertise' WHERE slot_name = 'slot_1'");
        \Illuminate\Support\Facades\DB::statement("UPDATE sidebar_ads SET placeholder_type = 'news_feed' WHERE slot_name = 'slot_2'");

        // 3. Clear caches
        \Illuminate\Support\Facades\Artisan::call('view:clear');
        \Illuminate\Support\Facades\Artisan::call('cache:clear');

        return "<h1>Success! Database updated & caches cleared.</h1><p>Existing Laws link is now /existing-laws!</p>";
    } catch (\Exception $e) {
        return "<h1>Error: " . $e->getMessage() . "</h1>";
    }
});



