const notification = document.querySelector(".notification");
const bell = document.querySelector("#bell");

$(notification).hide();

bell.addEventListener('click',function(){
    $(notification).fadeToggle(200);
});