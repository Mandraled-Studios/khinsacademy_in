<x-app-layout>
    <x-slot name="title">
        Score Card
    </x-slot>

    <x-slot name="specialClass2">
        {{ __('selectedTab') }}
    </x-slot>

    <div class="container mx-auto py-6">
        <?php $ans = json_decode($answers, true); ?>
        <div class = "p-3 text-white bg-orange-600 shadow mb-8">
            <h1 class = "text-xl"> You answered {{$answered}} out of {{$questionCount}} questions correctly and scored {{$score}} / {{$maxMarks}} </h1>
        </div>
        <div class = "p-3 text-orange-500 bg-white shadow mb-8">
            <ul type = "none">
                <li class = "mb-2"> Name: {{auth()->user()->name??"Details could not be fetched"}} </li>
                <li class = "mb-2"> Roll No: {{auth()->user()->id??"N/A"}} </li>
            </ul>
        </div>
        @foreach ($questions as $ques)
            <div class = "p-3 flex items-center bg-white shadow mb-4">
                <div class = "w-12 h-12 shrink-0 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center mr-3"> {{$loop->index+1}} </div> 
                <div class="grow w-2/3 lg:w-3/4 xl:w-5/6">
                    <h2 class="font-fold-text-gray-800 text-lg"> {!! $ques->question_part1 !!} </h2>
                    @if ($ques->quesImage != NULL)
                        <div class = "w-72 max-w-full mt-2 py-2"> <img src = {{$ques->quesImage}} class = "w-full" />  </div>
                    @endif
                    <h2 class="font-fold-text-gray-800 text-lg"> {!! $ques->question_part2 !!} </h2>
                </div>
            </div>
            <div class = "mb-8">
                <div class="bg-white shadow px-3 py-3 mb-3 @isset($ans[$loop->index]) @if($ans[$loop->index] == '1') bg-orange-200 @endif @endisset @if($ques->correct_answer == '1') bg-green-400 @endif"> 1) @isset($ans[$loop->index]) @if($ans[$loop->index] == "1") {{ "Your Answer: " }} @endif @endisset {{ $ques->option1 }} @if($ques->correct_answer == "1") {{ "[Correct Answer]" }} @endif </div>
                <div class="bg-white shadow px-3 py-3 mb-3 @isset($ans[$loop->index]) @if($ans[$loop->index] == '2') bg-orange-200 @endif @endisset @if($ques->correct_answer == '2') bg-green-400 @endif"> 2) @isset($ans[$loop->index]) @if($ans[$loop->index] == "2") {{ "Your Answer: " }} @endif @endisset {{ $ques->option2 }} @if($ques->correct_answer == "2") {{ "[Correct Answer]" }} @endif </div>
                <div class="bg-white shadow px-3 py-3 mb-3 @isset($ans[$loop->index]) @if($ans[$loop->index] == '3') bg-orange-200 @endif @endisset @if($ques->correct_answer == '3') bg-green-400 @endif"> 3) @isset($ans[$loop->index]) @if($ans[$loop->index] == "3") {{ "Your Answer: " }} @endif @endisset {{ $ques->option3 }} @if($ques->correct_answer == "3") {{ "[Correct Answer]" }} @endif </div>
                @isset($ques->option4)
                    <div class="bg-white shadow px-3 py-3 mb-3 @isset($ans[$loop->index]) @if($ans[$loop->index] == '4') bg-orange-200 @endif @endisset @if($ques->correct_answer == '4') bg-green-400 @endif"> 4) @isset($ans[$loop->index]) @if($ans[$loop->index] == "4") {{ "Your Answer: " }} @endif @endisset {{ $ques->option4 }} @if($ques->correct_answer == "4") {{ "[Correct Answer]" }} @endif </div>
                @endisset
                @isset($ques->option5)
                    <div class="bg-white shadow px-3 py-3 mb-3 @isset($ans[$loop->index]) @if($ans[$loop->index] == '5') bg-orange-200 @endif @endisset @if($ques->correct_answer == '5') bg-green-400 @endif"> 5) @isset($ans[$loop->index]) @if($ans[$loop->index] == "5") {{ "Your Answer: " }} @endif @endisset {{ $ques->option5 }} @if($ques->correct_answer == "5") {{ "[Correct Answer]" }} @endif </div>
                @endisset
            </div>
        @endforeach
    </div>
</x-app-layout>