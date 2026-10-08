<nav aria-label="Breadcrumb"
     class="border-b border-[#F0F0F0] py-3 my-5 hidden md:block"
     itemscope
     itemtype="https://schema.org/BreadcrumbList">

    <ol class="font-display flex flex-wrap items-center gap-2 text-sm uppercase font-bold">

        <li itemprop="itemListElement"
            itemscope
            itemtype="https://schema.org/ListItem">

            <a href="{{ route('home') }}"
               itemprop="item"
               class="text-primary transition-colors hover:opacity-80">

                <span itemprop="name">Home</span>
            
            </a>

            <meta itemprop="position" content="1">

        </li>

        <li aria-hidden="true" class="text-[#F0F0F0]">/</li>

        <li itemprop="itemListElement"
            itemscope
            itemtype="https://schema.org/ListItem">

            <a href="{{ route('article.index') }}"
               itemprop="item"
               class="text-primary transition-colors hover:opacity-80">

                <span itemprop="name">Articles</span>

            </a>

            <meta itemprop="position" content="2">

        </li>

        <li aria-hidden="true" class="text-[#F0F0F0]">/</li>

        <li itemprop="itemListElement"
            itemscope
            itemtype="https://schema.org/ListItem">

            <a href="{{ route('articles.category', $article->category) }}"
               itemprop="item"
               class="text-primary transition-colors hover:opacity-80">

                <span itemprop="name">{{ $article->category->name }}</span>

            </a>

            <meta itemprop="position" content="3">

        </li>

        <li aria-hidden="true" class="text-[#F0F0F0]">/</li>

        <li itemprop="itemListElement"
            itemscope
            itemtype="https://schema.org/ListItem"
            aria-current="page">

            <span itemprop="name" class="text-secondary">{{ $article->title }}</span>

            <meta itemprop="position" content="4">

        </li>

    </ol>

</nav>