<x-examhall-layout>
    <x-slot name="title">
        Quiz
    </x-slot>

    <x-slot name="specialClass2">
        {{ __('selectedTab') }}
    </x-slot>

    <x-slot name="pagescript">
        <script>
            const beforeUnloadListener = (event) => {
                event.preventDefault();
                return event.returnValue = "Are you sure you want to refresh / exit this page? You will lose all your answers and the progress in this exam!";
            };
        
            if (document.getElementById("props").dataset.completion == "false") {
                window.addEventListener("beforeunload", beforeUnloadListener, false);
            } else {
                window.removeEventListener("beforeunload", beforeUnloadListener, false);
            }
        
        </script>

        <script>
            let allQuestions, examHall, examID;
            let currentQuestion = 0;
            let allAnswersInString, allAnswers = new Array();
            let submitField, questionId, allNextButtons, allClearButtons, allMarkButtons;
            let openPaletteBtn = document.querySelector(".ms-palette-btn");
            let closePaletteBtn = document.querySelector("#ms-close-palette-btn");
            
            const waitForQuestions = function() {
                examHall = document.getElementById("mandraled-exam-center");
                examID = examHall.dataset.examid;
                allQuestions = document.querySelectorAll(".ms-exam-ques");
                allNextButtons = document.querySelectorAll(".ms-next-btn");
                allClearButtons = document.querySelectorAll(".ms-clear-btn");
                allMarkButtons = document.querySelectorAll(".ms-mark-btn");
                submitField = document.getElementById("ms-student-answers");
                
                //Wait for page to load with all questions
                if(!submitField || !examHall || !allQuestions || allQuestions.length<1) {
                    setTimeout(waitForQuestions, 500)
                    return;
                }
                
                //Once loaded, set the first question to be visible
                if(allQuestions[currentQuestion] && allQuestions[currentQuestion].dataset.questionid == currentQuestion) {
                    allQuestions[currentQuestion].classList.remove("hidden");
                }
                
                let cookieName = "mandraled-khins-exam-"+examID;
                
                //Clear Cookie when exam begins
                setCookie(cookieName, "", -1);
                
                //When Next button is clicked
                Array.from(allNextButtons).forEach(nextBtn => {
                nextBtn.addEventListener("click", function() {
                    
                    let targetNode = "#ms-exam-ques-"+nextBtn.dataset.questionid+" input[type='radio']";
                    let targetNode2 = "#ms-exam-ques-"+nextBtn.dataset.questionid+" .questionId";
                    let questionId = document.querySelector(targetNode2).value;
                    let chosenOption;

                    Array.from(document.querySelectorAll(targetNode)).forEach(option => {
                        //Check if any of the option is selected
                        if(option.checked) {
                            chosenOption = option.value;
                            document.querySelectorAll(".ms-questionSkipper")[nextBtn.dataset.questionid].classList.remove("ms-skipped");
                            document.querySelectorAll(".ms-questionSkipper")[nextBtn.dataset.questionid].classList.remove("ms-marked");
                            document.querySelectorAll(".ms-questionSkipper")[nextBtn.dataset.questionid].classList.add("ms-attended");
                        }
                    });
                    
                    //If none are selected, set answer to NULL
                    if(!chosenOption) {
                        chosenOption = null;
                        document.querySelectorAll(".ms-questionSkipper")[nextBtn.dataset.questionid].classList.remove("ms-attended");
                        document.querySelectorAll(".ms-questionSkipper")[nextBtn.dataset.questionid].classList.remove("ms-marked");
                        document.querySelectorAll(".ms-questionSkipper")[nextBtn.dataset.questionid].classList.add("ms-skipped");
                    }
                    
                    let myObj = allAnswers.find(obj => obj.quesID == questionId);
                    
                    //Store answers
                    
                    if(myObj) {
                        let myObj2 = allAnswers.find((obj, i) => {
                                if (obj.quesID == questionId) {
                                    allAnswers[i] = { sno: currentQuestion, quesID: questionId, chosenOption: chosenOption };
                                    return true; // stop searching
                                }
                        });
                    } else {
                        allAnswers.push({
                            sno: currentQuestion,
                            quesID: questionId,
                            chosenOption: chosenOption
                        });
                    }
                    
                    allAnswersInString = JSON.stringify(allAnswers);
                    
                    setCookie(cookieName, allAnswersInString, 1);
                    
                    submitField.value = allAnswersInString;
                    
                    //Check if last question
                    if(currentQuestion < allQuestions.length - 1) {
                        currentQuestion++;
                    }
                    
                    //Progress to next question
                    if(allQuestions[currentQuestion] && allQuestions[currentQuestion].dataset.questionid == currentQuestion) {
                            allQuestions[currentQuestion-1].classList.add("hidden");
                            allQuestions[currentQuestion].classList.remove("hidden");
                            getRadioState(currentQuestion);
                    }
                    
                }, false); 
                });
                
                //When Mark for Review button is clicked
                Array.from(allMarkButtons).forEach(markBtn => {
                markBtn.addEventListener("click", function() {
                    
                    let targetNode = "#ms-exam-ques-"+markBtn.dataset.questionid+" input[type='radio']";
                    let targetNode2 = "#ms-exam-ques-"+markBtn.dataset.questionid+" .questionId";
                    let questionId = document.querySelector(targetNode2).value;
                    let chosenOption;

                    Array.from(document.querySelectorAll(targetNode)).forEach(option => {
                        //Check if any of the option is selected
                        if(option.checked) {
                            chosenOption = option.value;
                            document.querySelectorAll(".ms-questionSkipper")[markBtn.dataset.questionid].classList.remove("ms-skipped");
                            document.querySelectorAll(".ms-questionSkipper")[markBtn.dataset.questionid].classList.remove("ms-attended");
                            document.querySelectorAll(".ms-questionSkipper")[markBtn.dataset.questionid].classList.add("ms-marked");
                        }
                    });
                    
                    //If none are selected, set answer to NULL
                    if(!chosenOption) {
                        chosenOption = null;
                        document.querySelectorAll(".ms-questionSkipper")[markBtn.dataset.questionid].classList.remove("ms-attended");
                        document.querySelectorAll(".ms-questionSkipper")[markBtn.dataset.questionid].classList.remove("ms-skipped");
                        document.querySelectorAll(".ms-questionSkipper")[markBtn.dataset.questionid].classList.add("ms-marked");
                    }
                    
                    let myObj = allAnswers.find(obj => obj.quesID == questionId);
                    
                    //Store answers
                    
                    if(myObj) {
                        let myObj2 = allAnswers.find((obj, i) => {
                                if (obj.quesID == questionId) {
                                    allAnswers[i] = { sno: currentQuestion, quesID: questionId, chosenOption: chosenOption };
                                    return true; // stop searching
                                }
                        });
                    } else {
                        allAnswers.push({
                            sno: currentQuestion,
                            quesID: questionId,
                            chosenOption: chosenOption
                        });
                    }
                    
                    allAnswersInString = JSON.stringify(allAnswers);
                    
                    setCookie(cookieName, allAnswersInString, 1);
                    
                    submitField.value = allAnswersInString;
                    
                    //Check if last question
                    if(currentQuestion < allQuestions.length - 1) {
                        currentQuestion++;
                    }
                    
                    //Progress to next question
                    if(allQuestions[currentQuestion] && allQuestions[currentQuestion].dataset.questionid == currentQuestion) {
                            allQuestions[currentQuestion-1].classList.add("hidden");
                            allQuestions[currentQuestion].classList.remove("hidden");
                            getRadioState(currentQuestion);
                    }
                    
                }, false); 
                });
                
                //When Clear button is clicked
                Array.from(allClearButtons).forEach(clearBtn => {
                clearBtn.addEventListener("click", function() {
                    
                    let targetNode = "#ms-exam-ques-"+clearBtn.dataset.questionid+" input[type='radio']";
                    let targetNode2 = "#ms-exam-ques-"+clearBtn.dataset.questionid+" .questionId";
                    let questionId = document.querySelector(targetNode2).value;
                    let chosenOption;

                    Array.from(document.querySelectorAll(targetNode)).forEach(option => {
                        //Check if any of the option is selected
                        if(option.checked) {
                            option.checked = false;
                            document.querySelectorAll(".ms-questionSkipper")[clearBtn.dataset.questionid].classList.remove("ms-attended");
                            document.querySelectorAll(".ms-questionSkipper")[clearBtn.dataset.questionid].classList.remove("ms-marked");
                            document.querySelectorAll(".ms-questionSkipper")[clearBtn.dataset.questionid].classList.add("ms-skipped");
                        }
                    });
                    
                    let myObj = allAnswers.find((obj, i) => {
                            if (obj.quesID == questionId) {
                                allAnswers[i] = { sno: currentQuestion, quesID: questionId, chosenOption: null };
                                return true; // stop searching
                            }
                    });
                    
                    allAnswersInString = JSON.stringify(allAnswers);
                    
                    setCookie(cookieName, allAnswersInString, 1);
                    
                    submitField.value = allAnswersInString;
                    
                }, false); 
                });
                
                openPaletteBtn.addEventListener("click", function(){
                    document.getElementById("ms-question-palette").classList.remove("hidden");
                }, false);
                
                closePaletteBtn.addEventListener("click", function(){
                    document.getElementById("ms-question-palette").classList.add("hidden");
                }, false);
                
            };
            
            waitForQuestions();
            
            const questionSkipper = function() {
                let skippers = document.querySelectorAll(".ms-questionSkipper");
                
                if(!allQuestions || skippers.length<1) {
                    setTimeout(questionSkipper, 500)
                    return;
                }
                
                Array.from(skippers).forEach(skipper => {
                    skipper.addEventListener("click", function() {
                        currentQuestion = skipper.dataset.skiptoid;
                        
                        Array.from(allQuestions).forEach(ques => {
                            ques.classList.add("hidden");
                        });
                        
                        //Once loaded, set the first question to be visible
                        if(allQuestions[currentQuestion] && allQuestions[currentQuestion].dataset.questionid == currentQuestion) {
                            allQuestions[currentQuestion].classList.remove("hidden");
                            getRadioState(currentQuestion);
                        }
                    }, false);   
                });
            };
            
            questionSkipper();
            
            function setCookie(cname, cvalue, exdays) {
            const d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            let expires = "expires="+d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
            //document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/" + "/;domain=admin.khinsacademy.com";
            }
            
            function getCookie(cname) {
            let name = cname + "=";
            let cookiearray = document.cookie.split(';');
            for(let i = 0; i < cookiearray.length; i++) {
                let c = cookiearray[i];
                while (c.charAt(0) == ' ') {
                c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
                }
            }
            return "";
            }
            
            function getRadioState(qno) {
                if(allQuestions[qno] && allQuestions[qno].dataset.questionid == qno) {
                    for(j=0; j<allAnswers.length; j++) {
                        if(allAnswers[j]['sno'] == qno) {
                            let state = allAnswers[j]['chosenOption'];
                            
                            let targetNode = "#ms-exam-ques-"+qno+" input[type='radio']";
                        
                            Array.from(document.querySelectorAll(targetNode)).forEach(option => {
                            //Check if any of the option is selected
                            if(option.value == state) {
                                option.checked = true;
                            }
                            });
                        }
                    }
            }
            }
            
            function compareAnswersWithCookie() {
                let examHall = document.getElementById("mandraled-exam-center");
                let examID = examHall.dataset.examid;
                let cookieName = "mandraled-khins-exam-"+examID;
                let allQuestions = document.querySelectorAll(".ms-exam-ques");
                let matchingAnswers = 0;
                let answerInArray = 0;

                let cookieString = getCookie(cookieName);
                let userAnswers = JSON.parse(cookieString);
                
                for(i=0; i<allQuestions.length; i++) {
                    if(allAnswers[i] && userAnswers[i]) {
                        if(allAnswers[i] == userAnswers[i]) {
                            matchingAnswers++;
                        }
                    
                        if(allAnswers[i]['chosenOption'] != null) {
                            answerInArray++;
                        } else {
                            if(userAnswers[i]['chosenOption'] != null) {
                                allAnswers[i] = userAnswers[i];
                            }
                        }
                    } else {
                        if(userAnswers[i]) {
                            if(userAnswers[i]['chosenOption'] != null) {
                                allAnswers[i] = userAnswers[i];
                            }
                        }
                    }
                    
                }
                
                allAnswersInString = JSON.stringify(allAnswers);
                    
                setCookie(cookieName, allAnswersInString, 1);
                    
                document.getElementById("ms-student-answers").value = allAnswersInString;
                
                console.log("Final Submit:" + allAnswersInString)
            }
            
        </script>

        <script>
            let hrs, mins, secs;
            let exam;

            window.addEventListener("load", function () {

                exam = document.getElementById("props").dataset.exam;
                slug = document.getElementById("props").dataset.slug;
                user = document.getElementById("props").dataset.user;

                console.log(exam, slug, user);

                var path = "/api/ajax/timer/" + slug + "/" + user;

                var xhttp = new XMLHttpRequest();
                
                xhttp.onreadystatechange = function () {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("timer").innerHTML = this.responseText;
                        hrs = parseInt(this.responseText.substr(1, 2));
                        mins = parseInt(this.responseText.substr(4, 2));
                        secs = parseInt(this.responseText.substr(7, 2));
                        console.log(hrs, mins, secs);
                        if (this.responseText == "Time Up") {
                            //window.location = "/online-exams/" + slug + "/stage3/timeup";
                            Array.from(document.querySelectorAll(".ms-exam-ques")).forEach(card => {
                                card.parentNode.removeChild(card);
                            });
                            document.getElementById("timer").innerHTML = "";
                            
                            setTimeout(() => {
                                document.getElementById("ms-exam-final-submit").click();
                            }, 1000);
                        }

                    }
                };

                xhttp.open("GET", path, true);
                //xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                //xhttp.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute("content"));
                xhttp.send();

                var mytimer = setInterval(function () {
                    secs = secs - 1;
                    if (secs < 0) {
                        secs = 59;
                        mins = mins - 1;
                        if (mins < 0) {
                            mins = 59;
                            hrs = hrs - 1;
                            if (hrs < 0) {
                                //window.location = "/online-exams/" + slug + "/stage3/timeup";
                                Array.from(document.querySelectorAll(".ms-exam-ques")).forEach(card => {
                                    card.parentNode.removeChild(card);
                                });
                                
                                clearInterval(mytimer);
                                document.getElementById("timer").innerHTML = "";
                                
                                setTimeout(() => {
                                    document.getElementById("ms-exam-final-submit").click();
                                }, 1000);
                            }
                        }
                    }

                    hrs = parseInt(hrs);
                    mins = parseInt(mins);
                    secs = parseInt(secs);
                    if (hrs < 10) hrs = "0" + hrs;
                    if (mins < 10) mins = "0" + mins;
                    if (secs < 10) secs = "0" + secs;

                    document.getElementById("timer").innerHTML = hrs + ":" + mins + ":" + secs;
                }, 1000);
            }, false);


        </script>
    </x-slot>

    <div class="container mx-auto py-6">
        <div class = "bg-orange-200 border-2 border-orange-400 mb-8 px-4 py-6"> 
            <h2 class="text-xl font-bold"> {{$title}} </h2> 
        </div>
        
        <div id="props" class = "hidden" data-completion = "false" data-slug="{{ $slug }}" data-user = {{ auth()->user()->id }} data-exam = {{ $quizID }} ></div>
        
        <div class="flex items-center flex-wrap font-bold justify-end px-3 py-3 mb-4">
            <h2 class = "text-xl text-gray-900 mr-3"> Time Left: </h2>
            <p class = "p-1" id = "timer"></p>
            <button class="ms-palette-btn md:hidden"> View Palette </button>
        </div>
        
        <main class = "lg:grid lg:grid-cols-12" id="mandraled-exam-center" data-examid="{{$quizID}}">
            <section class="px-6 py-3 col-span-8">
                <form>
                @foreach($questions as $question)
                    <div id="ms-exam-ques-{{$loop->index}}" class="ms-exam-ques hidden" data-questionid = "{{$loop->index}}">
                        <div class = "p-3 flex items-center bg-white shadow mb-4"> 
                            <div class = "w-12 h-12 rounded-full bg-orange-400 text-white flex flex-col justify-center items-center mr-3"> {{$loop->index + 1}} </div>
                            <div class = "block text-sm flex-1 mr-3"> {!! $question->question_part1 !!} </div>
                            <input type="hidden" class="questionId" value="{{ $question->id }}" />
                        </div>
                         @if ($question->quesImage != NULL)
                            <div class = "w-72 mt-2"> <img src = {{$question->quesImage}} class = "w-full" />  </div>
                         @endif
                         <div class = "block text-sm flex-1 mr-3"> {!! $question->question_part2 !!} </div>
                        <div class="mt-2 mb-12">
                            <div class="bg-white shadow px-3 py-5 mb-3 flex justify-start"> <label class = "cursor-pointer"> <input type="radio" name="chosenAnswer" value="1" class = "mr-3" /> {{ $question->option1 }} </label> </div>
                            <div class="bg-white shadow px-3 py-5 mb-3 flex justify-start"> <label class = "cursor-pointer"> <input type="radio" name="chosenAnswer" value="2" class = "mr-3" /> {{ $question->option2 }} </label> </div>
                            <div class="bg-white shadow px-3 py-5 mb-3 flex justify-start"> <label class = "cursor-pointer"> <input type="radio" name="chosenAnswer" value="3" class = "mr-3" /> {{ $question->option3 }} </label> </div>
                            @isset($question->option4)
                                <div class="bg-white shadow px-3 py-5 mb-3 flex justify-start"> <label class = "cursor-pointer"> <input type="radio" name="chosenAnswer" value="4" class = "mr-3" /> {{ $question->option4 }} </label> </div>
                            @endisset
                            @isset($question->option5)
                                <div class="bg-white shadow px-3 py-5 mb-3 flex justify-start"> <label class = "cursor-pointer"> <input type="radio" name="chosenAnswer" value="5" class = "mr-3" /> {{ $question->option5 }} </label> </div>
                            @endisset
                        </div>
                        
                        <div class = "p-3 flex flex-wrap items-center justify-between">
                            <div>
                                <button type="button" id="ms-next-btn-{{$loop->index}}" class = "px-5 py-2 text-gray-800 bg-green-400 rounded-lg rounded-lg mx-2 my-3 ms-next-btn" data-questionid = "{{$loop->index}}"> Save Answer &amp; Continue To Next </button>
                                <button type="button" id="ms-mark-btn-{{$loop->index}}" class = "px-5 py-2 text-gray-800 bg-purple-400 rounded-lg rounded-lg mx-2 my-3 ms-mark-btn" data-questionid = "{{$loop->index}}"> Mark For Review &amp; Go To Next </button>
                            </div>
                            <button type="button" id="ms-clear-btn-{{$loop->index}}" class = "ms-min-w-8 px-5 py-2 text-white bg-gray-400 rounded-lg rounded-lg mx-2 my-3 ms-clear-btn" data-questionid = "{{$loop->index}}"> Clear Answer </button>
                        </div>
                    </div>
                @endforeach
                </form>
            </section>
        
            <aside class = "col-span-4 px-3 py-4">
            <div id="ms-question-palette" class="hidden absolute top-12 right-4 w-10/12 z-50 md:block md:static bg-white flex flex-col justify-between p-4 shadow">
                <div class="flex justify-between">
                    <h2 class = "text-xl text-gray-900 mb-5 py-3"> Question Palette: </h2>
                    <button id="ms-close-palette-btn" class="md:hidden"> x </button>
                </div>
                <div class="grid grid-cols-5 px-3 mb-8">
                    @for ($qno = 1; $qno <= $totalQues; $qno++)
                        <button class = "ms-questionSkipper px-3 py-2 text-gray-800 bg-gray-100 rounded-lg rounded-lg mx-1 mb-1" data-skiptoid = "{{$qno-1}}"> {{$qno}} </button>
                    @endfor
                </div>
                <form action = "{{route('students.quiz.submit', ['slug' => $slug ])}}" method = "POST">
                    @csrf
                    <input type="hidden" id="ms-student-answers" name="studentAnswers" value="" />
                    
                    <div class="py-2">
                        <button id="ms-exam-final-submit" type = "button" onclick="event.preventDefault();
                                        if(confirm('Are you sure you want to submit the assessment for evaluation?')){
                                            this.parentNode.parentNode.submit();
                                        }"  name = "Save" class = "px-4 py-3 text-white cursor-pointer bg-emerald-500 hover:bg-emerald-600"> 
                            Submit For Evaluation 
                        </button>
                    </div>    
                </form>
            </div>
        </aside>
        </main>
    </div>
    

</x-examhall-layout>