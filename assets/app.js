/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import $ from 'jquery';

$(function() {
    $('.js-scrollToTop').on('click', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $('html, body').animate({scrollTop: 0}, 700)
    });

    let to = 'hello@fnev.eu';

    $('.js-mailto').attr('href', 'mailto:' + to);
});

$(window).on('scroll', function() {
    const $this = $(this);

    if ($this.scrollTop() > 75 * $this.height() / 100) {
        $('.js-scrollToTop').css('opacity', 1);
    } else if ($this.scrollTop() < $this.height() / 2) {
        $('.js-scrollToTop').css('opacity', 0);
    }
});

$(document).on('click', 'a', function (e) {
    e.preventDefault();
    const $this  = $(this);
    const target = $this.attr('href');

    console.log(target);

    if (target.charAt(0) !== '/') {
        if (target.charAt(0) === '#' && target !== '#' && $(target).length >= 1) {
            $('html, body').animate({
                scrollTop: $(target).offset().top
            }, 700)
        }

        if ($this.attr('target') === '_blank') {
            window.open(target, '_blank');
        } else {
            location.href = target;
        }

        return true;
    }

    let $ajax = $.ajax({
        method: 'GET',
        url: target,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();

            xhr.addEventListener("progress", function(evt){
                if (evt.lengthComputable) {
                    var percentComplete = evt.loaded / evt.total;
                    // Do something with download progress
                    //console.log(percentComplete);
                }
            }, false);

            return xhr;
        },
        beforeSend: function() {
            //$('.preloader').css('display', 'block');
            $('main').css('opacity', 0);
            window.history.pushState({}, '', target);
        },
        success: function (response) {
            //console.log(data);
            setTimeout(function() {
                $(window).scrollTop(0);
                let title=(/<title>(.*?)<\/title>/m).exec(response)[1];

                $('head title').text(title);
                $('meta[name="og:title"]').attr('content', title);

                let content = $($.parseHTML(response)).filter('#content');

                $('#content').html(content.html());
                $('main').css('opacity', 1);
                //$('.preloader').css('display', 'none');
            }, 500);
        }
    });
});

window.onpopstate = function(event) {
    if (event && event.state) {
        //if (!event.explicitOriginalTarget || event.explicitOriginalTarget !== window) {
            location.reload();
        //}
    }
}