<x-admin-layout>
    <x-slot name="title">
        Edit Question
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
    <div id="myForm" class = "w-3/4 p-4">
        <h3 class="text-lg mt-2 mb-6"> {{$quiz->title}} </h3>
        <form action="{{route('admin.questions.update', ['id' => $quiz->id, 'ques' => $question->id])}}" method="POST" class = "p-4" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            @if($errors->any())
            <div class="p-3 bg-red-300 text-red-800 mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="mb-6">
                <label class = "block mb-2" for = "question_part1"> Question Part 1 </label>
                <textarea id="editor1" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter New Question" name="question_part1" required> {{$question->question_part1}} </textarea>
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "quesImage"> Change image to support the question (optional) </label>
                @isset($question->quesImage)
                <img src="{{$question->quesImage}}" class="w-20 h-12 object-contain object-center" />
                @endisset
                <input name = "quesImage" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" type="file" accept="images/*" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "question_part2"> Question Part 2 (Optional) </label>
                <textarea id="editor2" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter New Question" name="question_part2"> {{$question->question_part2}} </textarea>
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "option1"> Option1 </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Option1" name="option1" required value = "{{$question->option1}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "option2"> Option2 </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Option2" name="option2" required value = "{{$question->option2}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "option3"> Option3 </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Option3" name="option3" required value = "{{$question->option3}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "option4"> Option4 (Optional) </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Option4" name="option4" value = "{{$question->option4}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "option5"> Option5 (Optional) </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Option5" name="option5" value = "{{$question->option5}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "correct_answer"> Choose the right option </label>
                <select name="correct_answer" id="correct_answer" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" required>
                    <option value="1" {{ ($question->correct_answer == "1") ? "selected" : null }}> Option 1 </option>
                    <option value="2" {{ ($question->correct_answer == "2") ? "selected" : null }}> Option 2 </option>
                    <option value="3" {{ ($question->correct_answer == "3") ? "selected" : null }}> Option 3 </option>
                    <option value="4" {{ ($question->correct_answer == "4") ? "selected" : null }}> Option 4 </option>
                    <option value="5" {{ ($question->correct_answer == "5") ? "selected" : null }}> Option 5 </option>
                </select>
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "shuffle"> Allow Options Shuffling </label>
                <select name="shuffle" id="shuffle" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" required>
                    <option value="0" {{ ($question->shuffle == "0") ? "selected" : null }}> No </option>
                    <option value="1" {{ ($question->shuffle == "1") ? "selected" : null }}> Yes </option>
                </select>
            </div>
            <div class="mb-6">
                <input class = "px-4 py-2 rounded bg-green-400 text-white mt-3" type="submit" value = "Add Question" name = "submit" />
            </div>
        </form>
    </div>
</x-admin-layout>