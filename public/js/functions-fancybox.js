


function scrollWin(y) {
    var scroll = $(document).scrollTop();
    if(scroll < y) {
        $("html, body").animate({scrollTop: y + 'px'});

    }
}







$(document).ready(function () {


    $('[data-fancybox="gallery"]').fancybox({
        //autoFocus: false,
        //infobar: false,
        //smallBtn: false,
        caption : function( instance, item ) {
            return $(this).find('figcaption').html();
        },
        toolbar: true,
        loop: false,
        preventCaptionOverlap: false,
        animationEffect: "zoom-in-out",
        trapFocus: true
        //toolbar: true
    });




    //caption : function( instance, item ) {
        //return $(this).find('figcaption').html();
    //},



    $('[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-green',
        increaseArea: '20%' // optional
    });


    var searchBlock = $('#almost-burger');
    $(document).on('click', '#almost-burger-open', function () {
        searchBlock.slideToggle(2500);
        return false;
    });


    $('.almost-burger__close').on('click', function () {
        $('#almost-burger').slideToggle('hide');
    });




    window.onscroll = function () {
        headerFixed();
    };

    var asideFixed = document.getElementById("aside-fixed");
    var fixed = asideFixed.offsetTop;
    var bodyFixed = document.getElementById("bodyFixed");
    console.log("bodyFixed='%s'", bodyFixed);

   // console.log("asideFixed='%s'", asideFixed);

    function headerFixed() {
        if (window.pageYOffset > fixed) {
            asideFixed.classList.add("fixed");
            bodyFixed.classList.add('fixed-margin');
            console.log("bodyFixed='%s'", bodyFixed);
        } else {
            asideFixed.classList.remove("fixed");
            bodyFixed.classList.remove('fixed-margin');
            console.log("bodyFixed='%s'", bodyFixed);
        }
       // console.dirxml(document.getElementById('asideFixed'));
    }





    $('.leisure-wide,  .park-wide, .accommodation-wide, .gallery-one-wide, .gallery-two-wide, .gallery-small-one, .gallery-small-two').slick({
        arrows: false,
        dots: true,
        infinite: true,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 1000,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1
    });





    $('.construction-progress').slick({
        arrows: false,
        dots: true,
        infinite: true,
        //fade: true,
        //cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 1000,
        speed: 1000,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 420,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });



    $('.spa-narrow, .yard-narrow,  .events-narrow, .long-bar-narrow').slick({
        arrows: false,
        dots: true,
        infinite: true,
        fade: true,
        cssEase: 'linear',
        initialSlide: 1,
        //autoplay: true,
        autoplay: false,
        autoplaySpeed: 1000,
        speed: 1000,
        slidesToShow: 1,
        slidesToScroll: 1
    });




});
