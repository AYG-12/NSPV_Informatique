@php $title = "Contact"; @endphp

@extends('layouts.guest')
@include('partials._navbar')
@section('content')
<main class="content-main contact">
    <h1>Contactez-Nous</h1>
    <section>
        <div class="contact">
            <h2>Contact</h2>
            @if(!empty($appSettings['shop_address']))
            <p><span>Adresse :</span> {{ $appSettings['shop_address'] }}</p>
            @endif
            @if(!empty($appSettings['shop_phone']))
            <p><span>Téléphone :</span> {{ $appSettings['shop_phone'] }}</p>
            @endif
            @if(!empty($appSettings['shop_email']))
            <p><span>Email :</span> <a href="mailto:{{ $appSettings['shop_email'] }}">{{ $appSettings['shop_email'] }}</a></p>
            @endif
        </div>
    
        <div class="form">
            <form action="">
                <div class="email">
                    <label for="email">Email <span>*</span></label> <br>
                    <input type="email" name="email" id="email" placeholder="example@gmail.com"  required>
                </div>
    
                <div class="objet">
                    <label for="objet">Objet <span>*</span></label> <br>
                    <input type="text" name="objet" id="objet" required>
                </div>
    
                <div class="message">
                    <label for="message">Message <span>*</span></label> <br>
                    <textarea name="message" id="messsage" required></textarea>
                </div>
    
                <button type="submit">Envoyer</button>
            </form>
        </div>

    </section>

    <section class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3971.7469421945884!2d-4.065660525630365!3d5.455326734655101!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc19327b259f881%3A0x39edab8bd9921374!2sNSPV%20informatique%20SARL!5e0!3m2!1sfr!2sci!4v1772200774677!5m2!1sfr!2sci" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
</main>
@endsection