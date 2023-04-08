/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './scss/app.scss';
import './js/cursor';
import $ from 'jquery';

$(function() {
    $('.js-scrollToTop').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $('html, body').animate({scrollTop: 0}, 700)
        $(e.currentTarget).blur();
    });

    let to = 'hello@fnev.eu';

    $('.js-mailto').attr('href', 'mailto:' + to);
});

$(function() {
    const $body = $('html body');
    const $navToggler = $('.js-nav-toggler');
    const $nav = $('header.header nav');

    $navToggler.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();

        $navToggler.toggleClass('open');
        $body.toggleClass('blur');
        $nav.toggleClass('open');
    })

    $('html').on('click', '.blur', function (e) {
        const $targetEvent = $(e.target);

        if (
            $targetEvent[0].tagName === 'A'
            || !$targetEvent[0].closest('header.header')
            || ($targetEvent[0].tagName === 'HEADER' && $targetEvent.hasClass('header'))
        ) {
            $navToggler.toggleClass('open');
            $body.toggleClass('blur');
            $nav.toggleClass('open');

            return;
        }

        e.preventDefault();
        e.stopPropagation();
    });
});

let lastScrollTop  = 0;

$(window).on('scroll', function() {
    const $this        = $(this);
    const $header      = $('header.header');
    const $scrollToTop = $('.js-scrollToTop');
    const scrollTop    = $this.scrollTop();

    if (scrollTop > 75 * $this.height() / 100) {
        $scrollToTop.css('opacity', 1);
    } else if (scrollTop < $this.height() / 2) {
        $scrollToTop.css('opacity', 0);
    }

    if (scrollTop > $header.height()) {
        $header.addClass('scrolling')

        scrollTop < lastScrollTop ? $header.addClass('scrollingTop') : $header.removeClass('scrollingTop');
    } else if (scrollTop <= 1) {
        $header.removeClass('scrolling scrollingTop');
    }

    lastScrollTop = scrollTop;
});

$(document).on('click', 'a', function (e) {
    e.preventDefault();
    const $this  = $(this);
    const target = $this.attr('href');

    if (target.charAt(0) !== '/') {
        if (target.charAt(0) === '#' && target !== '#' && $(target).length >= 1) {
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 700)

            return true;
        }

        if ($this.attr('target') === '_blank') {
            window.open(target, '_blank');
        } else {
            location.href = target;
        }

        return true;
    }

    $.ajax({
        method: 'GET',
        url: target,
        beforeSend: function() {
            $('main').css('opacity', 0);
            window.history.pushState({}, '', target);
        },
        success: function (response) {
            setTimeout(function() {
                $(window).scrollTop(0);
                let title = (/<title>(.*?)<\/title>/m).exec(response)[1];

                $('head title').html(title);
                $('meta[name="og:title"]').attr('content', title);

                let content = $($.parseHTML(response)).filter('#content');

                $('#content').html(content.html());
                $('main').css('opacity', 1);
            }, 500);
        }
    });
});

window.onpopstate = function(event) {
    if (event && event.state) {
        location.reload();
    }
}
