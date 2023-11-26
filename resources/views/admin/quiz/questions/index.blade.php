<x-admin-layout>
    <x-slot name="title">
        Add Questions / Sections to {{ $quiz->title }}
    </x-slot>
    <x-slot name="breadcrumb">
        <span> You are here: &nbsp; </span>
        <a class="inline-block pb-1 border-b border-1 border-gray-600" href="{{route('admin.quiz.index')}}"> Quizzes </a> &nbsp; &gt; &nbsp; 
        <span> {{ $quiz->title }} </span>
    </x-slot>
    <div class = "p-4">
        <div class="container mx-auto">
            <div class="flex justify-end my-6">
                <div class="flex">
                @if ($quiz->questions()->count() == 0 || $quiz->sections->count() > 0)
                    <a href="{{route('admin.quiz.sections.create', ['slug' => $quiz->slug])}}" class="flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white mr-2"> + Add New Section </a>
                @endif
                @if ($quizSections->count() == 0)
                    <a href="{{route('admin.questions.create', ['slug' => $quiz->slug])}}" class="flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white"> + Add New Question </a>
                @endif
                </div>
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
            @if ($quizSections->count() > 0)
                <h2 class = "text-xl font-bold mb-4 text-center md:text-left"> Sections </h2>
                @foreach($quizSections as $section)
                    <div class = "bg-white p-3 border-b mb-3 ml-3 grid grid-cols-12 items-center">
                        <form class="col-span-11 grid grid-cols-12 gap-1" action="{{route('admin.quiz.sections.update', ['slug' => $quiz->slug, 'section' => $section->id])}}" method = "POST" class = "flex flex-1 items-center">
                            @csrf
                            @method('PATCH')
                            <input class="col-span-4 border-none" type="text" name="name" id="name" value="{{$section->name}}">
                            <div class="col-span-2"> <span>Max Marks: </span><input name="max_marks" class = "w-full text-xl border-none flex-1 h-12 mr-2" value="{{$section->max_marks}}" /> </div>
                            <div class="col-span-2"> <span>Max Minutes: </span><input name="max_mins" class = "w-full text-xl border-none flex-1 h-12 mr-2" value="{{$section->max_mins}}" /> </div>
                            <div class="col-span-4 flex justify-end items-center">
                                <div class="flex flex-col mr-2">
                                    <a href="{{route('admin.questionsInSection.index', ['slug' => $quiz->slug, 'section' => $section->id])}}" class="flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white mb-2"> View Questions </a>
                                    <a href="{{route('admin.questionsInSection.create', ['slug' => $quiz->slug, 'section' => $section->id])}}" class="flex items-center px-3 py-2 bg-orange-500 hover:bg-orange-600 text-white mb-1"> + Add Question </a>
                                </div>
                                <input type="submit" value="" class = "bg-green-600 text-white p-2 w-12 h-12 rounded-lg mr-2 edit-btn"> 
                            </div>
                        </form>
                        <form class="col-span-1" action="{{route('admin.quiz.sections.destroy', ['slug' => $quiz->slug, 'section' => $section->id])}}" method = "POST">
                            @csrf
                            @method('DELETE')
                            <button type = "submit" class = "bg-red-600 text-white p-2 w-12 h-12 rounded-lg delete-btn" onclick="event.preventDefault();
                                                    if(confirm('Are you sure you want to delete this section?')){
                                                        this.parentNode.submit();
                                                    }"> 
                            </button>
                        </form>
                    </div>
                    @error('heading')
                        <span class="bg-red-300 text-red-800 p-3" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                @endforeach
            @endif
        </div>
    </div>
    <div class = "w-3/4 p-4">
        <div class="container mx-auto py-8">
            @if ($quiz->questions->count() > 0)
                @foreach ($questions as $question)
                    @if ($question->section == null)
                        <div class="p-3 border-b-2 border-gray-900 mb-4">  
                            <div class = "p-3 flex items-center bg-white shadow"> 
                                <div class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center mr-3"> {{$loop->index+1}} </div> 
                                <h2 class="block text-xl font-bold flex-1 mr-3"> {!! $question->question_part1 !!} </h2>
                                <a href = "{{route('admin.questions.edit', ['slug' => $quiz->slug, 'ques' => $question->id])}}" class = "px-4 py-2 text-white cursor-pointer bg-orange-500 hover:bg-orange-600"> Edit Question </a>
                                <form action="{{route('admin.questions.destroy', ['id' => $quiz->id, 'ques' => $question->id])}}" method = "POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type = "submit" class = "bg-red-600 text-white p-2 w-12 h-12 rounded-lg delete-btn" onclick="event.preventDefault();
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
            @endif
        </div>
    </div>
</x-admin-layout>