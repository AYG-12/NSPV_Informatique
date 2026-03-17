@php $title = 'Connexion'; @endphp

@extends('layouts.guest')

@section('content')

<div class="page">

    <!-- ══════════════════════════════════════
         PANNEAU GAUCHE
    ══════════════════════════════════════ -->
    <aside class="left">
        <div class="brand">
            <img src="/images/logo.jpeg" alt="Logo NSPV" class="brand-logo">
            <span class="brand-name"><em>NSPV</em> Informatique</span>
        </div>

        <div class="left-card">
            <h1>La <br><em>Technologie</em><br> près de chez vous !</h1>
            <p>Matériel informatique, accessoires et solutions professionnelles sélectionnés pour vous, livrés rapidement.</p>

            <div class="features">
                <div class="feat">
                    <span class="feat-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
                    </span>
                    Livraison rapide et sécurisée
                </div>
                <!-- <div class="feat">
                    <span class="feat-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
                    </span>
                    Garantie constructeur sur tous les produits
                </div> -->
                <!-- <div class="feat">
                    <span class="feat-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
                    </span>
                    Support technique dédié 7j/7
                </div> -->
                <div class="feat">
                    <span class="feat-icon">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><path d="M5 12l5 5L20 7"/></svg>
                    </span>
                    Paiement 100 % sécurisé
                </div>
            </div>
        </div>

        <!-- <div class="stats">
            <div class="stat"><strong>2 400+</strong><span>Produits</span></div>
            <div class="stat"><strong>12 k</strong><span>Clients</span></div>
            <div class="stat"><strong>4.9 ★</strong><span>Note moy.</span></div>
        </div> -->
    </aside>

    <!-- ══════════════════════════════════════
         PANNEAU DROIT
    ══════════════════════════════════════ -->
    <main class="right">

        <div class="return">
            <a href="{{ url()->previous() }}" class="return-link">
                <svg width="34" height="34" fill="none" stroke="currentColor" stroke-width="2.2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            </a>
        </div>

        <div class="auth-box">

            <!-- ONGLETS -->
            <div class="tabs">
                <button class="tab-btn active" data-tab="login">Connexion</button>
                <button class="tab-btn"        data-tab="register">Inscription</button>
            </div>

            <!-- ════════ CONNEXION ════════ -->
            <div class="form-panel active" id="panel-login">
                <h2 class="form-title">Bon retour 👋</h2>
                <p class="form-sub">Connectez-vous à votre compte NSPV.</p>

                <div class="alert" id="alert-login"></div>

                <form id="form-login" action="{{ url('/connexion') }}" method="POST" novalidate>
                    @csrf

                    <div class="field">
                        <label for="l-email">Adresse e-mail</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                            </span>
                            <input type="email" id="l-email" name="email"
                                   placeholder="vous@exemple.com"
                                   value="{{ old('email') }}" autocomplete="email">
                        </div>
                        <span class="field-error" id="err-l-email">Adresse e-mail invalide.</span>
                    </div>

                    <div class="field">
                        <label for="l-pass">Mot de passe</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                            </span>
                            <input type="password" id="l-pass" name="password"
                                   placeholder="••••••••" autocomplete="current-password">
                            <button type="button" class="eye-btn" data-t="l-pass" aria-label="Afficher">
                                <svg class="ico-open"   width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg class="ico-closed" style="display:none" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                            </button>
                        </div>
                        <span class="field-error" id="err-l-pass">Le mot de passe est requis.</span>
                    </div>

                    <div class="options">
                        <label class="check-label">
                            <input type="checkbox" name="remember"> Se souvenir de moi
                        </label>
                        <a href="{{ url('/mot-de-passe-oublie') }}" class="forgot">Mot de passe oublié ?</a>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-login">
                        <span class="btn-text">Se connecter</span>
                        <span class="btn-loader"></span>
                    </button>
                </form>

                <div class="divider">ou continuer avec</div>

                <button class="btn-social" onclick="alert('Google OAuth non configuré.')">
                    <svg width="17" height="17" viewBox="0 0 48 48">
                        <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                        <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                        <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                        <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.18 1.48-4.97 2.31-8.16 2.31-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    </svg>
                    Continuer avec Google
                </button>
            </div>

            <!-- ════════ INSCRIPTION ════════ -->
            <div class="form-panel" id="panel-register">
                <h2 class="form-title">Créer un compte</h2>
                <p class="form-sub">Rejoignez la communauté NSPV Informatique.</p>

                <div class="alert" id="alert-register"></div>

                <form id="form-register" action="{{ url('/inscription') }}" method="POST" novalidate>
                    @csrf

                    <!-- Prénom / Nom côte à côte -->
                    <div class="row-2">
                        <div class="field">
                            <label for="r-fname">Prénom</label>
                            <div class="field-wrap">
                                <span class="field-icon">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </span>
                                <input type="text" id="r-fname" name="firstname"
                                       placeholder="Jean" value="{{ old('firstname') }}" autocomplete="given-name">
                            </div>
                            <span class="field-error" id="err-r-fname">Prénom requis.</span>
                        </div>

                        <div class="field">
                            <label for="r-lname">Nom</label>
                            <div class="field-wrap">
                                <span class="field-icon">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                </span>
                                <input type="text" id="r-lname" name="lastname"
                                       placeholder="Dupont" value="{{ old('lastname') }}" autocomplete="family-name">
                            </div>
                            <span class="field-error" id="err-r-lname">Nom requis.</span>
                        </div>
                    </div>

                    <!-- E-mail -->
                    <div class="field">
                        <label for="r-email">Adresse e-mail</label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg>
                            </span>
                            <input type="email" id="r-email" name="email"
                                   placeholder="vous@exemple.com" value="{{ old('email') }}" autocomplete="email">
                        </div>
                        <span class="field-error" id="err-r-email">E-mail invalide.</span>
                    </div>

                    <!-- Téléphone -->
                    <div class="field">
                        <label for="r-phone">
                            Téléphone
                            <span style="color:var(--muted);font-weight:300;text-transform:none;letter-spacing:0">(optionnel)</span>
                        </label>
                        <div class="field-wrap">
                            <span class="field-icon">
                                <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 8.91a16 16 0 0 0 6 6l.81-.81a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </span>
                            <input type="tel" id="r-phone" name="phone"
                                   placeholder="+225 07 00 00 00 00" value="{{ old('phone') }}" autocomplete="tel">
                        </div>
                    </div>

                    <!-- Mot de passe + Confirmation côte à côte -->
                    <div class="row-2">
                        <div class="field">
                            <label for="r-pass">Mot de passe</label>
                            <div class="field-wrap">
                                <span class="field-icon">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                                <input type="password" id="r-pass" name="password"
                                       placeholder="••••••••" autocomplete="new-password">
                                <button type="button" class="eye-btn" data-t="r-pass" aria-label="Afficher">
                                    <svg class="ico-open"   width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg class="ico-closed" style="display:none" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                </button>
                            </div>
                            <div class="strength-bar">
                                <span id="s1"></span><span id="s2"></span>
                                <span id="s3"></span><span id="s4"></span>
                            </div>
                            <p class="strength-label" id="slabel">Entrez un mot de passe</p>
                            <span class="field-error" id="err-r-pass">8 caractères minimum.</span>
                        </div>

                        <div class="field">
                            <label for="r-confirm">Confirmation</label>
                            <div class="field-wrap">
                                <span class="field-icon">
                                    <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                </span>
                                <input type="password" id="r-confirm" name="password_confirmation"
                                       placeholder="••••••••" autocomplete="new-password">
                                <button type="button" class="eye-btn" data-t="r-confirm" aria-label="Afficher">
                                    <svg class="ico-open"   width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    <svg class="ico-closed" style="display:none" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                </button>
                            </div>
                            <span class="field-error" id="err-r-confirm">Les mots de passe ne correspondent pas.</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-register">
                        <span class="btn-text">Créer mon compte</span>
                        <span class="btn-loader"></span>
                    </button>

                    <p class="terms">
                        En créant un compte, vous acceptez nos
                        <a href="{{ url('/conditions') }}">Conditions d'utilisation</a>
                        et notre <a href="{{ url('/confidentialite') }}">Politique de confidentialité</a>.
                    </p>
                </form>
            </div>

        </div>
    </main>

