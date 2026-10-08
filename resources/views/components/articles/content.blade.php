<section itemprop="articleBody">

    <h1 itemprop="headline" class="font-display !text-primary !normal-case font-black text-3xl leading-tight tracking-tight md:text-3xl lg:text-4xl xl:text-5xl">

        {{ $article->title }}

    </h1>

    <x-articles.pub-date :article="$article" />

    <x-articles.summary :article="$article" />

    <p itemprop="description" class="mt-4 font-display text-secondary text-lg font-bold leading-snug tracking-wide md:text-2xl">

        {{ $article->excerpt }}
        
    </p>

    <div itemprop="articleBody" id="articleBody" class="prose prose-lg max-w-none mt-4">

        {!! $article->content !!}
    
    </div>

</section>