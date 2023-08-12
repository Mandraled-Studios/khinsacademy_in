<x-admin-layout>
    <x-slot name="title">
        All Quizzes
    </x-slot>

    <div class="container pt-4 py-12">

        <h3 class = "text-xl font-bold mb-4"> Batch-wise Quizzes </h3>
    
        <div class="tabs-nav">
            <ul class="flex flex-wrap my-8" id="pills-tab">
                @foreach ($occasions as $occasion)
                <li class="nav-item my-4 mx-1">
                    <a class="rounded-full px-4 py-3 border" href = "#occ{{$occasion->id}}">{{$occasion->heading}}</a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class = "py-4 mb-8">
            <div class="tab-content" id="pills-tabContent">
                @foreach ($occasions as $occasion)
                    <div class="tab-pane {{$loop->index == 0 ? 'show' : ''}}" id="occ{{$occasion->id}}">
                        @foreach ($occasion->quizzes as $quiz)
                            <div class="mt-2 mb-4 md:grid md:grid-cols-12 md:gap-4 px-4 py-4 bg-white dark:bg-gray-600 shadow-xl rounded-lg cursor-pointer ">
                                <!-- Card -->
                                <div class="md:col-span-2 lg:col-span-2 xl:col-start-1 xl:col-span-1 flex flex-col justify-center items-center">
                                    <div class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center"> {{$loop->index+1}} </div>
                                </div>
                    
                                <div class="md:col-span-7 xl:col-span-4 flex flex-col justify-center flex-1 min-w-64 my-2">
                                    <!-- Left side -->
                    
                                    <div class="flex flex-col capitalize text-gray-600 px-2 mb-2">
                                        <span class = "text-xs">Quiz Title</span>
                                        <span class="mt-1 text-black whitespace-nowrap">
                                            {{$quiz->title}}
                                        </span>
                                    </div>
                    
                                    <div class="flex flex-col capitalize text-gray-600 px-2 mb-2">
                                        <span class = "text-xs">Quiz Description</span>
                                        <span class="mt-1 text-black">
                                            {{$quiz->description}}
                                        </span>
                    
                                    </div>
                    
                                </div>
                    
                                <div class="md:col-span-3 xl:col-span-2 flex flex-col justify-center my-2">
                                    <!-- Middle Part -->
                    
                                    <div class="my-1 capitalize text-gray-600 px-2">
                                        <span class = "text-xs"> Total Marks: </span>
                                        <span class="mt-1 text-black">
                                            {{$quiz->max_marks}}
                                        </span>
                                    </div>
                    
                                    <div class="my-1 capitalize text-gray-600 px-2">
                                        <span class = "text-xs">Allowed Time: </span>
                                        <span class="mt-1 text-black">
                                            {{$quiz->max_mins}} mins
                                        </span>
                                    </div>
                    
                                    <div class="my-1 capitalize text-gray-600 px-2">
                                        <span class = "text-xs">Max Attempts: </span>
                                        <span class="mt-1 text-black">
                                            {{$quiz->attempts}}
                                        </span>
                                    </div>
                    
                                </div>
                                
                                <div class = "md:col-span-5 md:col-start-3 xl:col-span-2 xl:col-start-8 flex flex-col justify-center">
                    
                                    <div
                                        class="mb-3 flex flex-col capitalize text-gray-600 px-2">
                                        <span class = "text-xs">Quiz Status</span>
                                        <span class="mt-1 text-sm text-blueGray-400">
                                            {{$quiz->publish_status ? "Published" : "Saved In Drafts"}}
                                        </span>
                                        <span class="text-orange-500 text-sm">
                                            {!!$quiz->publish_status ? "Published Date: <br/>".date('d-m-Y', strtotime($quiz->published_at)) : "Saved Date: <br/>".date('d-m-Y', strtotime($quiz->created_at))!!}
                                        </span>
                                    </div>
                    
                                </div>
                    
                                <div class = "md:col-span-5 xl:col-span-3 flex flex-1 flex-col justify-center">
                    
                                    <div class="mb-3 capitalize text-gray-600 px-2">
                                        <a href = "/online-exams/{{$quiz->slug}}/questions" class = "block text-center mb-3 px-4 py-2 bg-orange-400 text-white"> View Questions </a>
                                        <a href = "{{route('admin.quiz.edit', ['slug' => $quiz->slug])}}" class = "block text-center mb-3 px-4 py-2 bg-orange-400 text-white"> Edit Quiz </a>
                                        <form id = "deleteForm" action="{{route('admin.quiz.destroy', ['slug' => $quiz->slug])}}" method = "POST" class="inline">
                                            @csrf
                                            @method('DELETE') 
                                            <button type = "submit" class = "block w-full px-4 py-2 rounded text-gray-200 bg-red-500 hover:bg-red-600" onclick="event.preventDefault();
                                                            if(confirm('Are you sure you want to delete this exam?')){
                                                                this.parentNode.submit();
                                                            }"> 
                                                Delete Exam
                                            </button>
                                        </form>
                                    </div>
                    
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    
</x-admin-layout>