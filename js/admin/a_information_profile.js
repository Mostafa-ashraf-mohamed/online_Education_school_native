const exit = document.querySelector("#exit");
const show = document.querySelector("#show");
const comments = document.querySelector(".comments");

$(comments).hide();

show.addEventListener('click',function(){
    $(comments).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(comments).fadeOut("slow");
});