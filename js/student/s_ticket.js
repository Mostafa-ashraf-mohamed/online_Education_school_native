const exit = document.querySelector("#exit");
const add = document.querySelector("#add");
const ticket = document.querySelector(".ticket");

$(ticket).hide();

add.addEventListener('click',function(){
    $(ticket).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(ticket).fadeOut("slow");
});