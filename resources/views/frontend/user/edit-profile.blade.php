@php
    $pageSeo = \App\Models\Page::where('slug', 'edit-profile')->where('is_active', true)->firstOrFail();
@endphp

<x-app :pageSeo="$pageSeo ?? null">

    <div class="flex flex-col xl:flex-row flex-1">

        <x-user.navigation />

        <div class="flex-1 min-w-0 p-6">

            <section class="max-w-5xl mx-auto py-12">

                <h2 class="font-display font-bold text-2xl mb-8">
                    Edit profile
                </h2>

                <livewire:user.edit-profile />

            </section>

        </div>

    </div>

</x-app>