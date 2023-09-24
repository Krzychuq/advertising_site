document.getElementsByTagName('body')[0].insertAdjacentHTML('afterbegin','<div id=loading></div>');
var liczba_formularzy = document.getElementsByTagName('form').length;
if(liczba_formularzy > 0){
for(numer = 0; numer <= liczba_formularzy;){
    formularz = document.getElementsByTagName('form')[numer];
    document.getElementsByTagName('form')[numer].setAttribute('onsubmit', 'return loading()');
    numer++;
}
}
function loading(){
    document.getElementById('loading').insertAdjacentHTML('beforebegin',
    '<div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>');
    document.getElementsByClassName('menu_nav')[0].style.opacity = '0.5';
    document.getElementsByClassName('menu_nav')[0].style.filter = 'blur(4px)';

    document.getElementsByClassName('contener')[0].style.opacity = '0.5';
    document.getElementsByClassName('contener')[0].style.filter = 'blur(4px)';

    document.getElementsByClassName('footer')[0].style.opacity = '0.5';
    document.getElementsByClassName('footer')[0].style.filter = 'blur(4px)';
}
