window.addEventListener('DOMContentLoaded', function(){

       switchColor.addEventListener('click', nighmode);
       function nighmode(){
           body = document.querySelector('body');
           body.classList.toggle('color2');
       }
    switchColor.addEventListener('click', night);


    if (sessionStorage.night) {
        if(sessionStorage.night==="1"){
            document.querySelector('body').classList.add('color2');
        }
    }

    function night() {
        if(sessionStorage.night=="1"){
            sessionStorage.setItem("night","0");
        }else {
            sessionStorage.setItem("night","1");
        }
    }
});