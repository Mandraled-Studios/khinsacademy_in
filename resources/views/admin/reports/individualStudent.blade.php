<x-admin-layout>
    <x-slot name="title">
        Individual Student Report
    </x-slot>

    <h3 class = "text-xl font-bold mb-4 text-uppercase"> {{$student->name??"Student Name could not be fetched"}} (Roll No: {{$student->rollno??"N/A"}}) </h3>
    
    <div class="container mx-auto py-6">
        <?php 
            $ans = json_decode($progresses['userAnswer'], true); 
            $maxMarks = $exam->max_marks;
            $questionCount = $questions->count();
            $score = $progresses->score;
        ?>
        <div class = "p-3 text-white bg-orange-600 shadow mb-8">
            <h1 class = "text-xl"> Student scored {{ $score }} / {{$maxMarks}} </h1>
        </div>
        
        <div class="ms-tabs-nav flex justify-center">
            <ul class="flex flex-wrap my-8" id="pills-tab">
                @foreach ($questions as $ques)
                    <li class="nav-item mb-1">
                        <a class="w-12 h-12 rounded-full @isset($ans[$loop->index]) @if($ques->correct_answer == $ans[$loop->index]) bg-green-400 @else bg-orange-400 @endif @else bg-gray-400 @endisset text-white flex flex-col justify-center items-center mr-3" 
                           id="pills-{{$loop->index+1}}-tab" href="#tab{{$loop->index+1}}"> 
                            {{$loop->index+1}} 
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
            
        <div class="ms-tab-content" id="pills-tabContent">
            @foreach ($questions as $ques)
                <div class="ms-tab-pane show" id="tab{{$loop->index+1}}" style="">
                    <div class = "p-3 flex items-center bg-white shadow mb-4">
                        <div style="flex-shrink:0;" class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center mr-3"> {{$loop->index+1}} </div> 
                        <div>
                        <h2 class="font-fold-text-gray-800 text-lg"> {!! $ques->question_part1 !!} </h2>
                        @isset($ques->quesImage)
                          <img class="w-72 object-contain object-center max-w-full" src="{{$ques->quesImage}}" />
                        @endisset
                        @isset($ques->question_part2)
                        <h2 class="font-fold-text-gray-800 text-lg"> {!! $ques->question_part2 !!} </h2>
                        @endisset
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
                </div>
            @endforeach
        </div>
    </div>
    
    <script>
      Array.from(document.querySelectorAll('.ms-tab-content div.ms-tab-pane')).forEach(pane => {
         pane.classList.add("hidden"); 
      });
      
      Array.from(document.querySelectorAll('.ms-tabs-nav .nav-item a')).forEach(tab => {
        tab.addEventListener("click", function (ev) {
            ev.preventDefault();
            var currentTab = this.getAttribute('href');
            
            Array.from(document.querySelectorAll('.ms-tab-content div.ms-tab-pane')).forEach(pane => {
                pane.classList.add("hidden"); 
            });
            
            console.log(currentTab);
            
            document.querySelector(currentTab).classList.remove("hidden");
     
        }, false);
      });
    </script>
</x-admin-layout>