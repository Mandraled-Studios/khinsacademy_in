<x-admin-layout>
    <x-slot name="title">
        {{$quiz->title}}
    </x-slot>

    <div>
        @foreach($quizSections as $section)
            <div class = "bg-white p-3 border-b mb-3 ml-3 grid grid-cols-12 items-center">
                <form class="col-span-11 grid grid-cols-12 gap-1" action="{{route('admin.quiz.sections.update', ['slug' => $quiz->slug, 'section' => $section->id])}}" method = "POST" class = "flex flex-1 items-center">
                    @csrf
                    @method('PATCH')
                    <input class="col-span-4 border-none" type="text" name="name" id="name" value="{{$section->name}}">
                    <div class="col-span-3"> <span>Max Marks: </span><input name="max_marks" class = "w-full text-xl border-none flex-1 h-12 mr-2" value="{{$section->max_marks}}" /> </div>
                    <div class="col-span-3"> <span>Max Minutes: </span><input name="max_mins" class = "w-full text-xl border-none flex-1 h-12 mr-2" value="{{$section->max_mins}}" /> </div>
                    <div class="col-span-2 flex justify-end items-center"> <input type="submit" value="" class = "bg-green-600 text-white p-2 w-12 h-12 rounded-lg mr-2 edit-btn"> </div>
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
    </div>

    <div class = "w-3/4 p-4">
        <h3 class="text-lg mt-2 mb-6 font-bold"> Create Section </h3>
        <form action="{{route('admin.quiz.sections.store', ['slug' => $quiz->slug])}}" method="POST" class = "p-4" enctype="multipart/form-data">
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
                <label class = "block mb-2" for = "name"> Section Name </label>
                <input name = "name" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" type="text" />
            </div>

            <div class="mb-6">
                <label class = "block mb-2" for = "max_marks"> Max Marks </label>
                <input name = "max_marks" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" type="number" />
            </div>

            <div class="mb-6">
                <label class = "block mb-2" for = "max_mins"> Max Mins </label>
                <input name = "max_mins" class = "block px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" type="number" />
            </div>
            
            <div class="mb-6">
                <input class = "px-4 py-2 rounded bg-green-400 text-white mt-3 cursor-pointer" type="submit" value = "Add Section" name = "submit" />
            </div>
        </form>
    </div>
</x-admin-layout>