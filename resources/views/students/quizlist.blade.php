<x-app-layout>
    <x-slot name="title">
        List of Quizzes
    </x-slot>
    <div class="container mx-auto py-6">
        @foreach ($quizzes as $quiz)
            <div class="px-4 py-6 bg-white shadow mb-4">
                <h3 class = "text-lg font-bold mb-4"> {{$quiz->title}} </h3>
                <p class="text-base mb-6"> {{$quiz->description}} </p>
                <a href="{{route('students.quiz.instructions', ['slug' => $quiz->slug])}}" class="px-4 py-2 bg-orange-400 text-white hover:bg-orange-500"> View Quiz Details </a>
            </div>
        @endforeach
    </div>
</x-app-layout>