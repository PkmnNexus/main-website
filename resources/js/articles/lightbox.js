document.addEventListener('DOMContentLoaded', () => {
    const articleBody = document.querySelector(
        '[itemprop="articleBody"]'
    );

    const lightbox = document.querySelector(
        '#article-lightbox'
    );

    if (!articleBody || !lightbox) {
        return;
    }

    const images = Array.from(
        articleBody.querySelectorAll('img')
    );

    if (!images.length) {
        return;
    }

    const lightboxImage = lightbox.querySelector(
        '[data-lightbox-image]'
    );

    const closeButton = lightbox.querySelector(
        '[data-lightbox-close]'
    );

    const previousButton = lightbox.querySelector(
        '[data-lightbox-prev]'
    );

    const nextButton = lightbox.querySelector(
        '[data-lightbox-next]'
    );

    const backdrop = lightbox.querySelector(
        '[data-lightbox-backdrop]'
    );

    const thumbnails = lightbox.querySelector(
        '[data-lightbox-thumbnails]'
    );

    let currentIndex = 0;
    let touchStartX = 0;
    let touchStartY = 0;
    let touchCurrentX = 0;
    let isTouching = false;

    const swipeThreshold = 50;

    const centerActiveThumbnail = () => {
        const activeThumbnail =
            thumbnails.querySelector(
                '.lightbox-thumbnail.is-active'
            );

        if (!activeThumbnail) {
            return;
        }

        const containerWidth =
            thumbnails.clientWidth;

        const thumbnailLeft =
            activeThumbnail.offsetLeft;

        const thumbnailWidth =
            activeThumbnail.offsetWidth;

        const scrollLeft =
            thumbnailLeft -
            (containerWidth / 2) +
            (thumbnailWidth / 2);

        thumbnails.scrollTo({
            left: scrollLeft,
            behavior: 'smooth',
        });
    };

    const updateThumbnailState = () => {
        const buttons =
            thumbnails.querySelectorAll(
                '.lightbox-thumbnail'
            );

        buttons.forEach((button, index) => {
            const isActive =
                index === currentIndex;

            button.classList.toggle(
                'is-active',
                isActive
            );

            button.classList.toggle(
                'opacity-100',
                isActive
            );

            button.classList.toggle(
                'opacity-60',
                !isActive
            );

            button.classList.toggle(
                'ring-2',
                isActive
            );

            button.classList.toggle(
                'ring-white',
                isActive
            );
        });

        requestAnimationFrame(() => {
            centerActiveThumbnail();
        });
    };

    const createThumbnails = () => {
        thumbnails.innerHTML = '';

        images.forEach((image, index) => {
            const button =
                document.createElement('button');

            button.type = 'button';

            button.setAttribute(
                'aria-label',
                `View image ${index + 1}`
            );

            button.className = [
                'lightbox-thumbnail',
                'is-active',
                'shrink-0',
                'overflow-hidden',
                'rounded-md',
                'opacity-60',
                'transition',
                'duration-200',
                'focus:outline-none',
                'focus:ring-2',
                'focus:ring-white',
            ].join(' ');

            const thumbnail =
                document.createElement('img');

            thumbnail.src =
                image.currentSrc ||
                image.src;

            thumbnail.alt =
                image.alt || '';

            thumbnail.className = [
                'h-14',
                'w-20',
                'object-cover',
                'md:h-16',
                'md:w-24',
            ].join(' ');

            button.appendChild(
                thumbnail
            );

            button.addEventListener(
                'click',
                () => {
                    showImage(
                        index,
                        true
                    );
                }
            );

            thumbnails.appendChild(
                button
            );
        });
    };

    const setImage = (index) => {
        const image =
            images[index];

        lightboxImage.src =
            image.currentSrc ||
            image.src;

        lightboxImage.alt =
            image.alt || '';
    };

    const showImage = (
        index,
        animate = false
    ) => {
        currentIndex =
            (index + images.length) %
            images.length;

        const image =
            images[currentIndex];

        previousButton.hidden =
            images.length <= 1;

        nextButton.hidden =
            images.length <= 1;

        if (!animate) {
            setImage(
                currentIndex
            );

            updateThumbnailState();

            return;
        }

        lightbox.classList.add(
            'is-changing'
        );

        setTimeout(() => {
            setImage(
                currentIndex
            );

            updateThumbnailState();

            requestAnimationFrame(() => {
                lightbox.classList.remove(
                    'is-changing'
                );
            });
        }, 200);
    };

    const open = (index) => {
        createThumbnails();

        showImage(index);

        lightbox.classList.remove(
            'hidden'
        );

        lightbox.setAttribute(
            'aria-hidden',
            'false'
        );

        document.body.classList.add(
            'overflow-hidden'
        );

        requestAnimationFrame(() => {
            lightbox.classList.add(
                'is-visible'
            );

            centerActiveThumbnail();
        });

        closeButton.focus();
    };

    const close = () => {
        lightbox.classList.remove(
            'is-visible'
        );

        lightbox.setAttribute(
            'aria-hidden',
            'true'
        );

        document.body.classList.remove(
            'overflow-hidden'
        );

        setTimeout(() => {
            lightbox.classList.add(
                'hidden'
            );

            lightboxImage.src = '';
            lightboxImage.alt = '';

            thumbnails.innerHTML = '';
        }, 250);
    };

    const previous = () => {
        showImage(
            currentIndex - 1,
            true
        );
    };

    const next = () => {
        showImage(
            currentIndex + 1,
            true
        );
    };

    const handleTouchStart = (event) => {
        if (!event.touches.length) {
            return;
        }

        touchStartX =
            event.touches[0].clientX;

        touchStartY =
            event.touches[0].clientY;

        touchCurrentX =
            touchStartX;

        isTouching = true;
    };

    const handleTouchMove = (event) => {
        if (
            !isTouching ||
            !event.touches.length
        ) {
            return;
        }

        touchCurrentX =
            event.touches[0].clientX;
    };

    const handleTouchEnd = (event) => {
        if (!isTouching) {
            return;
        }

        isTouching = false;

        if (!event.changedTouches.length) {
            return;
        }

        const touchEndX =
            event.changedTouches[0].clientX;

        const touchEndY =
            event.changedTouches[0].clientY;

        const deltaX =
            touchEndX - touchStartX;

        const deltaY =
            touchEndY - touchStartY;

        if (
            Math.abs(deltaX) <
            swipeThreshold
        ) {
            return;
        }

        if (
            Math.abs(deltaY) >
            Math.abs(deltaX)
        ) {
            return;
        }

        if (deltaX < 0) {
            next();
        } else {
            previous();
        }
    };

    images.forEach((image, index) => {
        image.addEventListener(
            'click',
            () => {
                open(index);
            }
        );
    });

    closeButton.addEventListener(
        'click',
        close
    );

    previousButton.addEventListener(
        'click',
        previous
    );

    nextButton.addEventListener(
        'click',
        next
    );

    backdrop.addEventListener(
        'click',
        (event) => {
            if (
                event.target === backdrop
            ) {
                close();
            }
        }
    );

    lightboxImage.addEventListener(
        'touchstart',
        handleTouchStart,
        {
            passive: true,
        }
    );

    lightboxImage.addEventListener(
        'touchmove',
        handleTouchMove,
        {
            passive: true,
        }
    );

    lightboxImage.addEventListener(
        'touchend',
        handleTouchEnd,
        {
            passive: true,
        }
    );

    document.addEventListener(
        'keydown',
        (event) => {
            if (
                lightbox.classList.contains(
                    'hidden'
                )
            ) {
                return;
            }

            if (event.key === 'Escape') {
                close();
            }

            if (event.key === 'ArrowLeft') {
                previous();
            }

            if (event.key === 'ArrowRight') {
                next();
            }
        }
    );
});