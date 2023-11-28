<x-admin-layout>
    <x-slot name="title">
        {{ $thisSection->name }} - Questions
    </x-slot>
    <x-slot name="breadcrumb">
        <span> You are here: &nbsp; </span>
        <a class="inline-block pb-1 border-b border-1 border-gray-600" href="{{route('admin.quiz.index')}}"> Quizzes </a> &nbsp; &gt; &nbsp; 
        <a class="inline-block pb-1 border-b border-1 border-gray-600" href="{{route('admin.questions.index', ['slug' => $quiz->slug ])}}"> {{ $quiz->title }} </a> &nbsp; &gt; &nbsp; 
        <span> {{ $thisSection->name }} </span>
    </x-slot>
    <x-slot name="pageincludes">
        <script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
        <script id="MathJax-script" src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
        <script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
    </x-slot>
    <x-slot name="pagescript">
        <script>
            CKEDITOR.replace( 'editor1' );
            CKEDITOR.replace( 'editor2' );
        </script>
    </x-slot>
    <div class="flex justify-end my-6">
        <a href="{{route('admin.questionsInSection.create', ['slug' => $quiz->slug, 'section' => $thisSection])}}" class="flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white mr-2"> + Add New Question </a>
    </div>
    @foreach ($questions as $question)
        @if ($question->section == null)
            <div class="p-3 border-b-2 border-gray-900 mb-4">  
                <div class = "p-3 flex items-center bg-white shadow"> 
                    <div class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center mr-3"> {{$loop->index+1}} </div> 
                    <h2 class="block text-xl font-bold flex-1 mr-3"> {!! $question->question_part1 !!} </h2>
                    <a href = "{{route('admin.questions.edit', ['slug' => $quiz->slug, 'ques' => $question->id])}}" class = "px-4 py-2 text-white cursor-pointer bg-orange-500 hover:bg-orange-600 mr-3"> Edit Question </a>
                    <form action="{{route('admin.questions.destroy', ['id' => $quiz->id, 'ques' => $question->id])}}" method = "POST">
                        @csrf
                        @method('DELETE')
                        <button type = "submit" class = "bg-red-600 text-white p-2 w-10 h-10 rounded-lg delete-btn" onclick="event.preventDefault();
                                                if(confirm('Are you sure you want to delete this question?')){
                                                    this.parentNode.submit();
                                                }"> 
                        </button>
                    </form>
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
        @endif
    @endforeach
</x-admin-layout>