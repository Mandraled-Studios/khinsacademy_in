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

        <header class = "fixed flex z-50 w-full">
            <section id="logo" class = "w-7/12 h-24 md:w-96 md:h-24 p-4 bg-white">
                <a href = "/" class = "block w-full sm:w-72 md:w-80"> <img class = "w-full align-middle" src = "/images/logo.png" alt = "Khins-academy-logo" /> </a>
            </section>
            <section id = "header-bars" class = "w-5/12 md:flex-1 h-24">
                <div id = "top-bar" class = "bg-gray-700 h-12"> 
                    @if (Route::has('login'))
                        <div class="w-10/12 mx-auto py-2 text-right md:text-left md:flex md:justify-end">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-sm text-gray-100 border rounded px-2 py-1 ml-2">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="text-sm text-gray-100 border rounded px-2 ml-2 py-2 md:py-1 md:flex md:items-center">
                                    <img class = "w-6 h-6 inline md:block md:mr-2" src="{{asset('images/lock.svg')}}" alt="login">
                                    <span class = "hidden md:inline"> Log in </span>
                                </a>
        
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="text-sm text-gray-100 border rounded px-2 ml-2 py-2 md:py-1 md:flex md:items-center">
                                        <img class = "w-6 h-6 inline md:block md:mr-2" src="{{asset('images/register.svg')}}" alt="login">
                                        <span class = "hidden md:inline"> Register </span>
                                    </a>
                                @endif
                            @endauth

                            <div class="hidden sm:flex sm:items-center sm:ml-6">
                                <!-- Teams Dropdown -->
                                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                                    <div class="ml-3 relative">
                                        <x-dropdown align="right" width="60">
                                            <x-slot name="trigger">
                                                <span class="inline-flex rounded-md">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                        {{ Auth::user()->currentTeam->name }}
                
                                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            </x-slot>
                
                                            <x-slot name="content">
                                                <div class="w-60">
                                                    <!-- Team Management -->
                                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                                        {{ __('Manage Team') }}
                                                    </div>
                
                                                    <!-- Team Settings -->
                                                    <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                                        {{ __('Team Settings') }}
                                                    </x-dropdown-link>
                
                                                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                                        <x-dropdown-link href="{{ route('teams.create') }}">
                                                            {{ __('Create New Team') }}
                                                        </x-dropdown-link>
                                                    @endcan
                
                                                    <!-- Team Switcher -->
                                                    @if (Auth::user()->allTeams()->count() > 1)
                                                        <div class="border-t border-gray-200 dark:border-gray-600"></div>
                
                                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                                            {{ __('Switch Teams') }}
                                                        </div>
                
                                                        @foreach (Auth::user()->allTeams() as $team)
                                                            <x-switchable-team :team="$team" />
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </x-slot>
                                        </x-dropdown>
                                    </div>
                                @endif
                
                                <!-- Settings Dropdown -->
                                <div class="ml-3 relative">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                                <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                                </button>
                                            @else
                                                <span class="inline-flex rounded-md">
                                                    <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                                                        {{ Auth::user()->name }}
                
                                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>
                                                </span>
                                            @endif
                                        </x-slot>
                
                                        <x-slot name="content">
                                            <!-- Account Management -->
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Manage Account') }}
                                            </div>
                
                                            <x-dropdown-link href="{{ route('profile.show') }}">
                                                {{ __('Profile') }}
                                            </x-dropdown-link>
                
                                            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                                    {{ __('API Tokens') }}
                                                </x-dropdown-link>
                                            @endif
                
                                            <div class="border-t border-gray-200 dark:border-gray-600"></div>
                
                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}" x-data>
                                                @csrf
                
                                                <x-dropdown-link href="{{ route('logout') }}"
                                                         @click.prevent="$root.submit();">
                                                    {{ __('Log Out') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                
                            <!-- Hamburger -->
                            <div class="-mr-2 flex items-center sm:hidden">
                                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
                <div id = "bottom-bar" class = "bg-orange-500 h-12"> 
                    <nav class = "w-10/12 mx-auto text-right pt-1">
                        <button id = "ham" class = "inline-block w-10 h-10 border p-1 lg:hidden">  
                            <div class="w-8 h-1 bg-gray-100 my-1"> </div>
                            <div class="w-8 h-1 bg-gray-100 my-1"> </div>
                            <div class="w-8 h-1 bg-gray-100"> </div>
                        </button>
                        <ul class = "text-left bg-orange-600 lg:block lg:flex lg:justify-end lg:bg-orange-500">
                            <li class="px-3 py-2"> <a href = "/about" class = "text-gray-100 mr-2"> About </a> </li>
                            <li class="px-3 py-2"> <a href = "/gallery" class = "text-gray-100 mr-2"> Gallery </a> </li>
                            <li class="px-3 py-2"> <a href = "/current-affairs" class = "text-gray-100 mr-2"> Current Affairs </a> </li>
                            <li class="px-3 py-2"> <a href = "/contact" class = "text-gray-100"> Contact </a> </li>
                        </ul>
                    </nav>
                </div>
            </section>
        </header>

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
