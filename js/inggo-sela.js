(function($){
    $(document).ready(function(){
        $('.more-link').click(function(e){
            if ($(this).closest('.entry-content').find('.entry-extended').length > 0) {
              e.preventDefault();
              $(this)
                .toggleClass('active')
                  .find('.dashicons')
                    .toggleClass('dashicons-arrow-down')
                    .toggleClass('dashicons-arrow-up')
                  .end()
                    .closest('.entry-content')
                      .find('.entry-extended')
                        .stop()
                        .slideToggle(200)
                        .toggleClass('shown');
              return false;
            }
        });
    });
})(jQuery);