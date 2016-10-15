@section('menu-items')
    {{--

        This section contains all of the menu items
        We're using partial views so we can focus on
        the structure on the menu

    --}}
    <ul class="navigation-list clearfix" id="main-menu">
        @include('layout._navigation-top-menu-item', [
            'url' => '/about',
            'title' => 'About',
            'subItems' => [
                ['url' => "/about/history", 'title' => 'History'],
                ['url' => "/about/honorary-members", 'title' => 'Honerary members'],
                ['url' => "/about/boards", 'title' => 'Boards'],
                ['url' => "/about/committees", 'title' => 'Committees'],
                ['url' => "/about/francken-vrij", 'title' => 'Francken Vrij']
            ]
        ])
        @include('layout._navigation-top-menu-item', [
            'url' => '/news',
            'title' => 'News',
            'subItems' => [
                ['url' => "/post", 'title' => 'All'],
                ['url' => "/news", 'title' => 'News'],
                ['url' => "/blog", 'title' => 'Blog']
            ]
        ])
        @include('layout._navigation-top-menu-item', ['url' => '/study', 'title' => 'Study'])
        @include('layout._navigation-top-menu-item', [
            'url' => '/career',
            'title' => 'Career',
            'subItems' => [
                ['url' => "/career/job-openings", 'title' => 'Job openings'],
                ['url' => "/career/companies", 'title' => 'Company profiles'],
                ['url' => "/career/excursions", 'title' => 'Excursions']
            ]
        ])
        @include('layout._navigation-top-menu-item', ['url' => '/books', 'title' => 'Books'])
        @include('layout._navigation-top-menu-item', ['url' => 'https://www.flickr.com/photos/fotocie/sets/', 'title' => 'Photos'])
        @include('layout._navigation-top-menu-item', ['url' => '/contact', 'title' => 'Contact'])
    </ul>
@endsection

@section('hamburger-menu')
    {{-- This section adds the Hamburger menu --}}
    <div class="navigation__mobile-menu">
        <button id="navbar-toggler" class="hamburger-menu">
            <span class="hamburger-menu__line"></span>
            <span class="hamburger-menu__line"></span>
            <span class="hamburger-menu__line"></span>
        </button>
    </div>
@endsection

<header class="francken-header">
    {{-- Change to : francken-header-container --}}
    <nav class="clearfix container">
        @yield('hamburger-menu')

        <h1 class="navigation__logo">
            <a class="navigation__logo-link" href="/">
                <span>T.F.V. 'Professor Francken'</span>
            </a>
        </h1>

        @yield('menu-items')
    </nav>

    <ul class="navigation-desktop">
        <div class="container">
            @stack('sub-navigation')
        </div>
    </ul>
</header>