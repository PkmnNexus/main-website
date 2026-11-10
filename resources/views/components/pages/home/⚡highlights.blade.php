
<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<section class="max-w-lg md:max-w-3xl lg:max-w-4xl xl:max-w-6xl mx-auto px-6 xl:px-0 py-12 grid grid-cols-1 md:grid-cols-12 gap-4 items-stretch">

    <div class="md:col-span-5">
        <livewire:polls.show />
    </div>

    <div class="md:col-span-7">
        <livewire:pages.home.trivia />
    </div>

</section>