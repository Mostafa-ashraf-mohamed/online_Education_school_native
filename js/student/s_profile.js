const exit = document.querySelector("#exit");
const edit = document.querySelector("#edit");
const backEdit = document.querySelector(".back-edit");

$(backEdit).hide();

edit.addEventListener('click',function(){
    $(backEdit).fadeIn("slow");
});

exit.addEventListener('click',function(){
    $(backEdit).fadeOut("slow");
});

// change image
const image = document.querySelector(".image");
let input = document.querySelector("#input");
const proImgSub = document.querySelector("#proImgSub")
let imgedit = document.querySelector("#imgedit")
const proImgCan = document.querySelector("#proImgCan")
let lastscr = imgedit.src;

image.onclick = () => {
    input.click();
};
proImgCan.addEventListener('click', () => {
    proImgSub.setAttribute("hidden","hidden");
    proImgCan.setAttribute("hidden","hidden");
    $('#imgedit')
            .attr('src', lastscr);
    input.value = "";
});
input.addEventListener('change', () => {
    proImgSub.removeAttribute("hidden");
    proImgCan.removeAttribute("hidden");
    filURLFUN();
});
function filURLFUN() {
    if (fileValidation()) {
        alert('This extension is not valid');
        proImgSub.setAttribute("hidden","hidden");
        proImgCan.setAttribute("hidden","hidden");
        $('#imgedit')
                .attr('src', lastscr);
        input.value = "";
    }
       
}
function fileValidation() {
    fileInput = input;
    filePath = fileInput.value;
    if (filePath.includes(".png")|filePath.includes(".jpg")|filePath.includes(".jpeg")|filePath.includes(".PNG")|filePath.includes(".JPG")|filePath.includes(".JPEG")) {
        return false
    } else {
        return true
    }
}
function readURL(input) {
    if (!fileValidation()) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#imgedit')
                .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
}
