document.addEventListener('DOMContentLoaded', () => {
    const articleBody = document.querySelector(
        '[itemprop="articleBody"]'
    );

    const lightbox = document.querySelector(
        '#article-lightbox'
    );

    if (lightbox && lightbox.parentElement !== document.body) {
        document.body.appendChild(lightbox);
    }

    if (!lightbox) {
        return;
    }

    const articleImages = articleBody
        ? Array.from(articleBody.querySelectorAll('img'))
        : [];

    let images = articleImages;

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
    let isTouching = false;

    const swipeThreshold = 50;

    const getImageSource = (image) => {
        return image.dataset.lightboxSrc
            || image.currentSrc
            || image.src;
    };

    const getImageAlt = (image) => {
        return image.dataset.lightboxAlt
            || image.alt
            || image.querySelector('img')?.alt
            || '';
    };

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
                image.dataset.lightboxThumb ||
                getImageSource(image);

            thumbnail.alt =
                getImageAlt(image);

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
            getImageSource(image);

        lightboxImage.alt =
            getImageAlt(image);
    };

    const showImage = (
        index,
        animate = false
    ) => {
        if (!images.length) {
            return;
        }

        currentIndex =
            (index + images.length) %
            images.length;

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

    const open = (
        index,
        imageGroup = articleImages
    ) => {
        if (!imageGroup.length) {
            return;
        }

        images = imageGroup;

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

            images = articleImages;
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

        isTouching = true;
    };

    const handleTouchMove = (event) => {
        if (
            !isTouching ||
            !event.touches.length
        ) {
            return;
        }
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

    articleImages.forEach((image, index) => {
        image.addEventListener(
            'click',
            () => {
                open(index);
            }
        );
    });

    document.addEventListener(
        'click',
        (event) => {
            const target = event.target;

            if (!(target instanceof Element)) {
                return;
            }

            const item = target.closest(
                '[data-lightbox-item]'
            );

            if (!item) {
                return;
            }

            const group = item.closest(
                '[data-lightbox-group]'
            );

            if (!group) {
                return;
            }

            let groupContainer = group;

            if (group === item) {
                groupContainer = item.closest(
                    '[aria-label="Pokémon TCG card gallery"]'
                ) || item.parentElement;
            }

            const groupImages = Array.from(
                groupContainer.querySelectorAll(
                    '[data-lightbox-item]'
                )
            );

            if (groupContainer === item) {
                groupImages.unshift(item);
            }

            const index =
                groupImages.indexOf(item);

            if (index !== -1) {
                open(
                    index,
                    groupImages
                );
            }
        }
    );

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