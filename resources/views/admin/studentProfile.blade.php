<x-admin-layout>
    <x-slot name="title">
        Student Profile
    </x-slot>
    <div class="container pt-4 py-12">
        <div class="bg-white px-6 py-8 rounded-lg shadow-lg h-full">
            <div class="mb-3">
                @if ($student->profile_photo_path != NULL)
                    <img class="w-auto rounded-full" src="{{$student->profile_photo_path}}" alt="dp" />
                @else
                    <img class="w-auto rounded-full" src="https://ui-avatars.com/api/?name={{ str_replace(".", "", str_replace(" ","+",$student->name)) }}" alt="dp" />
                @endif
                
            </div>
            <h2 class="text-xl font-medium text-gray-700 mb-3 uppercase"> {{ str_replace(".", " ", $student->name) }} </h2>
            <h5 class="text-sm text-orange-500 block mb-3 lowercase overflow-hidden">{{ $student->email }}</h5>
            <span class="text-small text-gray-500 block mb-5">Joined on: {{ date('d-m-Y', strtotime($student->created_at)) }}</span>
            <div class="border border-b border-gray-300"></div>
            <h3 class = "text-xl font-bold my-4"> {{$student->name}}'s Exam Marks </h3>
    
            <table>
                <thead>
                    <tr>
                        <th class = "uppercase p-3"> Exam Title </th>
                        <th class = "uppercase p-3"> Exam Date </th>
                        <th class = "uppercase p-3"> Score </th>
                        <th class = "uppercase p-3"> Total Marks </th>
                        <th class = "uppercase p-3"> Percentage </th>
                        <th class = "uppercase p-3"> Attempts Remaining </th>
                    </tr>
                </thead>
                <tbody>
                    @isset($progresses)
                        @foreach ($progresses as $prog)  
                            <tr>
                                <td class = "border border-gray-500 p-3"> {{$prog->exam->title??""}} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{ date('d-m-Y', strtotime($prog->updated_at)) }} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{$prog->score}} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{$prog->exam->maxMarks}} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{round($prog->score/$prog->exam->maxMarks * 100, 1)}}% </td>
                                <td class = "border border-gray-500 text-center p-3"> {{$prog->attempts_remain<=0?"0":$prog->attempts_remain}} </td>
                            </tr>   
                        @endforeach
                    @endisset
                </tbody>
            </table>
        </div>
        
    </div>
</x-admin-layout>