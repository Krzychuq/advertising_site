function zniknieciebledu(){
    blad = document.getElementsByClassName('error')[0];
    l=0;
    for(i=100; l < 10;){
        i -= 10;
        blad.style.opacity = i; 
        l++;
    }
} 
const myTimeout = setTimeout(zniknieciebledu, 3000);

