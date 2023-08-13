<x-app-layout>
    <x-slot name="title">
        View Questions of Completed Exam
    </x-slot>

    <x-slot name="specialClass2">
        {{ __('selectedTab') }}
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="px-4 py-6 bg-white shadow mb-4">
            <h3 class = "text-lg font-bold mb-4"> {{ $quizTitle }} </h3>
            @if ($quespdf !== null)
                <a class="px-4 py-2 mr-3 bg-orange-400 text-white hover:bg-orange-500" href = "{{$quespdf}}"> View Questions as PDF </a>
            @else
                <span class="rounded px-4 py-2 mr-3 bg-gray-400 text-white hover:bg-gray-500"> Question PDF not available at this moment. Please try later. </span>
            @endif
            @if ($answerkey !== null)
                <a class="px-4 py-2 bg-orange-400 text-white hover:bg-orange-500" href = "{{$answerkey}}"> View Answer Key PDF </a>
            @else
                <span class="rounded px-4 py-2 bg-gray-400 text-white hover:bg-gray-500"> Answer key PDF not available at this moment. Please try later. </span>
            @endif
        </div>
    </div>
</x-app-layout>