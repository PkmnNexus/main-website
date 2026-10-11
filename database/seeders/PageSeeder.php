<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'data' => [
                    'page' => 'Home',
                    'title' => 'PkmnInsider - Pokémon News & Guides',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_description' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_keywords' => 'pokemon, news, guides, tcg, pokedex',
                    'og_title' => 'Og Title Test',
                    'og_description' => 'Og Description Test',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'articles',
                'data' => [
                    'page' => 'Articles',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'tag',
                'data' => [
                    'page' => 'Tag',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'category',
                'data' => [
                    'page' => 'Category',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'disclaimer',
                'data' => [
                    'page' => 'Disclaimer',
                    'title' => 'Pokémon Articles - PkmnInsider',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnInsider.',
                    'meta_description' => 'Read in-depth Pokémon articles, guides, strategies and analyses on PkmnInsider.',
                    'meta_keywords' => 'pokemon articles, pokemon guides, tcg articles, pokemon analysis',
                    'og_title' => 'Pokémon Articles - PkmnInsider',
                    'og_description' => 'Explore detailed Pokémon articles and guides.',
                    'is_active' => true,
                ],
                [
                'slug' => 'cookie-policy',
                'data' => [
                    'page' => 'Cookie Policy',
                    'title' => 'Cookie Policy - PkmnInsider',
                    'content' => '
                        <h2>1. Introduction</h2>
                        <p>Welcome to PkmnNexus. This Cookie Policy explains how we use cookies and similar technologies when you visit our website. It describes which technologies we use, why we use them, and how you can manage your preferences.</p>
                        <p>PkmnNexus operates from Belgium and welcomes visitors from around the world. Applicable privacy and data protection requirements may vary depending on your location. We aim to respect your privacy and provide clear choices regarding optional tracking technologies.</p>
                        <p>This Cookie Policy should be read together with our Privacy Policy, where applicable.</p>

                        <h2>2. What Are Cookies?</h2>
                        <p>Cookies are small text files stored on your device when you visit a website. Similar technologies, such as browser local storage and scripts, can also store or access information on your device. These technologies may be used to make a website function correctly, remember your preferences, or understand how visitors use a website.</p>

                        <h2>3. How We Use Cookies and Similar Technologies</h2>
                        <p>PkmnNexus currently uses technologies for essential website functionality, remembering your cookie preferences, and optional website analytics through Google Analytics 4 (GA4), managed using Google Tag Manager (GTM).</p>
                        <p>We distinguish between necessary technologies and optional analytics technologies. Optional analytics remains disabled until you actively provide your consent through our cookie banner.</p>

                        <h3>3.1 Necessary Technologies</h3>
                        <p>Necessary technologies support essential website functionality, security, and the operation of the website. Depending on how you use the website, these may include Laravel session cookies and security-related cookies. These technologies are used where necessary for the relevant functionality.</p>
                        <p>Our website also uses browser local storage to remember your cookie preference. This allows us to remember whether you accepted or rejected optional analytics so that we do not need to ask you again on every page load.</p>

                        <h3>3.2 Analytics Technologies</h3>
                        <p>If you accept optional analytics, our website loads Google Tag Manager, which activates the configured Google tag for Google Analytics 4. GA4 helps us understand how visitors use PkmnNexus, including which pages are visited and how visitors interact with website content.</p>
                        <p>Depending on the configuration, Google Analytics may use cookies such as <code>_ga</code> and <code>_ga_*</code> to distinguish browsers and maintain analytics session information. Analytics data may include page information, interactions, browser and device information, approximate location information, and online identifiers.</p>
                        <p>Google Analytics is provided by Google. Information collected through this service may be transmitted to and processed by Google in accordance with Google\'s applicable terms and privacy documentation.</p>

                        <h2>4. Google Tag Manager and Consent</h2>
                        <p>We use Google Tag Manager to manage tracking tags on our website. Our implementation is designed to load the Google Tag Manager container only after you have accepted optional analytics.</p>
                        <p>If you reject optional analytics, Google Tag Manager is not loaded through this consent-controlled integration. If you accept analytics, the Google tag can send permitted analytics events to our Google Analytics 4 property.</p>
                        <p>Our current implementation does not intentionally activate advertising or remarketing tags. Accepting analytics should not be interpreted as consent to use your information for personalised advertising.</p>

                        <h2>5. Managing Your Cookie Preferences</h2>
                        <p>When you visit PkmnNexus, our cookie banner allows you to accept optional analytics, reject optional analytics, or open the cookie settings to manage your preferences.</p>
                        <p>Analytics is optional and is not enabled by default. Necessary technologies may remain active where required for the website to function.</p>
                        <p>You can access your cookie preferences at any time by clicking the cookie icon in the bottom-right corner of the website.</p>

                        <h3>5.1 Changing or Withdrawing Consent</h3>
                        <p>You can change or withdraw your consent to optional analytics at any time. You are not required to continue allowing analytics because you accepted it previously.</p>
                        <p>Click the cookie icon in the bottom-right corner of PkmnNexus to reopen the cookie banner and access your cookie settings. You can then disable analytics or change your preferences and save your updated choice.</p>
                        <p>Your updated choice will apply going forward. Withdrawing consent does not affect the lawfulness of processing carried out before the withdrawal. It also does not automatically delete information that may already have been collected by Google Analytics. Where applicable, requests concerning previously collected personal data can be made through the relevant privacy rights or contact process.</p>

                        <h3>5.2 Remembering Your Preferences</h3>
                        <p>Your cookie preference is stored in your browser\'s local storage under the key <code>pkmnexus_cookie_consent</code>. This allows us to remember your choice on subsequent visits. The preference remains stored until you change or remove it, subject to browser settings and storage limitations.</p>
                        <p>You can also clear your browser\'s cookies and local storage. If you do so, PkmnNexus may ask you to choose your preferences again.</p>

                        <h2>6. Third-Party Services</h2>
                        <p>Google Analytics 4 and Google Tag Manager are Google services. Their operation is subject to Google\'s applicable documentation, terms, and privacy information.</p>
                        <p>For more information, please consult the <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">Google Privacy Policy</a> and the <a href="https://support.google.com/analytics/answer/6004245" target="_blank" rel="noopener noreferrer">Google Analytics privacy information</a>.</p>

                        <h2>7. Data Retention</h2>
                        <p>The period for which information is stored depends on the technology and its configuration. Our cookie preference is stored in your browser\'s local storage until it is changed or removed. Google Analytics cookies may have their own expiry settings, and browsers may impose additional limits.</p>
                        <p>Analytics data retention within Google Analytics is configured separately from the lifetime of cookies in your browser. The applicable retention periods depend on the relevant Google Analytics settings and configuration.</p>

                        <h2>8. Your Privacy Rights</h2>
                        <p>Depending on your location and the applicable data protection laws, you may have rights concerning the processing of your personal data. These may include the right to access, correct, or request deletion of personal data, to restrict or object to certain processing, and to withdraw consent where processing is based on consent.</p>
                        <p>Withdrawing consent does not affect the lawfulness of processing carried out before the withdrawal. You can change your analytics preference using the cookie settings available on our website.</p>

                        <h2>9. Changes to This Cookie Policy</h2>
                        <p>We may update this Cookie Policy when our website, technologies, or legal requirements change. The updated version will be published on this page. We encourage you to review this page periodically to stay informed about our use of cookies and similar technologies.</p>

                        <h2>10. Contact</h2>
                        <p>If you have questions about this Cookie Policy or our use of cookies and similar technologies, please contact the website operator using the contact details provided on PkmnNexus.</p>

                    ',
                    'meta_keywords' => 'PkmnNexus cookie policy, cookies, Google Analytics 4, Google Tag Manager, cookie consent, privacy',
                    'og_title' => 'Cookie Policy - PkmnNexus',
                    'og_description' => 'Learn how PkmnNexus uses cookies and analytics technologies and how to manage or withdraw your privacy preferences at any time.',
                    'is_active' => true,
                ],
            ],
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page['data']
            );
        }
    }
}
