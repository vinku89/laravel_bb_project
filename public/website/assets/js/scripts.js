$(document).ready(function () {

    // Off Canvas
    'use strict'
    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    })
    // Off Canvas End

    // Onscroll header color
    var header = $(".navbar");
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            header.addClass("scrolled");
        } else {
            header.removeClass("scrolled");
        }
    });
    // Onscroll header color End

    // Show more
    $('.support-img-btn').on('click', function () {
        // show more/less
        if ($(this).text() == "SHOW LESS") {
            $(this).text("SHOW MORE");
        } else {
            $(this).text("SHOW LESS");
        };
        // End show more/less
        if ($('.support-img').hasClass('show-less')) {
            $('.support-img').removeClass('show-less');
            $('.support-img').addClass('show-more');
        } else {
            $('.support-img').addClass('show-less');
            $('.support-img').removeClass('show-more');
        }
        $(this).hide;
    });
    // Show more End

    // Carousel
    $(".bestbox-hero").carousel({
        interval: 5000,
        pause: false
    });
    // Carousel End

    // navbar
    $(".navbar-toggler").on('click', function () {
        $(this).toggleClass("newopen");
    })

    // Smooth scrolling
    var scrollLink = $('.scroll');
    scrollLink.click(function (e) {
        e.preventDefault();
        $('body,html').animate({
            scrollTop: $(this.hash).offset().top
        }, 1000);
    });

    // Active link switching
    $(window).scroll(function () {
        var scrollbarLocation = $(this).scrollTop();

        scrollLink.each(function () {

            var sectionOffset = $(this.hash).offset().top - 20;

            if (sectionOffset <= scrollbarLocation) {
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass('active');
            }
        })

    })

    // Accordion
    $(document).ready(function () {
        $(".accordion-title").click(function (e) {
            var accordionitem = $(this).attr("data-tab");
            $("#" + accordionitem).slideToggle().parent().siblings().find(".accordion-content").slideUp();

            $(this).toggleClass("active-title");
            $("#" + accordionitem).parent().siblings().find(".accordion-title").removeClass("active-title");

            $("i.fa-chevron-down", this).toggleClass("chevron-top");
            $("#" + accordionitem).parent().siblings().find(".accordion-title i.fa-chevron-down").removeClass("chevron-top");
        });

    });

});
