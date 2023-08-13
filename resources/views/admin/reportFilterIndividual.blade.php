<x-admin-layout>
    <x-slot name="title">
        Report
    </x-slot>
    <div class="container mx-auto">
        <div class = "py-4 mb-8">
            <table class = "table w-full">
                <thead class = "bg-gray-800 text-gray-100">
                    <tr>
                        <th class = "uppercase p-3"> Rank </th>
                        <th class = "uppercase p-3"> Roll Number </th>
                        <th class = "uppercase p-3"> Student Name </th>
                        <th class = "uppercase p-3"> Exam Date </th>
                        <th class = "uppercase p-3"> Right Answers </th>
                        <th class = "uppercase p-3"> Your Marks </th>
                        <th class = "uppercase p-3"> Your Percentage </th>
                        <th width="190" class = "uppercase p-3"> Attempts Remaining </th>
                    </tr>
                </thead>
                <tbody class = "border border-gray-500">
                    @foreach ($progresses as $prog)  
                        <tr>
                            <td class = "border border-gray-500 p-3"> {{$loop->iteration}} </td>
                            <td class = "border border-gray-500 p-3"> {{$prog->user->id??"N/A"}} </td>
                            <td class = "border border-gray-500 p-3"> <a href="{{route('admin.reportsViewIndividualStudent', ['quiz' => $prog->quiz_id, 'student' => $prog->user->id])}}"> {{$prog->user->name??""}} </a> </td>
                            <td class = "border border-gray-500 text-center p-3"> {{ date('d-m-Y, h:i A', strtotime($prog->exam_date)) }} </td>
                            <td class = "border border-gray-500 text-center p-3"> {{$prog->answered_correctly}} </td>
                            <td class = "border border-gray-500 text-center p-3"> {{ $prog->score }} out of {{$quiz->max_marks}} </td>
                            <td class = "border border-gray-500 text-center p-3"> {{round($prog->score/$prog->quiz->max_marks * 100)}}% </td>
                            <td class = "border border-gray-500 text-center p-3"> 
                                <form method="POST" action="{{route('admin.quiz.changeStudentAttempt', ['pid' => $prog->id, 'sid' => $prog->user->id])}}">
                                @csrf
                                @method('PATCH')
                                <div class="flex flex-wrap">
                                    <input class="w-24 flex-grow-0" type="number" name="newprogress" value="{{$prog->attempts_remain<=0?"0":$prog->attempts_remain}}" /> 
                                    <input class="cursor-pointer p-2 bg-green-400 text-sm" type="submit" value="Update" />
                                </div>
                                </form>
                            </td>
                        </tr>   
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>