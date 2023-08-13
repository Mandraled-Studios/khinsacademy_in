<x-app-layout>
    <x-slot name="title">
        About the Quiz
    </x-slot>

    <div class="container mx-auto py-6">
        <div class="px-4 py-6 bg-white shadow mb-4">
            <p class="text-base mb-3"> {{$quiz->description}} </p>
            <p class="text-base mb-3"> Attempts remaining: {{ $attempts > 0 ? $attempts : "0"}} </p>
            <p class="text-base mb-6"> Time Limit : {{ floor($quiz->max_mins/60) }} hours <?php $mins = $quiz->max_mins%60; echo ($mins!=0)?("and ".$mins." minutes."):"." ?> </p>
            <hr class = "mb-6" />
            @if ($attempts>0)
                <h2 class = "text-xl font-bold mt-6 mb-3"> Instructions </h2>
                <p class = "mb-6"> Read each instruction carefully before clicking on the "Start Exam" button. The exam commences and the timer starts immediately after you click the "Start Exam" button </p>
                <h3 class = "text-lg font-bold mb-3"> Before the exam: </h3>
                <ol class = "list-decimal pl-6 mb-4">                
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/devices.svg') }}" alt="instruction-icon">  
                        <span class="block font-bold text-lg"> உங்கள் சாதனம் (மொபைல் / டேப்லெட் / லேப்டாப் / டெஸ்க்டாப்) தயாராக உள்ளதா என்பதை உறுதிப்படுத்திக் கொள்ளுங்கள் </span>
                        <span class="block text-base"> Make sure your device (mobile / tablet / laptop / desktop) is ready before for appearing for the online exam. </span>
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/network.svg') }}" alt="instruction-icon"> 
                        <span class="block font-bold text-lg"> உங்களிடம் நல்ல வேகமான மற்றும் நிலையான இணைய இணைப்பு இருப்பதை உறுதிப்படுத்திக் கொள்ளுங்கள். </span> 
                        <span class="block text-base"> Make sure you have a good and stable internet connection. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/clock.svg') }}" alt="instruction-icon"> 
                        <span class="block font-bold text-lg"> அறிவுறுத்தப்பட்ட நேரத்தில் நீங்கள் தேர்வைத் தொடங்குவதை உறுதிசெய்க. </span> 
                        <span class="block text-base"> Make sure you start the exam in the instructed time. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/other-tab.svg') }}" alt="instruction-icon"> 
                        <span class="block font-bold text-lg"> 
                            ஆன்லைன் தேர்வின் போது தேர்வு இணைப்பைத் தவிர உங்கள் உலாவியில் வேறு எந்த இணைப்பு / தாவலையும் திறக்கவில்லை என்பதை உறுதிப்படுத்திக் கொள்ளுங்கள். </span> 
                        <span class="block text-base"> Make sure you DO NOT open any other link / tab on your browser apart from the exam link during the online exam. </span>

                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/reading.svg') }}" alt="instruction-icon"> 
                        <span class="block font-bold text-lg"> அனைத்து வழிமுறைகளையும் கவனமாகப் படியுங்கள். எந்தவொரு தெளிவுக்கும் கொடுக்கப்பட்ட வாட்ஸ்அப் எண் / குழுவின் மூலம் எங்களைத் தொடர்பு கொள்ளுங்கள். </span> 
                        <span class="block text-base"> Read all the instructions carefully. Contact us through the given contact number / whatsapp group for any clarifications. </span> 
                    </li>
                </ol>    
                <h3 class = "text-lg font-bold mb-3"> During the exam: </h3>
                <ol class = "list-decimal pl-6 mb-4">
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/warn.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> Do not close or resize the browser during the exam </span> 
                        <span class = "block text-base"> ஆன்லைன் தேர்வின் போது உலாவியின் அளவை மாற்றவோ குறைக்கவோ வேண்டாம். </span> </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/close.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> உங்கள் தேர்வு முடிவடைவதற்கு முன்பு உலாவியை மூட வேண்டாம். </span> 
                        <span class = "block text-base"> Do not close the browser during the test / before your exam is complete. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/back.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> தேர்வின் போது உலாவியின் 'பின் (BACK)' அல்லது 'புதுப்பிப்பு (REFRESH)' பொத்தானைக் கிளிக் செய்யக்கூடாது. </span> 
                        <span class = "block text-base"> Do not click the ‘BACK’ or 'REFRESH' button of browser during exam. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/timer.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> உலாவியின் ஆன்லைன் தேர்வு பக்கத்தின் மேல் வலதுபுறத்தில் உள்ள TIMER / CLOCK - ஐ மீதமுள்ள நேரத்தை கண்காணிக்க கவனியுங்கள்.</span> 
                        <span class = "block text-base"> Keep an eye on the TIMER / CLOCK on top right of the online exam page of the browser to keep a track of 
                                                         the time left.  </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/interacting.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> வலைத்தளம் உங்களை தானாக வெளியேற்றுவதைத் தடுக்க 5 நிமிடங்களுக்கு மேல் ஆன்லைன் தேர்வு உலாவி பக்கத்தை எதுவும் செய்யாமல் விட வேண்டாம். தேர்வின் போது கர்சரை (லேப்டாப் / டெஸ்க்டாப்பிற்கு) நகர்த்துங்கள் அல்லது திரையில் (மொபைலுக்கு) அடிக்கடி தொடவும். </span> 
                        <span class = "block text-base"> Do not leave the online exam browser page idle for more than 5 minutes to prevent the website from logging you out automatically. 
                                                         Keep moving the cursor (for laptop / desktop) or touch the screen (for mobile) frequently during the exam. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/submit.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> தேர்வில் உள்ள அனைத்து கேள்விகளுக்கும் பதிலளித்த பிறகு, உங்கள் கடைசி கேள்வியில் பக்கத்தின் கீழே உள்ள "மதிப்பீடு செய்ய சமர்ப்பி (SUBMIT FOR EVALUATION)" பொத்தானைக் கிளிக் செய்க. </span> 
                        <span class = "block text-base"> After answering all the questions in the exam, click on the "SUBMIT FOR EVALUATION" button at the bottom of the page in your last question. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/ok.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> SUBMIT பொத்தானைக் கிளிக் செய்வதன் மூலம் தோன்றும் பாப்-அப்பில், மதிப்பீட்டிற்கான உங்கள் பதில்களைச் சமர்ப்பிக்க "OK" என்று கிளிக் செய்க.</span> 
                        <span class = "block text-base"> On the window that pops up on clicking the SUBMIT button, click on "OK" to submit your answers for evaluation. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/cancel.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> தேர்வு பக்கத்தில் உள்ள கேள்விகளுக்கு நீங்கள் திரும்பிச் செல்ல விரும்பினால், பாப் அப் இல் உள்ள "ரத்து செய் (CANCEL)" பொத்தானைக் கிளிக் செய்க. </span> 
                        <span class = "block text-base"> If you want to go back to the questions in exam page, click on the "CANCEL" button on the pop up. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/success.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> சமர்ப்பித்ததும், "உங்கள் தேர்வு வெற்றிகரமாக சமர்ப்பிக்கப்பட்டுள்ளது" என்ற செய்தி காண்பிக்கப்படும், அப்போதுதான் மாணவர் ஆன்லைன் போர்ட்டலில் இருந்து வெளியேறுவது பாதுகாப்பானது. </span> 
                        <span class = "block text-base"> Once submitted, a message shall be displayed “Your Exam has been submitted successfully" and only then it is safe to logout from the student online portal.  </span> 
                    </li>
                </ol>
                <h3 class = "text-lg font-bold mb-3"> General instructions: </h3>
                <ol class = "list-decimal pl-6 mb-6">
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/home.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> பரீட்சையின் முழு செயல்முறையிலும் எந்தவித இடையூறும் இல்லாமல் ஒரு அறையில் தனியாக உட்கார்ந்து ஆன்லைன் தேர்வில் கலந்துகொள்வதை உறுதிப்படுத்திக் கொள்ளுங்கள். </span> 
                        <span class = "block text-base"> Make sure you attend the online exam sitting alone in a room with no disturbance during the entire process of the exam. </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/paper.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> சோதனை வேலை / கணக்கீடு தேவைப்படும் பாடங்களுக்கு, உங்களிடம் வெற்று தாள் இருப்பதை உறுதிப்படுத்திக் கொள்ளுங்கள் </span> 
                        <span class = "block text-base"> For subjects that requires rough work / calculation, make sure you have a blank sheet </span> 
                    </li>
                    <li class = "mb-8 py-6 px-4 border-b border-orange-600">
                        <img class = "mb-2 h-48" src="{{ asset('images/icons/instructions/denied.svg') }}" alt="instruction-icon">
                        <span class = "block font-bold text-lg"> ஆன்லைன் தேர்வின் முழுப் போக்கில் எந்தவொரு மாணவரும் ஏதேனும் நியாயமற்ற வழிகளைப் பயன்படுத்துவதாகக் கண்டறியப்பட்டால், அந்த மாணவரின் தேர்வு தகுதி நீக்கம் செய்யப்படும் </span> 
                        <span class = "block text-base"> If any student is found to use any unfair means during the entire course of the online exam, that student’s exam will be disqualified </span> 
                    </li>
                </ol>
                
                <form action="{{route('students.quiz.setup', ['slug' => $quiz->slug])}}" method="POST">
                    @csrf
                    <input type="submit" class="px-4 py-2 bg-orange-400 text-white hover:bg-orange-500" value="Start Exam" /> 
                </form>
            
            @else
                <a href="{{route('students.quiz.pdf', ['slug' => $quiz->slug])}}" class="px-4 py-2 bg-orange-400 text-white hover:bg-orange-500"> View PDF of Questions </a> 
            @endif
        </div>
    </div>
    
</x-app-layout>