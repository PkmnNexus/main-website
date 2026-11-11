<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section class="w-full max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 py-12 grid grid-cols-1 md:grid-cols-12 gap-4 items-stretch">

    <div class="w-full min-w-0 md:col-span-6 lg:col-span-5">
        <livewire:polls.show />
    </div>

    <div class="w-full min-w-0 md:col-span-6 lg:col-span-7">
        <livewire:pages.home.trivia />
    </div>

</section>