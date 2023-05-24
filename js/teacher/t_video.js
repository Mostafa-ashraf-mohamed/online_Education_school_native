const exit = document.querySelector("#exit");
const reply = document.querySelector(".reply");
const backGround = document.querySelector(".back-new-comm");
const Comment_id = document.querySelector("#C_id");

function getid(id) {
        Comment_id.setAttribute("value", id.id);
    $(backGround).fadeIn("slow");

}

$(backGround).hide();



exit.addEventListener('click',function(){
    $(backGround).fadeOut("slow");
});