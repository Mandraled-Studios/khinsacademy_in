<x-admin-layout>
    <x-slot name="title">
        All Classrooms / Batches
    </x-slot>
    <div class="container mx-auto py-8">
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
        <h3 class = "text-xl font-bold mb-4"> All Khins Academy Departments </h3>
        <div class = "flex flex-wrap mb-8"> 
            @foreach ($departments as $department)
            <div class="w-24 bg-white border-2 border-gray-300 p-2 rounded-md tracking-wide shadow-lg mb-2 mr-2">
                <div class="card-header"> 
                    <img alt="icon" class="block w-full rounded-md border-2 border-gray-300 mb-2" src="{{$department->icon}}" />
                    <h4 class="text-sm text-center font-semibold"> {{$department->title}} </h4>
                </div>
            </div>
            @endforeach
        </div>

        <h3 class = "text-xl font-bold mb-4"> Year-wise Batches </h3>

        <div class="tabs-nav flex flex-wrap">
            <ul class="flex w-48 mt-8 mb-16" id="pills-tab">
                @for ($yr = date('Y'); $yr>=2017; $yr--)
                <li class="nav-item">
                    <a class="rounded-full px-4 py-3 border" href = "#y{{$yr}}">{{$yr}}</a>
                </li>
                @endfor
            </ul>
        </div>
        <div class = "py-4">
            <div class="tab-content" id="pills-tabContent">
                @for ($yr = date('Y'); $yr>=2017; $yr--)
                    <div class="tab-pane" id="y{{$yr}}">
                        <div class="md:grid md:grid-cols-12 md:gap-4">
                            @foreach ($classrooms as $classroom)
                                @if($classroom->classYear == $yr)
                                    <div class="border border-gray-600 md:col-span-4 lg:col-span-3 xl:col-span-2">
                                        <div class="p-2">
                                            <img src="{{$classroom->icon}}" class="w-full" alt="...">
                                            <div class="text-center mb-3">
                                                <h5 class="text-lg font-bold py-3">{{$classroom->title}}</h5>
                                                <form action="/classrooms/{{$classroom->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE') 
                                                    <button type = "submit" class = "w-full p-2 rounded text-gray-200 bg-red-500 mr-2 hover:bg-red-600 text-sm" onclick="event.preventDefault();
                                                                    if(confirm('Are you sure you want to delete this classroom / batch?')){
                                                                        this.parentNode.submit();
                                                                    }"> 
                                                        Delete Class Room
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endfor
            </div>
        </div>
        <div class="mt-6 bg-gray-700 py-2 px-4 my-4 flex justify-between items-center">
            <h2 class="text-gray-200 text-xl font-bold"> Starting a new batch? </h2>
            <a href="/classrooms/create" class="bg-emerald-400 text-white hover:bg-emerald-500 px-4 py-2 rounded"> <strong> + </strong> Create New Classroom / Batch </a>
        </div>
    </div>
</x-admin-layout>