</div>

<script>
    /* ── ONGLETS ── */
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.form-panel').forEach(p => p.classList.remove('active'));
            btn.classList.add('active');
            document.getElementById('panel-' + btn.dataset.tab).classList.add('active');
        });
    });

    /* ── AFFICHER/MASQUER MOT DE PASSE ── */
    document.querySelectorAll('.eye-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const inp    = document.getElementById(btn.dataset.t);
            const hidden = inp.type === 'password';
            inp.type = hidden ? 'text' : 'password';
            btn.querySelector('.ico-open').style.display   = hidden ? 'none'   : 'inline';
            btn.querySelector('.ico-closed').style.display = hidden ? 'inline' : 'none';
        });
    });

    /* ── FORCE DU MOT DE PASSE ── */
    document.getElementById('r-pass').addEventListener('input', function () {
        const v      = this.value;
        const bars   = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
        const label  = document.getElementById('slabel');
        const cols   = ['#e83535','#f97316','#eab308','#16a34a'];
        const labels = ['Très faible','Faible','Moyen','Fort'];

        let score = 0;
        if (v.length >= 8)           score++;
        if (/[A-Z]/.test(v))         score++;
        if (/[0-9]/.test(v))         score++;
        if (/[^A-Za-z0-9]/.test(v))  score++;

        bars.forEach((b, i) => {
            b.style.background = i < score ? cols[score - 1] : 'var(--border)';
        });
        label.textContent = v.length === 0 ? 'Entrez un mot de passe' : (labels[score - 1] || 'Très faible');
        label.style.color = v.length === 0 ? 'var(--muted)' : (cols[score - 1] || cols[0]);
    });

    /* ── HELPERS VALIDATION ── */
    const showErr   = (id, v) => { const el = document.getElementById(id); if(el) el.style.display = v ? 'block' : 'none'; };
    const markInput = (id, v) => { const el = document.getElementById(id); if(el) el.classList.toggle('error', v); };

    /* ── FORM CONNEXION ── */
    document.getElementById('form-login').addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;

        const email   = document.getElementById('l-email').value.trim();
        const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        showErr('err-l-email', !emailOk); markInput('l-email', !emailOk);
        if (!emailOk) ok = false;

        const pass   = document.getElementById('l-pass').value;
        const passOk = pass.length >= 1;
        showErr('err-l-pass', !passOk); markInput('l-pass', !passOk);
        if (!passOk) ok = false;

        if (!ok) return;
        document.getElementById('btn-login').classList.add('loading');
        setTimeout(() => this.submit(), 300);
    });

    /* ── FORM INSCRIPTION ── */
    document.getElementById('form-register').addEventListener('submit', function (e) {
        e.preventDefault();
        let ok = true;

        const fn = document.getElementById('r-fname').value.trim();
        showErr('err-r-fname', !fn); markInput('r-fname', !fn);
        if (!fn) ok = false;

        const ln = document.getElementById('r-lname').value.trim();
        showErr('err-r-lname', !ln); markInput('r-lname', !ln);
        if (!ln) ok = false;

        const email   = document.getElementById('r-email').value.trim();
        const emailOk = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
        showErr('err-r-email', !emailOk); markInput('r-email', !emailOk);
        if (!emailOk) ok = false;

        const pass   = document.getElementById('r-pass').value;
        const passOk = pass.length >= 8;
        showErr('err-r-pass', !passOk); markInput('r-pass', !passOk);
        if (!passOk) ok = false;

        const confirm  = document.getElementById('r-confirm').value;
        const matchOk  = confirm === pass && confirm.length > 0;
        showErr('err-r-confirm', !matchOk); markInput('r-confirm', !matchOk);
        if (!matchOk) ok = false;

        if (!ok) return;
        document.getElementById('btn-register').classList.add('loading');
        setTimeout(() => this.submit(), 300);
    });

    /* ── ERREURS LARAVEL ── */
    @if ($errors->any())
        document.querySelector('[data-tab="{{ old("_form", "login") }}"]')?.click();
    @endif

    @if (session('success'))
        const al = document.getElementById('alert-login');
        al.textContent   = '{{ session("success") }}';
        al.className     = 'alert success';
        al.style.display = 'block';
    @endif
</script>
@endsection