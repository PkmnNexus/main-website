<?php

use App\Models\Trivia;
use Livewire\Component;

new class extends Component
{
    public ?Trivia $trivia = null;

    public function mount(): void
    {
        $this->trivia = Trivia::query()
            ->active()
            ->with('heroImage')
            ->orderBy('sort_order')
            ->first();
    }
};
?>

@if ($trivia)

    <article class="trivia group h-full bg-[#FAFAFA] rounded-lg overflow-hidden shadow-lg transition duration-300 hover:shadow-xl">

        @if ($trivia->heroImage?->getFirstMediaUrl('asset'))

            <figure class="relative overflow-hidden leading-none h-full min-h-[320px]">

                <img src="{{ $trivia->heroImage->getFirstMediaUrl('asset') }}"
                     alt=""
                     class="w-full h-full min-h-[320px] object-cover block group-hover:scale-105 transition duration-300"
                     loading="lazy">

                <div class="absolute inset-0 bg-gradient-to-t from-[var(--color-primary)]/90 via-[var(--color-primary)]/40 to-transparent"></div>

                <figcaption class="absolute bottom-0 right-0 left-0 p-6 text-white z-10">

                    <div class="flex items-center gap-2 mb-3 text-xs uppercase font-display font-black tracking-wider text-white">

                        <span class="w-2 h-2 rounded-full bg-white"></span>

                        {{ __('general.trivia') }}

                    </div>

                    <p class="text-2xl md:text-4xl leading-ease font-light font-display !font-black !text-white">
                        {{ $trivia->fact }}
                    </p>

                </figcaption>

            </figure>

        @else

            <div class="p-6 flex flex-col gap-3">

                <div class="flex items-center gap-2 text-xs uppercase font-display font-black tracking-wider text-[var(--color-primary)]">

                    <span class="w-2 h-2 rounded-full bg-[var(--color-primary)]"></span>

                    {{ __('general.trivia') }}

                </div>

                <p class="text-2xl font-light text-[var(--color-secondary)] leading-relaxed">
                    {{ $trivia->fact }}
                </p>

            </div>

        @endif

    </article>

@endif