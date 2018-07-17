
$(window).on('load',function(){


    var onCompleteGone = function(){

        $('#wrapperBeforeLoad').attr('style','display:none !important');
        $('#wrapperAfterLoad').css('display','block');


        // alert();
        $.fn.isInViewport = function() {
            var elementTop = $(this).offset().top;
            var elementBottom = elementTop + $(this).outerHeight();
            var elementHalf = elementTop + ($(this).outerHeight() / 2) ;

            var viewportTop = $(window).scrollTop();
            var viewportBottom = viewportTop + $(window).height();

            return elementBottom > viewportTop && elementHalf < viewportBottom;
        };

        function playAnimation(){
            $("*[target-class]").each(function(){

                if($(this).attr('animation-done')){
                    return;
                }

                if($(this).isInViewport()){

                    var targetClass = $(this).attr('target-class');
                    // $(this).addClass(targetClass);
                    animation(targetClass);
                    // $(this).removeClass(targetClass);
                    $(this).attr('animation-done',true);
                    // $(this).removeAttr("target-class");

                }
            });

        }

        $(window).on('scroll',function(){
            playAnimation();
        });
        playAnimation();



        $('.scrollToBottom').on('click',function(){

            $('html, body').animate({scrollTop:$(document).height()}, 1000);
        });





    }
    TweenMax.to($('#wrapperBeforeLoad'),0.3,{scale:5, opacity: 0,ease:Linear.easeNone, onComplete:onCompleteGone});




    $('.image-link').magnificPopup({type:'image'});
    $('.popup-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        tLoading: 'Loading image #%curr%...',
        mainClass: 'mfp-img-mobile',
        gallery: {
            enabled: true,
            navigateByImgClick: true,
            preload: [0,1] // Will preload 0 - before current, and 1 after the current image
        },
        image: {
            tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
            titleSrc: function(item) {
                return "";
                // return item.el.attr('title') + '';
            }
        },

    });


});
