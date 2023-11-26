<x-admin-layout>
    <x-slot name="title">
        Create New Classroom / Batch
    </x-slot>
    <form action="/classrooms" method="POST" class = "py-4">
        @csrf
        @if (session()->has('success'))
        <div class="p-3 mb-3 bg-green-300 text-green-800">
            <h3> {{session('success')}} </h3>
        </div>
        @endif
        @if (session()->has('danger'))
            <div class="p-3 mb-3 bg-red-300 text-red-800">
                <h3> {{session('danger')}} </h3>
            </div>
        @endif

        <div class="mb-3">
            <label class = "block mb-2" for = "department"> Create New Batch For: </label>
            <select class = "block @error('department') border-red-500 @enderror px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" name="department" id="department" required>
                @foreach ($departments as $department)
                    <option value="{{$department->id}}"> {{$department->title}} </option>
                @endforeach
            </select>
        </div>
        
        <div class="mb-3">
            <label class = "block mb-2" for = "classYear"> Choose Year Of Batch: </label>
            <select class = "block @error('classYear') border-red-500 @enderror px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" name="classYear" id="classYear" required>
                @for ($y = date('Y')+1; $y >= 2018; $y--)
                    <option value="{{$y}}"> {{$y}} </option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label class = "block mb-2" for = "examYear"> Choose Year Of Exam: </label>
            <select class = "block @error('examYear') border-red-500 @enderror px-4 py-2 mb-4 border border-gray-400 w-full focus:ring-0 focus:border-orange-600" name="examYear" id="examYear" required>
                @for ($y = date('Y')+1; $y >= 2018; $y--)
                    <option value="{{$y}}"> {{$y}} </option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <input class = "px-4 py-2 rounded bg-orange-400 text-white mt-3" type="submit" value = "Create Batch" name = "save" />
        </div>
    </form>
</x-admin-layout>