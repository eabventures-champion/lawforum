//-------------------------------------------------------------------------------------------------------------------------
// Intercept XMLHttpRequest to prevent page flickering on readyState changes
(function() {
    let proto = XMLHttpRequest.prototype;
    let descriptor = Object.getOwnPropertyDescriptor(proto, 'onreadystatechange');
    if (!descriptor && window.XMLHttpRequestEventTarget) {
        proto = window.XMLHttpRequestEventTarget.prototype;
        descriptor = Object.getOwnPropertyDescriptor(proto, 'onreadystatechange');
    }
    if (descriptor && descriptor.set) {
        const originalSet = descriptor.set;
        Object.defineProperty(proto, 'onreadystatechange', {
            set: function(callback) {
                const xhr = this;
                originalSet.call(xhr, function(e) {
                    if (xhr.readyState === 4) {
                        callback.call(xhr, e);
                    }
                });
            },
            configurable: true,
            enumerable: true
        });
    }
})();

window.resetReaderScroll = function(panel) {
    if (panel) {
        var pBody = document.getElementById('bodyPanel' + panel);
        if (pBody) pBody.scrollTop = 0;
        var sPanel = document.querySelector('#splitPanel' + panel + ' .split-panel-body');
        if (sPanel) sPanel.scrollTop = 0;
    }
    var scrollTargets = [
        document.querySelector('.workspace-body'),
        document.getElementById('display_content'),
        document.querySelector('.reader-container'),
        document.getElementById('v-pills-profile'),
        document.querySelector('.expanded-container'),
        document.querySelector('.main-content-area'),
        document.querySelector('.split-panel-body')
    ];
    scrollTargets.forEach(function(el) {
        if (el) {
            el.scrollTop = 0;
        }
    });
    if (window.jQuery) {
        window.jQuery('.workspace-body, .reader-container, #display_content, .split-panel-body, html, body').scrollTop(0);
    } else {
        window.scrollTo(0, 0);
    }
    if (typeof updateReadingProgress === 'function') {
        updateReadingProgress();
    }
};

$(document).on('click', '.previous_content_act, .next_content_act, .previous_constitutional_acts, .next_constitutional_acts, .previous_executive_acts, .next_executive_acts, .plain_previous_content_act, .plain_next_content_act, .displayed_previous_next, .previous_content_pre_act, .next_content_pre_act, .previous_content_constitution_act, .next_content_constitution_act, .previous_content_constitution_amended_act, .next_content_constitution_amended_act, .previous_content_regulation, .next_content_regulation, .previous_content_amendments, .next_content_amendments, .constitution_content_link, .pre_content_link, .content_link, .amendments_content_link, .regulation_content_link, .constitution_amended_content_link, .amended_regulation_content_link, .constitution_preamble_link, .pre_preamble_content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link', function() {
    if (typeof resetReaderScroll === 'function') {
        resetReaderScroll();
    }
});

