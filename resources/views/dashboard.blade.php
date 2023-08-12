@if (auth()->user()->email == "mandraledstudios@gmail.com" || auth()->user()->email == "admin@khinsacademy.in")
<x-admin-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                
            </div>
        </div>
    </div>
</x-admin-layout>
@else 
<x-app-layout>
    <x-slot name="title">
        Dashboard
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                
            </div>
        </div>
    </div>
</x-app-layout>
@endif
