<nav aria-label="{{ __('general.account_general') }}" class="w-full bg-white border-b border-gray-200 shadow-md xl:flex xl:w-[250px] xl:shrink-0 xl:border-b-0 xl:border-r xl:shadow-none">

    <ul class="flex flex-col items-stretch gap-1 w-full p-4 font-display font-bold text-sm">

        <li>

            <a href="{{ route('account.profile') }}"
               @class([
                   'flex items-center w-full rounded-sm px-4 py-2 transition-colors duration-200',
                   'bg-gradient text-white' => request()->routeIs('account.profile'),
                   'text-[var(--color-secondary)] hover:text-[var(--color-primary)]' => ! request()->routeIs('account.profile'),
               ])>

                {{ __('general.profile') }}

            </a>

        </li>

        <li>

            <a href="{{ route('account.profile.edit') }}"
               @class([
                   'flex items-center w-full rounded-sm px-4 py-2 transition-colors duration-200',
                   'bg-gradient text-white' => request()->routeIs('account.profile.edit'),
                   'text-[var(--color-secondary)] hover:text-[var(--color-primary)]' => ! request()->routeIs('account.profile.edit'),
               ])>

                {{ __('general.edit_profile') }}

            </a>

        </li>

        <li>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="flex items-center w-full cursor-pointer rounded-sm px-4 py-2 text-[var(--color-secondary)] hover:text-[var(--color-primary)] transition-colors duration-200">
                    {{ __('general.log_out') }}
                </button>

            </form>

        </li>

        <li class="border-t border-gray-200 w-full my-2"></li>

        <li>

            <a href="{{ route('home') }}" class="flex items-center w-full rounded-sm px-4 py-2 text-[var(--color-secondary)] hover:text-[var(--color-primary)] transition-colors duration-200">{{ __('general.back_to_website') }}</a>

        </li>

    </ul>

</nav>