import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';

window.Alpine = Alpine;
Alpine.plugin(focus);
Alpine.start();



console.log("Tabs script running");

Array.from(document.querySelectorAll(".tab-content div.tab-pane:not(.show)")).forEach(tabPane => {
    tabPane.style.display = "none";
});

Array.from(document.querySelectorAll(".tabs-nav .nav-item a")).forEach(tab => {
    tab.addEventListener("click", function(ev) {
        ev.preventDefault(); 
        Array.from(document.querySelectorAll('.tabs-nav .nav-item a')).forEach(myTab => {
            myTab.classList.remove('bg-orange-200');
        });

        tab.classList.add('bg-orange-200');

        let currentTab = tab.getAttribute('href');
        Array.from(document.querySelectorAll(".tab-content div.tab-pane")).forEach(myTabPane => {
            myTabPane.classList.remove('show');
            myTabPane.style.display = "none";
        });
        
        document.querySelector(currentTab).style.display="block";
        document.querySelector(currentTab).classList.add('show');

    }, false);
});