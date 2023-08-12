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
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

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
                    <nav class="hidden lg:block flex flex-col bg-gray-200 dark:bg-gray-900 w-96 px-6 pt-6 pb-6">
                        <!-- SideNavBar -->
                
                        <div class="mt-8">
                            <!-- User info -->
                            <div class="flex flex-row border-b items-center justify-between pb-2">
                                <div class="h-12 w-12 bg-gray-900 rounded-full overflow-hidden">
                                    <img
                                        class="h-12 w-12 object-cover"
                                        src="https://cdn.mandraled.com/images/logo.png"
                                        alt="admin-dp" 
                                    />
                                </div>
                                <div>
                                    <h2
                                        class="text-xl dark:text-gray-300 font-extrabold capitalize">
                                        Hello {{auth()->user()->name}}
                                    </h2>
                                    <span class="text-sm">
                                        <span class="font-semibold text-orange-600 dark:text-orange-300">
                                            {{auth()->user()->email}}
                                        </span>
                                    </span>
                                </div>
                                <span class="relative mt-3">
                                    <a
                                        class="hover:text-green-500 dark-hover:text-green-300
                                        text-gray-600 dark:text-gray-300"
                                        href="inbox/">
                                        <svg
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path
                                                d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                    </a>
                                    <div
                                        class="absolute w-2 h-2 rounded-full bg-green-500
                                        dark-hover:bg-green-300 right-0 mb-5 bottom-0"></div>
                                </span>
                            </div>
                        </div>
                
                        <ul class="mt-2 text-gray-600">
                            <!-- Links -->
                            <li class="mt-8 @yield('specialClass1')">
                                <a href="/student-registrations" class="flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg>
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        student registrations
                                    </span>
                                </a>
                            </li>
                
                            <li class="mt-8 @yield('specialClass3')">
                                <a href="/occasions" class="flex">
                                    <svg
                                        class="fill-current h-5 w-5 dark:text-gray-300"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M19 19H5V8h14m-3-7v2H8V1H6v2H5c-1.11 0-2 .89-2
                                            2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0
                                            00-2-2h-1V1m-1 11h-5v5h5v-5z"></path>
                                    </svg>
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        events / occasions
                                    </span>
                                </a>
                            </li>
            
            
                            <li class="mt-8 @yield('specialClass9')">
                                <a href="/online-exams" class="flex">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path><rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect></svg>
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        Quizes 
                                    </span>
                                </a>
                            </li>

                            <li class="mt-8 @yield('specialClass2')">
                                <a href="/exam-reports" class="flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.2 7.8l-7.7 7.7-4-4-5.7 5.7"/><path d="M15 7h6v6"/></svg>
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        Quiz reports
                                    </span>
                                </a>
                            </li>
                
                        </ul>
                
                        <div class="mt-16 flex items-center text-red-700 dark:text-red-400">
                            <!-- important action -->
                            <form action="/logout" class="flex items-center" method = "POST">
                                @csrf
                                <svg class="fill-current h-5 w-5" viewBox="0 0 24 24">
                                    <path
                                        d="M16 17v-3H9v-4h7V7l5 5-5 5M14 2a2 2 0 012
                                        2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2
                                        0 012-2h9z"></path>
                                </svg>
                                <input type = "submit" class="ml-2 capitalize font-medium cursor-pointer bg-transparent" value = "Log Out" />
                            </form>
                
                        </div>
                    </nav>
                    <main
                        class="flex-1 flex flex-col bg-gray-100 dark:bg-gray-700 transition
                        duration-500 ease-in-out overflow-y-auto pt-12">
                        <div class="mx-10 my-2">
                            @isset($tabContents)
                            <nav
                                class="flex flex-row justify-between border-b
                                dark:border-gray-600 dark:text-gray-400 transition duration-500
                                ease-in-out">
                                <div class="flex">
                                    <!-- Top NavBar -->
                                    @foreach($tabContents as $tab)
                                    <a
                                        href="{{$tab->link}}"
                                        class="py-2 block text-green-500 border-green-500
                                        dark:text-green-200 dark:border-green-200
                                        focus:outline-none border-b-2 font-medium capitalize
                                        transition duration-500 ease-in-out">
                                        {{$tab->tabName}}
                                    </a>
                                    @endforeach
                                </div>
                
                                <div class="flex items-center select-none">
                                    <span
                                        class="hover:text-green-500 dark-hover:text-green-300
                                        cursor-pointer mr-3 transition duration-500 ease-in-out">
                
                                        <svg viewBox="0 0 512 512" class="h-5 w-5 fill-current">
                                            <path
                                                d="M505 442.7L405.3
                                                343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7
                                                44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1
                                                208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4
                                                2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9
                                                0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7
                                                0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0
                                                128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
                                        </svg>
                                    </span>
                
                                    <input
                                        class="w-12 bg-transparent focus:outline-none"
                                        placeholder="Search" />
                
                                </div>
                
                            </nav>
                            @endif
                            <h2 class="my-4 text-4xl font-semibold dark:text-gray-400">
                                {{$title ?? "Page Heading"}}
                            </h2>
                            @isset($filterabale)
                                <div class="pb-2 flex items-center justify-between text-gray-600
                                    dark:text-gray-400 border-b dark:border-gray-600">
                                    <!-- Header -->
                    
                                    <div>
                                        <span>
                                            <span class="text-orange-500 dark:text-green-200">
                                                {{$count ?? "431"}}
                                            </span>
                                            {{$contentHeading ?? "Current Affair Articles."}}
                                        </span>
                                    </div>
                                    <div>
                                        <span class="capitalize ml-12">
                                            sort by:
                                            <div class="dropdown group inline-block">
                                                <button
                                                class="ml-4 flex items-center justify-between py-1 px-3 text-gray-700
                                                dark:text-gray-200 border border-orange-600 rounded-lg shadow">
                                                    <span class="pr-1 font-semibold flex-1"> Select One </span>
                                                    <span>
                                                        <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                        </svg>
                                                    </span>
                                                </button>
                                                <ul class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute 
                                                transition duration-150 ease-in-out origin-top min-w-32 cursor-pointer">
                                                <li class="rounded-sm px-3 py-1 hover:bg-gray-100"> Recently Added </li>
                                                <li class="rounded-sm px-3 py-1 hover:bg-gray-100"> Oldest First </li>
                                                </ul>
                                            </div>
                                        </span>
                                        <span class="capitalize ml-12">
                                            filter by:
                                            <span class="cursor-pointer">
                                                <div class="dropdown group inline-block">
                                                    <button
                                                    class="ml-4 flex items-center justify-between py-1 px-3 text-gray-700
                                                    dark:text-gray-200 border border-orange-600 rounded-lg shadow">
                                                        <span class="pr-1 font-semibold flex-1"> Show All </span>
                                                        <span>
                                                            <svg class="fill-current h-4 w-4 transform group-hover:-rotate-180 transition duration-150 ease-in-out"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                            <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <ul class="bg-white border rounded-sm transform scale-0 group-hover:scale-100 absolute 
                                                    transition duration-150 ease-in-out origin-top min-w-32 cursor-pointer">
                                                    <li class="rounded-sm px-3 py-1 hover:bg-gray-100"> Only This Month </li>
                                                    <li class="rounded-sm px-3 py-1 hover:bg-gray-100"> Only This Year </li>
                                                    </ul>
                                                </div>
                                            </span>
                                        </span>
                                    </div>
                    
                                </div>
                            @endif
                            
                            <!-- Page Content -->
                            <main>
                                {{ $slot }}
                            </main>
                
                        </div>
                
                    </main>
                
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
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>