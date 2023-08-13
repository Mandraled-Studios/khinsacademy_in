<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles

        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
        
        @isset($pageincludes)
            {{$pageincludes}}
        @endisset

        <!-- Scripts -->
        <script src="/js/app.js?version={{random_int(10000, 90000)}}" defer></script>

    </head>
    <body class="font-sans antialiased">

        <x-header></x-header>

        <div class="min-h-screen bg-gray-100">
            <!-- Page Content -->
            <div class="min-h-screen w-full flex overflow-hidden pt-24 box-border">
                {{$slot}}
            </div>
        </div>

        <footer class = "relative bg-trueGray-800 text-gray-100 overflow-hidden">
            <div id="footer-pattern" class = "absolute z-1 h-full">
                <img class = "w-full h-full object-cover" src="{{asset('images/footer-pattern.png')}}" alt="">
            </div>
            <div class="container mx-auto relative z-10 pt-16 pb-3 px-6">
                <div class="lg:flex">
                    <div class="lg:flex-auto mb-12">
                        <ul class = "md:flex">
                            <li class = "py-3 pr-3 my-2 md:mr-3 md:my-0 md:text-center"><a href="/"> Home </a></li>
                            <li class = "py-3 pr-3 my-2 md:mr-3 md:my-0 md:text-center"><a href="/about"> About </a></li>
                            <li class = "py-3 pr-3 my-2 md:mr-3 md:my-0 md:text-center"><a href="/current-affairs"> Current Affairs </a></li>
                            <li class = "py-3 pr-3 my-2 md:mr-3 md:my-0 md:text-center"><a href="/register"> Register Now </a></li>
                            <li class = "py-3 pr-3 my-2 md:mr-3 md:my-0 md:text-center"><a href="/home"> Your Dashboard </a></li>
                            <li class = "py-3 pr-3 my-2 md:mr-3 md:my-0 md:text-center"><a href="/contact"> Contact </a></li>
                        </ul>
                        <h1 class = "mt-8 mb-8 text-5xl"> We are here to help you </h1>
                        <a href = "/register" class = "p-3 bg-gray-100 text-gray-900 rounded-lg"> Register Now </a>
                    </div>
                    <div class="lg:flex-auto lg:text-right">
                        <p class = "mb-3"> Call </p>
                        <h2 class = "mb-4 text-orange-400 text-2xl font-semibold"> +91 77084 98905 </h2>
                        <p class = "mb-3"> Email </p>
                        <h2 class = "mb-4 text-orange-400 text-2xl font-semibold"> khinsacademy@gmail.com </h2>
                        <div class="social">
                            <a href="facebook.com/khinsacademy"></a>
                            <a href="twitter.com/khinsacademy"></a>
                            <a href="youtube.com/khinsacademy"></a>
                        </div>
                        <p> Khins Academy <br/>
                        110M, Polpettai, Tuticorin - 628002 </p>
                    </div>
                </div>
            </div>
            <section id="developer-stamp" class = "relative z-10 bg-gray-900 text-center mt-12 py-2"> 
                <p> Designed &amp; Developed by 
                    <a href="https://www.mandraled.com"> 
                        <img class = "inline rounded-full w-10 h-10 ml-2" src="https://cdn.mandraled.com/images/logo.png" alt="mandraled-logo">
                        <strong class = "text-orange-400"> Mandraled Studios </strong> 
                    </a> 
                </p> 
            </section>
        </footer>

        

        @stack('modals')

        @livewireScripts

        @isset($pagescript)
            {{$pagescript}}
        @endisset
    </body>
</html>
