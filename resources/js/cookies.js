
document.addEventListener('DOMContentLoaded', () => {
    const banner = document.getElementById('cookie-consent-banner');

    if (!banner) {
        return;
    }

    const settings = document.getElementById('cookie-settings');
    const analyticsCheckbox = document.getElementById('cookie-analytics');
    const acceptButton = document.getElementById('cookie-accept-all');
    const rejectButton = document.getElementById('cookie-reject-optional');
    const settingsButton = document.getElementById('cookie-open-settings');
    const saveButton = document.getElementById('cookie-save-settings');

    const consentKey = 'pkmnexus_cookie_consent';

    const readConsent = () => {
        try {
            const consent = JSON.parse(localStorage.getItem(consentKey));

            if (consent && typeof consent.analytics === 'boolean') {
                return consent;
            }
        } catch (error) {
            return null;
        }

        return null;
    };

    const showBanner = () => {
        banner.classList.remove('hidden');
    };

    const hideBanner = () => {
        banner.classList.add('hidden');
        settings.classList.add('hidden');
        settingsButton.setAttribute('aria-expanded', 'false');
    };

    const openSettings = () => {
        const consent = readConsent();

        analyticsCheckbox.checked = consent?.analytics === true;

        showBanner();
        settings.classList.remove('hidden');
        settingsButton.setAttribute('aria-expanded', 'true');
    };

    const saveConsent = (analytics) => {
        const previousConsent = readConsent();

        const consent = {
            necessary: true,
            analytics,
            savedAt: new Date().toISOString()
        };

        try {
            localStorage.setItem(consentKey, JSON.stringify(consent));
        } catch (error) {
            return;
        }

        hideBanner();

        if (analytics) {
            if (typeof window.loadGoogleTagManager === 'function') {
                window.loadGoogleTagManager();
            }

            return;
        }

        if (previousConsent?.analytics === true) {
            if (typeof window.gtag === 'function') {
                window.gtag('consent', 'update', {
                    analytics_storage: 'denied',
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied'
                });
            }

            window.location.reload();
        }
    };

    acceptButton.addEventListener('click', () => {
        analyticsCheckbox.checked = true;
        saveConsent(true);
    });

    rejectButton.addEventListener('click', () => {
        analyticsCheckbox.checked = false;
        saveConsent(false);
    });

    settingsButton.addEventListener('click', () => {
        if (settings.classList.contains('hidden')) {
            openSettings();
        } else {
            settings.classList.add('hidden');
            settingsButton.setAttribute('aria-expanded', 'false');
        }
    });

    saveButton.addEventListener('click', () => {
        saveConsent(analyticsCheckbox.checked);
    });

    window.openCookieSettings = openSettings;

    const consent = readConsent();

    if (consent) {
        hideBanner();
    } else {
        showBanner();
    }
});
