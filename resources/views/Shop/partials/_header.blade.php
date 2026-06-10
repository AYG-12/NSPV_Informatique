<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $appSettings['shop_description'] ?? 'NSPV Informatique est votre partenaire de confiance pour la vente d\'ordinateurs et de services informatiques.' }}">
    <meta name="keywords" content="{{ ($appSettings['shop_name'] ?? 'NSPV Informatique') }}, vente d'ordinateurs, services informatiques, produits informatiques">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | {{ $appSettings['shop_name'] ?? 'NSPV Informatique' }}</title>

    <!-- style -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <!-- google fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
</head>
<body>