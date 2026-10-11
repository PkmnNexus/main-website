
@if(config('services.google_tag_manager.id'))
    <script>
        (function (window, document) {
            const containerId = @js(config('services.google_tag_manager.id'));

            window.dataLayer = window.dataLayer || [];

            window.gtag = window.gtag || function () {
                window.dataLayer.push(arguments);
            };

            window.gtag('consent', 'default', {
                ad_storage: 'denied',
                analytics_storage: 'denied',
                ad_user_data: 'denied',
                ad_personalization: 'denied',
                functionality_storage: 'granted',
                security_storage: 'granted',
                personalization_storage: 'denied'
            });

            window.loadGoogleTagManager = function () {
                if (window.__pkmnexusGtmLoaded) {
                    return;
                }

                window.__pkmnexusGtmLoaded = true;

                window.gtag('consent', 'update', {
                    analytics_storage: 'granted',
                    ad_storage: 'denied',
                    ad_user_data: 'denied',
                    ad_personalization: 'denied'
                });

                window.dataLayer.push({
                    'gtm.start': new Date().getTime(),
                    event: 'gtm.js'
                });

                const firstScript = document.getElementsByTagName('script')[0];
                const gtmScript = document.createElement('script');

                gtmScript.async = true;
                gtmScript.src =
                    'https://www.googletagmanager.com/gtm.js?id=' +
                    encodeURIComponent(containerId);

                firstScript.parentNode.insertBefore(gtmScript, firstScript);
            };

            try {
                const consent = JSON.parse(
                    localStorage.getItem('pkmnexus_cookie_consent') || 'null'
                );

                if (consent && consent.analytics === true) {
                    window.loadGoogleTagManager();
                }
            } catch (error) {
                // Keep analytics disabled if consent cannot be read.
            }
        })(window, document);
    </script>
@endif
