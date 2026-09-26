// =======================
// Swiper
// =======================
import Swiper from 'swiper';
import { Autoplay, Pagination, Navigation } from 'swiper/modules';

import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

// =======================
// Swiper init
// =======================
function initSwiper() {
    const el = document.querySelector('.swiper');
    if (!el) return;

    if (el.swiper) {
        el.swiper.destroy(true, true);
    }

    new Swiper(el, {
        modules: [Autoplay, Pagination, Navigation],

        slidesPerView: 1.2,
        centeredSlides: true,
        spaceBetween: 16,
        loop: false,

        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        },

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
}

// =======================
// Scroll
// =======================
document.addEventListener('livewire:init', () => {
    Livewire.on('scrollToTop', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});

// =======================
// Page init
// =======================
function initPage() {
    initSwiper();
}

// =======================
// Init all
// =======================
document.addEventListener("DOMContentLoaded", () => {
    initPage();
});