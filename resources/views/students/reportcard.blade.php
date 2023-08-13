<x-app-layout>
    <x-slot name="title">
        My Report Card
    </x-slot>
    <div class="container mx-auto py-6">
        <div class="container mx-auto py-6">
            <div class = "table-responsive">
                <table class = "table w-full border border-gray-500">
                    <thead class = "bg-gray-800 text-gray-100">
                        <tr>
                            <th class = "uppercase p-3"> S.No </th>
                            <th class = "uppercase p-3"> Exam Title </th>
                            <th class = "uppercase p-3"> Exam Date </th>
                            <th class = "uppercase p-3"> Right Answers </th>
                            <th class = "uppercase p-3"> Your Marks </th>
                            <th class = "uppercase p-3"> Your Percentage </th>
                            <th class = "uppercase p-3"> Attempts Remaining </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($progresses as $prog)
                            @if($prog->score !== NULL)
                            <tr>
                                <td class = "border border-gray-500 text-center p-3"> {{$loop->index+1}} </td>
                                <td class = "border border-gray-500 p-3"> {{$prog->quiz->title}} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{ date('d-m-Y', strtotime($prog->exam_date)) }} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{ $prog->answered_correctly }} out of {{$prog->quiz->questions()->count()}}</td>
                                <td class = "border border-gray-500 text-center p-3"> {{ $prog->score }} out of {{$prog->quiz->max_marks}} </td>
                                <td class = "border border-gray-500 text-center p-3"> {{round($prog->score/$prog->quiz->max_marks * 100)}}% </td>
                                <td class = "border border-gray-500 text-center p-3"> {{$prog->attempts_remain<=0?"0":$prog->attempts_remain}} </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>