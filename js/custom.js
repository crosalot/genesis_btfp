(function ($) {
  Drupal.behaviors.genesis_btfp = {
      attach: function(context, settings) {

        $("#block-views-calendar-block_1 .date-prev a ,  #block-views-calendar-block_1 .date-next a").live(
           'mouseover touchend', function() {
              $(".bt-wrapper").hide();
             });    
    $(".search-click").click(function() {
      $("#edit-search-block-form--2").focus()
    });  
   
    $('.jcarousel-prev-horizontal').text(Drupal.t('Previous'));
    $('.jcarousel-next-horizontal').text(Drupal.t('Next'));            
    
     $('.field-name-field-video-url .field-item').each(function() { 
      var alt = $(this).find('.video-embed-description').html();
      $(this).find('img').attr('alt', alt);
    });    

  }
 }
})(jQuery);