// TOGGLE DISPLAY BETWEEN REGULATION PREAMBLE AND REGULATION CONTENT
$(document).ready(function(){
        
    var gsid = 0; 
    var psid = 0, nsid = 0;

    $(".open").on("click", function() {
        $(".popup-overlay").addClass("active");
      });

    $(".close").on("click", function() {
        $(".popup-overlay").removeClass("active");
    });

  $('.previous_next_hidden_show').hide();
  $('.tabPanedHide_amendments').hide();
  $('.tabPanedHide_amendments_table').hide();
  $('.tabPanedHide_amendments_content').hide();
  $('.tabPanedHide_regulations').hide();
  $('.tabPanedHide_regulations_table').hide();
  $('.tabPanedHide_regulations_content').hide();
  $('.tabPanedHide_acts_content').hide();
  $('.tabPanedHide_expanded_view').hide();


  //-------------------------New changing background colors
  // Default table of content color
  $('.tabPaned_table_of_table_color').css("background-color","#f5f5f5");
  $('.tabPaned_table_of_table_color').css("border",".1px solid #ddd");
  $('.tabPaned_table_of_table_color').css("color","blue");

  //click table of content tab
  $(".tabPaned_table_of_table_color").click(function(){
    $('.tabPaned_table_of_table_color').css("background-color","#f5f5f5");
    $('.tabPaned_table_of_table_color').css("border",".1px solid #ddd");
    $('.tabPaned_table_of_table_color').css("color","blue");
    //color change on other tabs
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click section link
  $(".content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link, .pre_content_link, .pre_preamble_content_link, .constitution_preamble_link, .regulation_content_link, .amendments_content_link, .tabPanedHide_acts_content, .preamble_link").click(function(){
    $('.tabPanedHide_acts_content').css("background-color","#f5f5f5");
    $('.tabPanedHide_acts_content').css("border",".1px solid #ddd");
    $('.tabPanedHide_acts_content').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click expanded link
  $(".expanded_link, .tabPanedHide_expanded_view").click(function(){
    $('.tabPanedHide_expanded_view').css("background-color","#f5f5f5");
    $('.tabPanedHide_expanded_view').css("border",".1px solid #ddd");
    $('.tabPanedHide_expanded_view').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click all amendments link from related Acts
  $(".all_amendments_link, .tabPanedHide_amendments").click(function(){
    $('.tabPanedHide_amendments').css("background-color","#f5f5f5");
    $('.tabPanedHide_amendments').css("border",".1px solid #ddd");
    $('.tabPanedHide_amendments').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click all amendments link from related Acts
  $(".amended_link, .amended_for_regulation_link, .tabPanedHide_amendments_table").click(function(){
    $('.tabPanedHide_amendments_table').css("background-color","#f5f5f5");
    $('.tabPanedHide_amendments_table').css("border",".1px solid #ddd");
    $('.tabPanedHide_amendments_table').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_content').css("background-color","white");
    $('.tabPanedHide_amendments_content').css("color","blue");
  });

  //click amended section link to move to it's content display
  $(".sinlge_amended_act_content_link, .single_amendments_to_regulation_link, .tabPanedHide_amendments_content").click(function(){
    $('.tabPanedHide_amendments_content').css("background-color","#f5f5f5");
    $('.tabPanedHide_amendments_content').css("border",".1px solid #ddd");
    $('.tabPanedHide_amendments_content').css("color","blue");
    //color change on other tabs
    $('.tabPaned_table_of_table_color').css("background-color","white");
    $('.tabPaned_table_of_table_color').css("color","blue");
    $('.tabPanedHide_acts_content').css("background-color","white");
    $('.tabPanedHide_acts_content').css("color","blue");
    $('.tabPanedHide_expanded_view').css("background-color","white");
    $('.tabPanedHide_expanded_view').css("color","blue");
    $('.tabPanedHide_amendments').css("background-color","white");
    $('.tabPanedHide_amendments').css("color","blue");
    $('.tabPanedHide_amendments_table').css("background-color","white");
    $('.tabPanedHide_amendments_table').css("color","blue");
  });
















  //For the table of content tab color on document ready
  $('.tabPaned_color_table_of_table').css("background-color","#f5f5f5");
  $('.tabPaned_color_table_of_table').css("border-color","#ddd");
  $('.tabPaned_color_table_of_table').css("color","black");

  //Click to change color for Table of Content
  $(".tabPaned_color_table_of_table").click(function(){
    $('.tabPaned_color_table_of_table').css("background-color","#f5f5f5");
    $('.tabPaned_color_table_of_table').css("color","black");
    //changes in the contents
    $('.bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-table, .bg-color-regulations-contents').css("background-color","white");
    $('.bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-table, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-table, .bg-color-regulations-contents').css({"color" : "black"});
  });

  //Click to change color for Content
  $(".constitution_amended_content_link, .constitution_content_link, .pre_content_link, .pre_preamble_content_link, .constitution_preamble_link, .content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link, .amendments_content_link, .regulation_content_link, .amended_regulation_content_link, .tabPanedHide_acts_content, .preamble_link").click(function(){
    $('.bg-color-content').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-content').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-expanded, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table').css("color","black");
  });

   //Click to change color for Expanded View
   $(".expanded_link, .tabPanedHide_expanded_view").click(function(){
    $('.bg-color-expanded').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-expanded').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-amendments, .bg-color-regulations, .bg-color-amendments-table, .bg-color-amendments-contents, .bg-color-regulations-contents').css("color","black");
  });

  //Click to change color for Amendments
  $(".all_amendments_link, .tabPanedHide_amendments").click(function(){
    $('.bg-color-amendments').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-amendments').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table, .bg-color-amendments-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table, .bg-color-amendments-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table, .bg-color-amendments-contents').css("color","black");
  });

  //Click to change color for Amendments Table of Contents
  $(".tabPanedHide_amendments_table").click(function(){
    $('.bg-color-amendments-table').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-amendments-table').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-contents').css("color","black");
  });

  //Click to change color for Amended Contents
  $(".tabPanedHide_amendments_content").click(function(){
    $('.bg-color-amendments-contents').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-amendments-contents').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-table').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-table').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments, .bg-color-amendments-table').css("color","black");
  });

  //Click to change color for Regulation
  $(".all_regulations_link, .tabPanedHide_regulations").click(function(){
    $('.bg-color-regulations').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-regulations').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table, .bg-color-regulations-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table, .bg-color-regulations-contents').css("color","black");
  });

  //Click to change color for Regulation table of contents
  $(".tabPanedHide_regulations_table").click(function(){
    $('.bg-color-regulations-table').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-regulations-table').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-contents').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-contents').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-contents').css("color","black");
  });

  //Click to change color for Regulations Contents
  $(".tabPanedHide_regulations_content").click(function(){
    $('.bg-color-regulations-contents').css({"backgroundColor" : "#f5f5f5"});
    $('.bg-color-regulations-contents').css({"color" : "black"});
    //changes in table of content
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-table').css("background-color","white");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-table').css("border-color","#ddd");
    $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-regulations-table').css("color","black");
  });


  // To toggle print and view options scoped to the clicked button's panel with click-outside auto-close support
  $(document).on('click', '#print_options', function(e){
      e.preventDefault();
      e.stopPropagation();
      const dropdown = $(this).siblings('.menu_options');
      dropdown.slideToggle(200);
      $('.menu_options').not(dropdown).slideUp(150);
  });

  $(document).on('click', function(e) {
      if (!$(e.target).closest('#print_options, .menu_options').length) {
          $('.menu_options').slideUp(150);
      }
  });

    //TOGGLE ALL AMENDMENTS AND REGULATION UNDER AN ACT
    //For all amendments
    function all_amendments_link_toggle() {
            $('.tabPanedHide_regulations').hide();
            $('.tabPanedHide_regulations_table').hide();
            $('.tabPanedHide_regulations_content').hide();
            $('.tabPanedHide_amendments_table').hide();
            $('.tabPanedHide_amendments_content').hide();
            $('.tabPanedHide_amendments').show();
            $('#tabs a[href="#all_amendmentsTab"]').tab('show');
    }

    $(document).on('click','.all_amendments_link', function(e){
        e.preventDefault();
        all_amendments_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) { 
            $("#v-pills-settings-tab").trigger("click");
            $("#all_amendments").html(this.responseText); 
            $("#amend_datatable").DataTable();
        }
    xhr.send();
    });
   

    //For all regulations
   $('#all_regulations_link_toggle').click(function (e) {
    e.preventDefault();
        $('#tabs a[href="#all_regulationsTab"]').tab('show');
        $('.tabPanedHide_amendments').hide();
        $('.tabPanedHide_amendments_table').hide();
        $('.tabPanedHide_amendments_content').hide();
        $('.tabPanedHide_regulations').show();
    });
    
   $('.all_regulations_link').click(function(e){
    e.preventDefault();
    var xhr = new XMLHttpRequest();
    var link = $(this).attr("href");
    xhr.open("GET", link, true);
    xhr.onreadystatechange = function receiveUpdate(e) {
        $("#all_regulations").html(this.responseText);
        $("#regulated_datatable").DataTable();  
    }
    xhr.send();
    });



    //TOGGLE FUNCTION FOR AMENDMENT AND REGULATION
    //For a particular amendment...Toggle to table of content
   function amended_act_toggle() {
        $('#tabs a[href="#amended_table_of_Content_Tab"]').tab('show');
        $('.tabPanedHide_amendments_table').show();
   }
   function act_content_link_toggle()
    {
    $('#tabs a[href="#contentTab"]').tab('show');
    $('.tabPanedHide_acts_content').show();
    }  
    
    // For a particular amendment .....toggle to content
   function amended_act_toggle_content() {
    $('#tabs a[href="#amendmentcontentTab"]').tab('show');
    $('.tabPanedHide_amendments_content').show();
    }

    //for regulation
   function regulation_act_toggle() {
    $('#tabs a[href="#regulated_table_of_Content_Tab"]').tab('show');
    $('.tabPanedHide_regulations_table').show();

    }

   function regulation_act_toggle_content() {
    $('#tabs a[href="#regulatedcontentTab"]').tab('show');
    $('.tabPanedHide_regulations_content').show();
    }


    //for amendments under act
   $(document).on('click','.amended_link', function(e){
        e.preventDefault();
        amended_act_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) { 
            // $("#single_preamble_amended_content").html(""); 
            // $("#single_amended_content").html("");
            // $("#single_view_all_sections_amend").html("");
            // $("#single_container_details_amend").hide();

            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments').css("background-color","white");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments').css("border-color","#ddd");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments').css("color","black");

            // $('.bg-color-amendments-table').css({"backgroundColor" : "#f5f5f5"});
            // $('.bg-color-amendments-table').css({"color" : "black"});
            // $("#v-pills-amendments-content-tab").tab('hide')
            $("#v-pills-amendments-tab").trigger("click");
            $("#amended_table_of_content").html(this.responseText);
        }
    xhr.send();
    });
    
     //for amendments under regulation
   $(document).on('click','.amended_for_regulation_link', function(e){
        e.preventDefault();
        amended_act_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) { 
            // $("#single_preamble_amended_content_for_regulation").html(""); 
            // $("#single_amended_content_for_regulation").html("");
            // $("#single_view_all_sections_amend_for_regulation").html("");
            // $("#single_container_details_amends_under_regulation").hide();
            $("#v-pills-amendments-tab").trigger("click");
            $("#amended_table_of_content").html(this.responseText);
        }
    xhr.send();
    });

    //regulations
    $(document).on('click','.regulated_link', function(e){
        e.preventDefault();
        regulation_act_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html(""); 
            $("#single_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $("#single_container_details_regulation").hide();

            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations').css("background-color","white");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations').css("border-color","#ddd");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations').css("color","black");

            $('.bg-color-regulations-table').css({"backgroundColor" : "#f5f5f5"});
            $('.bg-color-regulations-table').css({"color" : "black"});

            $("#regulated_table_of_content").html(this.responseText);
        }
    xhr.send();
    });

    //for preamble amendment under act
    $(document).on('click','.single_preamble_amended_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {

            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments, .bg-color-amendments-table').css("background-color","white");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments, .bg-color-amendments-table').css("border-color","#ddd");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations, .bg-color-amendments, .bg-color-amendments-table').css("color","black");
            
            $('.bg-color-amendments-contents').css({"backgroundColor" : "#f5f5f5"});
            $('.bg-color-amendments-contents').css({"color" : "black"});

            $("#single_preamble_amended_content").html(this.responseText); 
            $("#single_amended_content").html("");
            $("#single_view_all_sections_amend").html("");
            $(".single_container_details_link_amend").trigger("click");
            $(".show li").hide();
        }
        xhr.send();
    });
    
    //for preamble amendment under regulation
    $(document).on('click','.single_preamble_amended_regulation_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html(this.responseText); 
            $("#single_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html("");
            $(".single_container_details_link_amend_regulation").trigger("click");
            $(".show li").hide();
        }
        xhr.send();
    });

    $(document).on('click','.single_preamble_regulation_link', function(e){
        e.preventDefault();
        regulation_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html(this.responseText); 
            $("#single_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $('.single_container_details_link_regulation').trigger("click");
            $(".show li").hide();
        }
        xhr.send();
    });

    //show the hidden for amendments under an act
    $(document).on('click','.single_container_details_link_amend', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_container_details_amend").html(this.responseText);
            $("#single_container_details_amend").show();
            $(".show li").hide();
        }
        xhr.send();
    });
    
     //show the hidden for amendments under an regulation
    $(document).on('click','.single_container_details_link_amend_regulation', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_container_details_amends_under_regulation").html(this.responseText);
            $("#single_container_details_amends_under_regulation").show();
            $(".show li").hide();
        }
        xhr.send();
    });

    $(document).on('click','.single_container_details_link_regulation', function(e){
        e.preventDefault();
        regulation_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_container_details_regulation").html(this.responseText);
            $("#single_container_details_regulation").show(); 
            $(".show li").hide();
        }
        xhr.send();
    });

    //-----------------------------------------------------end
    //GENERAL CONTENT LINK
    // General content click to show on content tab
    $('.content_link_toggle').click(function (e) {
        e.preventDefault();
         $('#tabs a[href="#contentTab"]').tab('show');
    });
    
    $('.view_all_section_link').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });
    
    
    //IMPORTANT FOR THE PREVIOUS AND NEXT--------------------THE STARTING OF THE PREVIOUS AND NEXT-----------------------------
    
    // VIEW ALL SECTIONS FOR THE VARIOUS GROUPS
    
    // General View all section links for post
    $('.view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        setPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");       
        }
        xhr.send();
    });

    // General View all section links for constitutional
    $('.constitutional_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        constitutionalSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });

    // General View all section links for executive
    $('.executive_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        executiveSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });
    
    // General View all section links for pre
    $('.pre_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        preSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");    
        }
        xhr.send();
    });
    
    // General View all section links for constitution
    $('.constitution_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        constitutionSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText); 
            $(".preamble_hide_pre_next").css("display", "block");  
        }
        xhr.send();
    });
    
    // General View all section links for constitution amended
    $('.constitution_amended_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        constitutionAmendedSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);   
        }
        xhr.send();
    });
    
    // General View all section links for regulation
    $('.regulation_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        regulationSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");   
        }
        xhr.send();
    });
    
    // General View all section links for amendments
    $('.amendments_view_all_section_link_with_prev_next').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        
        var psid = $(this).attr("sid");
        amendmentsSetPrevNext(psid);
        
       console.log("this is activated when all section dropdown is clicked");
       
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_content").html("");
            $("#display_preamble").html("");
            $("#display_view_all_section").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");   
        }
        xhr.send();
    });
    
    //View all single amendments links for amendments under an act
    $(document).on('click','.single_view_all_amendments_section_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        var psid = $(this).attr("sid");
        amendsUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content").html("");
            $("#single_amended_content").html("");
            $("#single_view_all_sections_amend").html(this.responseText);
            $(".show li").show();
        }
        xhr.send();
    });
    
    //View all single amendments links for amendments under an regulation
    $(document).on('click','.single_view_all_amendments_under_regulation_section_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        var psid = $(this).attr("sid");
        amendsUnderRegulationsetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html("");
            $("#single_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html(this.responseText);
            $(".show li").show();
        }
        xhr.send();
    });
    
    //View all single regulation links for regulation under an act
    $(document).on('click','.single_view_all_regulation_section_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        var psid = $(this).attr("sid");
        regulationUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html("");
            $("#single_regulation_content").html("");
            $("#single_view_all_sections_regulation").html(this.responseText);
            $(".show li").show();
        }
        xhr.send();
    });
    //-----------------------------------------------------------------------------------------------------------------
    
    // PREVIOUS AND NEXT BUTTON FOR ACTS
    
    //previous for post act
    $(document).on('click','.previous_content_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        setPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //previous for constitutional instruments
    $(document).on('click','.previous_constitutional_acts', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionalSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //previous for executive instruments
    $(document).on('click','.previous_executive_acts', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        executiveSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    $(document).on('click','.plain_previous_content_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        setPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $(".plain_content_display").html("");
            $(".next_previous_content_display").html(this.responseText);
        }
        xhr.send();
    });

    
    // $(document).on('click','.checking_link', function(e){ 
    //      alert( $(this).attr("href") );
    // });

    $(document).on('click','.displayed_previous_next', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        var psid = $(this).attr("sid");
        setPrevNext(psid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $(".plain_content_display").html("");
            $(".hide_sections").hide();
            $('.previous_next_hidden_show').show();
            $(".next_previous_content_display").html(this.responseText);
        }
        xhr.send();
    });

    

     //previous for pre act
    $(document).on('click','.previous_content_pre_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        preSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                $("#display_preamble").html("");
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
            }
        }
        xhr.send();
    });
    
    //previous for constitution act
    $(document).on('click','.previous_content_constitution_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for constitution amended act
    $(document).on('click','.previous_content_constitution_amended_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionAmendedSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //previous for regulation
    $(document).on('click','.previous_content_regulation', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for amendments
    $(document).on('click','.previous_content_amendments', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendmentsSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for amendments UNDER act
    $(document).on('click','.previous_amended_under_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content").html("");
            $("#single_view_all_sections_amend").html("");
            $("#single_amended_content").html(this.responseText);
        }
        xhr.send();
    });
    
     //previous for amendments UNDER regulation
    $(document).on('click','.previous_amendment_under_regulation', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderRegulationsetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html("");
            $("#single_amended_content_for_regulation").html(this.responseText);
        }
        xhr.send();
    });
    
    //previous for regulations UNDER act
    $(document).on('click','.previous_regulation_under_act', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationUnderActSetPrevNext(psid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $("#single_regulation_content").html(this.responseText);
        }
        xhr.send();
    });
    //-------------------------------------------END OF PREVIOUS BUTTON---------------------------------
    //next for post act
    $(document).on('click','.next_content_act', function(e){
         e.preventDefault();
        var ids = $('#act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        setPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //next for constitutional instruments
    $(document).on('click','.next_constitutional_acts', function(e){
        e.preventDefault();
    //    var ids = $('#constitutional_act_contents').val();
       var xhr = new XMLHttpRequest();
       var link = $(this).attr("href");
       constitutionalSetPrevNext(nsid);

       xhr.open("GET", link, true);
       xhr.onreadystatechange = function receiveUpdate(e) {
           $("#display_preamble").html("");
           $("#display_view_all_section").html("");
           $("#display_content").html(this.responseText);
       }
       xhr.send();
   });

    //next for executive instruments
    $(document).on('click','.next_executive_acts', function(e){
        e.preventDefault();
        // var ids = $('#executive_act_contents').val();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        executiveSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    $(document).on('click','.plain_next_content_act', function(e){
        e.preventDefault();
       var ids = $('#act_contplain_next_content_actents').val();

       var xhr = new XMLHttpRequest();
       var link = $(this).attr("href");
       setPrevNext(nsid);

       xhr.open("GET", link, true);
       xhr.onreadystatechange = function receiveUpdate(e) {
           $(".plain_content_display").html("");
           $(".next_previous_content_display").html(this.responseText);
       }
       xhr.send();
   });
    
     //next for pre act
    $(document).on('click','.next_content_pre_act', function(e){
         e.preventDefault();
        var ids = $('#pre_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        preSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                $("#display_preamble").html("");
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
            }
        }
        xhr.send();
    });
    
    
    //next for constitution act
    $(document).on('click','.next_content_constitution_act', function(e){
         e.preventDefault();
        var ids = $('#constitution_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for constitution amended act
    $(document).on('click','.next_content_constitution_amended_act', function(e){
         e.preventDefault();
        var ids = $('#constitution_amended_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        constitutionAmendedSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
     //next for regulation
    $(document).on('click','.next_content_regulation', function(e){
         e.preventDefault();
        var ids = $('#regulation_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for amendments
    $(document).on('click','.next_content_amendments', function(e){
         e.preventDefault();
        var ids = $('#amendments_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendmentsSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for amendments UNDER act
    $(document).on('click','.next_amended_under_act', function(e){
         e.preventDefault();
        var ids = $('#amends_under_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderActSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content").html("");
            $("#single_view_all_sections_amend").html("");
            $("#single_amended_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for amendments UNDER regulations
    $(document).on('click','.next_amendment_under_regulation', function(e){
         e.preventDefault();
        var ids = $('#amends_under_regulations_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        amendsUnderRegulationsetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_amended_content_for_regulation").html("");
            $("#single_view_all_sections_amend_for_regulation").html("");
            $("#single_amended_content_for_regulation").html(this.responseText);
        }
        xhr.send();
    });
    
    //next for regulations UNDER act
    $(document).on('click','.next_regulation_under_act', function(e){
         e.preventDefault();
        var ids = $('#regulation_under_act_contents').val();
 
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        regulationUnderActSetPrevNext(nsid);

        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html("");
            $("#single_view_all_sections_regulation").html("");
            $("#single_regulation_content").html(this.responseText);
        }
        xhr.send();
    });
    
    
    // END OF PREVIOUS AND NEXT BUTTON for act--------end of the clicking
    
    //-------------------------------------------THE PROCESS FOR THE PREVIOUS AND NEXT---------------------------------------

    //BUILDING THE FUNCTION FOR THE PREVIOUS AND NEXT

    // BUILDING THE PREVIOUS AND NEXT--------the process for the post act
    function setPrevNext(gsid1){
        var sid = gsid1;       
        var ids = $('#act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
    
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post_1992_legislation/content/'+aay[previous];
        var nLink = '/post_1992_legislation/content/'+aay[next];

        $('.previous_content_act').attr('href', pLink);
        $('.next_content_act').attr('href', nLink);

        // for the plain view

        // var p_Link = '/post_1992_legislation/plain-content/'+aay[previous];
        // var n_Link = '/post_1992_legislation/plain-content/'+aay[next];

        // var p_Link = '/post_1992_legislation/plain-content/'+aay[previous];
        // var n_Link = '/post_1992_legislation/plain-content/'+aay[next];
        
        // $('.plain_previous_content_act').attr('href', p_Link);
        // $('.plain_next_content_act').attr('href', n_Link);

    }

    // BUILDING THE PREVIOUS AND NEXT--------the process for the pre act
    function constitutionalSetPrevNext(gsid11){
        var sid = gsid11;       
        var ids = $('#constitutional_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post-1992-legislation/constitutional-acts/content/'+aay[previous];
        var nLink = '/post-1992-legislation/constitutional-acts/content/'+aay[next];
        
        $('.previous_constitutional_acts').attr('href', pLink);
        $('.next_constitutional_acts').attr('href', nLink);

    }

     // BUILDING THE PREVIOUS AND NEXT--------the process for the pre act
     function executiveSetPrevNext(gsid12){
        var sid = gsid12;       
        var ids = $('#executive_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post-1992-legislation/executive-acts/content/'+aay[previous];
        var nLink = '/post-1992-legislation/executive-acts/content/'+aay[next];
        
        $('.previous_executive_acts').attr('href', pLink);
        $('.next_executive_acts').attr('href', nLink);

    }
    
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the pre act
    function preSetPrevNext(gsid2){
        var sid = gsid2;       
        var ids = $('#pre_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/pre_1992_legislation/content/'+aay[previous];
        var nLink = '/pre_1992_legislation/content/'+aay[next];
        
        $('.previous_content_pre_act').attr('href', pLink);
        $('.next_content_pre_act').attr('href', nLink);

        if (typeof window.highlightActiveTOCItem === 'function') {
            window.highlightActiveTOCItem(gsid2);
        } else if (typeof updateActiveTOCHighlight === 'function') {
            updateActiveTOCHighlight(gsid2);
        }
    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the constitution act
    function constitutionSetPrevNext(gsid3){
        var sid = gsid3;       
        var ids = $('#constitution_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/constitution/Republic/constitution_content/'+aay[previous];
        var nLink = '/constitution/Republic/constitution_content/'+aay[next];
        
        $('.previous_content_constitution_act').attr('href', pLink);
        $('.next_content_constitution_act').attr('href', nLink);

        if (typeof window.highlightActiveConstitutionTOCItem === 'function') {
            window.highlightActiveConstitutionTOCItem(gsid3);
        }
    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the constitution amended act
    function constitutionAmendedSetPrevNext(gsid4){
        var sid = gsid4;       
        var ids = $('#constitution_amended_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/constitution_amended/Republic/constitution_content/'+aay[previous];
        var nLink = '/constitution_amended/Republic/constitution_content/'+aay[next];
        
        $('.previous_content_constitution_amended_act').attr('href', pLink);
        $('.next_content_constitution_amended_act').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the regulation
    function regulationSetPrevNext(gsid5){
        var sid = gsid5;       
        var ids = $('#regulation_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post_1992_legislation/regulation_act/content/'+aay[previous];
        var nLink = '/post_1992_legislation/regulation_act/content/'+aay[next];
        
        $('.previous_content_regulation').attr('href', pLink);
        $('.next_content_regulation').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the amendments
    function amendmentsSetPrevNext(gsid6){
        var sid = gsid6;       
        var ids = $('#amendments_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post_1992_legislation/amended_acts/content/'+aay[previous];
        var nLink = '/post_1992_legislation/amended_acts/content/'+aay[next];
        
        $('.previous_content_amendments').attr('href', pLink);
        $('.next_content_amendments').attr('href', nLink);
    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the amendments UNDER an act
    function amendsUnderActSetPrevNext(gsid7){
        var sid = gsid7;       
        var ids = $('#amends_under_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post_1992_legislation/amended_act_content/'+aay[previous];
        var nLink = '/post_1992_legislation/amended_act_content/'+aay[next];
        
        $('.previous_amended_under_act').attr('href', pLink);
        $('.next_amended_under_act').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the amendments UNDER an regulation
    function amendsUnderRegulationsetPrevNext(gsid8){
        var sid = gsid8;       
        var ids = $('#amends_under_regulations_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post_1992_legislation/amended_act_regulation_content/'+aay[previous];
        var nLink = '/post_1992_legislation/amended_act_regulation_content/'+aay[next];
        
        $('.previous_amendment_under_regulation').attr('href', pLink);
        $('.next_amendment_under_regulation').attr('href', nLink);

    }
    
    // BUILDING THE PREVIOUS AND NEXT--------the process for the regulation UNDER an act
    function regulationUnderActSetPrevNext(gsid9){
        var sid = gsid9;       
        var ids = $('#regulation_under_act_contents').val();
        console.log('ids', JSON.parse(ids)); //showing all ids
        var previous = '', next = '';
        //find index of sid in ids array
        var aay = JSON.parse(ids);
        
        var arrayLength = aay.length;
        var index = 0;
        for (var i = 0; i < arrayLength; i++) {
            if(aay[i] == sid){
                index = i;
            }
        }

        console.log('index', index); // showing the clicked index
        previous = (index > 0) ? index - 1: 0;
        next = (index == arrayLength-1)?arrayLength-1:index + 1;
        console.log('previous', aay[previous], 'next',aay[next]); //showing the next and previous ids
        psid = aay[previous]; nsid = aay[next];
        
        var pLink = '/post_1992_legislation/regulations_content/'+aay[previous];
        var nLink = '/post_1992_legislation/regulations_content/'+aay[next];
        
        $('.previous_regulation_under_act').attr('href', pLink);
        $('.next_regulation_under_act').attr('href', nLink);

    }
    
    //---------------------------------------PREVIOUS AND NEXT FOR THE PARTS AND SECTION-----------------------------------
    
    //FOR POST
    $(document).on('click','.content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        //set previous and next function
        gsid = $(this).attr("sid"); 
        setPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");
        }
        xhr.send();
    });

    //FOR Constitutional Instruments
    $(document).on('click','.constitutional_content_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionalSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });

    //FOR Executive Instruments
    $(document).on('click','.executive_content_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        executiveSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION
    //FOR PRE
    $(document).on('click','.pre_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href"); 

        //set previous and next function
        gsid = $(this).attr("sid"); 
        preSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                $("#v-pills-profile-tab").trigger("click");
                $(".preamble_hide_pre_next").css("display", "block"); 
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
                if (typeof window.highlightActiveTOCItem === 'function') {
                    window.highlightActiveTOCItem(gsid);
                } else if (typeof updateActiveTOCHighlight === 'function') {
                    updateActiveTOCHighlight(gsid);
                }
            }
        }
        xhr.send();
    });

    $(document).on('click','.pre_preamble_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        preSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            if (this.readyState == 4 && this.status == 200) {
                // $("#display_preamble").html("");
                $("#display_view_all_section").html("");
                $("#display_content").html(this.responseText);
                $("#v-pills-profile-tab").trigger("click");
                $(".preamble_hide_pre_next").css("display", "none");            
                if (typeof setSidebarState === 'function') {
                    setSidebarState('right', false);
                }
                $('.toc-sidebar-module').hide();
                $('.content-sidebar-module').show();
            }
        }
        xhr.send();
    });

    $(document).on('click','.post_preamble_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        setPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });

    $(document).on('click','.amendments_preamble_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendmentsSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });

    $(document).on('click','.regulation_preamble_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        regulationSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });
    
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR CONSTITUTION
    $(document).on('click','.constitution_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block"); 
        }
        xhr.send();
    });

    $(document).on('click','.constitution_preamble_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");  

        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "none");            
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDED CONSTITUTION
    $(document).on('click','.constitution_amended_content_link', function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        constitutionAmendedSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR REGULATIONS
    $(document).on('click','.regulation_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");

        //set previous and next function
        gsid = $(this).attr("sid"); 
        regulationSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDMENTS
    $(document).on('click','.amendments_content_link', function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");        
        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendmentsSetPrevNext(gsid);
        
        xhr.open("GET", link, true);

        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
            $(".preamble_hide_pre_next").css("display", "block");
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDMENTS UNDER AN ACT
    $(document).on('click','.sinlge_amended_act_content_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendsUnderActSetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {

            // $("#single_preamble_amended_content").html("");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table').css("background-color","white");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table').css("border-color","#ddd");
            // $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-amendments-table').css("color","black");
            
            // $('.bg-color-amendments-contents').css({"backgroundColor" : "#f5f5f5"});
            // $('.bg-color-amendments-contents').css({"color" : "black"});
            // $('.single_container_details_link_amend').trigger("click");
            $("#single_amended_content").html(this.responseText);
            $("#single_view_all_sections_amend").html("");
            $("#v-pills-amendments-content-tab").trigger("click");
            $(".show li").show();
            
        }
        xhr.send();
    }); 
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR AMENDMENTS UNDER AN REGULATION
    $(document).on('click','.single_amendments_to_regulation_link', function(e){
        e.preventDefault();
        amended_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        //set previous and next function
        gsid = $(this).attr("sid"); 
        amendsUnderRegulationsetPrevNext(gsid);
        
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            // $("#single_preamble_amended_content_for_regulation").html(""); 
            // $('.single_container_details_link_amend_regulation').trigger("click");
            $("#single_amended_content").html(this.responseText);
            $("#single_view_all_sections_amend").html("");
            $("#v-pills-amendments-content-tab").trigger("click");
            $(".show li").show();
            
        }
        xhr.send();
    });
    
    //PREVIOUS AND NEXT FOR THE PARTS AND SECTION 
    //FOR REGULATIONS UNDER AN ACT
    $(document).on('click','.sinlge_regulation_act_content_link', function(e){
        e.preventDefault();
        regulation_act_toggle_content();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        //set previous and next function
        gsid = $(this).attr("sid"); 
        regulationUnderActSetPrevNext(gsid);
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#single_preamble_regulation_content").html(""); 

            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table').css("background-color","white");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table').css("border-color","#ddd");
            $('.tabPaned_color_table_of_table, .bg-color-content, .bg-color-expanded, .bg-color-regulations-table').css("color","black");

            $('.bg-color-regulations-contents').css({"backgroundColor" : "#f5f5f5"});
            $('.bg-color-regulations-contents').css({"color" : "black"});

            $("#single_regulation_content").html(this.responseText);
            $("#single_view_all_sections_regulation").html("");
            $('.single_container_details_link_regulation').trigger("click");
            $(".show li").show();
        }
        xhr.send();
    }); 
    
    //-----------------------------------------------------------------------------------------------------end of the process for act 







    // DISPLAY PREAMBLE AND CONTENT IN TAB
    //Acts preamble
    // $('.act_preamble_link').click(function(e){
    //     e.preventDefault();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#act_content").html("");
    //         $("#view_acts_section").html("");
    //         $("#act_preamble").html(this.responseText);  

    //         $("#display_content").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_preamble").html(this.responseText);
    //     }
    //     xhr.send();
    // });

    //EXPANDED VIEW
    $('.expanded_link').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#v-pills-messages-tab").trigger("click");
            $("#acts_expanded_view").html(this.responseText);
        }
        xhr.send();
    });
    
    //New
    $('#expanded_link_toggle_all_pre1992_preview_1').click(function (e) {
        e.preventDefault();
        $('#tabs a[href="#expandedTab"]').tab('show');
        $('.tabPanedHide_expanded_view').show();
    });
    $('#expanded_link_toggle_all_pre1992_preview_2').click(function (e) {
        e.preventDefault();
        $('#tabs a[href="#expandedTab"]').tab('show');
        $('.tabPanedHide_expanded_view').show();
    });

    $('.toggle_expanded_view').click(function (e) {
        e.preventDefault();
        $('#tabs a[href="#expandedTab"]').tab('show');
        $('.tabPanedHide_expanded_view').show();
    });



    //GENERAL PREAMBLE LINK
    // General Preamble link: Click and go to Display Preamble at Content
    $('.preamble_link').click(function(e){
        e.preventDefault();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#v-pills-profile-tab").trigger("click");
            $("#display_content").html(this.responseText);
        }
        xhr.send();
    });
    
    //---------------------------------------IMPORTANT FOR THE PREVIOUS AND NEXT-----------THE BEGINNING----FROM THE PARTS AND SECTIONS
    //GENERAL CONTENT LINK
    // General content link: Click and go to Display section at Content for post 
    // $('.content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText); 
    //     }
    //     xhr.send();
    // });

    $('.constitutional_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });

    $('.executive_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });
    
    // General content link: Click and go to Display section at Content for pre
    // $('.pre_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
    //         $(".preamble_hide_pre_next").css("display", "block");            
    //     }
    //     xhr.send();
    // });

    // General content link: Click and go to Display section at Content for pre
    // $('.pre_preamble_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
    //         $(".preamble_hide_pre_next").css("display", "none");            
    //     }
    //     xhr.send();
    // });
    
    // General content link: Click and go to Display section at Content for constitution
    // $('.constitution_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
            
    //     }
    //     xhr.send();
    // });
    
    // General content link: Click and go to Display section at Content for amended constitution
    $('.constitution_amended_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });
    
    // General content link: Click and go to Display section at Content for regulation
    // $('.regulation_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
            
    //     }
    //     xhr.send();
    // });
    
    // General content link: Click and go to Display section at Content for amendments
    // $('.amendments_content_link').click(function(e){
    //     e.preventDefault();
    //     act_content_link_toggle();
    //     var xhr = new XMLHttpRequest();
    //     var link = $(this).attr("href");
    //     xhr.open("GET", link, true);
    //     xhr.onreadystatechange = function receiveUpdate(e) {
    //         $("#display_preamble").html("");
    //         $("#display_view_all_section").html("");
    //         $("#display_content").html(this.responseText);
            
    //     }
    //     xhr.send();
    // });

    // General content link: Click and go to Display section at Content for amendments on regulation
    $('.amended_regulation_content_link').click(function(e){
        e.preventDefault();
        act_content_link_toggle();
        var xhr = new XMLHttpRequest();
        var link = $(this).attr("href");
        xhr.open("GET", link, true);
        xhr.onreadystatechange = function receiveUpdate(e) {
            $("#display_preamble").html("");
            $("#display_view_all_section").html("");
            $("#display_content").html(this.responseText);
            
        }
        xhr.send();
    });
    
    //GENERAL PREVIOUS AND NEXT SHOW/HIDE
    // hide next and previous for General preamble and content
    $(".preamble_link").click(function(){
        $(".show li").hide();
    });
    $(".content_link, .post_preamble_content_link, .amendments_preamble_link, .regulation_preamble_link, .pre_content_link,.pre_preamble_content_link, .constitution_preamble_link, .constitution_content_link,.constitution_amended_content_link,.amendments_content_link, .amended_regulation_content_link,.regulation_content_link, .view_all_section_link").click(function(){
        $(".show li").show();
    });
    //----------------------------------------------------IMPORTANT FOR THE PREVIOUS AND NEXT----------THE END

    //click to scroll to top
    $("[data-scroll-to]").click(function() {
      var $this = $(this),
      $toElement      = $this.attr('data-scroll-to'),
      $focusElement   = $this.attr('data-scroll-focus'),
      $offset         = $this.attr('data-scroll-offset') * 1 || 0,
      $speed          = $this.attr('data-scroll-speed') * 1 || 500;

      $('html, body').animate({
        scrollTop: $($toElement).offset().top + $offset
      }, $speed);
  
      if ($focusElement) $($focusElement).focus();
    });

     // FILTERING CONSTITUTION----------------------------------------------------
    /* For all Constitution */
    $('#all_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_constitution_filter_year").val();
        var country     = $(".all_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/filter/'+year+'/'+country;
    });

    /* For all Africa Countries */
    $('#africa_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".africa_constitution_filter_year").val();
        var country     = $(".africa_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/1/africa/filter/'+year+'/'+country;
    });

    /* For all Asia Countries */
    $('#asia_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".asia_constitution_filter_year").val();
        var country     = $(".asia_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/2/asia/filter/'+year+'/'+country;
    });

    /* For all Europe Countries */
    $('#europe_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".europe_constitution_filter_year").val();
        var country     = $(".europe_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/3/europe/filter/'+year+'/'+country;
    });

    /* For all North America Countries */
    $('#north_america_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".north_america_constitution_filter_year").val();
        var country     = $(".north_america_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/4/north_america/filter/'+year+'/'+country;
    });

    /* For all North America Countries */
    $('#south_america_constitution_filter').click(function(e){
        e.preventDefault();
        var year        = $(".south_america_constitution_filter_year").val();
        var country     = $(".south_america_constitution_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/constitution/5/south_america/filter/'+year+'/'+country;
    });

    // FILTERING POST-1992 LEGISLATION----------------------------------------------------
    /* For all Post-1992 Legislation */
    $('#all_post_1992_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_post_1992_legislation_filter_year").val();
        var category     = $(".all_post_1992_legislation_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/post_1992_legislation/filter/'+year+'/'+category;
    });

    /* For Acts of Parliament */
    $('#acts_of_parliament_filter').click(function(e){
        e.preventDefault();
        var year        = $(".acts_of_parliament_filter_year").val();
        var category     = $(".acts_of_parliment_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/post_1992_legislation/1/filter/'+year+'/'+category;
    });

    /* For Legislative Instruments */
    $('#legislative_instrument_filter').click(function(e){
        e.preventDefault();
        var year        = $(".legislative_instrument_filter_year").val();
        var category     = $(".legislative_instrument_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/post_1992_legislation/2/filter/'+year+'/'+category;
    });

    /* For Amendments */
    $('#amendments_filter').click(function(e){
        e.preventDefault();
        var year        = $(".amendments_filter_year").val();
        var category     = $(".amendments_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/post_1992_legislation/3/filter/'+year+'/'+category;
    });

    // FILTERING PRE-1992 LEGISLATION----------------------------------------------------
    /* For all Pre-1992 Legislation */
    $('#all_pre_1992_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_pre_1992_legislation_filter_year").val();
        var category     = $(".all_pre_1992_legislation_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/filter/'+year+'/'+category;
    });

    /* For all first republic*/
    $('#first_republic_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".first_republic_filter_year").val();
        var category     = $(".first_republic_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/1/filter/'+year+'/'+category;
    });

    /* For all second republic*/
    $('#second_republic_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".second_republic_filter_year").val();
        var category     = $(".second_republic_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/2/filter/'+year+'/'+category;
    });

    /* For all third republic*/
    $('#third_republic_legislation_filter').click(function(e){
        e.preventDefault();
        var year        = $(".third_republic_filter_year").val();
        var category     = $(".third_republic_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/3/filter/'+year+'/'+category;
    });

    /* PNDC Law*/
    $('#pndc_law_filter').click(function(e){
        e.preventDefault();
        var year        = $(".pndc_law_filter_year").val();
        var category     = $(".pndc_law_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/4/filter/'+year+'/'+category;
    });

    /* NLC Decree*/
    $('#nlc_decree_filter').click(function(e){
        e.preventDefault();
        var year        = $(".nlc_decree_filter_year").val();
        var category     = $(".nlc_decree_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/5/filter/'+year+'/'+category;
    });

    /* NRC Decree*/
    $('#nrc_decree_filter').click(function(e){
        e.preventDefault();
        var year        = $(".nrc_decree_filter_year").val();
        var category     = $(".nrc_decree_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/6/filter/'+year+'/'+category;
    });

    /* SMC Decree*/
    $('#smc_decree_filter').click(function(e){
        e.preventDefault();
        var year        = $(".smc_decree_filter_year").val();
        var category     = $(".smc_decree_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
            category = 0;
        }        
        window.location.href = '/pre_1992_legislation/7/filter/'+year+'/'+category;
    });

    // FILTERING LAW JUDGMENTS-----------------------------------------------------------
    /* For all Foreign Law Judgments */
    $('#all_foreign_judgment_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_judgment_filter_year").val();
        var country    = $(".all_judgment_filter_country").val();
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }        
        window.location.href = '/judgement/Foreign/filter/'+year+'/'+country;
    });

    /* For Africa Court */
    $('#africa_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".africa_court_filter_year").val();
        var country     = $(".africa_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/1/africa-court/filter/'+year+'/'+country;
    });

    /* For Asia Court */
    $('#asia_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".asia_court_filter_year").val();
        var country     = $(".asia_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/2/asia-court/filter/'+year+'/'+country;
    });

    /* For Europe Court */
    $('#europe_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".europe_court_filter_year").val();
        var country     = $(".europe_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/3/europe-court/filter/'+year+'/'+country;
    });

    /* For North America */
    $('#north_america_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".north_america_court_filter_year").val();
        var country     = $(".north_america_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/4/north-america-court/filter/'+year+'/'+country;
    });

    /* For South America */
    $('#south_america_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".south_america_court_filter_year").val();
        var country     = $(".south_america_court_filter_country").val();
        
        if(year === ""){
            year = 0;
        }
        if(country === ""){
            country = 0;
        }
        window.location.href = '/judgement/5/south-america-court/filter/'+year+'/'+country;
    });


    /* For all Ghana Law Judgments */
    $('#all_ghana_judgment_filter').click(function(e){
        e.preventDefault();
        var year        = $(".all_judgment_filter_year").val();
        var category    = $(".all_judgment_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }        
        window.location.href = '/judgement/Ghana/filter/'+year+'/'+category;
    });

    /* For Supreme Court */
    $('#supreme_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".supreme_court_filter_year").val();
        var category    = $(".supreme_court_filter_category").val();
        
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/1/supreme-court/filter/'+year+'/'+category;
    });

    /* For High Court */
    $('#high_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".high_court_filter_year").val();
        var category    = $(".high_court_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/2/high-court/filter/'+year+'/'+category;
    });
    /* Court of Appeal */
    $('#court_of_appeal_filter').click(function(e){
        e.preventDefault();
        var year        = $(".court_of_appeal_filter_year").val();
        var category    = $(".court_of_appeal_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/3/court-of-appeal/filter/'+year+'/'+category;
    });
    /*Circuit Court*/
    $('#circuit_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".circuit_court_filter_year").val();
        var category    = $(".circuit_court_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/4/circuit-court/filter/'+year+'/'+category;
    });
    /*District Court*/
    $('#district_court_filter').click(function(e){
        e.preventDefault();
        var year        = $(".district_court_filter_year").val();
        var category    = $(".district_court_filter_category").val();
         
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/judgement/5/district-court/filter/'+year+'/'+category;
    });
    //------------------------------------------------------------------------------------------------------
    
    /* For Supreme Court 
    $('#acts_of_parliament_filter').click(function(e){
        e.preventDefault();
        var year        = $(".acts_of_parliament_filter_year").val();
        var id=1;
        var category    = $(".act_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
        window.location.href = '/post_1992_legislation/acts_of_parliament/'+id+'/'+year+'/'+category;
    });
    */
    //------------------------------------------------------------------------------------------------------
    /* For the amendment */
    $('#amendment_filter').click(function(e){
        e.preventDefault();
        var year = $(".amendment_filter_year").val();
        var category = $(".amendment_filter_category").val();
        if(year === ""){
            year = 0;
        }
        if(category === ""){
             category = 0;
        }
       window.location.href = '/post_1992_legislation/amendments/'+year+'/'+category;
    }); 
});

// FILTERING FOR LAW JUDGEMENTS
    /* For all law judgements */
    // $('#all_judgement').click(function(e){
    //     e.preventDefault();
    //     var year = $(".judgement_filter_year").val();
    //     var category = $(".judgement_filter_category").val();
    //     if(year === ""){
    //         year = 0;
    //     }
    //     if(category === ""){
    //          category = 0;
    //     }
    //     window.location.href = '/judgement/Ghana/filter/'+year+'/'+category;
    // });

// PAGINATION FOR THE ACCORDION
/* pagination plugin */
$.fn.pageMe = function(opts){
    var $this = this,
        defaults = {
            perPage: 7,
            showPrevNext: false,
            numbersPerPage: 1,
            hidePageNumbers: false
        },
        settings = $.extend(defaults, opts);
    
    var listElement = $this;
    var perPage = settings.perPage; 
    var children = listElement.children();
    var pager = $('.pagination');
    
    if (typeof settings.childSelector!="undefined") {
        children = listElement.find(settings.childSelector);
    }
    
    if (typeof settings.pagerSelector!="undefined") {
        pager = $(settings.pagerSelector);
    }
    
    var numItems = children.size();
    var numPages = Math.ceil(numItems/perPage);

    var curr = 0;
    pager.data("curr",curr);
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
    }
    
    while(numPages > curr && (settings.hidePageNumbers==false)){
        $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
        curr++;
    }
  
    if (settings.numbersPerPage>1) {
       $('.page_link').hide();
       $('.page_link').slice(pager.data("curr"), settings.numbersPerPage).show();
    }
    
    if (settings.showPrevNext){
        $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
    }
    
    pager.find('.page_link:first').addClass('active');
    pager.find('.prev_link').hide();
    if (numPages<=1) {
        pager.find('.next_link').hide();
    }
      pager.children().eq(0).addClass("active");
    
    children.hide();
    children.slice(0, perPage).show();
    
    pager.find('li .page_link').click(function(){
        var clickedPage = $(this).html().valueOf()-1;
        goTo(clickedPage,perPage);
        return false;
    });
    pager.find('li .prev_link').click(function(){
        previous();
        return false;
    });
    pager.find('li .next_link').click(function(){
        next();
        return false;
    });
    
    function previous(){
        var goToPage = parseInt(pager.data("curr")) - 1;
        goTo(goToPage);
    }
     
    function next(){
        goToPage = parseInt(pager.data("curr")) + 1;
        goTo(goToPage);
    }
    
    function goTo(page){
        var startAt = page * perPage,
            endOn = startAt + perPage;
        
        children.css('display','none').slice(startAt, endOn).show();
        
        if (page>=1) {
            pager.find('.prev_link').show();
        }
        else {
            pager.find('.prev_link').hide();
        }
        
        if (page<(numPages-1)) {
            pager.find('.next_link').show();
        }
        else {
            pager.find('.next_link').hide();
        }
        
        pager.data("curr",page);
       
        if (settings.numbersPerPage>1) {
               $('.page_link').hide();
               $('.page_link').slice(page, settings.numbersPerPage+page).show();
        }
      
          pager.children().removeClass("active");
        pager.children().eq(page+1).addClass("active");
    
    }
};

/* end plugin */
$(document).ready(function(){ 
  $('#accordion').pageMe({pagerSelector:'#myPager',childSelector:'.panel',showPrevNext:true,hidePageNumbers:false,perPage:45});   
});

function newFunction() {
    return '.panel-collapse';
}

