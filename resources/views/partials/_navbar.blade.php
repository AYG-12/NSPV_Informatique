<nav>
    <div class="logo">
        <a href="{{ url('/') }}">
            <img src="/images/logo.jpeg" alt="Logo NSPV Informatique">
            <span><span>NSPV</span> <span>Informatique</span></span>
        </a>
    </div>

    <button class="nav-toggle" id="nav-toggle" aria-label="Menu">
        <span></span><span></span><span></span>
    </button>

    <div class="menu" id="nav-menu">
        <ul class="flex space-x-8 items-center">
            <li><a href="{{ url('/') }}">Accueil</a></li>
            <li><a href="{{ url('/contact') }}">Contacts</a></li>
            <li><a href="{{ url('/Shop') }}">Boutique</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="{{ url('/Apropos') }}">Apropos</a></li>
            <li><a href="{{ url('/connexion') }}">Inscription/Connexion</a></li>
        </ul>
    </div>
</nav>
<script>
    document.getElementById('nav-toggle').addEventListener('click', function () {
        this.classList.toggle('open');
        document.getElementById('nav-menu').classList.toggle('open');
    });
</script>