@include('partials._header')
    <!-- Appel de la barre de navigation -->
     @include('partials._navbar')

    <!-- Appel du banner -->
    @include('partials._banner')

    <!-- Appel de la barre de recherche  -->
     @include('partials._search')
    <!-- Appel du contenu principal -->
    @yield('content')
@include('partials._footer')