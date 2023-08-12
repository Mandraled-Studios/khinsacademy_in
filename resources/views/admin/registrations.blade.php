<x-admin-layout>
    <x-slot name="title">
        Student Registrations
    </x-slot>
    <div class="container mx-auto">
        @isset($_GET['term'])
        <div class="py-3">
            <a class = "bg-gray-200 text-gray-700 px-3 py-2 border border-gray-600" href="{{route('admin.registrations')}}"> &lt; Back to List Of All Students</a>
        </div>
        @endisset
        <div class="md:flex md:justify-between md:items-center py-3">
            <p> <strong class = "text-orange-400"> {{$studentsCount}} </strong> students {{ isset($_GET['term']) ? "found" : "registered" }}. </p>
            <form class = "w-full md:w-1/2 flex" action="/student-registrations/search" method = "GET">
                @csrf
                <input type="text" name = "term" class = "h-12 block flex-1 @error('department') border-red-500 @enderror px-4 py-2 mb-4 border border-gray-400 focus:ring-0 focus:border-orange-600" placeholder="Search student by roll number or name" />
                <input id = "searchBtn" type="submit" class = "h-12 bg-orange-400 hover:bg-orange-500 text-white px-2" value = "Search" />
            </form>
        </div>
        <div id = "studContainer" class="flex flex-col sm:flex-row sm:flex-wrap">
          
            @foreach ($students as $student)
                <div class="md:w-1/2 lg:w-1/3 2xl:w-1/4 p-2 mb-6 mb-4">
                    <div class="bg-white px-6 py-8 rounded-lg shadow-lg text-center h-full">
                        <div class="mb-3">
                            @if ($student->profile_photo_path != NULL)
                                <img class="w-auto mx-auto rounded-full" src="{{$student->profile_photo_path}}" alt="dp" />
                            @else
                                <img class="w-auto mx-auto rounded-full" src="https://ui-avatars.com/api/?name={{ str_replace(".", "", str_replace(" ","+",$student->name)) }}" alt="dp" />
                            @endif
                            
                        </div>
                        <h2 class="text-xl font-medium text-gray-700 mb-3 uppercase"> {{ str_replace(".", " ", $student->name) }} </h2>
                        <h5 class="text-sm text-orange-500 block mb-3 lowercase px-2 overflow-hidden">{{ $student->email }}</h5>
                        <span class="text-small text-gray-500 block mb-5">Joined on: {{ date('d-m-Y', strtotime($student->created_at)) }}</span>
                
                        <a href="/student-registrations/{{$student->id}}" class="px-4 py-2 bg-orange-500 text-white rounded-full"> View Details </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class = "py-2">
            @isset($_GET['term'])
            @else
                {{ $students->links() }}
            @endisset
        </div>
    </div>
</x-admin-layout>
