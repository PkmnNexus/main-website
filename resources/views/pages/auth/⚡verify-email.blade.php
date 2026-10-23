<?php

use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

new class extends Component {
    public function resendVerificationEmail(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirect(route('account.profile'), navigate: false);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        session()->flash('status', 'verification-link-sent');
    }
};

?>

<div class="mx-auto max-w-md px-6 py-12">

    <h2 class="font-display text-3xl font-black text-[var(--color-secondary)]">Verify Your Email Address</h2>

    <p class="mt-2 text-sm text-gray-600">Before continuing, please verify your email address using the link we sent you.</p>

    @if (session('status') === 'verification-link-sent')

        <div class="mt-4 rounded-sm bg-[var(--color-primary)] p-3 text-sm font-display font-bold text-white shadow-md"">A new verification link has been sent to your email address.</div>

    @endif

    <div class="mt-6 space-y-5">

        <p class="text-sm text-gray-600">If you did not receive the email, you can request another verification link.</p>

        <button type="button"
                wire:click="resendVerificationEmail"
                wire:loading.attr="disabled"
                class="w-full rounded-sm bg-gradient px-4 py-3 font-bold text-white transition-opacity hover:opacity-90 disabled:opacity-50">

            <span wire:loading.remove wire:target="resendVerificationEmail">Resend Verification Email</span>

            <span wire:loading wire:target="resendVerificationEmail">Sending...</span>

        </button>

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="w-full rounded-sm border border-gray-300 px-4 py-3 font-bold text-gray-700 transition-colors hover:bg-gray-50">

                Sign Out

            </button>

        </form>

    </div>

</div>