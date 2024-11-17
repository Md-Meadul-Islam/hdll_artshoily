$(document).ready(function () {
    //image lazy loading
    var lazyImages = $("img").toArray();
    let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
        $.each(entries, function (index, entry) {
            if (entry.isIntersecting) {
                let lazyImage = entry.target;
                lazyImage.src = $(lazyImage).data('src');
                $(lazyImage).addClass('active');
                observer.unobserve(lazyImage);
            }
        });
    });

    $.each(lazyImages, function (index, lazyImage) {
        lazyImageObserver.observe(lazyImage);
    });
    //image animation ovserver
    var animElements = $('.anim, .anim1, .anim2').toArray();
    let animObserver = new IntersectionObserver(function (entries, observer) {
        $.each(entries, function (index, entry) {
            if (entry.isIntersecting) {
                $(entry.target).addClass('active');
                observer.unobserve(entry.target);
            }
        });
    });

    $.each(animElements, function (index, animElement) {
        animObserver.observe(animElement);
    });
});
