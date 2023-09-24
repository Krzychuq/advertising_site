function zniknieciepowiadomienia(){
    powiadomienie = document.getElementsByClassName('success')[0];
    l=0;
    for(i=100; l < 10;){
        i -= 10;
        powiadomienie.style.opacity = i; 
        l++;
    }
} 
const czas = setTimeout(zniknieciepowiadomienia, 3000);