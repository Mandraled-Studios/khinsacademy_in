<x-admin-layout>
    <x-slot name="title">
        Questions
    </x-slot>
    <div id="myForm" class = "w-3/4 p-4">
        <div class="container mx-auto py-8">
            <div class="flex justify-between my-6">
                <h2 class = "text-2xl uppercase mb-4"> {{ $quiz->title }} </h2>
                <a href="{{route('admin.questions.create', ['slug' => $quiz->slug])}}" class="px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white"> + Add New Question </a>
            </div>
            @if($errors->any())
                <div class="p-3 bg-red-300 text-red-800 mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            @foreach ($questions as $question)
                <div class="p-3 border-b-2 border-gray-900 mb-4">  
                    <div class = "p-3 flex items-center bg-white shadow"> 
                        <div class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center mr-3"> {{$loop->index+1}} </div> 
                        <h2 class="block text-xl font-bold flex-1 mr-3"> {!! $question->question_part1 !!} </h2>
                        <a href = "{{route('admin.questions.edit', ['slug' => $quiz->slug, 'ques' => $question->id])}}" class = "px-4 py-2 text-white cursor-pointer bg-orange-500 hover:bg-orange-600"> Edit Question </a>
                    </div>
                    @isset($question->quesImage)
                        <div class="bg-white shadow p-3">
                            <img src="{{$question->quesImage}}" alt="" class = "w-48 h-32 object-contain object-center">
                        </div>
                    @endisset
                    @isset($question->question_part2)
                    <div class = "py-3 pl-16 flex items-center bg-white shadow">
                        <h2 class="block text-xl font-bold flex-1 mr-3"> {!! $question->question_part2 !!} </h2>
                    </div>
                    @endisset
                    <div class="mt-4 mb-4">
                        <div class="bg-white shadow p-3 mb-3 flex justify-start {{$question->correct_answer == 1 ? "bg-green-300" : null}}"> <label> {{$question->option1}} </label> </div>
                        <div class="bg-white shadow p-3 mb-3 flex justify-start {{$question->correct_answer == 2 ? "bg-green-300" : null}}"> <label> {{$question->option2}} </label> </div>
                        <div class="bg-white shadow p-3 mb-3 flex justify-start {{$question->correct_answer == 3 ? "bg-green-300" : null}}"> <label> {{$question->option3}} </label> </div>
                        @isset($question->option4)
                            <div class="bg-white shadow p-3 mb-3 flex justify-start {{$question->correct_answer == 4 ? "bg-green-300" : null}}"> <label> {{$question->option4}} </label> </div>    
                        @endisset
                        @isset($question->option5)
                            <div class="bg-white shadow p-3 mb-3 flex justify-start {{$question->correct_answer == 5 ? "bg-green-300" : null}}"> <label> {{$question->option5}} </label> </div>
                        @endisset
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-admin-layout>