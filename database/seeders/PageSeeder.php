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
                    'title' => 'PkmnNexus - Pokémon News & Guides',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                    'meta_description' => 'Get the latest Pokémon news, game updates, Pokémon GO coverage, and helpful guides for fans across the Pokémon universe.',
                    'meta_keywords' => 'pokemon news, pokemon guides, pokemon game updates, pokemon go news, pokemon universe',
                    'og_title' => 'Pokémon News & Guides | PkmnNexus',
                    'og_description' => 'Stay up to date with Pokémon news, game updates, Pokémon GO coverage, and helpful guides for fans.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'articles',
                'data' => [
                    'page' => 'Articles',
                    'title' => 'Pokémon Articles and Guides',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                    'meta_description' => 'Explore Pokémon news, in-depth articles, game guides, updates, and analysis from across the Pokémon universe.',
                    'meta_keywords' => 'pokemon articles, pokemon news, pokemon guides, pokemon game updates, pokemon analysis',
                    'og_title' => 'Pokémon Articles and Guides',
                    'og_description' => 'Explore Pokémon news, in-depth articles, game guides, updates, and analysis from across the Pokémon universe.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'tag',
                'data' => [
                    'page' => 'Tag',
                    'title' => 'Pokémon Articles and Guides',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                    'meta_description' => 'Browse Pokémon articles, news, and guides covering games, updates, events, and other topics across the Pokémon universe.',
                    'meta_keywords' => 'pokemon articles, pokemon news, pokemon guides, pokemon topics',
                    'og_title' => 'Pokémon Articles and Guides',
                    'og_description' => 'Browse Pokémon articles, news, and guides covering games, updates, and events.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'category',
                'data' => [
                    'page' => 'Category',
                    'title' => 'Pokémon Articles and Guides',
                    'content' => 'Discover the latest Pokémon news, competitive guides, and in-depth articles on PkmnNexus.',
                    'meta_description' => 'Discover Pokémon articles, news, and guides in this category, including relevant game updates, tips, and developments.',
                    'meta_keywords' => 'pokemon articles, pokemon category, pokemon news, pokemon guides',
                    'og_title' => 'Pokémon Articles and Guides',
                    'og_description' => 'Discover Pokémon articles, news, and guides in this category.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'about',
                'data' => [
                    'page' => 'About',
                    'title' => 'About PkmnNexus',
                    'content' => '
                        <h2>About PkmnNexus</h2>
                        <p>Welcome to PkmnNexus, an independent website dedicated to Pokémon news, updates, guides, and everything happening across the Pokémon universe.</p>
                        <p>From the latest announcements and game updates to helpful guides and interesting discoveries, PkmnNexus aims to bring Pokémon fans together around the games, news, and experiences they love.</p>
                        <p>Whether you\'re a longtime Pokémon fan or just starting your journey, our goal is to provide a place where you can discover what\'s new, learn something useful, and stay connected with the ever-evolving world of Pokémon.</p>
                        <h2>Our Mission</h2>
                        <p>Our mission is simple: to make Pokémon news and information accessible, engaging, and easy to explore.</p>
                        <p>The Pokémon universe continues to grow through new games, updates, events, and experiences. Keeping up with everything can be challenging, so PkmnNexus aims to bring relevant information together in one place.</p>
                        <p>We want to help readers stay informed, discover useful information, and enjoy their interest in Pokémon even more.</p>
                        <h2>What You\'ll Find on PkmnNexus</h2>
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
                        <p>At PkmnNexus, we aim to follow these developments and share the information that matters to our readers. Whether you\'re looking for the latest news, useful tips, or something new to discover, we hope you\'ll find something worth exploring here.</p>
                        <p>Thank you for visiting PkmnNexus and being part of our journey.</p>
                        <h2>Get in Touch</h2>
                        <p>Have a question, suggestion, correction, or other feedback? We\'d love to hear from you.</p>
                        <p>Please visit our <a href="/contact">Contact page</a> to get in touch. We appreciate hearing from our readers and welcome feedback that helps us make PkmnNexus better.</p>
                    ',
                    'meta_description' => 'Learn about PkmnNexus, an independent Pokémon website covering news, game updates, guides, and discoveries from across the Pokémon universe.',
                    'meta_keywords' => 'about PkmnNexus, independent pokemon website, pokemon news, pokemon guides, pokemon game updates',
                    'og_title' => 'About PkmnNexus',
                    'og_description' => 'Learn about our mission to bring Pokémon news, game updates, guides, and discoveries together in one place.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'privacy-policy',
                'data' => [
                    'page' => 'Privacy Policy',
                    'title' => 'Privacy Policy',
                    'content' => '
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
                        <h2>14. Children\'s Privacy</h2>
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
                    ',
                    'meta_description' => 'Learn how PkmnNexus collects, uses, stores, and protects personal data, and how you can exercise your privacy rights under applicable law.',
                    'meta_keywords' => 'privacy policy, personal data, data protection, GDPR, privacy rights, PkmnNexus',
                    'og_title' => 'Privacy Policy',
                    'og_description' => 'Find out how PkmnNexus handles personal data and explains your privacy rights and choices.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'disclaimer',
                'data' => [
                    'page' => 'Disclaimer',
                    'title' => 'Disclaimer',
                    'content' => '
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
                    ',
                    'meta_description' => 'Read the PkmnNexus disclaimer covering content accuracy, independent Pokémon coverage, third-party links, intellectual property, and liability.',
                    'meta_keywords' => 'disclaimer, website disclaimer, pokemon information, independent pokemon website, intellectual property',
                    'og_title' => 'Disclaimer',
                    'og_description' => 'Learn about the scope and limitations of information published on PkmnNexus.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'terms-and-conditions',
                'data' => [
                    'page' => 'Terms and Conditions',
                    'title' => 'Terms and Conditions',
                    'content' => '
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
                        <p>We do not control third-party websites and are not responsible for their content, accuracy, availability, privacy practices, security, or terms of use. Visiting a third-party website is at your own discretion and is subject to that website\'s own terms and policies.</p>
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
                    ',
                    'meta_description' => 'Read the terms governing your use of PkmnNexus, including website rules, intellectual property, external links, and applicable law.',
                    'meta_keywords' => 'terms and conditions, website terms, terms of use, intellectual property, PkmnNexus',
                    'og_title' => 'Terms and Conditions',
                    'og_description' => 'Review the rules and conditions that apply when using the PkmnNexus website.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'cookie-policy',
                'data' => [
                    'page' => 'Cookie Policy',
                    'title' => 'Cookie Policy',
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
                        <p>Depending on the configuration, Google Analytics may use cookies such as <code>\_ga</code> and <code>\_ga\_*</code> to distinguish browsers and maintain analytics session information. Analytics data may include page information, interactions, browser and device information, approximate location information, and online identifiers.</p>
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
                        <p>For more information, please consult the <a href="https://policies.google.com/privacy" target="\_blank" rel="noopener noreferrer">Google Privacy Policy</a> and the <a href="https://support.google.com/analytics/answer/6004245" target="\_blank" rel="noopener noreferrer">Google Analytics privacy information</a>.</p>
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
                    'meta_description' => 'Learn how PkmnNexus uses essential technologies and optional Google Analytics cookies, and how to manage or withdraw your consent.',
                    'meta_keywords' => 'cookie policy, cookies, Google Analytics 4, Google Tag Manager, cookie consent, privacy preferences',
                    'og_title' => 'Cookie Policy',
                    'og_description' => 'Learn about cookies and analytics on PkmnNexus and how to manage your privacy preferences.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'login',
                'data' => [
                    'page' => 'Member Login',
                    'title' => 'Member Login | PkmnNexus',
                    'content' => 'Sign in to your PkmnNexus account.',
                    'meta_description' => 'Sign in to your PkmnNexus account to access your member profile and account features.',
                    'meta_keywords' => 'PkmnNexus login, member login, Pokémon community',
                    'og_title' => 'Member Login | PkmnNexus',
                    'og_description' => 'Sign in to your PkmnNexus account.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'register',
                'data' => [
                    'page' => 'Member Registration',
                    'title' => 'Create an Account | PkmnNexus',
                    'content' => 'Create a PkmnNexus account and join the Pokémon community.',
                    'meta_description' => 'Create your PkmnNexus account and join the Pokémon community.',
                    'meta_keywords' => 'PkmnNexus registration, create account, Pokémon community',
                    'og_title' => 'Join PkmnNexus',
                    'og_description' => 'Create your PkmnNexus account.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'forgot-password',
                'data' => [
                    'page' => 'Forgot Password',
                    'title' => 'Forgot Your Password? | PkmnNexus',
                    'content' => 'Request a password reset link for your PkmnNexus account.',
                    'meta_description' => 'Request a password reset link for your PkmnNexus account.',
                    'meta_keywords' => 'PkmnNexus password reset, forgotten password',
                    'og_title' => 'Forgot Your Password? | PkmnNexus',
                    'og_description' => 'Request a password reset link for your account.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'reset-password',
                'data' => [
                    'page' => 'Reset Password',
                    'title' => 'Reset Your Password | PkmnNexus',
                    'content' => 'Choose a new password for your PkmnNexus account.',
                    'meta_description' => 'Choose a new password for your PkmnNexus account.',
                    'meta_keywords' => 'PkmnNexus reset password, new password',
                    'og_title' => 'Reset Your Password | PkmnNexus',
                    'og_description' => 'Set a new password for your PkmnNexus account.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'verify-email',
                'data' => [
                    'page' => 'Email Verification',
                    'title' => 'Verify Your Email Address | PkmnNexus',
                    'content' => 'Verify your email address to complete your PkmnNexus account setup.',
                    'meta_description' => 'Verify your email address to complete your PkmnNexus account setup.',
                    'meta_keywords' => 'PkmnNexus email verification, verify email',
                    'og_title' => 'Verify Your Email | PkmnNexus',
                    'og_description' => 'Complete email verification for your PkmnNexus account.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'two-factor-challenge',
                'data' => [
                    'page' => 'Two-Factor Authentication',
                    'title' => 'Two-Factor Authentication | PkmnNexus',
                    'content' => 'Complete two-factor authentication to securely sign in to PkmnNexus.',
                    'meta_description' => 'Complete two-factor authentication to securely sign in to PkmnNexus.',
                    'meta_keywords' => 'PkmnNexus two-factor authentication, secure login',
                    'og_title' => 'Secure Sign In | PkmnNexus',
                    'og_description' => 'Complete the additional authentication step for your account.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'confirm-password',
                'data' => [
                    'page' => 'Confirm Password',
                    'title' => 'Confirm Your Password | PkmnNexus',
                    'content' => 'Confirm your identity before continuing with this protected action.',
                    'meta_description' => 'Confirm your identity before continuing with this protected action.',
                    'meta_keywords' => 'PkmnNexus password confirmation, account security',
                    'og_title' => 'Confirm Your Password | PkmnNexus',
                    'og_description' => 'Confirm your identity to continue securely.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'passkey-login',
                'data' => [
                    'page' => 'Passkey Login',
                    'title' => 'Sign In with a Passkey | PkmnNexus',
                    'content' => 'Sign in to your PkmnNexus account using a passkey.',
                    'meta_description' => 'Sign in securely to your PkmnNexus account using a passkey.',
                    'meta_keywords' => 'PkmnNexus passkey login, secure sign in, passkey',
                    'og_title' => 'Sign In with a Passkey | PkmnNexus',
                    'og_description' => 'Sign in securely to your PkmnNexus account using a passkey.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'profile',
                'data' => [
                    'page' => 'Member Profile',
                    'title' => 'My Profile | PkmnNexus',
                    'content' => 'Manage your PkmnNexus member profile and account details.',
                    'meta_description' => 'Manage your PkmnNexus member profile and account details.',
                    'meta_keywords' => 'PkmnNexus member profile, account settings',
                    'og_title' => 'My Profile | PkmnNexus',
                    'og_description' => 'Manage your PkmnNexus profile.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'edit-profile',
                'data' => [
                    'page' => 'Edit Profile',
                    'title' => 'Edit Profile | PkmnNexus',
                    'content' => 'Manage your PkmnNexus member profile and account details.',
                    'meta_description' => 'Manage your PkmnNexus member profile and account details.',
                    'meta_keywords' => 'PkmnNexus member profile, account settings',
                    'og_title' => 'Edit Profile | PkmnNexus',
                    'og_description' => 'Manage your PkmnNexus profile.',
                    'is_active' => true,
                ],
            ],
            [
                'slug' => 'sitemap',
                'data' => [
                    'page' => 'sitemap',
                    'title' => 'Sitemap | PkmnNexus',
                    'content' => 'Manage your PkmnNexus member profile and account details.',
                    'meta_description' => 'Manage your PkmnNexus member profile and account details.',
                    'meta_keywords' => 'PkmnNexus member profile, account settings',
                    'og_title' => 'Sitemap | PkmnNexus',
                    'og_description' => 'Manage your PkmnNexus profile.',
                    'is_active' => true,
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