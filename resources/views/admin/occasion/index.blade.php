<x-admin-layout>
    <x-slot name="title">
        All Events & Occasions
    </x-slot>
    <div class="pb-12">
        <div class="mt-6 bg-gray-700 py-2 px-4 my-4 flex justify-between items-center">
            <h2 class="text-gray-200 text-xl font-bold"> All Occasions / Events </h2>
            <a href="#myForm" class="bg-emerald-400 text-white hover:bg-emerald-500 px-4 py-2 rounded"> <strong> + </strong> Add New Occasion </a>
        </div>
        @if (session()->has('success'))
            <div class="p-3 bg-green-300 text-green-800">
                <h3> {{session('success')}} </h3>
            </div>
        @endif
        @if (session()->has('danger'))
            <div class="p-3 bg-red-300 text-red-800">
                <h3> {{session('danger')}} </h3>
            </div>
        @endif
        @foreach($occasions as $occasion)
            <div class = "bg-white p-3 border-b mb-3 ml-3 flex items-center">
                <form action="{{route('admin.occasions.update', ['id' => $occasion->id])}}" method = "POST" class = "flex flex-1 items-center">
                    @csrf
                    @method('PATCH')
                    <img src="{{$occasion->banner}}" class="inline-block w-24 h-16 object-contain object-center mr-2"/>
                    <textarea name = "heading" class = "text-xl border-none flex-1 h-12 mr-2"> {{$occasion->heading}} </textarea>
                    <input type="submit" value="" class = "bg-green-600 text-white p-2 w-12 h-12 rounded-lg mr-2 edit-btn">
                </form>
                <form action="{{route('admin.occasions.destroy', ['id' => $occasion->id])}}" method = "POST">
                    @csrf
                    @method('DELETE')
                    <button type = "submit" class = "bg-red-600 text-white p-2 w-12 h-12 rounded-lg delete-btn" onclick="event.preventDefault();
                                            if(confirm('Are you sure you want to delete this occasion / event ?')){
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
        <div id="myForm" class = "w-3/4 p-4">
            <h2 class = "text-xl font-bold mb-4 mt-6"> Add New Occasion / Event </h2>
            <form action = "{{route('admin.occasions.store')}}" method = "POST" class = "mb-3" enctype="multipart/form-data">
                @csrf
                <input type="text" name = "heading" class = "@error('heading') border-red-400 @enderror block px-4 py-2 border border-gray-400 w-full focus:ring-0 focus:border-orange-600 mb-4" placeholder="Enter new event name / occasion name" />
                @error('heading')
                    <span class="bg-red-300 text-red-800 p-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input type="file" name="banner" id="banner" class = "@error('banner') border-red-400 @enderror block px-4 py-2 border border-gray-400 w-full focus:ring-0 focus:border-orange-600 mb-4">
                @error('banner')
                    <span class="bg-red-300 text-red-800 p-3" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <input type="submit" value="+ Add New Event / Occasion " class = "px-4 py-2 text-white bg-orange-500">
            </form> 
        </div>
    </div>
</x-admin-layout>