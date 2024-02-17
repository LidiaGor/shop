document.addEventListener('DOMContentLoaded', function () {
    $('[data-fancybox^="gallery"]').fancybox({
        loop: true,
        animationEffect: false,
        autoFocus: false,
        arrows: true,
        trapFocus: true,
        toolbar: true,
        infobar: false,
        margin: [100, 0],
        transitionEffect: "fade",
        smallBtn: false
    });

    $(".header__btn").click(function () {
        $(this).toggleClass('active');
        $('.header-catalog-menu').toggleClass('active');
    });

    $(".header-catalog-menu_close").click(function () {
        $('.header-catalog-menu, .header__btn').toggleClass('active');
    });

    $('.menu-accordion').accordion({
        active: true,
        collapsible: true,
        heightStyle: 'content',
        header: '> .menu-accordion-item > .menu-accordion-header'

    });

    $(window).resize(function () {
        var windowWidth = document.documentElement.clientWidth;

        if (windowWidth > 1025) {
            $(".menu-accordion .ui-accordion-content").show();
        } else {
            $(".menu-accordion .ui-accordion-content").hide();
        }
    });

    $(window).resize();

    $('.order-accordion').accordion({
        active: true,
        collapsible: true,
        heightStyle: 'content',
        header: '> .order-accordion-item > .order-accordion-header'
    });
    $(".order-accordion .order-accordion-content").hide();

    $('.page-title .favorites').click(function () {
        $(this).toggleClass('active');
        if (!$(this).data('status')) {
            $(".page-title .favorites span").text('В избранном:');
            $(this).data('status', true);
        } else {
            $(".page-title .favorites span").text('В избранное:');
            $(this).data('status', false);
        }
    })

    $('.description-block__text .show-more').click(function () {
        $('.description-block__text p:not(:first-of-type)').slideToggle(300);
        $(this).text($(this).text() == "Скрыть" ? "Далее" : "Скрыть");
        return false;
    });


    $(".basket .del").click(function () {
        $(this).parents('article').remove();
    });


    $('.slider-similar').slick({
        arrows: false,
        dots: false,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4,
                    arrows: false
                }
            },
            {
                breakpoint: 667,
                settings: {
                    slidesToShow: 3,
                    arrows: false
                }
            },
            {
                breakpoint: 430,
                settings: {
                    slidesToShow: 1,
                    arrows: false,
                    centerMode: true,
                    centerPadding: '70px'
                }
            }

        ]
    });




    $("#lk-edit").click(function () {
        $('.block-lk').find('label').hide();
        $('.block-lk').find('input').show();
        return false;
    });


    $("#textsubmit").click(function () {
        $('#myprice').modal('hide');
        $('#submission').modal('show');
        setTimeout(function () {
            $('#submission').modal('hide');
        }, 5000);
        return false;
    });


});
