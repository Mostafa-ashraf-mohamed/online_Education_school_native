
$(document).ready(function () {
    $(".collapse.show").each(function () {
        $(this).prev("#btn1").find(".fas").addClass("fa-sort-down").removeClass("fa-caret-right");
    });
    $(".collapse").on('show.bs.collapse', function () {
        $(this).prev(".btn-toggle").addClass("active");
        $(this).prev(".btn-toggle").find(".fas").removeClass("fa-caret-right").addClass("fa-sort-down");
    }).on('hide.bs.collapse', function () {
        $(this).prev(".btn-toggle").removeClass("active");
        $(this).prev(".btn-toggle").find(".fas").removeClass("fa-sort-down").addClass("fa-caret-right");
    });
});

const exit = document.querySelector("#exit");
const newDepartment = document.querySelector("#newDepartment");
const AddDepartment = document.querySelector(".department");

$(AddDepartment).hide();

newDepartment.addEventListener('click',function(){
    $(AddDepartment).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(AddDepartment).fadeOut("slow");
});


const exit2 = document.querySelector("#exit2");
const newSubject = document.querySelector("#newSubject");
const subject = document.querySelector(".subject");

$(subject).hide();

newSubject.addEventListener('click',function(){
    $(subject).fadeIn("slow");
});

exit2.addEventListener('click',function(){
    $(subject).fadeOut("slow");
});