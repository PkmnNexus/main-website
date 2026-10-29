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
                'key' => 'home',
                'data' => [
                    'page' => 'Home',
                    'slug' => [
                        'en' => 'home',
                        'nl' => 'home',
                    ],
                    'title' => [
                        'en' => 'PkmnNexus - Pokémon News & Guides',
                        'nl' => 'PkmnNexus - Pokémonnieuws en gidsen',
                    ],
                    'content' => [
                        'en' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                        'nl' => 'Ontdek het laatste Pokémonnieuws, competitieve gidsen en uitgebreide artikelen op PkmnNexus.',
                    ],
                    'meta_description' => [
                        'en' => 'Get the latest Pokémon news, game updates, Pokémon GO coverage, and helpful guides for fans across the Pokémon universe.',
                        'nl' => 'Ontdek het laatste Pokémonnieuws, game-updates, Pokémon GO-nieuws en handige gidsen voor fans van het Pokémon-universum.',
                    ],
                    'meta_keywords' => [
                        'en' => 'pokemon news, pokemon guides, pokemon game updates, pokemon go news, pokemon universe',
                        'nl' => 'pokemon nieuws, pokemon gidsen, pokemon game updates, pokemon go nieuws, pokemon universum',
                    ],
                    'og_title' => [
                        'en' => 'Pokémon News & Guides | PkmnNexus',
                        'nl' => 'Pokémonnieuws en gidsen | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Stay up to date with Pokémon news, game updates, Pokémon GO coverage, and helpful guides for fans.',
                        'nl' => 'Blijf op de hoogte van Pokémonnieuws, game-updates, Pokémon GO-nieuws en handige gidsen voor fans.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'articles',
                'data' => [
                    'page' => 'Articles',
                    'slug' => [
                        'en' => 'articles',
                        'nl' => 'artikelen',
                    ],
                    'title' => [
                        'en' => 'Pokémon Articles and Guides',
                        'nl' => 'Pokémonartikelen en gidsen',
                    ],
                    'content' => [
                        'en' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                        'nl' => 'Ontdek het laatste Pokémonnieuws, competitieve gidsen en uitgebreide artikelen op PkmnNexus.',
                    ],
                    'meta_description' => [
                        'en' => 'Explore Pokémon news, in-depth articles, game guides, updates, and analysis from across the Pokémon universe.',
                        'nl' => 'Ontdek Pokémonnieuws, uitgebreide artikelen, gamegidsen, updates en analyses uit het Pokémon-universum.',
                    ],
                    'meta_keywords' => [
                        'en' => 'pokemon articles, pokemon news, pokemon guides, pokemon game updates, pokemon analysis',
                        'nl' => 'pokemon artikelen, pokemon nieuws, pokemon gidsen, pokemon game updates, pokemon analyse',
                    ],
                    'og_title' => [
                        'en' => 'Pokémon Articles and Guides',
                        'nl' => 'Pokémonartikelen en gidsen',
                    ],
                    'og_description' => [
                        'en' => 'Explore Pokémon news, in-depth articles, game guides, updates, and analysis from across the Pokémon universe.',
                        'nl' => 'Ontdek Pokémonnieuws, uitgebreide artikelen, gamegidsen, updates en analyses.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'tag',
                'data' => [
                    'page' => 'Tag',
                    'slug' => [
                        'en' => 'tag',
                        'nl' => 'tag',
                    ],
                    'title' => [
                        'en' => 'Pokémon Articles and Guides',
                        'nl' => 'Pokémonartikelen en gidsen',
                    ],
                    'content' => [
                        'en' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                        'nl' => 'Ontdek het laatste Pokémonnieuws, competitieve gidsen en uitgebreide artikelen op PkmnNexus.',
                    ],
                    'meta_description' => [
                        'en' => 'Browse Pokémon articles, news, and guides covering games, updates, events, and other topics across the Pokémon universe.',
                        'nl' => 'Bekijk Pokémonartikelen, nieuws en gidsen over games, updates, evenementen en andere onderwerpen uit het Pokémon-universum.',
                    ],
                    'meta_keywords' => [
                        'en' => 'pokemon articles, pokemon news, pokemon guides, pokemon topics',
                        'nl' => 'pokemon artikelen, pokemon nieuws, pokemon gidsen, pokemon onderwerpen',
                    ],
                    'og_title' => [
                        'en' => 'Pokémon Articles and Guides',
                        'nl' => 'Pokémonartikelen en gidsen',
                    ],
                    'og_description' => [
                        'en' => 'Browse Pokémon articles, news, and guides covering games, updates, and events.',
                        'nl' => 'Bekijk Pokémonnieuws, artikelen en gidsen over games, updates en evenementen.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'category',
                'data' => [
                    'page' => 'Category',
                    'slug' => [
                        'en' => 'category',
                        'nl' => 'categorie',
                    ],
                    'title' => [
                        'en' => 'Pokémon Articles and Guides',
                        'nl' => 'Pokémonartikelen en gidsen',
                    ],
                    'content' => [
                        'en' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                        'nl' => 'Ontdek het laatste Pokémonnieuws, competitieve gidsen en uitgebreide artikelen op PkmnNexus.',
                    ],
                    'meta_description' => [
                        'en' => 'Discover Pokémon articles, news, and guides in this category, including relevant game updates, tips, and developments.',
                        'nl' => 'Ontdek Pokémonartikelen, nieuws en gidsen in deze categorie, met relevante game-updates, tips en ontwikkelingen.',
                    ],
                    'meta_keywords' => [
                        'en' => 'pokemon articles, pokemon category, pokemon news, pokemon guides',
                        'nl' => 'pokemon artikelen, pokemon categorie, pokemon nieuws, pokemon gidsen',
                    ],
                    'og_title' => [
                        'en' => 'Pokémon Articles and Guides',
                        'nl' => 'Pokémonartikelen en gidsen',
                    ],
                    'og_description' => [
                        'en' => 'Discover Pokémon articles, news, and guides in this category.',
                        'nl' => 'Ontdek Pokémonartikelen, nieuws en gidsen in deze categorie.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'about',
                'data' => [
                    'page' => 'About',
                    'slug' => [
                        'en' => 'about',
                        'nl' => 'over-ons',
                    ],
                    'title' => [
                        'en' => 'About PkmnNexus',
                        'nl' => 'Over PkmnNexus',
                    ],
                    'content' => [
                        'en' => <<<'CONTENT'

                        <h2>About PkmnNexus</h2>
                        <p>Welcome to PkmnNexus, an independent website dedicated to Pokémon news, updates, guides, and everything happening across the Pokémon universe.</p>
                        <p>From the latest announcements and game updates to helpful guides and interesting discoveries, PkmnNexus aims to bring Pokémon fans together around the games, news, and experiences they love.</p>
                        <p>Whether you're a longtime Pokémon fan or just starting your journey, our goal is to provide a place where you can discover what's new, learn something useful, and stay connected with the ever-evolving world of Pokémon.</p>
                        <h2>Our Mission</h2>
                        <p>Our mission is simple: to make Pokémon news and information accessible, engaging, and easy to explore.</p>
                        <p>The Pokémon universe continues to grow through new games, updates, events, and experiences. Keeping up with everything can be challenging, so PkmnNexus aims to bring relevant information together in one place.</p>
                        <p>We want to help readers stay informed, discover useful information, and enjoy their interest in Pokémon even more.</p>
                        <h2>What You'll Find on PkmnNexus</h2>
                        <p>PkmnNexus covers a range of Pokémon-related topics, with content designed to inform, guide, and entertain readers.</p>
                        <ul>
                            <li><strong>Pokémon News:</strong> News, announcements, and developments from across the Pokémon universe.</li>
                            <li><strong>Game Updates:</strong> Information about updates, new features, events, and other important changes.</li>
                            <li><strong>Guides and Tips:</strong> Helpful information to make your Pokémon adventures easier and more enjoyable.</li>
                            <li><strong>Pokémon GO:</strong> News, events, updates, and useful information for Pokémon GO players.</li>
                            <li><strong>Features and Discoveries:</strong> Interesting details, developments, and topics worth exploring within the Pokémon community.</li>
                        </ul>
                        <p>Our content may evolve over time as new games, features, and topics emerge across the Pokémon universe.</p>
                        <h2>Our Editorial Approach</h2>
                        <p>We believe that useful Pokémon content should be clear, accessible, and informative.</p>
                        <p>We aim to present information in a way that is easy to understand and relevant to our readers. When covering news and announcements, we strive to use reliable information and distinguish confirmed details from speculation or interpretation where appropriate.</p>
                        <p>As information can change, some articles may be updated when new details become available. Despite our efforts, mistakes or outdated information may occasionally occur.</p>
                        <p>If you notice an error or believe an article needs clarification, we welcome your feedback. Reader feedback helps us identify issues and improve the information we publish.</p>
                        <h2>An Independent Pokémon Website</h2>
                        <p>PkmnNexus is an independent website created for fans of the Pokémon universe.</p>
                        <p>We are not affiliated with, endorsed by, sponsored by, or officially connected to Nintendo, The Pokémon Company, Game Freak, or their subsidiaries or affiliates.</p>
                        <p>Pokémon and all related names, characters, logos, trademarks, and other intellectual property belong to their respective owners. Their appearance on PkmnNexus does not imply official affiliation or ownership by our website.</p>
                        <p>For more information about our use of content and the limitations of the information published on this website, please consult our <a href="/disclaimer">Disclaimer</a>.</p>
                        <h2>Join Us on the Journey</h2>
                        <p>The Pokémon universe is constantly evolving, bringing new adventures, discoveries, and experiences to fans around the world.</p>
                        <p>At PkmnNexus, we aim to follow these developments and share the information that matters to our readers. Whether you're looking for the latest news, useful tips, or something new to discover, we hope you'll find something worth exploring here.</p>
                        <p>Thank you for visiting PkmnNexus and being part of our journey.</p>
                        <h2>Get in Touch</h2>
                        <p>Have a question, suggestion, correction, or other feedback? We'd love to hear from you.</p>
                        <p>Please visit our <a href="/contact">Contact page</a> to get in touch. We appreciate hearing from our readers and welcome feedback that helps us make PkmnNexus better.</p>
                    
CONTENT,
                        'nl' => <<<'CONTENT'
<h2>Over PkmnNexus</h2>
<p>Welkom bij PkmnNexus, een onafhankelijke website die zich richt op Pokémonnieuws, updates, gidsen en alles wat er gebeurt in het Pokémon-universum.</p>
<p>Van de nieuwste aankondigingen en game-updates tot handige gidsen en interessante ontdekkingen: PkmnNexus wil Pokémonfans samenbrengen rond de games, het nieuws en de ervaringen waar ze van houden.</p>
<p>Of je nu al jarenlang Pokémonfan bent of net aan je avontuur begint, ons doel is je een plek te bieden waar je nieuwe ontwikkelingen kunt ontdekken, nuttige informatie kunt vinden en verbonden blijft met de steeds veranderende wereld van Pokémon.</p>
<h2>Onze missie</h2>
<p>Onze missie is eenvoudig: Pokémonnieuws en -informatie toegankelijk, boeiend en gemakkelijk te ontdekken maken.</p>
<p>Het Pokémon-universum blijft groeien met nieuwe games, updates, evenementen en ervaringen. Het kan lastig zijn om alles bij te houden. Daarom wil PkmnNexus relevante informatie op één plek samenbrengen.</p>
<p>We willen lezers helpen op de hoogte te blijven, nuttige informatie te ontdekken en nog meer plezier te beleven aan hun interesse in Pokémon.</p>
<h2>Wat je op PkmnNexus vindt</h2>
<p>PkmnNexus behandelt uiteenlopende Pokémononderwerpen. Onze content is bedoeld om lezers te informeren, te helpen en te vermaken.</p>
<ul>
<li><strong>Pokémonnieuws:</strong> nieuws, aankondigingen en ontwikkelingen uit het Pokémon-universum.</li>
<li><strong>Game-updates:</strong> informatie over updates, nieuwe functies, evenementen en andere belangrijke veranderingen.</li>
<li><strong>Gidsen en tips:</strong> handige informatie om je Pokémonavonturen eenvoudiger en leuker te maken.</li>
<li><strong>Pokémon GO:</strong> nieuws, evenementen, updates en nuttige informatie voor Pokémon GO-spelers.</li>
<li><strong>Artikelen en ontdekkingen:</strong> interessante details, ontwikkelingen en onderwerpen die de Pokémoncommunity het ontdekken waard vindt.</li>
</ul>
<p>Onze inhoud kan in de loop van de tijd veranderen wanneer er nieuwe games, functies en onderwerpen binnen het Pokémon-universum verschijnen.</p>
<h2>Onze redactionele aanpak</h2>
<p>We vinden dat nuttige Pokémoncontent duidelijk, toegankelijk en informatief moet zijn.</p>
<p>We proberen informatie helder en relevant te presenteren. Bij nieuws en aankondigingen streven we ernaar betrouwbare informatie te gebruiken en waar nodig onderscheid te maken tussen bevestigde feiten, speculatie en interpretatie.</p>
<p>Omdat informatie kan veranderen, kunnen artikelen worden bijgewerkt wanneer nieuwe details beschikbaar komen. Ondanks onze inspanningen kunnen er fouten voorkomen of kan informatie verouderd raken.</p>
<p>Zie je een fout of vind je dat een artikel verduidelijking nodig heeft? Dan horen we dat graag. Feedback van lezers helpt ons problemen te herkennen en onze informatie te verbeteren.</p>
<h2>Een onafhankelijke Pokémonwebsite</h2>
<p>PkmnNexus is een onafhankelijke website voor fans van het Pokémon-universum.</p>
<p>We zijn niet verbonden aan, goedgekeurd door, gesponsord door of officieel gelieerd aan Nintendo, The Pokémon Company, Game Freak of hun dochterondernemingen en partners.</p>
<p>Pokémon en alle bijbehorende namen, personages, logo's, handelsmerken en andere intellectuele eigendommen behoren toe aan hun respectieve eigenaren. Het gebruik ervan op PkmnNexus betekent niet dat onze website officieel verbonden is met deze partijen of eigenaar is van die rechten.</p>
<p>Lees onze <a href="/disclaimer">disclaimer</a> voor meer informatie over ons gebruik van content en de beperkingen van de informatie op deze website.</p>
<h2>Ga met ons mee op avontuur</h2>
<p>Het Pokémon-universum blijft zich ontwikkelen en brengt fans over de hele wereld nieuwe avonturen, ontdekkingen en ervaringen.</p>
<p>Bij PkmnNexus volgen we deze ontwikkelingen en delen we informatie die voor onze lezers van belang is. Of je nu op zoek bent naar het laatste nieuws, handige tips of iets nieuws om te ontdekken: we hopen dat je hier iets interessants vindt.</p>
<p>Bedankt voor je bezoek aan PkmnNexus en dat je deel uitmaakt van ons avontuur.</p>
<h2>Neem contact met ons op</h2>
<p>Heb je een vraag, suggestie, correctie of andere feedback? We horen graag van je.</p>
<p>Ga naar onze <a href="/contact">contactpagina</a> om ons te bereiken. We waarderen reacties van lezers en verwelkomen feedback waarmee we PkmnNexus kunnen verbeteren.</p>
CONTENT,
                    ],
                    'meta_description' => [
                        'en' => 'Learn about PkmnNexus, an independent Pokémon website covering news, game updates, guides, and discoveries from across the Pokémon universe.',
                        'nl' => 'Lees meer over PkmnNexus, een onafhankelijke Pokémonwebsite met nieuws, game-updates, gidsen en ontdekkingen uit het Pokémon-universum.',
                    ],
                    'meta_keywords' => [
                        'en' => 'about PkmnNexus, independent pokemon website, pokemon news, pokemon guides, pokemon game updates',
                        'nl' => 'over PkmnNexus, onafhankelijke pokemon website, pokemon nieuws, pokemon gidsen, pokemon game updates',
                    ],
                    'og_title' => [
                        'en' => 'About PkmnNexus',
                        'nl' => 'Over PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Learn about our mission to bring Pokémon news, game updates, guides, and discoveries together in one place.',
                        'nl' => 'Ontdek onze missie: Pokémonnieuws, game-updates, gidsen en ontdekkingen samenbrengen op één plek.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'privacy-policy',
                'data' => [
                    'page' => 'Privacy Policy',
                    'slug' => [
                        'en' => 'privacy-policy',
                        'nl' => 'privacybeleid',
                    ],
                    'title' => [
                        'en' => 'Privacy Policy',
                        'nl' => 'Privacyverklaring',
                    ],
                    'content' => [
                        'en' => <<<'CONTENT'

                        <h2>1. Introduction</h2>
                        <p>Welcome to PkmnNexus ("we", "us", or "our"). We respect your privacy and are committed to handling personal data responsibly and transparently.</p>
                        <p>This Privacy Policy explains how personal data may be collected, used, stored, and shared when you visit or interact with the PkmnNexus website (the "Website"). It also explains your rights under applicable data protection laws, including the General Data Protection Regulation (GDPR).</p>
                        <p>This policy should be read together with our Cookie Policy, which provides additional information about cookies and similar technologies used on the Website.</p>
                        <h2>2. Who We Are</h2>
                        <p>PkmnNexus is an independent website that publishes news, articles, guides, and other informational content relating to Pokémon and related topics.</p>
                        <p>For the purposes of applicable data protection legislation, the data controller responsible for the processing described in this Privacy Policy is:</p>
                        <ul>
                            <li><strong>Website:</strong> PkmnNexus</li>
                            <li><strong>Data controller:</strong> [Full legal name or registered business name]</li>
                            <li><strong>Address:</strong> [Business or contact address]</li>
                            <li><strong>Email:</strong> [Privacy contact email address]</li>
                        </ul>
                        <p>If you have questions about this Privacy Policy or how your personal data is handled, you can contact us using the details provided above.</p>
                        <h2>3. Personal Data We May Collect</h2>
                        <p>The personal data we process depends on how you use the Website and which features are available. Depending on your interactions, this may include the following categories of information:</p>
                        <ul>
                            <li><strong>Technical and usage data:</strong> Information such as your IP address, browser type, device information, operating system, referring pages, pages visited, and timestamps of visits, where collected by our hosting infrastructure or other services.</li>
                            <li><strong>Communication data:</strong> Information you provide when contacting us, such as your name, email address, and the contents of your message.</li>
                            <li><strong>Cookie and analytics data:</strong> Information collected through cookies or similar technologies, subject to applicable consent requirements and your privacy preferences.</li>
                            <li><strong>Preference data:</strong> Information relating to your privacy choices, such as consent preferences stored by our cookie management system.</li>
                        </ul>
                        <p>We aim to collect and process only personal data that is necessary for the relevant purposes. We do not intentionally request sensitive personal data through ordinary Website features.</p>
                        <h2>4. How We Collect Personal Data</h2>
                        <p>We may collect personal data in the following ways:</p>
                        <ul>
                            <li><strong>Directly from you:</strong> For example, when you contact us or voluntarily provide information through an available Website feature.</li>
                            <li><strong>Automatically:</strong> Certain technical information may be processed when you visit the Website, including information required to deliver pages, maintain security, and diagnose technical issues.</li>
                            <li><strong>Through third-party services:</strong> Certain service providers may collect or receive information when their services are used on the Website, subject to the applicable configuration, legal requirements, and your consent where required.</li>
                        </ul>
                        <h2>5. Why We Process Personal Data</h2>
                        <p>Depending on the circumstances, we may process personal data for the following purposes:</p>
                        <ul>
                            <li>To operate, maintain, and deliver the Website.</li>
                            <li>To protect the Website against abuse, malicious activity, and security threats.</li>
                            <li>To respond to enquiries and communicate with visitors who contact us.</li>
                            <li>To understand Website usage and improve our content, performance, and user experience through analytics where implemented lawfully.</li>
                            <li>To store and respect cookie and privacy preferences.</li>
                            <li>To comply with applicable legal obligations and establish, exercise, or defend legal claims where necessary.</li>
                        </ul>
                        <p>We will not use personal data for purposes that are incompatible with the purposes for which it was collected, unless permitted by applicable law.</p>
                        <h2>6. Legal Bases for Processing</h2>
                        <p>We process personal data only where a valid legal basis under the GDPR or other applicable data protection legislation applies. Depending on the processing activity, this may include:</p>
                        <ul>
                            <li><strong>Legitimate interests:</strong> Where necessary for legitimate purposes such as operating and securing the Website, preventing abuse, or improving our services, provided that these interests do not override your rights and freedoms.</li>
                            <li><strong>Consent:</strong> Where you have given valid consent, for example for analytics or other non-essential technologies when consent is legally required.</li>
                            <li><strong>Legal obligation:</strong> Where processing is necessary to comply with a legal obligation.</li>
                            <li><strong>Pre-contractual measures or contractual necessity:</strong> Where applicable to a request you make or an agreement with you.</li>
                        </ul>
                        <p>The applicable legal basis depends on the specific purpose and circumstances of the processing. Where processing is based on consent, you may withdraw that consent at any time. Withdrawal does not affect the lawfulness of processing carried out before the withdrawal.</p>
                        <h2>7. Cookies and Analytics</h2>
                        <p>The Website may use cookies and similar technologies to support essential functionality, remember preferences, understand Website usage, or provide other features.</p>
                        <p>Where Google Analytics 4 or another analytics service is enabled, information about Website interactions may be processed to help us understand traffic and improve the Website. The data collected and the purposes of processing depend on the service configuration and the applicable settings.</p>
                        <p>Non-essential cookies and similar technologies will only be used where the required consent has been obtained. You can manage your preferences through the available cookie settings, where provided.</p>
                        <p>For further details about the technologies used, their purposes, and how to manage your preferences, please consult our Cookie Policy.</p>
                        <h2>8. Third-Party Services and Recipients</h2>
                        <p>We may share personal data with third parties where necessary for the purposes described in this Privacy Policy. Depending on the services actually used on the Website, these recipients may include:</p>
                        <ul>
                            <li><strong>Hosting and infrastructure providers:</strong> To host, deliver, maintain, and secure the Website.</li>
                            <li><strong>Analytics providers:</strong> To measure and analyse Website usage where analytics services are enabled.</li>
                            <li><strong>Embedded content and external platforms:</strong> Where third-party content, such as videos, is embedded or accessed through the Website.</li>
                            <li><strong>Professional advisers and public authorities:</strong> Where necessary to comply with legal obligations or establish, exercise, or defend legal claims.</li>
                        </ul>
                        <p>Third-party services may process personal data under their own privacy policies and terms, depending on their role and the way they are integrated into the Website.</p>
                        <p>We do not sell personal data to third parties as a business practice.</p>
                        <h2>9. International Data Transfers</h2>
                        <p>Some service providers may process personal data outside the European Economic Area (EEA).</p>
                        <p>Where personal data is transferred outside the EEA, we will take the measures required by applicable data protection law. Depending on the circumstances, these measures may include an applicable adequacy decision, appropriate safeguards such as Standard Contractual Clauses, and any additional measures required by law.</p>
                        <p>Further information about relevant international transfers and applicable safeguards can be requested using the contact details provided in this Privacy Policy, where applicable.</p>
                        <h2>10. Data Retention</h2>
                        <p>We retain personal data only for as long as necessary to fulfil the purposes for which it was collected, including any applicable legal, accounting, security, or reporting requirements.</p>
                        <p>Retention periods depend on the type of data and the purpose of processing. For example:</p>
                        <ul>
                            <li>Technical and security logs may be retained for a period appropriate to security, troubleshooting, and abuse prevention.</li>
                            <li>Messages sent to us may be retained for as long as necessary to respond to the enquiry and maintain appropriate records.</li>
                            <li>Analytics data may be retained according to the configuration and retention settings of the analytics service used.</li>
                            <li>Cookie consent records may be retained for the period necessary to document and respect your preferences.</li>
                        </ul>
                        <p>When personal data is no longer required, it will be deleted or anonymised where appropriate, unless further retention is required or permitted by law.</p>
                        <h2>11. Data Security</h2>
                        <p>We take reasonable technical and organisational measures designed to protect personal data against unauthorised access, accidental loss, alteration, disclosure, or destruction.</p>
                        <p>However, no website, transmission method, or storage system can be guaranteed to be completely secure. We therefore cannot guarantee absolute security.</p>
                        <h2>12. Your Data Protection Rights</h2>
                        <p>Subject to the conditions and limitations established by applicable law, you may have the following rights in relation to your personal data:</p>
                        <ul>
                            <li><strong>Right of access:</strong> To request confirmation of whether we process your personal data and obtain access to that data.</li>
                            <li><strong>Right to rectification:</strong> To request correction of inaccurate or incomplete personal data.</li>
                            <li><strong>Right to erasure:</strong> To request deletion of personal data in circumstances provided for by law.</li>
                            <li><strong>Right to restriction:</strong> To request restriction of processing in certain circumstances.</li>
                            <li><strong>Right to data portability:</strong> To receive certain personal data in a structured, commonly used, machine-readable format and, where applicable, transmit it to another controller.</li>
                            <li><strong>Right to object:</strong> To object to processing based on legitimate interests or to processing for direct marketing, where applicable.</li>
                            <li><strong>Right to withdraw consent:</strong> Where processing is based on consent, to withdraw that consent at any time.</li>
                        </ul>
                        <p>These rights are not absolute and may be subject to legal conditions or exceptions.</p>
                        <p>To exercise your rights, contact us using the details provided in this Privacy Policy. We may need to verify your identity before responding to your request.</p>
                        <h2>13. Right to Lodge a Complaint</h2>
                        <p>If you believe that we have processed your personal data in violation of applicable data protection law, you may contact us so that we can review your concern.</p>
                        <p>You also have the right to lodge a complaint with the competent data protection supervisory authority. In Belgium, this is the Belgian Data Protection Authority (Gegevensbeschermingsautoriteit / Autorité de protection des données).</p>
                        <p>You can find information about the Belgian Data Protection Authority at <a href="https://www\.dataprotectionauthority.be/" target="\_blank" rel="noopener noreferrer">www\.dataprotectionauthority.be</a>.</p>
                        <h2>14. Children's Privacy</h2>
                        <p>The Website publishes content relating to Pokémon, which may be of interest to younger audiences. We do not knowingly request personal data from children beyond what is necessary for a specific, lawful purpose.</p>
                        <p>If you believe that a child has provided personal data to us in circumstances where it should not have been collected, please contact us so that we can assess the situation and take appropriate action where required by law.</p>
                        <h2>15. Links to Third-Party Websites</h2>
                        <p>The Website may contain links to third-party websites or services that are not operated by us.</p>
                        <p>We are not responsible for the privacy practices or content of those third parties. We encourage you to read their privacy policies before providing them with personal data or interacting with their services.</p>
                        <h2>16. Changes to This Privacy Policy</h2>
                        <p>We may update this Privacy Policy from time to time to reflect changes to our practices, the services used on the Website, or applicable legal requirements.</p>
                        <p>The updated version will be published on this page, together with a revised effective or updated date where appropriate. Where required by law, we will provide additional information about material changes.</p>
                        <p>We encourage you to review this page periodically.</p>
                        <h2>17. Contact Us</h2>
                        <p>If you have questions about this Privacy Policy, wish to exercise your data protection rights, or need further information about how your personal data is processed, please contact us:</p>
                        <ul>
                            <li><strong>Data controller:</strong> [Full legal name or registered business name]</li>
                            <li><strong>Email:</strong> [Privacy contact email address]</li>
                            <li><strong>Address:</strong> [Business or contact address]</li>
                        </ul>
                    
CONTENT,
                        'nl' => <<<'CONTENT'
<h2>1. Inleiding</h2>
<p>Welkom bij PkmnNexus ("wij", "ons" of "onze"). We respecteren je privacy en willen persoonsgegevens op een verantwoorde en transparante manier verwerken.</p>
<p>Deze privacyverklaring legt uit hoe persoonsgegevens kunnen worden verzameld, gebruikt, opgeslagen en gedeeld wanneer je de website van PkmnNexus (de "website") bezoekt of gebruikt. Ook beschrijft ze je rechten op grond van toepasselijke privacywetgeving, waaronder de Algemene verordening gegevensbescherming (AVG/GDPR).</p>
<p>Lees deze verklaring samen met ons cookiebeleid, waarin meer informatie staat over cookies en vergelijkbare technologieën op de website.</p>
<h2>2. Wie zijn wij?</h2>
<p>PkmnNexus is een onafhankelijke website met nieuws, artikelen, gidsen en andere informatieve inhoud over Pokémon en aanverwante onderwerpen.</p>
<p>Voor de toepasselijke wetgeving inzake gegevensbescherming is de verwerkingsverantwoordelijke voor de hier beschreven verwerking:</p>
<ul>
<li><strong>Website:</strong> PkmnNexus</li>
<li><strong>Verwerkingsverantwoordelijke:</strong> [Volledige wettelijke naam of geregistreerde bedrijfsnaam]</li>
<li><strong>Adres:</strong> [Bedrijfs- of contactadres]</li>
<li><strong>E-mail:</strong> [E-mailadres voor privacyvragen]</li>
</ul>
<p>Heb je vragen over deze privacyverklaring of over de verwerking van je persoonsgegevens, neem dan contact met ons op via de bovenstaande gegevens.</p>
<h2>3. Welke persoonsgegevens kunnen we verzamelen?</h2>
<p>Welke persoonsgegevens we verwerken, hangt af van je gebruik van de website en de beschikbare functies. Afhankelijk van je interacties kan het onder meer gaan om de volgende gegevens:</p>
<ul>
<li><strong>Technische gegevens en gebruiksgegevens:</strong> gegevens zoals je IP-adres, browsertype, apparaatgegevens, besturingssysteem, verwijzende pagina's, bezochte pagina's en tijdstippen van bezoeken, voor zover onze hostinginfrastructuur of andere diensten deze verzamelen.</li>
<li><strong>Communicatiegegevens:</strong> gegevens die je verstrekt wanneer je contact met ons opneemt, zoals je naam, e-mailadres en de inhoud van je bericht.</li>
<li><strong>Cookie- en analysegegevens:</strong> gegevens die via cookies of vergelijkbare technologieën worden verzameld, met inachtneming van toepasselijke toestemmingsvereisten en je privacyvoorkeuren.</li>
<li><strong>Voorkeursgegevens:</strong> gegevens over je privacykeuzes, zoals toestemmingsvoorkeuren die door ons cookiemanagementsysteem worden opgeslagen.</li>
</ul>
<p>We streven ernaar alleen persoonsgegevens te verzamelen en te verwerken die nodig zijn voor de betreffende doeleinden. Via de gewone functies van de website vragen we niet bewust om bijzondere persoonsgegevens.</p>
<h2>4. Hoe verzamelen we persoonsgegevens?</h2>
<p>We kunnen persoonsgegevens op de volgende manieren verzamelen:</p>
<ul>
<li><strong>Rechtstreeks van jou:</strong> bijvoorbeeld wanneer je contact met ons opneemt of vrijwillig informatie verstrekt via een beschikbare functie op de website.</li>
<li><strong>Automatisch:</strong> bepaalde technische informatie kan worden verwerkt wanneer je de website bezoekt, onder meer om pagina's te leveren, de beveiliging te waarborgen en technische problemen te onderzoeken.</li>
<li><strong>Via diensten van derden:</strong> bepaalde dienstverleners kunnen informatie verzamelen of ontvangen wanneer hun diensten op de website worden gebruikt, afhankelijk van de configuratie, wettelijke vereisten en waar nodig je toestemming.</li>
</ul>
<h2>5. Waarom verwerken we persoonsgegevens?</h2>
<p>Afhankelijk van de situatie kunnen we persoonsgegevens verwerken voor de volgende doeleinden:</p>
<ul>
<li>De website beheren, onderhouden en beschikbaar maken.</li>
<li>De website beschermen tegen misbruik, kwaadwillige activiteiten en beveiligingsrisico's.</li>
<li>Vragen beantwoorden en communiceren met bezoekers die contact met ons opnemen.</li>
<li>Het gebruik van de website begrijpen en onze inhoud, prestaties en gebruikerservaring verbeteren via analyses, voor zover dit rechtmatig wordt uitgevoerd.</li>
<li>Cookie- en privacyvoorkeuren bewaren en respecteren.</li>
<li>Voldoen aan wettelijke verplichtingen en waar nodig juridische aanspraken instellen, uitoefenen of verdedigen.</li>
</ul>
<p>We gebruiken persoonsgegevens niet voor doeleinden die onverenigbaar zijn met de doeleinden waarvoor ze zijn verzameld, tenzij de toepasselijke wetgeving dit toestaat.</p>
<h2>6. Rechtsgrondslagen voor verwerking</h2>
<p>We verwerken persoonsgegevens alleen wanneer daarvoor een geldige rechtsgrond bestaat onder de AVG/GDPR of andere toepasselijke privacywetgeving. Afhankelijk van de verwerking kan dit onder meer zijn:</p>
<ul>
<li><strong>Gerechtvaardigde belangen:</strong> wanneer verwerking nodig is voor gerechtvaardigde doeleinden, zoals het beheren en beveiligen van de website, het voorkomen van misbruik of het verbeteren van onze diensten, mits deze belangen niet zwaarder wegen dan jouw rechten en vrijheden.</li>
<li><strong>Toestemming:</strong> wanneer je geldige toestemming hebt gegeven, bijvoorbeeld voor analyses of andere niet-essentiële technologieën waarvoor wettelijk toestemming vereist is.</li>
<li><strong>Wettelijke verplichting:</strong> wanneer verwerking nodig is om aan een wettelijke verplichting te voldoen.</li>
<li><strong>Precontractuele maatregelen of uitvoering van een overeenkomst:</strong> wanneer dit van toepassing is op een verzoek dat je doet of een overeenkomst met jou.</li>
</ul>
<p>De toepasselijke rechtsgrond hangt af van het specifieke doel en de omstandigheden. Wanneer verwerking op toestemming is gebaseerd, kun je die toestemming op elk moment intrekken. Dit heeft geen invloed op de rechtmatigheid van de verwerking vóór de intrekking.</p>
<h2>7. Cookies en analyses</h2>
<p>De website kan cookies en vergelijkbare technologieën gebruiken voor essentiële functies, het onthouden van voorkeuren, inzicht in het gebruik van de website of andere functies.</p>
<p>Wanneer Google Analytics 4 of een andere analysedienst is ingeschakeld, kunnen gegevens over interacties met de website worden verwerkt om het verkeer te begrijpen en de website te verbeteren. De verzamelde gegevens en verwerkingsdoeleinden hangen af van de gebruikte dienst en configuratie.</p>
<p>Niet-essentiële cookies en vergelijkbare technologieën worden alleen gebruikt wanneer de vereiste toestemming is verkregen. Je kunt je voorkeuren beheren via de beschikbare cookie-instellingen.</p>
<p>Raadpleeg ons cookiebeleid voor meer informatie over de gebruikte technologieën, hun doeleinden en het beheren van je voorkeuren.</p>
<h2>8. Diensten van derden en ontvangers</h2>
<p>We kunnen persoonsgegevens met derden delen wanneer dit nodig is voor de doeleinden in deze privacyverklaring. Afhankelijk van de diensten die daadwerkelijk op de website worden gebruikt, kunnen dit de volgende ontvangers zijn:</p>
<ul>
<li><strong>Hosting- en infrastructuurproviders:</strong> voor het hosten, leveren, onderhouden en beveiligen van de website.</li>
<li><strong>Analyseproviders:</strong> om het gebruik van de website te meten en analyseren wanneer analysediensten zijn ingeschakeld.</li>
<li><strong>Ingesloten inhoud en externe platforms:</strong> wanneer inhoud van derden, zoals video's, wordt ingesloten of via de website wordt geopend.</li>
<li><strong>Professionele adviseurs en overheidsinstanties:</strong> wanneer dit nodig is om aan wettelijke verplichtingen te voldoen of juridische aanspraken in te stellen, uit te oefenen of te verdedigen.</li>
</ul>
<p>Diensten van derden kunnen persoonsgegevens verwerken volgens hun eigen privacyverklaringen en voorwaarden, afhankelijk van hun rol en de manier waarop ze zijn geïntegreerd.</p>
<p>We verkopen persoonsgegevens niet als bedrijfsactiviteit aan derden.</p>
<h2>9. Internationale doorgifte van gegevens</h2>
<p>Sommige dienstverleners kunnen persoonsgegevens verwerken buiten de Europese Economische Ruimte (EER).</p>
<p>Wanneer persoonsgegevens buiten de EER worden doorgegeven, nemen we de maatregelen die de toepasselijke wetgeving vereist. Afhankelijk van de situatie kunnen dit een adequaatheidsbesluit, passende waarborgen zoals standaardcontractbepalingen en aanvullende wettelijk vereiste maatregelen zijn.</p>
<p>Waar van toepassing kun je via de contactgegevens in deze privacyverklaring meer informatie vragen over internationale doorgiften en de bijbehorende waarborgen.</p>
<h2>10. Bewaartermijnen</h2>
<p>We bewaren persoonsgegevens niet langer dan nodig is voor de doeleinden waarvoor ze zijn verzameld, rekening houdend met toepasselijke wettelijke, boekhoudkundige, beveiligings- en rapportageverplichtingen.</p>
<p>De bewaartermijn hangt af van het soort gegevens en het doel. Voorbeelden:</p>
<ul>
<li>Technische en beveiligingslogboeken kunnen worden bewaard zolang dat passend is voor beveiliging, probleemoplossing en het voorkomen van misbruik.</li>
<li>Berichten die je ons stuurt, kunnen worden bewaard zolang dat nodig is om je vraag te beantwoorden en passende administratie bij te houden.</li>
<li>Analysegegevens kunnen worden bewaard volgens de configuratie en bewaartermijnen van de gebruikte analysedienst.</li>
<li>Bewijzen van cookietoestemming kunnen worden bewaard zolang dat nodig is om je voorkeuren te documenteren en te respecteren.</li>
</ul>
<p>Wanneer persoonsgegevens niet langer nodig zijn, worden ze waar passend verwijderd of geanonimiseerd, tenzij verdere bewaring wettelijk vereist of toegestaan is.</p>
<h2>11. Beveiliging van gegevens</h2>
<p>We nemen redelijke technische en organisatorische maatregelen om persoonsgegevens te beschermen tegen onbevoegde toegang, verlies, wijziging, openbaarmaking of vernietiging.</p>
<p>Geen enkele website, overdrachtsmethode of opslagomgeving kan echter volledig veilig worden gegarandeerd. Absolute veiligheid kunnen we daarom niet beloven.</p>
<h2>12. Je rechten inzake gegevensbescherming</h2>
<p>Afhankelijk van de voorwaarden en beperkingen van de toepasselijke wetgeving kun je de volgende rechten hebben met betrekking tot je persoonsgegevens:</p>
<ul>
<li><strong>Recht op inzage:</strong> vragen of we je persoonsgegevens verwerken en toegang tot die gegevens verkrijgen.</li>
<li><strong>Recht op rectificatie:</strong> onjuiste of onvolledige persoonsgegevens laten corrigeren.</li>
<li><strong>Recht op gegevenswissing:</strong> in wettelijk bepaalde omstandigheden vragen om persoonsgegevens te verwijderen.</li>
<li><strong>Recht op beperking:</strong> in bepaalde omstandigheden vragen om de verwerking te beperken.</li>
<li><strong>Recht op overdraagbaarheid:</strong> bepaalde persoonsgegevens ontvangen in een gestructureerd, gangbaar en machineleesbaar formaat en, waar van toepassing, aan een andere verwerkingsverantwoordelijke laten overdragen.</li>
<li><strong>Recht van bezwaar:</strong> bezwaar maken tegen verwerking op basis van gerechtvaardigde belangen of tegen direct marketing, waar van toepassing.</li>
<li><strong>Recht om toestemming in te trekken:</strong> toestemming op elk moment intrekken wanneer de verwerking daarop is gebaseerd.</li>
</ul>
<p>Deze rechten zijn niet absoluut en kunnen aan wettelijke voorwaarden of uitzonderingen onderworpen zijn.</p>
<p>Neem contact met ons op via de gegevens in deze privacyverklaring om je rechten uit te oefenen. Mogelijk moeten we je identiteit verifiëren voordat we op je verzoek reageren.</p>
<h2>13. Recht om een klacht in te dienen</h2>
<p>Als je denkt dat we je persoonsgegevens in strijd met de toepasselijke privacywetgeving hebben verwerkt, kun je contact met ons opnemen zodat we je bezorgdheid kunnen onderzoeken.</p>
<p>Je kunt ook een klacht indienen bij de bevoegde toezichthoudende autoriteit voor gegevensbescherming. In België is dit de Gegevensbeschermingsautoriteit (Autorité de protection des données).</p>
<p>Informatie vind je op de website van de <a href="https://www.dataprotectionauthority.be/" target="_blank" rel="noopener noreferrer">Gegevensbeschermingsautoriteit</a>.</p>
<h2>14. Privacy van kinderen</h2>
<p>De website publiceert inhoud over Pokémon, die ook interessant kan zijn voor jongere bezoekers. We vragen kinderen niet bewust om persoonsgegevens, behalve wanneer dat voor een specifiek rechtmatig doel noodzakelijk is.</p>
<p>Denk je dat een kind persoonsgegevens heeft verstrekt in omstandigheden waarin die gegevens niet verzameld hadden mogen worden? Neem dan contact met ons op, zodat we de situatie kunnen beoordelen en waar nodig passende maatregelen kunnen nemen.</p>
<h2>15. Links naar websites van derden</h2>
<p>De website kan links bevatten naar websites of diensten van derden die niet door ons worden beheerd.</p>
<p>We zijn niet verantwoordelijk voor het privacybeleid of de inhoud van deze derden. We raden je aan hun privacyverklaringen te lezen voordat je persoonsgegevens verstrekt of met hun diensten communiceert.</p>
<h2>16. Wijzigingen in deze privacyverklaring</h2>
<p>We kunnen deze privacyverklaring van tijd tot tijd bijwerken om wijzigingen in onze werkwijze, de gebruikte diensten of toepasselijke wettelijke vereisten weer te geven.</p>
<p>De bijgewerkte versie wordt op deze pagina gepubliceerd, waar passend met een herziene ingangsdatum of datum van bijwerking. Wanneer de wet dit vereist, geven we aanvullende informatie over belangrijke wijzigingen.</p>
<p>We raden je aan deze pagina regelmatig te bekijken.</p>
<h2>17. Contact</h2>
<p>Heb je vragen over deze privacyverklaring, wil je je privacyrechten uitoefenen of heb je meer informatie nodig over de verwerking van persoonsgegevens? Neem dan contact met ons op:</p>
<ul>
<li><strong>Verwerkingsverantwoordelijke:</strong> [Volledige wettelijke naam of geregistreerde bedrijfsnaam]</li>
<li><strong>E-mail:</strong> [E-mailadres voor privacyvragen]</li>
<li><strong>Adres:</strong> [Bedrijfs- of contactadres]</li>
</ul>
CONTENT,
                    ],
                    'meta_description' => [
                        'en' => 'Learn how PkmnNexus collects, uses, stores, and protects personal data, and how you can exercise your privacy rights under applicable law.',
                        'nl' => 'Lees hoe PkmnNexus persoonsgegevens verzamelt, gebruikt, bewaart en beschermt en hoe je je privacyrechten kunt uitoefenen.',
                    ],
                    'meta_keywords' => [
                        'en' => 'privacy policy, personal data, data protection, GDPR, privacy rights, PkmnNexus',
                        'nl' => 'privacyverklaring, persoonsgegevens, gegevensbescherming, AVG, privacyrechten, PkmnNexus',
                    ],
                    'og_title' => [
                        'en' => 'Privacy Policy',
                        'nl' => 'Privacyverklaring',
                    ],
                    'og_description' => [
                        'en' => 'Find out how PkmnNexus handles personal data and explains your privacy rights and choices.',
                        'nl' => 'Lees hoe PkmnNexus met persoonsgegevens omgaat en welke privacyrechten en keuzes je hebt.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'disclaimer',
                'data' => [
                    'page' => 'Disclaimer',
                    'slug' => [
                        'en' => 'disclaimer',
                        'nl' => 'disclaimer',
                    ],
                    'title' => [
                        'en' => 'Disclaimer',
                        'nl' => 'Disclaimer',
                    ],
                    'content' => [
                        'en' => <<<'CONTENT'

                        <h2>1. General Information</h2>
                        <p>The information published on PkmnNexus ("we", "us", or "our") is provided for general informational and entertainment purposes only.</p>
                        <p>We publish news, articles, guides, opinions, and other content relating to Pokémon and related topics. Although we aim to provide accurate, useful, and up-to-date information, we make no guarantee that all content is complete, accurate, reliable, or current at all times.</p>
                        <p>Information may become outdated, and errors or omissions may occur. You should independently verify important information where necessary, particularly when it relates to official announcements, game updates, events, release dates, or other time-sensitive matters.</p>
                        <h2>2. Independent Pokémon Website</h2>
                        <p>PkmnNexus is an independent website and is not affiliated with, endorsed by, sponsored by, or officially connected to Nintendo, The Pokémon Company, Game Freak, or their subsidiaries or affiliates, unless expressly stated otherwise.</p>
                        <p>Pokémon and all related names, characters, logos, trademarks, artwork, and other intellectual property belong to their respective owners. Their appearance on PkmnNexus does not imply that we own these rights or have an official relationship with their owners.</p>
                        <p>Any references to Pokémon, its games, products, characters, or related services are made for identification, informational, commentary, or other lawful purposes, as applicable.</p>
                        <h2>3. No Guarantee of Accuracy</h2>
                        <p>We make reasonable efforts to verify information before publication. However, we cannot guarantee that every article, guide, statistic, image, announcement, or other piece of content is free from errors or remains accurate over time.</p>
                        <p>Game mechanics, features, availability, events, announcements, and other details may change. Information published on PkmnNexus may not immediately reflect such changes.</p>
                        <p>Unless expressly indicated, content published on this Website should not be interpreted as an official statement from Pokémon-related companies, game developers, publishers, or other third parties.</p>
                        <h2>4. External Links</h2>
                        <p>PkmnNexus may contain links to third-party websites, social media platforms, videos, or other external resources.</p>
                        <p>These links are provided for convenience and informational purposes. We do not control or guarantee the accuracy, availability, security, or content of external websites, and we are not responsible for their privacy policies, practices, or terms of use.</p>
                        <p>Following an external link is at your own discretion. We recommend reviewing the applicable terms and privacy policies of any third-party website you visit.</p>
                        <h2>5. Intellectual Property</h2>
                        <p>Unless otherwise stated, original articles, written content, and other materials created by PkmnNexus are protected by applicable intellectual property laws.</p>
                        <p>Third-party trademarks, images, artwork, videos, and other materials remain the property of their respective rights holders and may be subject to separate copyright, trademark, licensing, or other restrictions.</p>
                        <p>The presence of third-party material on this Website does not imply ownership by PkmnNexus or endorsement by the relevant rights holder.</p>
                        <p>If you believe that content published on PkmnNexus infringes your rights, please contact us through the contact details provided on the Website and identify the material in question. We will review the report and take appropriate action where warranted.</p>
                        <h2>6. Opinions and Editorial Content</h2>
                        <p>Some content published on PkmnNexus may include opinions, commentary, analysis, predictions, interpretations, or speculation.</p>
                        <p>Such content reflects its stated purpose and should not necessarily be understood as confirmed fact or official information. Predictions and opinions may prove inaccurate or may differ from subsequent announcements or developments.</p>
                        <h2>7. Limitation of Liability</h2>
                        <p>To the extent permitted by applicable law, PkmnNexus makes no warranties or representations, express or implied, regarding the accuracy, completeness, availability, or suitability of the information published on the Website.</p>
                        <p>Your use of the information provided on PkmnNexus is at your own discretion. We are not responsible for decisions made solely on the basis of information published on the Website, subject to any liability that cannot lawfully be excluded or limited.</p>
                        <p>To the extent permitted by applicable law, PkmnNexus shall not be liable for indirect or consequential loss arising from the use of, or inability to use, the Website or its content. Nothing in this Disclaimer excludes or limits liability where such exclusion or limitation is prohibited by law, or affects mandatory consumer rights or other non-waivable legal protections.</p>
                        <h2>8. Changes to This Disclaimer</h2>
                        <p>We may update this Disclaimer from time to time to reflect changes to the Website, our content, or applicable legal requirements.</p>
                        <p>Any updated version will be published on this page. We encourage visitors to review this page periodically.</p>
                        <h2>9. Contact</h2>
                        <p>If you have questions about this Disclaimer or concerns regarding content published on PkmnNexus, please contact us using the contact details or contact form provided on the Website.</p>
                    
CONTENT,
                        'nl' => <<<'CONTENT'
<h2>1. Algemene informatie</h2>
<p>De informatie die op PkmnNexus ("wij", "ons" of "onze") wordt gepubliceerd, is uitsluitend bedoeld voor algemene informatieve en amusementsdoeleinden.</p>
<p>We publiceren nieuws, artikelen, gidsen, meningen en andere inhoud over Pokémon en aanverwante onderwerpen. Hoewel we streven naar nauwkeurige, nuttige en actuele informatie, garanderen we niet dat alle inhoud altijd volledig, juist, betrouwbaar of actueel is.</p>
<p>Informatie kan verouderd raken en er kunnen fouten of weglatingen voorkomen. Controleer belangrijke informatie waar nodig zelfstandig, vooral wanneer die betrekking heeft op officiële aankondigingen, game-updates, evenementen, releasedata of andere tijdgevoelige onderwerpen.</p>
<h2>2. Onafhankelijke Pokémonwebsite</h2>
<p>PkmnNexus is een onafhankelijke website en is niet verbonden aan, goedgekeurd door, gesponsord door of officieel gelieerd aan Nintendo, The Pokémon Company, Game Freak of hun dochterondernemingen en partners, tenzij uitdrukkelijk anders vermeld.</p>
<p>Pokémon en alle bijbehorende namen, personages, illustraties, logo's, handelsmerken en andere intellectuele eigendommen behoren toe aan hun respectieve eigenaren. Het gebruik ervan op PkmnNexus betekent niet dat wij deze rechten bezitten of een officiële relatie met de eigenaren hebben.</p>
<p>Verwijzingen naar Pokémon, games, producten, personages of aanverwante diensten worden gebruikt voor identificatie, informatie, commentaar of andere rechtmatige doeleinden, voor zover van toepassing.</p>
<h2>3. Geen garantie op juistheid</h2>
<p>We doen redelijke inspanningen om informatie vóór publicatie te controleren. We kunnen echter niet garanderen dat elk artikel, elke gids, statistiek, afbeelding, aankondiging of ander onderdeel foutloos blijft of altijd juist is.</p>
<p>Spelmechanismen, functies, beschikbaarheid, evenementen, aankondigingen en andere details kunnen veranderen. De informatie op PkmnNexus weerspiegelt zulke wijzigingen mogelijk niet onmiddellijk.</p>
<p>Tenzij uitdrukkelijk anders aangegeven, mag de inhoud van deze website niet worden opgevat als een officiële verklaring van Pokémon-gerelateerde bedrijven, gameontwikkelaars, uitgevers of andere derden.</p>
<h2>4. Externe links</h2>
<p>PkmnNexus kan links bevatten naar websites, sociale mediaplatforms, video's of andere externe bronnen.</p>
<p>Deze links worden aangeboden voor het gemak en ter informatie. We beheren externe websites niet en garanderen niet de juistheid, beschikbaarheid, veiligheid of inhoud ervan. We zijn niet verantwoordelijk voor hun privacybeleid, werkwijzen of gebruiksvoorwaarden.</p>
<p>Het openen van een externe link gebeurt naar eigen inzicht. We raden je aan de toepasselijke voorwaarden en privacyverklaringen te lezen van websites die je bezoekt.</p>
<h2>5. Intellectuele eigendom</h2>
<p>Tenzij anders vermeld, worden originele artikelen, geschreven inhoud en andere materialen die door PkmnNexus zijn gemaakt, beschermd door de toepasselijke wetgeving inzake intellectuele eigendom.</p>
<p>Handelsmerken, afbeeldingen, illustraties, video's en andere materialen van derden blijven eigendom van hun respectieve rechthebbenden en kunnen onder afzonderlijke auteursrechten, merkrechten, licenties of andere beperkingen vallen.</p>
<p>De aanwezigheid van materiaal van derden op deze website betekent niet dat PkmnNexus eigenaar is van dat materiaal of dat de rechthebbende PkmnNexus onderschrijft.</p>
<p>Denk je dat inhoud op PkmnNexus inbreuk maakt op jouw rechten? Neem dan contact met ons op via de contactgegevens op de website en vermeld om welk materiaal het gaat. We onderzoeken de melding en nemen waar nodig passende maatregelen.</p>
<h2>6. Meningen en redactionele inhoud</h2>
<p>Sommige inhoud op PkmnNexus kan meningen, commentaar, analyses, voorspellingen, interpretaties of speculatie bevatten.</p>
<p>Dergelijke inhoud heeft het aangegeven doel en mag niet noodzakelijk worden beschouwd als bevestigd feit of officiële informatie. Voorspellingen en meningen kunnen onjuist blijken of afwijken van latere aankondigingen en ontwikkelingen.</p>
<h2>7. Beperking van aansprakelijkheid</h2>
<p>Voor zover de toepasselijke wetgeving dit toestaat, geeft PkmnNexus geen uitdrukkelijke of stilzwijgende garanties over de juistheid, volledigheid, beschikbaarheid of geschiktheid van de informatie op de website.</p>
<p>Je gebruikt de informatie op PkmnNexus naar eigen inzicht. We zijn niet verantwoordelijk voor beslissingen die uitsluitend op basis van de gepubliceerde informatie worden genomen, met inachtneming van aansprakelijkheid die wettelijk niet kan worden uitgesloten of beperkt.</p>
<p>Voor zover wettelijk toegestaan, is PkmnNexus niet aansprakelijk voor indirecte schade of gevolgschade die voortvloeit uit het gebruik van, of het niet kunnen gebruiken van, de website of de inhoud ervan. Dit sluit geen aansprakelijkheid uit of beperkt die volgens de wet niet mag worden uitgesloten of beperkt en doet geen afbreuk aan dwingende consumentenrechten of andere rechten waarvan geen afstand kan worden gedaan.</p>
<h2>8. Wijzigingen in deze disclaimer</h2>
<p>We kunnen deze disclaimer van tijd tot tijd aanpassen vanwege wijzigingen aan de website, onze inhoud of toepasselijke wettelijke vereisten.</p>
<p>Elke bijgewerkte versie wordt op deze pagina gepubliceerd. We raden bezoekers aan deze pagina regelmatig te bekijken.</p>
<h2>9. Contact</h2>
<p>Heb je vragen over deze disclaimer of zorgen over inhoud op PkmnNexus? Neem dan contact met ons op via de contactgegevens of het contactformulier op de website.</p>
CONTENT,
                    ],
                    'meta_description' => [
                        'en' => 'Read the PkmnNexus disclaimer covering content accuracy, independent Pokémon coverage, third-party links, intellectual property, and liability.',
                        'nl' => 'Lees de disclaimer van PkmnNexus over de juistheid van inhoud, onafhankelijke Pokémoninformatie, externe links, intellectuele eigendom en aansprakelijkheid.',
                    ],
                    'meta_keywords' => [
                        'en' => 'disclaimer, website disclaimer, pokemon information, independent pokemon website, intellectual property',
                        'nl' => 'disclaimer, website disclaimer, pokemon informatie, onafhankelijke pokemon website, intellectuele eigendom',
                    ],
                    'og_title' => [
                        'en' => 'Disclaimer',
                        'nl' => 'Disclaimer',
                    ],
                    'og_description' => [
                        'en' => 'Learn about the scope and limitations of information published on PkmnNexus.',
                        'nl' => 'Lees meer over de reikwijdte en beperkingen van de informatie op PkmnNexus.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'terms-and-conditions',
                'data' => [
                    'page' => 'Terms and Conditions',
                    'slug' => [
                        'en' => 'terms-and-conditions',
                        'nl' => 'algemene-voorwaarden',
                    ],
                    'title' => [
                        'en' => 'Terms and Conditions',
                        'nl' => 'Algemene voorwaarden',
                    ],
                    'content' => [
                        'en' => <<<'CONTENT'

                        <h2>1. Introduction</h2>
                        <p>Welcome to PkmnNexus ("we", "us", or "our"). These Terms and Conditions govern your access to and use of the PkmnNexus website, including its articles, news, guides, features, and other published content (collectively, the "Website").</p>
                        <p>By accessing or using the Website, you agree to these Terms and Conditions. If you do not agree with these terms, please discontinue your use of the Website.</p>
                        <p>These terms should be read together with our Privacy Policy, Cookie Policy, and Disclaimer, where applicable.</p>
                        <h2>2. About PkmnNexus</h2>
                        <p>PkmnNexus is an independent website that publishes news, articles, guides, and other informational content relating to Pokémon and related topics.</p>
                        <p>PkmnNexus is not affiliated with, endorsed by, sponsored by, or officially connected to Nintendo, The Pokémon Company, Game Freak, or any of their subsidiaries or affiliates, unless expressly stated otherwise.</p>
                        <p>All third-party names, trademarks, logos, characters, and other intellectual property remain the property of their respective owners.</p>
                        <h2>3. Use of the Website</h2>
                        <p>You may access and use the Website for lawful, personal, and informational purposes, subject to these Terms and Conditions and applicable law.</p>
                        <p>When using the Website, you agree not to:</p>
                        <ul>
                            <li>Use the Website for any unlawful, fraudulent, or harmful purpose.</li>
                            <li>Attempt to gain unauthorized access to the Website, its servers, systems, or related infrastructure.</li>
                            <li>Interfere with the security, availability, or proper functioning of the Website.</li>
                            <li>Introduce malicious software, code, or other harmful material.</li>
                            <li>Use automated tools to access, collect, or extract Website content in a manner that violates applicable law, these terms, or the rights of others.</li>
                            <li>Copy, reproduce, republish, or commercially exploit Website content in violation of applicable intellectual property rights or other legal restrictions.</li>
                            <li>Misrepresent your relationship with PkmnNexus or suggest that you represent us without authorization.</li>
                        </ul>
                        <p>Nothing in these terms prohibits activities that are permitted by applicable law, including any mandatory exceptions or limitations to intellectual property rights.</p>
                        <h2>4. Website Content and Accuracy</h2>
                        <p>We aim to provide useful, accurate, and up-to-date Pokémon news, articles, guides, and other information. However, information may change over time, and errors, omissions, or outdated material may occur.</p>
                        <p>Unless expressly stated otherwise, the content on the Website is provided for general informational and entertainment purposes. It should not be regarded as official advice or as a guarantee that any particular information, feature, release date, game mechanic, event, or announcement is current or accurate.</p>
                        <p>We may update, correct, modify, or remove content at any time. We do not guarantee that every article or page will always be available or that all information will be updated immediately following a change or announcement.</p>
                        <h2>5. Intellectual Property</h2>
                        <p>Unless otherwise indicated, original content created for PkmnNexus, including articles, written descriptions, website design, and other original materials, is protected by applicable intellectual property laws.</p>
                        <p>You may link to publicly available pages on the Website and refer to our content in accordance with applicable law. You may not reproduce, republish, distribute, modify, or commercially exploit our original content without prior permission where such permission is legally required.</p>
                        <p>Requests to reproduce or republish our original content may be directed to us through the contact details provided on the Website.</p>
                        <p>Pokémon-related names, characters, artwork, logos, trademarks, and other materials may belong to Nintendo, The Pokémon Company, Game Freak, or other respective rights holders. Their inclusion on PkmnNexus does not imply ownership by or affiliation with PkmnNexus. Such material remains subject to the rights and permissions applicable to it.</p>
                        <p>If you believe that material published on the Website infringes your intellectual property rights, please contact us with sufficient information to identify the material and explain your concern. We will review such reports and take appropriate action where warranted.</p>
                        <h2>6. Third-Party Websites and Services</h2>
                        <p>The Website may contain links to third-party websites, platforms, services, or resources. These links are provided for convenience and informational purposes.</p>
                        <p>We do not control third-party websites and are not responsible for their content, accuracy, availability, privacy practices, security, or terms of use. Visiting a third-party website is at your own discretion and is subject to that website's own terms and policies.</p>
                        <p>The inclusion of a link does not necessarily imply endorsement of the linked website, its operator, or its content.</p>
                        <h2>7. Availability and Changes to the Website</h2>
                        <p>We aim to keep the Website accessible and functioning properly, but we do not guarantee uninterrupted, error-free, or continuous availability.</p>
                        <p>We may maintain, update, modify, suspend, or discontinue any part of the Website where reasonably necessary, including for technical, operational, security, or legal reasons.</p>
                        <p>Where required by applicable law, we will respect any rights you may have in relation to the availability or provision of the Website.</p>
                        <h2>8. Disclaimer and Limitation of Liability</h2>
                        <p>To the extent permitted by applicable law, PkmnNexus does not guarantee that the Website or its content will always be accurate, complete, current, available, secure, or free from errors.</p>
                        <p>Nothing on the Website constitutes a guarantee of a particular result, and you are responsible for how you use the information provided.</p>
                        <p>To the extent permitted by applicable law, we will not be liable for indirect or consequential loss arising from your use of, or inability to use, the Website. This does not exclude or limit liability where such exclusion or limitation is prohibited by law.</p>
                        <p>Nothing in these Terms and Conditions excludes or limits liability for fraud, intentional misconduct, or any other liability that cannot lawfully be excluded or limited. Nothing in these terms affects mandatory consumer rights or other protections that apply under applicable law.</p>
                        <p>For further information about the nature and limitations of the information published on PkmnNexus, please consult our Disclaimer.</p>
                        <h2>9. Privacy and Cookies</h2>
                        <p>Your use of the Website may involve the processing of personal data and the use of cookies or similar technologies.</p>
                        <p>Our Privacy Policy explains how we process personal data, while our Cookie Policy provides information about cookies and similar technologies used on the Website and how you can manage your preferences.</p>
                        <p>Where consent is legally required, non-essential cookies and similar technologies will be used in accordance with the applicable consent requirements.</p>
                        <h2>10. Changes to These Terms</h2>
                        <p>We may update these Terms and Conditions from time to time to reflect changes to the Website, our practices, or applicable legal requirements.</p>
                        <p>The updated version will be published on this page, together with a revised effective or updated date where appropriate. Changes will apply from the date indicated in the updated version, subject to any requirements imposed by applicable law.</p>
                        <p>We encourage you to review this page periodically to stay informed about the terms governing your use of the Website.</p>
                        <h2>11. Governing Law</h2>
                        <p>These Terms and Conditions are governed by the laws of Belgium, without prejudice to any mandatory legal provisions that may apply.</p>
                        <p>If you are a consumer residing in another country, this choice of law does not deprive you of the protection afforded by provisions that cannot be derogated from under the law that would otherwise apply to you.</p>
                        <p>Any disputes arising in connection with these terms will be handled by the competent courts in accordance with applicable law, including any mandatory rules concerning consumer jurisdiction.</p>
                        <h2>12. Severability</h2>
                        <p>If any provision of these Terms and Conditions is found to be invalid, unlawful, or unenforceable, the remaining provisions will continue to apply to the extent permitted by law.</p>
                        <p>Any invalid or unenforceable provision will be interpreted or replaced, where legally possible, in a manner that most closely reflects its original purpose while complying with applicable law.</p>
                        <h2>13. Contact</h2>
                        <p>If you have questions about these Terms and Conditions, or if you wish to contact us regarding the content published on PkmnNexus, please use the contact details or contact form provided on the Website.</p>                   
                    
CONTENT,
                        'nl' => <<<'CONTENT'
<h2>1. Inleiding</h2>
<p>Welkom bij PkmnNexus ("wij", "ons" of "onze"). Deze algemene voorwaarden regelen je toegang tot en gebruik van de website van PkmnNexus, waaronder artikelen, nieuws, gidsen, functies en andere gepubliceerde inhoud (samen de "website").</p>
<p>Door de website te bezoeken of te gebruiken, ga je akkoord met deze algemene voorwaarden. Ga je niet akkoord, gebruik de website dan niet verder.</p>
<p>Lees deze voorwaarden waar van toepassing samen met onze privacyverklaring, ons cookiebeleid en onze disclaimer.</p>
<h2>2. Over PkmnNexus</h2>
<p>PkmnNexus is een onafhankelijke website met nieuws, artikelen, gidsen en andere informatieve inhoud over Pokémon en aanverwante onderwerpen.</p>
<p>PkmnNexus is niet verbonden aan, goedgekeurd door, gesponsord door of officieel gelieerd aan Nintendo, The Pokémon Company, Game Freak of hun dochterondernemingen en partners, tenzij uitdrukkelijk anders vermeld.</p>
<p>Alle namen, handelsmerken, logo's, personages en andere intellectuele eigendommen van derden blijven eigendom van hun respectieve eigenaren.</p>
<h2>3. Gebruik van de website</h2>
<p>Je mag de website gebruiken voor rechtmatige, persoonlijke en informatieve doeleinden, met inachtneming van deze voorwaarden en de toepasselijke wetgeving.</p>
<p>Bij het gebruik van de website stem je ermee in om niet:</p>
<ul>
<li>de website te gebruiken voor onwettige, frauduleuze of schadelijke doeleinden;</li>
<li>te proberen ongeautoriseerde toegang te krijgen tot de website, servers, systemen of bijbehorende infrastructuur;</li>
<li>de beveiliging, beschikbaarheid of goede werking van de website te verstoren;</li>
<li>kwaadaardige software, code of ander schadelijk materiaal te introduceren;</li>
<li>geautomatiseerde hulpmiddelen te gebruiken om inhoud te benaderen, verzamelen of extraheren op een manier die in strijd is met de wet, deze voorwaarden of de rechten van anderen;</li>
<li>inhoud van de website te kopiëren, reproduceren, opnieuw publiceren of commercieel te exploiteren in strijd met intellectuele-eigendomsrechten of andere wettelijke beperkingen;</li>
<li>je relatie met PkmnNexus verkeerd voor te stellen of zonder toestemming te beweren dat je ons vertegenwoordigt.</li>
</ul>
<p>Niets in deze voorwaarden verbiedt activiteiten die volgens de toepasselijke wetgeving zijn toegestaan, waaronder dwingende uitzonderingen of beperkingen op intellectuele-eigendomsrechten.</p>
<h2>4. Website-inhoud en juistheid</h2>
<p>We streven naar nuttig, nauwkeurig en actueel Pokémonnieuws, artikelen, gidsen en andere informatie. Informatie kan echter veranderen en fouten, weglatingen of verouderde inhoud kunnen voorkomen.</p>
<p>Tenzij uitdrukkelijk anders vermeld, is de inhoud van de website bedoeld voor algemene informatie en amusement. De inhoud is geen officieel advies en garandeert niet dat informatie, functies, releasedata, spelmechanismen, evenementen of aankondigingen actueel of juist zijn.</p>
<p>We kunnen inhoud op elk moment bijwerken, corrigeren, wijzigen of verwijderen. We garanderen niet dat elk artikel of elke pagina altijd beschikbaar is of dat alle informatie onmiddellijk na een wijziging wordt bijgewerkt.</p>
<h2>5. Intellectuele eigendom</h2>
<p>Tenzij anders aangegeven, wordt originele inhoud die voor PkmnNexus is gemaakt, waaronder artikelen, geschreven beschrijvingen, het websiteontwerp en andere originele materialen, beschermd door de toepasselijke wetgeving inzake intellectuele eigendom.</p>
<p>Je mag links plaatsen naar openbaar beschikbare pagina's op de website en naar onze inhoud verwijzen in overeenstemming met de toepasselijke wetgeving. Je mag onze originele inhoud niet zonder voorafgaande toestemming reproduceren, opnieuw publiceren, verspreiden, wijzigen of commercieel exploiteren wanneer die toestemming wettelijk vereist is.</p>
<p>Verzoeken om onze originele inhoud te reproduceren of opnieuw te publiceren kun je indienen via de contactgegevens op de website.</p>
<p>Pokémon-gerelateerde namen, personages, illustraties, logo's, handelsmerken en andere materialen kunnen eigendom zijn van Nintendo, The Pokémon Company, Game Freak of andere rechthebbenden. De opname ervan op PkmnNexus betekent niet dat PkmnNexus eigenaar is of met hen is verbonden. Dergelijk materiaal blijft onderworpen aan de toepasselijke rechten en toestemmingen.</p>
<p>Denk je dat materiaal op de website inbreuk maakt op jouw intellectuele-eigendomsrechten? Neem dan contact met ons op met voldoende informatie om het materiaal te identificeren en je bezwaar toe te lichten. We onderzoeken meldingen en nemen waar nodig passende maatregelen.</p>
<h2>6. Websites en diensten van derden</h2>
<p>De website kan links bevatten naar websites, platforms, diensten of bronnen van derden. Deze links worden aangeboden voor het gemak en ter informatie.</p>
<p>We beheren websites van derden niet en zijn niet verantwoordelijk voor hun inhoud, juistheid, beschikbaarheid, privacypraktijken, beveiliging of gebruiksvoorwaarden. Het bezoeken van een website van derden gebeurt naar eigen inzicht en valt onder de eigen voorwaarden en beleidsregels van die website.</p>
<p>Een link betekent niet noodzakelijk dat we de gelinkte website, de beheerder ervan of de inhoud onderschrijven.</p>
<h2>7. Beschikbaarheid en wijzigingen van de website</h2>
<p>We proberen de website toegankelijk en goed werkend te houden, maar garanderen geen ononderbroken, foutloze of voortdurende beschikbaarheid.</p>
<p>We kunnen onderdelen van de website onderhouden, bijwerken, wijzigen, opschorten of stopzetten wanneer dat redelijkerwijs nodig is, onder meer om technische, operationele, veiligheids- of wettelijke redenen.</p>
<p>Waar de toepasselijke wetgeving dit vereist, respecteren we de rechten die je hebt met betrekking tot de beschikbaarheid of levering van de website.</p>
<h2>8. Disclaimer en beperking van aansprakelijkheid</h2>
<p>Voor zover de toepasselijke wetgeving dit toestaat, garandeert PkmnNexus niet dat de website of de inhoud altijd nauwkeurig, volledig, actueel, beschikbaar, veilig of foutloos is.</p>
<p>Niets op de website garandeert een bepaald resultaat. Je bent zelf verantwoordelijk voor de manier waarop je de verstrekte informatie gebruikt.</p>
<p>Voor zover wettelijk toegestaan, zijn we niet aansprakelijk voor indirecte schade of gevolgschade die voortvloeit uit je gebruik van, of het niet kunnen gebruiken van, de website. Dit beperkt geen aansprakelijkheid wanneer uitsluiting of beperking wettelijk verboden is.</p>
<p>Niets in deze voorwaarden sluit aansprakelijkheid uit of beperkt die voor fraude, opzettelijk wangedrag of andere aansprakelijkheid die wettelijk niet kan worden uitgesloten of beperkt. Deze voorwaarden doen geen afbreuk aan dwingende consumentenrechten of andere beschermingen die op grond van de toepasselijke wetgeving gelden.</p>
<p>Raadpleeg onze disclaimer voor meer informatie over de aard en beperkingen van de informatie op PkmnNexus.</p>
<h2>9. Privacy en cookies</h2>
<p>Je gebruik van de website kan de verwerking van persoonsgegevens en het gebruik van cookies of vergelijkbare technologieën met zich meebrengen.</p>
<p>Onze privacyverklaring legt uit hoe we persoonsgegevens verwerken. Ons cookiebeleid geeft informatie over cookies en vergelijkbare technologieën op de website en over het beheren van je voorkeuren.</p>
<p>Wanneer de wet toestemming vereist, worden niet-essentiële cookies en vergelijkbare technologieën alleen gebruikt volgens de toepasselijke toestemmingsvereisten.</p>
<h2>10. Wijzigingen in deze voorwaarden</h2>
<p>We kunnen deze algemene voorwaarden van tijd tot tijd aanpassen vanwege wijzigingen aan de website, onze werkwijze of toepasselijke wettelijke vereisten.</p>
<p>De bijgewerkte versie wordt op deze pagina gepubliceerd, waar passend met een herziene ingangsdatum. Wijzigingen gelden vanaf de aangegeven datum, met inachtneming van de toepasselijke wetgeving.</p>
<p>We raden je aan deze voorwaarden regelmatig te bekijken.</p>
<h2>11. Toepasselijk recht</h2>
<p>Op deze algemene voorwaarden is het Belgische recht van toepassing, onverminderd eventuele dwingende wettelijke bepalingen die van toepassing zijn.</p>
<p>Ben je consument en woon je in een ander land, dan ontneemt deze rechtskeuze je niet de bescherming die je geniet op grond van bepalingen waarvan volgens het anders toepasselijke recht niet mag worden afgeweken.</p>
<p>Geschillen in verband met deze voorwaarden worden behandeld door de bevoegde rechtbanken overeenkomstig de toepasselijke regels, waaronder dwingende regels over de bevoegde rechter bij consumentengeschillen.</p>
<h2>12. Scheidbaarheid</h2>
<p>Als een bepaling van deze voorwaarden ongeldig, onwettig of niet-afdwingbaar blijkt, blijven de overige bepalingen van kracht voor zover de wet dit toestaat.</p>
<p>Een ongeldige of niet-afdwingbare bepaling wordt, waar juridisch mogelijk, uitgelegd of vervangen op een manier die het oorspronkelijke doel zo dicht mogelijk benadert en tegelijk aan de wet voldoet.</p>
<h2>13. Contact</h2>
<p>Heb je vragen over deze algemene voorwaarden of wil je contact opnemen over inhoud op PkmnNexus? Gebruik dan de contactgegevens of het contactformulier op de website.</p>
CONTENT,
                    ],
                    'meta_description' => [
                        'en' => 'Read the terms governing your use of PkmnNexus, including website rules, intellectual property, external links, and applicable law.',
                        'nl' => 'Lees de voorwaarden voor het gebruik van PkmnNexus, waaronder regels voor de website, intellectuele eigendom, externe links en toepasselijk recht.',
                    ],
                    'meta_keywords' => [
                        'en' => 'terms and conditions, website terms, terms of use, intellectual property, PkmnNexus',
                        'nl' => 'algemene voorwaarden, websitevoorwaarden, gebruiksvoorwaarden, intellectuele eigendom, PkmnNexus',
                    ],
                    'og_title' => [
                        'en' => 'Terms and Conditions',
                        'nl' => 'Algemene voorwaarden',
                    ],
                    'og_description' => [
                        'en' => 'Review the rules and conditions that apply when using the PkmnNexus website.',
                        'nl' => 'Bekijk de regels en voorwaarden voor het gebruik van de website van PkmnNexus.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'cookie-policy',
                'data' => [
                    'page' => 'Cookie Policy',
                    'slug' => [
                        'en' => 'cookie-policy',
                        'nl' => 'cookiebeleid',
                    ],
                    'title' => [
                        'en' => 'Cookie Policy',
                        'nl' => 'Cookiebeleid',
                    ],
                    'content' => [
                        'en' => <<<'CONTENT'

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
                        <p>Depending on the configuration, Google Analytics may use cookies such as <code>\_ga</code> and <code>\_ga\_*</code> to distinguish browsers and maintain analytics session information. Analytics data may include page information, interactions, browser and device information, approximate location information, and online identifiers.</p>
                        <p>Google Analytics is provided by Google. Information collected through this service may be transmitted to and processed by Google in accordance with Google's applicable terms and privacy documentation.</p>
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
                        <p>Your cookie preference is stored in your browser's local storage under the key <code>pkmnexus_cookie_consent</code>. This allows us to remember your choice on subsequent visits. The preference remains stored until you change or remove it, subject to browser settings and storage limitations.</p>
                        <p>You can also clear your browser's cookies and local storage. If you do so, PkmnNexus may ask you to choose your preferences again.</p>
                        <h2>6. Third-Party Services</h2>
                        <p>Google Analytics 4 and Google Tag Manager are Google services. Their operation is subject to Google's applicable documentation, terms, and privacy information.</p>
                        <p>For more information, please consult the <a href="https://policies.google.com/privacy" target="\_blank" rel="noopener noreferrer">Google Privacy Policy</a> and the <a href="https://support.google.com/analytics/answer/6004245" target="\_blank" rel="noopener noreferrer">Google Analytics privacy information</a>.</p>
                        <h2>7. Data Retention</h2>
                        <p>The period for which information is stored depends on the technology and its configuration. Our cookie preference is stored in your browser's local storage until it is changed or removed. Google Analytics cookies may have their own expiry settings, and browsers may impose additional limits.</p>
                        <p>Analytics data retention within Google Analytics is configured separately from the lifetime of cookies in your browser. The applicable retention periods depend on the relevant Google Analytics settings and configuration.</p>
                        <h2>8. Your Privacy Rights</h2>
                        <p>Depending on your location and the applicable data protection laws, you may have rights concerning the processing of your personal data. These may include the right to access, correct, or request deletion of personal data, to restrict or object to certain processing, and to withdraw consent where processing is based on consent.</p>
                        <p>Withdrawing consent does not affect the lawfulness of processing carried out before the withdrawal. You can change your analytics preference using the cookie settings available on our website.</p>
                        <h2>9. Changes to This Cookie Policy</h2>
                        <p>We may update this Cookie Policy when our website, technologies, or legal requirements change. The updated version will be published on this page. We encourage you to review this page periodically to stay informed about our use of cookies and similar technologies.</p>
                        <h2>10. Contact</h2>
                        <p>If you have questions about this Cookie Policy or our use of cookies and similar technologies, please contact the website operator using the contact details provided on PkmnNexus.</p>
                    
CONTENT,
                        'nl' => <<<'CONTENT'
<h2>1. Inleiding</h2>
<p>Welkom bij PkmnNexus. Dit cookiebeleid legt uit hoe we cookies en vergelijkbare technologieën gebruiken wanneer je onze website bezoekt. Het beschrijft welke technologieën we gebruiken, waarom we ze gebruiken en hoe je je voorkeuren kunt beheren.</p>
<p>PkmnNexus is gevestigd in België en verwelkomt bezoekers uit de hele wereld. De toepasselijke privacy- en gegevensbeschermingsregels kunnen verschillen afhankelijk van je locatie. We streven ernaar je privacy te respecteren en duidelijke keuzes te bieden over optionele trackingtechnologieën.</p>
<p>Lees dit cookiebeleid waar van toepassing samen met onze privacyverklaring.</p>
<h2>2. Wat zijn cookies?</h2>
<p>Cookies zijn kleine tekstbestanden die op je apparaat worden opgeslagen wanneer je een website bezoekt. Vergelijkbare technologieën, zoals lokale browseropslag en scripts, kunnen eveneens informatie op je apparaat opslaan of uitlezen. Deze technologieën kunnen worden gebruikt om een website goed te laten werken, voorkeuren te onthouden of inzicht te krijgen in het gebruik van een website.</p>
<h2>3. Hoe gebruiken we cookies en vergelijkbare technologieën?</h2>
<p>PkmnNexus gebruikt momenteel technologieën voor essentiële websitefuncties, het onthouden van je cookievoorkeuren en optionele websiteanalyse via Google Analytics 4 (GA4), beheerd met Google Tag Manager (GTM).</p>
<p>We maken onderscheid tussen noodzakelijke technologieën en optionele analysetechnologieën. Optionele analyse blijft uitgeschakeld totdat je daar actief toestemming voor geeft via onze cookiebanner.</p>
<h3>3.1 Noodzakelijke technologieën</h3>
<p>Noodzakelijke technologieën ondersteunen essentiële websitefuncties, beveiliging en de werking van de website. Afhankelijk van je gebruik kunnen daar Laravel-sessiecookies en beveiligingscookies bij horen. Deze technologieën worden gebruikt wanneer ze nodig zijn voor de betreffende functie.</p>
<p>Onze website gebruikt ook lokale browseropslag om je cookievoorkeur te onthouden. Zo kunnen we onthouden of je optionele analyse hebt geaccepteerd of geweigerd, zonder je bij elke paginalading opnieuw te vragen.</p>
<h3>3.2 Analysetechnologieën</h3>
<p>Als je optionele analyse accepteert, laadt onze website Google Tag Manager. Deze activeert de geconfigureerde Google-tag voor Google Analytics 4. GA4 helpt ons te begrijpen hoe bezoekers PkmnNexus gebruiken, bijvoorbeeld welke pagina's worden bezocht en hoe bezoekers met de inhoud omgaan.</p>
<p>Afhankelijk van de configuratie kan Google Analytics cookies zoals <code>_ga</code> en <code>_ga_*</code> gebruiken om browsers te onderscheiden en sessiegegevens voor analyse bij te houden. Analysegegevens kunnen pagina-informatie, interacties, browser- en apparaatgegevens, geschatte locatiegegevens en online identificatoren omvatten.</p>
<p>Google Analytics wordt geleverd door Google. Informatie die via deze dienst wordt verzameld, kan worden verzonden naar en verwerkt door Google overeenkomstig de toepasselijke voorwaarden en privacydocumentatie van Google.</p>
<h2>4. Google Tag Manager en toestemming</h2>
<p>We gebruiken Google Tag Manager om trackingtags op onze website te beheren. Onze implementatie is zo ontworpen dat de Google Tag Manager-container pas wordt geladen nadat je toestemming hebt gegeven voor optionele analyse.</p>
<p>Als je optionele analyse weigert, wordt Google Tag Manager niet geladen via deze toestemmingsgestuurde integratie. Als je analyse accepteert, kan de Google-tag toegestane analysegebeurtenissen naar onze Google Analytics 4-property sturen.</p>
<p>Onze huidige implementatie activeert niet bewust advertentie- of remarketingtags. Toestemming voor analyse betekent niet dat je toestemming geeft voor gepersonaliseerde advertenties.</p>
<h2>5. Je cookievoorkeuren beheren</h2>
<p>Wanneer je PkmnNexus bezoekt, kun je via onze cookiebanner optionele analyse accepteren, weigeren of de cookie-instellingen openen om je voorkeuren te beheren.</p>
<p>Analyse is optioneel en staat standaard uit. Noodzakelijke technologieën kunnen actief blijven wanneer ze nodig zijn om de website te laten werken.</p>
<p>Je kunt je cookievoorkeuren op elk moment openen door op het cookiepictogram rechtsonder op de website te klikken.</p>
<h3>5.1 Toestemming wijzigen of intrekken</h3>
<p>Je kunt je toestemming voor optionele analyse op elk moment wijzigen of intrekken. Je hoeft analyse niet te blijven toestaan omdat je er eerder mee hebt ingestemd.</p>
<p>Klik op het cookiepictogram rechtsonder op PkmnNexus om de cookiebanner opnieuw te openen en de instellingen te bekijken. Je kunt analyse vervolgens uitschakelen of je voorkeuren wijzigen en opslaan.</p>
<p>Je bijgewerkte keuze geldt vanaf dat moment. Het intrekken van toestemming heeft geen invloed op de rechtmatigheid van verwerking vóór de intrekking. Het verwijdert ook niet automatisch informatie die Google Analytics mogelijk al heeft verzameld. Waar van toepassing kun je verzoeken over eerder verzamelde persoonsgegevens indienen via de relevante privacyrechten of contactprocedure.</p>
<h3>5.2 Je voorkeuren onthouden</h3>
<p>Je cookievoorkeur wordt in de lokale opslag van je browser bewaard onder de sleutel <code>pkmnexus_cookie_consent</code>. Zo kunnen we je keuze bij volgende bezoeken onthouden. De voorkeur blijft opgeslagen totdat je deze wijzigt of verwijdert, afhankelijk van je browserinstellingen en opslagbeperkingen.</p>
<p>Je kunt ook de cookies en lokale opslag van je browser wissen. PkmnNexus kan je dan opnieuw vragen je voorkeuren te kiezen.</p>
<h2>6. Diensten van derden</h2>
<p>Google Analytics 4 en Google Tag Manager zijn diensten van Google. Het gebruik ervan valt onder de toepasselijke documentatie, voorwaarden en privacyinformatie van Google.</p>
<p>Raadpleeg voor meer informatie het <a href="https://policies.google.com/privacy" target="_blank" rel="noopener noreferrer">privacybeleid van Google</a> en de <a href="https://support.google.com/analytics/answer/6004245" target="_blank" rel="noopener noreferrer">privacyinformatie van Google Analytics</a>.</p>
<h2>7. Bewaartermijnen</h2>
<p>De bewaartermijn van informatie hangt af van de technologie en de configuratie ervan. Onze cookievoorkeur wordt in de lokale opslag van je browser bewaard totdat deze wordt gewijzigd of verwijderd. Google Analytics-cookies kunnen een eigen vervaldatum hebben en browsers kunnen aanvullende beperkingen toepassen.</p>
<p>De bewaartermijn van analysegegevens in Google Analytics wordt afzonderlijk ingesteld van de levensduur van cookies in je browser. De toepasselijke termijnen hangen af van de instellingen van Google Analytics.</p>
<h2>8. Je privacyrechten</h2>
<p>Afhankelijk van je locatie en de toepasselijke wetgeving inzake gegevensbescherming kun je rechten hebben met betrekking tot de verwerking van je persoonsgegevens. Daaronder kunnen het recht op inzage, correctie of verwijdering, beperking of bezwaar tegen bepaalde verwerkingen en het intrekken van toestemming vallen.</p>
<p>Het intrekken van toestemming heeft geen invloed op de rechtmatigheid van de verwerking vóór de intrekking. Je kunt je analysevoorkeur wijzigen via de cookie-instellingen op onze website.</p>
<h2>9. Wijzigingen in dit cookiebeleid</h2>
<p>We kunnen dit cookiebeleid bijwerken wanneer onze website, technologieën of wettelijke vereisten veranderen. De bijgewerkte versie wordt op deze pagina gepubliceerd. We raden je aan deze pagina regelmatig te bekijken om op de hoogte te blijven van ons gebruik van cookies en vergelijkbare technologieën.</p>
<h2>10. Contact</h2>
<p>Heb je vragen over dit cookiebeleid of ons gebruik van cookies en vergelijkbare technologieën? Neem dan contact op met de websitebeheerder via de contactgegevens op PkmnNexus.</p>
CONTENT,
                    ],
                    'meta_description' => [
                        'en' => 'Learn how PkmnNexus uses essential technologies and optional Google Analytics cookies, and how to manage or withdraw your consent.',
                        'nl' => 'Lees hoe PkmnNexus noodzakelijke technologieën en optionele Google Analytics-cookies gebruikt en hoe je toestemming kunt beheren of intrekken.',
                    ],
                    'meta_keywords' => [
                        'en' => 'cookie policy, cookies, Google Analytics 4, Google Tag Manager, cookie consent, privacy preferences',
                        'nl' => 'cookiebeleid, cookies, Google Analytics 4, Google Tag Manager, cookietoestemming, privacyvoorkeuren',
                    ],
                    'og_title' => [
                        'en' => 'Cookie Policy',
                        'nl' => 'Cookiebeleid',
                    ],
                    'og_description' => [
                        'en' => 'Learn about cookies and analytics on PkmnNexus and how to manage your privacy preferences.',
                        'nl' => 'Lees over cookies en analyse op PkmnNexus en ontdek hoe je je privacyvoorkeuren beheert.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'login',
                'data' => [
                    'page' => 'Member Login',
                    'slug' => [
                        'en' => 'login',
                        'nl' => 'inloggen',
                    ],
                    'title' => [
                        'en' => 'Member Login | PkmnNexus',
                        'nl' => 'Inloggen als lid | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Sign in to your PkmnNexus account.',
                        'nl' => 'Log in op je PkmnNexus-account.',
                    ],
                    'meta_description' => [
                        'en' => 'Sign in to your PkmnNexus account to access your member profile and account features.',
                        'nl' => 'Log in op je PkmnNexus-account om je ledenprofiel en accountfuncties te gebruiken.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus login, member login, Pokémon community',
                        'nl' => 'PkmnNexus login, inloggen als lid, Pokémoncommunity',
                    ],
                    'og_title' => [
                        'en' => 'Member Login | PkmnNexus',
                        'nl' => 'Inloggen als lid | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Sign in to your PkmnNexus account.',
                        'nl' => 'Log in op je PkmnNexus-account.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'register',
                'data' => [
                    'page' => 'Member Registration',
                    'slug' => [
                        'en' => 'register',
                        'nl' => 'registreren',
                    ],
                    'title' => [
                        'en' => 'Create an Account | PkmnNexus',
                        'nl' => 'Account aanmaken | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Create a PkmnNexus account and join the Pokémon community.',
                        'nl' => 'Maak een PkmnNexus-account aan en word lid van de Pokémoncommunity.',
                    ],
                    'meta_description' => [
                        'en' => 'Create your PkmnNexus account and join the Pokémon community.',
                        'nl' => 'Maak je PkmnNexus-account aan en word lid van de Pokémoncommunity.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus registration, create account, Pokémon community',
                        'nl' => 'PkmnNexus registratie, account aanmaken, Pokémoncommunity',
                    ],
                    'og_title' => [
                        'en' => 'Join PkmnNexus',
                        'nl' => 'Word lid van PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Create your PkmnNexus account.',
                        'nl' => 'Maak je PkmnNexus-account aan.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'forgot-password',
                'data' => [
                    'page' => 'Forgot Password',
                    'slug' => [
                        'en' => 'forgot-password',
                        'nl' => 'wachtwoord-vergeten',
                    ],
                    'title' => [
                        'en' => 'Forgot Your Password? | PkmnNexus',
                        'nl' => 'Wachtwoord vergeten? | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Request a password reset link for your PkmnNexus account.',
                        'nl' => 'Vraag een link aan om het wachtwoord van je PkmnNexus-account opnieuw in te stellen.',
                    ],
                    'meta_description' => [
                        'en' => 'Request a password reset link for your PkmnNexus account.',
                        'nl' => 'Vraag een link aan om het wachtwoord van je PkmnNexus-account opnieuw in te stellen.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus password reset, forgotten password',
                        'nl' => 'PkmnNexus wachtwoord herstellen, wachtwoord vergeten',
                    ],
                    'og_title' => [
                        'en' => 'Forgot Your Password? | PkmnNexus',
                        'nl' => 'Wachtwoord vergeten? | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Request a password reset link for your account.',
                        'nl' => 'Vraag een link aan om het wachtwoord van je account opnieuw in te stellen.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'reset-password',
                'data' => [
                    'page' => 'Reset Password',
                    'slug' => [
                        'en' => 'reset-password',
                        'nl' => 'wachtwoord-herstellen',
                    ],
                    'title' => [
                        'en' => 'Reset Your Password | PkmnNexus',
                        'nl' => 'Wachtwoord opnieuw instellen | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Choose a new password for your PkmnNexus account.',
                        'nl' => 'Kies een nieuw wachtwoord voor je PkmnNexus-account.',
                    ],
                    'meta_description' => [
                        'en' => 'Choose a new password for your PkmnNexus account.',
                        'nl' => 'Kies een nieuw wachtwoord voor je PkmnNexus-account.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus reset password, new password',
                        'nl' => 'PkmnNexus wachtwoord herstellen, nieuw wachtwoord',
                    ],
                    'og_title' => [
                        'en' => 'Reset Your Password | PkmnNexus',
                        'nl' => 'Wachtwoord opnieuw instellen | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Set a new password for your PkmnNexus account.',
                        'nl' => 'Stel een nieuw wachtwoord in voor je account.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'verify-email',
                'data' => [
                    'page' => 'Email Verification',
                    'slug' => [
                        'en' => 'verify-email',
                        'nl' => 'email-verifieren',
                    ],
                    'title' => [
                        'en' => 'Verify Your Email Address | PkmnNexus',
                        'nl' => 'E-mailadres verifiëren | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Verify your email address to complete your PkmnNexus account setup.',
                        'nl' => 'Verifieer je e-mailadres om de configuratie van je PkmnNexus-account af te ronden.',
                    ],
                    'meta_description' => [
                        'en' => 'Verify your email address to complete your PkmnNexus account setup.',
                        'nl' => 'Verifieer je e-mailadres om de configuratie van je PkmnNexus-account af te ronden.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus email verification, verify email',
                        'nl' => 'PkmnNexus e-mailverificatie, e-mailadres verifiëren',
                    ],
                    'og_title' => [
                        'en' => 'Verify Your Email | PkmnNexus',
                        'nl' => 'E-mail verifiëren | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Complete email verification for your PkmnNexus account.',
                        'nl' => 'Rond de e-mailverificatie voor je PkmnNexus-account af.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'two-factor-challenge',
                'data' => [
                    'page' => 'Two-Factor Authentication',
                    'slug' => [
                        'en' => 'two-factor-challenge',
                        'nl' => 'tweestapsverificatie',
                    ],
                    'title' => [
                        'en' => 'Two-Factor Authentication | PkmnNexus',
                        'nl' => 'Tweestapsverificatie | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Complete two-factor authentication to securely sign in to PkmnNexus.',
                        'nl' => 'Voltooi de tweestapsverificatie om veilig in te loggen bij PkmnNexus.',
                    ],
                    'meta_description' => [
                        'en' => 'Complete two-factor authentication to securely sign in to PkmnNexus.',
                        'nl' => 'Voltooi de tweestapsverificatie om veilig in te loggen bij PkmnNexus.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus two-factor authentication, secure login',
                        'nl' => 'PkmnNexus tweestapsverificatie, veilig inloggen',
                    ],
                    'og_title' => [
                        'en' => 'Secure Sign In | PkmnNexus',
                        'nl' => 'Veilig inloggen | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Complete the additional authentication step for your account.',
                        'nl' => 'Voltooi de extra verificatiestap voor je account.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'confirm-password',
                'data' => [
                    'page' => 'Confirm Password',
                    'slug' => [
                        'en' => 'confirm-password',
                        'nl' => 'wachtwoord-bevestigen',
                    ],
                    'title' => [
                        'en' => 'Confirm Your Password | PkmnNexus',
                        'nl' => 'Bevestig je wachtwoord | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Confirm your identity before continuing with this protected action.',
                        'nl' => 'Bevestig je identiteit voordat je doorgaat met deze beveiligde actie.',
                    ],
                    'meta_description' => [
                        'en' => 'Confirm your identity before continuing with this protected action.',
                        'nl' => 'Bevestig je identiteit voordat je doorgaat met deze beveiligde actie.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus password confirmation, account security',
                        'nl' => 'PkmnNexus wachtwoord bevestigen, accountbeveiliging',
                    ],
                    'og_title' => [
                        'en' => 'Confirm Your Password | PkmnNexus',
                        'nl' => 'Bevestig je wachtwoord | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Confirm your identity to continue securely.',
                        'nl' => 'Bevestig je identiteit om veilig verder te gaan.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'passkey-login',
                'data' => [
                    'page' => 'Passkey Login',
                    'slug' => [
                        'en' => 'passkey-login',
                        'nl' => 'inloggen-met-passkey',
                    ],
                    'title' => [
                        'en' => 'Sign In with a Passkey | PkmnNexus',
                        'nl' => 'Inloggen met een passkey | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Sign in to your PkmnNexus account using a passkey.',
                        'nl' => 'Log in op je PkmnNexus-account met een passkey.',
                    ],
                    'meta_description' => [
                        'en' => 'Sign in securely to your PkmnNexus account using a passkey.',
                        'nl' => 'Log veilig in op je PkmnNexus-account met een passkey.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus passkey login, secure sign in, passkey',
                        'nl' => 'PkmnNexus passkey login, veilig inloggen, passkey',
                    ],
                    'og_title' => [
                        'en' => 'Sign In with a Passkey | PkmnNexus',
                        'nl' => 'Inloggen met een passkey | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Sign in securely to your PkmnNexus account using a passkey.',
                        'nl' => 'Log veilig in op je PkmnNexus-account.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'profile',
                'data' => [
                    'page' => 'Member Profile',
                    'slug' => [
                        'en' => 'profile',
                        'nl' => 'profiel',
                    ],
                    'title' => [
                        'en' => 'My Profile | PkmnNexus',
                        'nl' => 'Mijn profiel | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Manage your PkmnNexus member profile and account details.',
                        'nl' => 'Beheer je PkmnNexus-profiel en accountgegevens.',
                    ],
                    'meta_description' => [
                        'en' => 'Manage your PkmnNexus member profile and account details.',
                        'nl' => 'Beheer je PkmnNexus-profiel en accountgegevens.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus member profile, account settings',
                        'nl' => 'PkmnNexus ledenprofiel, accountinstellingen',
                    ],
                    'og_title' => [
                        'en' => 'My Profile | PkmnNexus',
                        'nl' => 'Mijn profiel | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Manage your PkmnNexus profile.',
                        'nl' => 'Beheer je PkmnNexus-profiel.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'edit-profile',
                'data' => [
                    'page' => 'Edit Profile',
                    'slug' => [
                        'en' => 'edit-profile',
                        'nl' => 'profiel-bewerken',
                    ],
                    'title' => [
                        'en' => 'Edit Profile | PkmnNexus',
                        'nl' => 'Profiel bewerken | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Manage your PkmnNexus member profile and account details.',
                        'nl' => 'Beheer je PkmnNexus-profiel en accountgegevens.',
                    ],
                    'meta_description' => [
                        'en' => 'Manage your PkmnNexus member profile and account details.',
                        'nl' => 'Beheer je PkmnNexus-profiel en accountgegevens.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus member profile, account settings',
                        'nl' => 'PkmnNexus ledenprofiel, accountinstellingen',
                    ],
                    'og_title' => [
                        'en' => 'Edit Profile | PkmnNexus',
                        'nl' => 'Profiel bewerken | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Manage your PkmnNexus profile.',
                        'nl' => 'Beheer je PkmnNexus-profiel.',
                    ],
                    'is_active' => true,
                ],
            ],
            [
                'key' => 'sitemap',
                'data' => [
                    'page' => 'sitemap',
                    'slug' => [
                        'en' => 'sitemap',
                        'nl' => 'sitemap',
                    ],
                    'title' => [
                        'en' => 'Sitemap | PkmnNexus',
                        'nl' => 'Sitemap | PkmnNexus',
                    ],
                    'content' => [
                        'en' => 'Manage your PkmnNexus member profile and account details.',
                        'nl' => 'Een overzicht van de pagina’s op PkmnNexus.',
                    ],
                    'meta_description' => [
                        'en' => 'Manage your PkmnNexus member profile and account details.',
                        'nl' => 'Bekijk het overzicht van pagina’s op PkmnNexus.',
                    ],
                    'meta_keywords' => [
                        'en' => 'PkmnNexus member profile, account settings',
                        'nl' => 'PkmnNexus sitemap, websiteoverzicht',
                    ],
                    'og_title' => [
                        'en' => 'Sitemap | PkmnNexus',
                        'nl' => 'Sitemap | PkmnNexus',
                    ],
                    'og_description' => [
                        'en' => 'Manage your PkmnNexus profile.',
                        'nl' => 'Een overzicht van de pagina’s op PkmnNexus.',
                    ],
                    'is_active' => true,
                ],
            ],
        ];

        foreach ($pages as $page) {
            Page::updateOrCreate(
                ['key' => $page['key']],
                $page['data'],
            );
        }
    }
}
