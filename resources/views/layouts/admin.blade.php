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
        @isset($pageincludes)
            {{$pageincludes}}
        @endisset

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

            <x-header></x-header>

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
                                <a href="{{route('admin.registrations')}}" class="flex ">
                                    <svg class="w-6 h-6 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                        <circle cx="8.5" cy="7" r="4"></circle>
                                        <polyline points="17 11 19 13 23 9"></polyline>
                                    </svg>
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        student registrations
                                    </span>
                                </a>
                            </li>

                            <li class="mt-8 @yield('specialClass3')">
                                <a href="{{route('admin.departments.index')}}" class="flex">
                                    

                                    <svg viewBox="0 0 64 64" class="h-6 w-6 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Layer_2" data-name="Layer 2">
                                            <path d="m32 33a6 6 0 1 0 -6-6 6 6 0 0 0 6 6zm0-10a4 4 0 1 1 -4 4 4 4 0 0 1 4-4z"/>
                                            <path d="m54 52a1 1 0 0 0 1-1v-8.5l6.2-4.65a2.87 2.87 0 0 0 1.14-2.29 2.84 2.84 0 0 0 -2.34-2.79 2.78 2.78 0 0 0 -2.13.43l-.91.6v-20.7a1 1 0 0 0 -.83-1l-11.13-1.94v-2.16a1 1 0 0 0 -1-1h-4v-5a1 1 0 0 0 -1-1h-14a1 1 0 0 0 -1 1v5h-4a1 1 0 0 0 -1 1v2.16l-11.17 1.95a1 1 0 0 0 -.83 1v20.69l-.9-.6a2.85 2.85 0 0 0 -3.3 4.65l6.2 4.65v8.5a1 1 0 0 0 1 1v9h-9v2h62v-2h-9zm-7-27a4 4 0 1 1 -4 4 4 4 0 0 1 4-4zm-21-22h12v4h-12zm-5 26a4 4 0 1 1 -4-4 4 4 0 0 1 4 4zm-12-15.06 10-1.75v11.16a6 6 0 1 0 2 1.19v-15.54h22v15.54a6 6 0 1 0 2-1.19v-11.16l10 1.75v21.19l-1.3.87h-12.7a5 5 0 0 0 -4-2h-10a5 5 0 0 0 -4 2h-12.7l-1.3-.87zm24 27.82-1 1.44-1-1.44.87-5.76h.26zm-16.72 19.24.72-2.88.72 2.88zm5.72 0h-2.22l-1.78-7.24a1 1 0 0 0 -1.94 0l-1.84 7.24h-2.22v-9h10zm3 0h-1v-9h1zm0-11h-14v-8a1 1 0 0 0 -.4-.8l-6.6-5a.88.88 0 0 1 -.34-.69.81.81 0 0 1 .14-.46.88.88 0 0 1 .55-.37.87.87 0 0 1 .64.13l4.46 3a1 1 0 0 0 .55.19h12.1a5.47 5.47 0 0 0 -.1 1v7a4 4 0 0 0 3 3.86zm6.22 11 .78-3.9.78 3.9zm5.78 0h-2.18l-1.82-9.2a1 1 0 0 0 -2 0l-1.82 9.2h-2.18v-11h10zm0-13h-10v-10h-2v9.72a2 2 0 0 1 -1-1.72v-7a3 3 0 0 1 3-3h2.85l-.85 5.86a1 1 0 0 0 .16.69l2 3a1 1 0 0 0 1.66 0l2-3a1 1 0 0 0 .16-.69l-.83-5.86h2.85a3 3 0 0 1 3 3v7a2 2 0 0 1 -1 1.72v-9.72h-2zm3 13h-1v-9h1zm6.28 0 .72-2.88.72 2.88zm5.72 0h-2.22l-1.78-7.24a1 1 0 0 0 -1.94 0l-1.84 7.24h-2.22v-9h10zm1-19v8h-14v-.14a4 4 0 0 0 3-3.86v-7a5.47 5.47 0 0 0 -.1-1h12.1a1 1 0 0 0 .55-.17l4.47-3a.83.83 0 0 1 .63-.13.88.88 0 0 1 .55.37.81.81 0 0 1 .14.46.88.88 0 0 1 -.34.69l-6.6 5a1 1 0 0 0 -.4.78z"/><path d="m23 11h2v2h-2z"/><path d="m27 11h2v2h-2z"/><path d="m23 15h2v2h-2z"/><path d="m27 15h2v2h-2z"/><path d="m35 11h2v2h-2z"/><path d="m39 11h2v2h-2z"/><path d="m35 15h2v2h-2z"/><path d="m39 15h2v2h-2z"/><path d="m11 15h2v2h-2z"/><path d="m15 15h2v2h-2z"/><path d="m11 19h2v2h-2z"/><path d="m15 19h2v2h-2z"/>
                                            <path d="m47 15h2v2h-2z"/>
                                            <path d="m51 15h2v2h-2z"/>
                                            <path d="m47 19h2v2h-2z"/>
                                            <path d="m51 19h2v2h-2z"/>
                                        </g>
                                    </svg>
                                      
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        Departments
                                    </span>
                                </a>
                            </li>

                            <li class="mt-8 @yield('specialClass3')">
                                <a href="{{route('admin.classrooms.index')}}" class="flex">
                                    

                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="fill-current h-6 w-6 dark:text-gray-300" viewBox="0 0 16 16">
                                        <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917l-7.5-3.5ZM8 8.46 1.758 5.965 8 3.052l6.242 2.913L8 8.46Z"/>
                                        <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466 4.176 9.032Zm-.068 1.873.22-.748 3.496 1.311a.5.5 0 0 0 .352 0l3.496-1.311.22.748L8 12.46l-3.892-1.556Z"/>
                                    </svg>
                                      
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        Classrooms / Batches
                                    </span>
                                </a>
                            </li>
                
                            <li class="mt-8 @yield('specialClass3')">
                                <a href="{{route('admin.occasions.index')}}" class="flex">
                                    <svg
                                        class="fill-current h-6 w-6 dark:text-gray-300"
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
                                <a href="{{route('admin.quiz.index')}}" class="flex">
                                    <svg class="w-6 h-6 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                                        <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                                    </svg>
                                    <span
                                        class="ml-2 capitalize font-medium text-black
                                        dark:text-gray-300">
                                        Quizzes 
                                    </span>
                                </a>
                            </li>

                            <li class="mt-8 @yield('specialClass2')">
                                <a href="{{route('admin.quizreports')}}" class="flex ">
                                    <svg class="w-6 h-6 dark:text-gray-300" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20.2 7.8l-7.7 7.7-4-4-5.7 5.7"/>
                                        <path d="M15 7h6v6"/>
                                    </svg>
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
                                <svg class="fill-current h-6 w-6 dark:text-gray-300" viewBox="0 0 24 24">
                                    <path
                                        d="M16 17v-3H9v-4h7V7l5 5-5 5M14 2a2 2 0 012
                                        2v2h-2V4H5v16h9v-2h2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V4a2 2
                                        0 012-2h9z">
                                    </path>
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
                            @isset ($breadcrumb)
                                <div class="flex mb-4">
                                    {{ $breadcrumb }}
                                </div>
                            @endisset
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
            
            <x-footer></x-footer>
        </div>

        @stack('modals')
        
        @isset($pagescript)
            {{$pagescript}}
        @endisset

        @livewireScripts
    </body>
</html>