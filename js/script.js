document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.toggle('is-open');
            menuToggle.classList.toggle('is-open', isOpen);
            menuToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        });

        mobileMenu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                mobileMenu.classList.remove('is-open');
                menuToggle.classList.remove('is-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });
    }

    const showServicesButton = document.querySelector('[data-show-services]');
    const extraServices = document.querySelectorAll('[data-extra-service]');

    if (showServicesButton && extraServices.length > 0) {
        showServicesButton.addEventListener('click', function () {
            extraServices.forEach(function (serviceCard) {
                serviceCard.hidden = false;
                serviceCard.classList.add('is-visible');
            });

            showServicesButton.hidden = true;
        });
    }

    function initCarousel(slider, config) {
        const track = slider.querySelector(config.trackSelector);

        if (!track) {
            return;
        }

        const originalSlides = Array.from(track.querySelectorAll(config.slideSelector));

        if (originalSlides.length === 0) {
            return;
        }

        let visibleSlides = 1;
        let currentIndex = 0;
        let intervalId;
        const prevButton = slider.querySelector('[data-carousel-prev]');
        const nextButton = slider.querySelector('[data-carousel-next]');

        function getVisibleSlides() {
            if (window.innerWidth <= 680) {
                return Number(slider.dataset.visibleMobile || config.mobileVisible || 1);
            }

            if (window.innerWidth <= 1024) {
                return Number(slider.dataset.visibleTablet || config.tabletVisible || 1);
            }

            return Number(slider.dataset.visibleDesktop || config.desktopVisible || 1);
        }

        function buildClones() {
            track.querySelectorAll('.is-clone').forEach(function (node) {
                node.remove();
            });

            visibleSlides = getVisibleSlides();

            originalSlides.slice(0, visibleSlides).forEach(function (slide) {
                const clone = slide.cloneNode(true);
                clone.classList.add('is-clone');
                track.appendChild(clone);
            });
        }

        function getStepSize() {
            const firstSlide = track.querySelector(config.slideSelector);

            if (!firstSlide) {
                return 0;
            }

            const gap = parseFloat(window.getComputedStyle(track).gap) || 0;
            return firstSlide.getBoundingClientRect().width + gap;
        }

        function goToSlide(index, animate) {
            const stepSize = getStepSize();
            track.style.transition = animate ? 'transform 0.7s ease' : 'none';
            track.style.transform = 'translateX(-' + (stepSize * index) + 'px)';
        }

        function startSlider() {
            clearInterval(intervalId);

            intervalId = setInterval(function () {
                goNext();
            }, config.interval || 3200);
        }

        function normalizeLoop() {
            if (currentIndex >= originalSlides.length) {
                setTimeout(function () {
                    currentIndex = 0;
                    goToSlide(currentIndex, false);
                }, 720);
            }
        }

        function goNext() {
            currentIndex += 1;
            goToSlide(currentIndex, true);
            normalizeLoop();
        }

        function goPrev() {
            if (currentIndex <= 0) {
                currentIndex = originalSlides.length - 1;
                goToSlide(currentIndex, false);
                return;
            }

            currentIndex -= 1;
            goToSlide(currentIndex, true);
        }

        function setupSlider() {
            currentIndex = 0;
            buildClones();
            goToSlide(0, false);
            startSlider();
        }

        window.addEventListener('resize', function () {
            setupSlider();
        });

        slider.addEventListener('mouseenter', function () {
            clearInterval(intervalId);
        });

        slider.addEventListener('mouseleave', function () {
            startSlider();
        });

        if (prevButton) {
            prevButton.addEventListener('click', function () {
                clearInterval(intervalId);
                goPrev();
                startSlider();
            });
        }

        if (nextButton) {
            nextButton.addEventListener('click', function () {
                clearInterval(intervalId);
                goNext();
                startSlider();
            });
        }

        setupSlider();
    }

    const testimonialSlider = document.querySelector('[data-testimonial-slider]');

    if (testimonialSlider) {
        initCarousel(testimonialSlider, {
            trackSelector: '[data-testimonial-track]',
            slideSelector: '[data-testimonial-slide]',
            desktopVisible: 3,
            tabletVisible: 2,
            mobileVisible: 1,
            interval: 3200
        });
    }

    document.querySelectorAll('[data-carousel]').forEach(function (slider) {
        initCarousel(slider, {
            trackSelector: '[data-carousel-track]',
            slideSelector: '[data-carousel-slide]',
            desktopVisible: 1,
            tabletVisible: 1,
            mobileVisible: 1,
            interval: 3400
        });
    });
});
