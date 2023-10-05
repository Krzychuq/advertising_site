zdjecie_numer = 0;
liczba_zdjec = zdjecia.length - 1;
if(liczba_zdjec > 0){
    function zdjecie_plus(){
        if(zdjecie_numer < liczba_zdjec){
            zdjecie_numer += 1;
        }
        
        document.getElementById("zdjecie_produktu").setAttribute('src', zdjecia[zdjecie_numer]);
    }
    function zdjecie_minus(){
        if(zdjecie_numer == 1 || zdjecie_numer == 0){
            zdjecie_numer = 0;
        }
        else{
            zdjecie_numer -= 1;
        }

        document.getElementById("zdjecie_produktu").setAttribute('src', zdjecia[zdjecie_numer]);
    }
}