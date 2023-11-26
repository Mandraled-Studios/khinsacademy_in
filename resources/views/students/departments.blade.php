<x-app-layout>
    <x-slot name="title">
        All Departments
    </x-slot>

    <div class="container mx-auto py-8">
        <h3 class = "text-xl font-bold mb-4 text-center md:text-left"> All Khins Academy Departments </h3>
        <div class = "flex flex-wrap justify-center md:justify-start mb-8"> 
            @foreach ($departments as $department)
            @php
                $found = false
            @endphp
            <div class="w-40 bg-white relative border-2 border-gray-300 pb-16 rounded-md tracking-wide shadow-lg m-1">
                <div class="card-header px-2 pt-2"> 
                    <img alt="icon" class="w-full rounded-md border-2 border-gray-300 mx-auto" src="{{$department->icon}}" />
                    <h4 class="text-lg text-center font-semibold mt-3 mb-2"> {{$department->title}} </h4>
                    @foreach ($deptUsers as $du)
                        @if($department->id == $du->id)
                            @php
                                $found = true
                            @endphp
                            @break
                        @endif
                    @endforeach
                </div>
                <div class="absolute bottom-2 w-full text-center px-2">
                    @if ($found)
                        <h2 class = "text-center text-lg text-orange-400"> Joined! </h2>
                    @else
                        <form action="{{route('students.departments.join')}}" method = "POST" class = "w-full flex flex-col items-center justify-center">
                            @csrf 
                            <input type="hidden" name="department" value = "{{$department->id}}">
                            <input type="submit" name="join" value="Join Now" class = "block w-full text-white bg-orange-400 rounded px-4 py-2 cursor-pointer">
                        </form>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>