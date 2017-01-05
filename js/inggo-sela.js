(function($){
  $(document).ready(function () {
    // Upon clicking more-link...
    $('.more-link').click(function (e) {
      // ... override default behavior if .entry-extended div is found...
      if ($(this).closest('.entry-content').find('.entry-extended').length > 0) {
        e.preventDefault();
        // ... toggle the 'active' class to the link
        $(this).toggleClass('active');
        // ... and toggle thet dashicon arrow classes
        $(this).find('.dashicons').toggleClass('dashicons-arrow-down').toggleClass('dashicons-arrow-up');
        // ... and show/hide the extended contents
        $(this).closest('.entry-content').find('.entry-extended').stop().slideToggle(200).toggleClass('shown');
        return false;
      }
    });

    // Clicking of .widget-title
    $('.widget-title').click(function (e) {
      $(this).next('ul').slideToggle();
    });
  });
})(jQuery);