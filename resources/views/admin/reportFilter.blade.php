<x-admin-layout>
    <x-slot name="title">
        Select Quiz To View Report
    </x-slot>
    <div class="container mx-auto">
        @foreach ($quizzes as $quiz)
        <div class="mt-2 mb-4 md:grid md:grid-cols-12 md:gap-4 px-4 py-4 bg-white dark:bg-gray-600 shadow-xl rounded-lg cursor-pointer ">
            <!-- Card -->
            <div class="md:col-span-2 lg:col-span-1 xl:col-span-1 flex flex-col justify-center items-center">
                <div class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center"> {{$loop->index+1}} </div>
            </div>

            <div class="md:col-span-5 lg:col-span-6 xl:col-span-6 flex flex-col justify-center flex-1 min-w-64 my-2">
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

            <div class="md:col-span-3 lg:col-span-2 xl:col-span-2 flex flex-col justify-center my-2">
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
            
            <div class = "md:col-span-2 lg:col-span-3 xl:col-span-3 flex flex-col justify-center">

                <div
                    class="mb-3 flex flex-col capitalize text-gray-600 px-2">
                    <span class = "text-xs block mb-2">Action</span>
                    <a href = "{{route('admin.quizreports.individual', ['id' => $quiz->id])}}" class = "block text-center mb-3 px-4 py-2 bg-orange-400 text-white"> View Report </a>
                </div>

            </div>
        </div>
        @endforeach
    </div>
</x-admin-layout>