<x-admin-layout>
    <x-slot name="title">
        Create Quiz
    </x-slot>
    <div id="myForm" class = "w-3/4 p-4">
        <form action="{{route('admin.quiz.store')}}" method="POST" class = "p-4" enctype="multipart/form-data">
            @csrf
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
                <label class = "block mb-2" for = "occasion_id"> Choose what occasion this quiz is for? </label>
                <select name="occasion_id" id="occasion_id" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" required>
                    @foreach ( $occasions as $occasion )
                        <option value="{{$occasion->id}}" {{ (old('occasion_id') == $occasion->id) ? "selected" : null }}> {{$occasion->heading}} </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "title"> Title </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Quiz's Title" name="title" required value = "{{old('title')}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "slug"> Slug </label>
                <input type="text" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Quiz's Slug" name="slug" required value = "{{old('slug')}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "description"> Description </label>
                <textarea id = "ckeditor" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter a description for the Quiz" name="description">{{old('description')}}</textarea> 
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "max_marks"> Enter Maximum Marks For Quiz </label>
                <input type="number" min = "0" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Quiz Total Marks" name="max_marks" required value = "{{old('max_marks')}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "separate_marks"> Allow Separate Marks For Each Question? </label>
                <select name="separate_marks" id="separate_marks" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" required>
                    <option value="0" {{ (old('separate_marks') == "0") ? "selected" : null }}> No </option>
                    <option value="1" {{ (old('separate_marks') == "1") ? "selected" : null }}> Yes </option>
                </select>
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "max_mins"> Enter Maximum Time Allowed For Quiz (in minutes) </label>
                <input type="number" min = "0" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Total Time For Quiz in Minutes" name="max_mins" required value = "{{old('max_mins')}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "attempts"> Enter Maximum Attempts Allowed For Quiz </label>
                <input type="number" min = "0" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" placeholder="Enter Allowed No.Of Attempts" name="attempts" required value = "{{old('attempts')}}" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "shuffle"> Allow Question Shuffling </label>
                <select name="shuffle" id="shuffle" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" required>
                    <option value="0" {{ (old('shuffle') == "0") ? "selected" : null }}> No </option>
                    <option value="1" {{ (old('shuffle') == "1") ? "selected" : null }}> Yes </option>
                </select>
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "quespdf"> Add a PDF version of questions for students to download </label>
                <input name = "quespdf" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" type="file" accept="application/pdf" />
            </div>
            <div class="mb-6">
                <label class = "block mb-2" for = "keypdf"> Add a PDF version of answer key for students to download </label>
                <input name = "keypdf" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" type="file" accept="application/pdf" />
            </div>
            <div class="mb-6">
                <input class = "px-4 py-2 rounded bg-orange-400 text-white mt-3" type="submit" value = "Save Draft" name = "save" />
                <input class = "px-4 py-2 rounded bg-green-400 text-white mt-3" type="submit" value = "Publish Quiz" name = "publish" />
            </div>
        </form>
    </div>
</x-admin-layout>