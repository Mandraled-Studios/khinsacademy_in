<header class = "fixed flex z-50 w-full">
    <section id="logo" class = "w-7/12 h-24 md:w-96 md:h-24 p-4 bg-white">
        <a href = "/" class = "block w-full sm:w-72 md:w-80"> <img class = "w-full align-middle" src = "/images/logo.png" alt = "Khins-academy-logo" /> </a>
    </section>
    <section id = "header-bars" class = "w-5/12 md:flex-1 h-24">
        <div id = "top-bar" class = "bg-gray-700 h-12"> 
            @if (Route::has('login'))
                <div class="w-10/12 mx-auto py-2 text-right md:text-left md:flex md:justify-end">
                    @guest
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
                    @endguest

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
                    <div x-data={open:false} class="relative -mr-2 flex items-center sm:hidden justify-end" >
                        <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <div x-cloak x-show="open" class="w-full absolute top-20 bg-white shadow-lg p-2">
                            <ul>
                                <li class="p-2 border-b border-gray-600"><a href="{{route('profile.show')}}"> My Profile </a></li>
                                <li class="p-2 border-b border-gray-600"><a href="{{route('dashboard')}}"> Dashboard </a></li>
                                <li class="p-2 border-b border-gray-600"><a href="{{route('students.quiz')}}"> Quizzes </a></li>
                                <li class="p-2"><a href="{{route('students.reportCard')}}"> My Report Card </a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div id = "bottom-bar" class = "bg-orange-500 h-12"> 
            
        </div>
    </section>
</header>