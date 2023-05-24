const exit = document.querySelector("#exit");
const New = document.querySelector("#new");
const back = document.querySelector(".back-new-comm");

$(back).hide();

New.addEventListener('click',function(){
    $(back).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(back).fadeOut("slow");
});