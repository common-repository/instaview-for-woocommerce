( function( $ ) { 
  "use strict";
    $( document ).ready(function() { 
        $( document ).on( 'click', '.instaview-popup', function() { 
            var product_id = $( this ).data( 'product_id' );
            $.ajax({
                type : 'POST',
                url : instaviewAjax.ajaxurl,
                data: {
                    action : 'instaview_product_popup',
                    product_id : product_id,
                    nonce: instaviewAjax.nonce
                },
                success: function(data) {
                    $( '#instaview_popup' ).html( data );
                    $.colorbox({
                        inline: true,
                        href: '#instaview_popup',
                        width: "95%",
                        height: "80%",
                        maxWidth: "960px",
                        className: 'instaviewpopup-wrap',
                        onOpen: function() {
                            $('body').addClass('single-product');
                            $('body').addClass('singular');
                            $('body').css('overflow','hidden');
                        },
                        onClosed: function() {
                            $( '#instaview_popup' ).html('');
                            $('body').removeClass('singular');
                            $('body').removeClass('single-product');
                            $('body').css('overflow','visible');
                        },
                        onComplete: function() {
                            var product_gallery = $('#instaview_popup').find('.woocommerce-product-gallery');
                            product_gallery.each(function() {
                                $( this ).wc_product_gallery();
                            });

                            var form_variation = $('#instaview_popup').find('.variations_form');
                            form_variation.each(function() {
                                $( this ).wc_variation_form();
                            });

                            setTimeout(function() {
                                form_variation.trigger( 'check_variations' );
                                form_variation.trigger( 'wc_variation_form' );
                            }, 100);
                        }
                    });
                },
                error :function(){
                },
            });
        }); // End of Popup close
    });
})( jQuery );