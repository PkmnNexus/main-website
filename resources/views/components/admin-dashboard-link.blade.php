@auth

    @if(auth()->user()->canAccessPanel(\Filament\Facades\Filament::getPanel('admin')))

        <div class="hidden xl:block bg-gradient">

            <div class="mx-auto max-w-lg px-6 py-3 md:max-w-3xl lg:max-w-4xl xl:max-w-6xl xl:px-0">

                <div class="flex items-center justify-between gap-4 text-sm font-semibold text-gray-900 xl:text-white">

                    <span class="font-black">{{ __('general.welcome') }} {{ auth()->user()->name }} {{ auth()->user()->surname }}</span>

                    <a href="{{ url('/admin') }}" class="inline-flex shrink-0 items-center gap-2 hover:underline font-black">

                        {{ __('general.go_to_admin') }}
                        <x-heroicon-o-arrow-right class="h-4 w-4" />

                    </a>

                </div>

            </div>

        </div>

    @endif

@endauth