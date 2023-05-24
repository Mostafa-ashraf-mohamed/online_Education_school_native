    subject = document.getElementsByClassName('subject') ; 
    gender = document.getElementsByClassName('gender') ;
    Scientific = document.getElementsByClassName('Scientific') ;  
    document.querySelector("#subject").addEventListener("click", function() {
        if(document.querySelector("#subject").checked==false){
        for (let i = 0; i < subject.length; i++) {
            subject[i].disabled=true
        }
    } 
    if(document.querySelector("#subject").checked==true){
        for (let i = 0; i < subject.length; i++) {
            subject[i].disabled=false
        }
    } 
});
document.querySelector("#gender").addEventListener("click", function() {
        if(document.querySelector("#gender").checked==false){
        for (let i = 0; i < subject.length; i++) {
            gender[i].disabled=true
        }
    } 
    if(document.querySelector("#gender").checked==true){
        for (let i = 0; i < subject.length; i++) {
            gender[i].disabled=false
        }
    } 
});
document.querySelector("#Scientific").addEventListener("click", function() {
        if(document.querySelector("#Scientific").checked==false){
        for (let i = 0; i < subject.length; i++) {
            Scientific[i].disabled=true
        }
    } 
    if(document.querySelector("#Scientific").checked==true){
        for (let i = 0; i < subject.length; i++) {
            Scientific[i].disabled=false
        }
    } 
});

// new teacher
const exit = document.querySelector("#exit");
const addT = document.querySelector(".addT");
const create = document.querySelector(".create");

$(create).hide();

addT.addEventListener('click',function(){
    $(create).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(create).fadeOut("slow");
});