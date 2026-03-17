@php $title = "Fiche Produit"; @endphp

@extends('layouts.guest')

<!-- Appel de la barre de navigation -->
@include('Shop.partials._navbar')

@section('content')
    <main class="content-main">
        <div class="container">
            <div class="img_squares">
                <div class="img_squa_top">
                    <img id="imageBox" src="{{Vite::asset('resources/images/slide.jpeg')}}" alt="img_square_top">
                </div>
                
                <div class="img_square">
                    <div class="im_square"><img src="{{Vite::asset('resources/images/slide.jpeg')}}" alt="img_square" onclick="myFunction(this)"></div>
                    <div class="im_square"><img src="{{Vite::asset('resources/images/background.jpeg')}}" alt="img_square" onclick="myFunction(this)"></div>
                </div>
            </div>

            <div class="info_fiche_produit">
                <h3>Categorie du produit</h3>
                <h1>Nom du produit</h1>
                <p><span>350 000</span> F CFA</p>
                <p>Stock disponible : <span>500</span></p>

                <a href="#" class="bt">Ajouter au panier</a>

                <div class="descrip">
                    <h2>Description</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit ea soluta molestias sint distinctio sunt, facilis nesciunt optio earum eius perspiciatis, in nulla expedita maxime explicabo reiciendis quos veniam eum numquam corrupti eaque. Nisi et accusantium eveniet eius, quam eaque perferendis cumque molestiae recusandae dolores molestias eum sed aperiam pariatur delectus rerum modi minima sapiente natus aliquam. Nulla repellendus non officiis nesciunt illum adipisci cumque, earum eveniet eos! Nulla hic sint laborum temporibus et nesciunt doloremque, natus deleniti animi neque eaque, provident eum expedita, rerum harum aliquid. Veritatis hic placeat, fugiat ad delectus quas odit libero nihil incidunt vitae minus sint dolores, asperiores sit corporis esse eaque aspernatur odio nulla, omnis cum quo magni. Commodi deserunt perferendis quisquam illo expedita animi cum similique placeat eligendi modi? Ullam vel, officia deleniti sit quidem ex odit at alias mollitia libero quia modi voluptate quae dolorum quas veritatis voluptatum error inventore facilis? Repellendus ducimus modi ut nulla. Et alias earum maxime voluptates provident ipsam, necessitatibus labore. Fugit, animi possimus distinctio ad praesentium facilis suscipit consectetur quibusdam nobis architecto ab, dolores reprehenderit. Fuga, corporis quibusdam et omnis quod veritatis quo dolorem a atque consectetur optio? Optio possimus natus, excepturi vel rerum deserunt soluta laboriosam?
                    </p>
                </div>
            </div>
        </div>
    </main>
    <script type="text/javaScript">
        function myFunction(smallImg) {
            var fullImg = document.getElementById("imageBox");
            fullImg.src = smallImg.src;
        }
    </script>
@endsection
