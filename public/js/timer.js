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

