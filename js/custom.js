(function ($) {
  Drupal.behaviors.genesis_btfp = {
    attach: function(context, settings) {
      
      if ($.fn.cycle) {
        $.fn.cycle.transitions.scrollHorz = function($cont, $slides, opts) {
        
          var make_width = $(window).width();
        
          if (make_width >= 960) {
            make_width = 960;
          }
          $('.view-slide-front .views-slideshow-cycle-main-frame-row, #views_slideshow_cycle_teaser_section_slide_front-block').width(make_width);
          

          
          $cont.width(make_width);
          $cont.css('overflow','hidden');
        
          var width = make_width;
          opts.before.push(function(curr, next, opts, fwd) {
            if (opts.rev)
              fwd = !fwd;
            $.fn.cycle.commonReset(curr,next,opts);
            opts.cssBefore.left = fwd ? (next.cycleW-1) : (1-next.cycleW);
            opts.animOut.left = fwd ? -width : width;
            
            $slides.each(function () {
              if ($(this).attr('id') != $(curr).attr('id')) {
                $(this).css('left', -make_width);
              }
            });
            
          });  
          opts.cssFirst.left = 0; 
          opts.cssBefore.top = 0; 
          opts.animIn.left = 0; 
          opts.animOut.top = 0; 
        };
      }
    


      $("#block-views-calendar-block_1 .date-prev a ,  #block-views-calendar-block_1 .date-next a").live('mouseover touchend', function() {
        $(".bt-wrapper").hide();
      });    

   
      $('.jcarousel-prev-horizontal').text(Drupal.t('Previous'));
      $('.jcarousel-next-horizontal').text(Drupal.t('Next'));            
    
      $('.field-name-field-video-url .field-item').each(function() { 
        var alt = $(this).find('.video-embed-description').html();
        $(this).find('img').attr('alt', alt);
      });
      
      
      
      // Responsive
      
      var menu = $('#superfish-1');
      var menu_btn = $('#block-superfish-1 .block-title');
      
      var search = $('#search-block-form');
      var search_btn = $('.block-search .block-title');
      
      var responsive_init = function () {
        
        var make_width = $(window).width();
        
        if (make_width >= 940) {
          menu.css({'height': 'auto', 'display': 'block', 'overflow': 'visible'});
          //menu_btn.removeClass('hide_menu')
          make_width = 950;
        }
        else {
          if (parseInt($.cookie('hide_menu'))) {

            menu.css({'height': 0, 'display': 'block', 'overflow': 'hidden'});
            menu_btn.addClass('hide_menu')
          }
          
        }
        
        $('.view-slide-front .views-slideshow-cycle-main-frame-row, #views_slideshow_cycle_teaser_section_slide_front-block').width(make_width);
        
        
        
      }
      
      
      var responsive_monitor = function () {
      
        menu_btn.click(function () {
          
          if ($(window).width() >= 960) {
            return true;
          }
        
          if (menu.css('height') != '0px') {
            menu.css({'height': 0, 'display': 'block', 'overflow': 'hidden'});
            $.cookie('hide_menu', 1);
            menu_btn.addClass('hide_menu')
          }
          else {
            menu.css({'height': 'auto', 'display': 'block', 'overflow': 'visible'});
            $.cookie('hide_menu', 0);
            menu_btn.removeClass('hide_menu')
          
          }
        })
      

      
        search_btn.click(function () {

          if (search.css('height') != '0px') {
            search.css({'height': 0, 'display': 'block', 'overflow': 'hidden'});
            search_btn.addClass('hide_search')
          }
          else {
            search.css({'height': 'auto', 'display': 'block', 'overflow': 'visible'});
            search_btn.removeClass('hide_search')
            search.find('.compact-form-field').focus();
          }
        })
      
        search_btn.addClass('hide_search');
      
      }
      
      $(".search-click").click(function() {
        $("#edit-search-block-form--2").focus()
      });
      
      responsive_init();
      responsive_monitor();
      $(window).resize(function() {
        console.log($(window).width());
        
        responsive_init();
        
      });

    }
    
    

    
    
 }
})(jQuery);


