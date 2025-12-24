<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Cadeaux de Noël</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mountains+of+Christmas:wght@400;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'sauge': '#84A36E',
                        'anthracite': '#2D2D2D',
                        'vert-foret': '#35452E',
                        'rose-corail': '#F08C8E',
                        'vert-clair': '#C2D6B0',
                    },
                    fontFamily: {
                        'christmas': ['"Mountains of Christmas"', 'cursive'],
                        'sans': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #84A36E;
            background-image: url('{{ asset('images/fond-vert.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-6xl grid md:grid-cols-2 gap-8 items-center">
        
        <!-- Section Gauche - Message d'incitation -->
        <div class="hidden md:block text-center space-y-6 order-1 md:order-1">
            <div class="bg-white/10 backdrop-blur-md rounded-2xl p-8 border-2 border-white/30">
                <i class="fas fa-star text-yellow-300 text-6xl mb-6 animate-pulse"></i>
                <h2 class="text-5xl md:text-6xl font-christmas font-bold text-white leading-tight mb-6 drop-shadow-lg">
                    Obtenez des cadeaux pour vos enfants aléatoirement
                </h2>
                <p class="text-xl text-white/90 font-sans font-light leading-relaxed">
                    <i class="fas fa-sparkles text-yellow-300 mr-2"></i>
                    Découvrez la magie de Noël avec notre système de distribution de cadeaux
                    <i class="fas fa-sparkles text-yellow-300 ml-2"></i>
                </p>
            </div>
            
            <div class="flex justify-center gap-8 text-white">
                <div class="text-center">
                    <i class="fas fa-gifts text-4xl mb-2"></i>
                    <p class="font-sans text-sm">Cadeaux variés</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-shuffle text-4xl mb-2"></i>
                    <p class="font-sans text-sm">Sélection aléatoire</p>
                </div>
                <div class="text-center">
                    <i class="fas fa-heart text-4xl mb-2"></i>
                    <p class="font-sans text-sm">Joie garantie</p>
                </div>
            </div>
        </div>

        <!-- Section Droite - Formulaire -->
        <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-2xl p-8 md:p-12 order-2 md:order-2">
            <div class="text-center mb-8">
                <i class="fas fa-@yield('icon') text-rose-corail text-5xl mb-4"></i>
                <h1 class="text-4xl font-christmas font-bold text-anthracite mb-2">@yield('heading')</h1>
                <p class="text-vert-foret font-sans">@yield('subheading')</p>
            </div>

            @yield('form')

            <div class="mt-8 text-center">
                @yield('footer-link')
            </div>
        </div>

    </div>
</body>
</html>