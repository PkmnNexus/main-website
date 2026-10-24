@php
    $pageSeo = \App\Models\Page::where('slug', 'profile')->where('is_active', true)->firstOrFail();
@endphp

<x-app :pageSeo="$pageSeo ?? null">

    <div class="flex flex-col xl:flex-row flex-1">

        <x-user.navigation />

        <div class="flex-1 min-w-0">

            <section class="max-w-5xl mx-auto px-6 xl:px-0 py-12">

                <div class="mb-8">

                    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">My Profile</h2>

                    <p class="mt-2 text-gray-600">Manage your account and profile information.</p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-[1fr_250px] gap-8 items-start">

                    <div class="rounded-lg border border-gray-200 bg-white p-6 space-y-6">

                        <div>

                            <h3 class="font-display text-lg font-bold text-[var(--color-secondary)]">Account Information</h3>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">Name</p>

                            <p class="font-medium">{{ auth()->user()->name }} {{ auth()->user()->surname }}</p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">Display name</p>

                            <p class="font-medium">{{ auth()->user()->display_name }}</p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">Email address</p>

                            <p class="font-medium">{{ auth()->user()->email }}</p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">Location</p>

                            <p class="font-medium">{{ auth()->user()->location ?: 'No location set.'}}</p>

                        </div>

                        <div>

                            <p class="text-sm text-gray-500">Bio</p>

                            <p class="font-medium whitespace-pre-line">{{ auth()->user()->bio ?: 'No bio added yet.' }}</p>

                        </div>

                    </div>

                    <div class="space-y-8">

                        <div class="flex justify-center md:justify-end">

                            <div class="w-[250px] h-[250px] rounded-md border border-[var(--color-primary)] p-2">

                                <img
                                    src="{{ auth()->user()->getFirstMediaUrl('user_avatar') ?: asset('images/default_avatar.png') }}"
                                    alt="{{ auth()->user()->display_name }}'s profile picture"
                                    width="250"
                                    height="250"
                                    class="w-full h-full object-cover rounded-sm"
                                >

                            </div>

                        </div>

                        <div class="rounded-lg border border-gray-200 bg-white p-6 space-y-6">

                            <div>

                                <h3 class="font-display text-lg font-bold text-[var(--color-secondary)]">Website</h3>

                            </div>

                            <div>

                                @if (auth()->user()->website)

                                    <a href="{{ auth()->user()->website }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       class="text-[var(--color-primary)] hover:underline break-words">

                                        {{ auth()->user()->formatted_website }}

                                    </a>

                                @else

                                    <p class="text-sm text-gray-500">There is no website.</p>

                                @endif

                            </div>

                            <div class="border-t border-gray-200 pt-6">

                                <h3 class="font-display text-lg font-bold text-[var(--color-secondary)]">Social media</h3>

                            </div>

                            <div class="space-y-4">

                                <x-user.social-links :links="auth()->user()->social_links" />

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </div>

</x-app>