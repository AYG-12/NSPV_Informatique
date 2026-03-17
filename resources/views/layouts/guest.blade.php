@include('Shop.partials._header')
    <!-- Appel du contenu principal -->
    @yield('content')
@if (Request::is('connexion'))
@else
    @include('Shop.partials._footer')
@endif