const exit = document.querySelector("#exit");
const backGround = document.getElementsByClassName("back-ground");
const Unit_id = document.getElementsByClassName("U_id");

function getid(id) {
    for (let index = 0; index < Unit_id.length; index++) {
        Unit_id[index].setAttribute("value", id.id);
    }

}
$(backGround).hide();

exit.addEventListener('click', function () {
    $(backGround).fadeOut("slow");
});

// jQuery animation add file
$(document).ready(function () {
    $("#btn-file").click(function () {
        document.querySelector(".cont").classList.add('hidden');
        $("#panel-file").slideDown("slow");
    });
});

$(document).ready(function () {
    $("#arrow-file").click(function () {
        document.querySelector(".cont").classList.remove('hidden');
        $("#panel-file").slideUp(300);
    });
});

// jQuery animation add video
$(document).ready(function () {
    $("#btn-video").click(function () {
        document.querySelector(".cont").classList.add('hidden');
        $("#panel-video").slideDown("slow");
    });
});

$(document).ready(function () {
    $("#arrow-video").click(function () {
        document.querySelector(".cont").classList.remove('hidden');
        $("#panel-video").slideUp(300);
    });
});

// file scrept
const dragArea = document.querySelector(".drag-area");
const dragText = document.querySelector(".header");

let button = document.querySelector(".button");
let input = document.querySelector("#input");

let file;

// when click to browse
button.onclick = () => {
    input.click();
};
input.addEventListener('change', () => {
    file = this.input;
    dragArea.classList.add('activeDr');
    filURLFUN();
});
// when file is inside the drag area
dragArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    dragText.textContent = 'Release to upload';
    dragArea.classList.add('activeDr');
});

// when file is leaves the drag area
dragArea.addEventListener('dragleave', (event) => {
    dragText.textContent = 'Drag & Drop';
    dragArea.classList.remove('activeDr');
});

// when file is dropped the drag area
dragArea.addEventListener('drop', (event) => {
    event.preventDefault();
    file = event.dataTransfer.files[0]
    const dT = new DataTransfer();
    dT.items.add(file);
    input.files = dT.files;
    dragArea.classList.add('activeDr');
    file = this.input;
    filURLFUN();
});

function filURLFUN() {
    if (fileValidation()) {
        alert('This extension is not valid');
        dragArea.classList.remove('activeDr');
        file.value = "";
    }
}

function fileValidation() {
    fileInput = file
    filePath = fileInput.value;
    if (filePath.includes(".doc") |filePath.includes( ".docx") |filePath.includes( ".pdf") |filePath.includes( ".ppt" )|filePath.includes( ".pptx") |filePath.includes( ".pptm") |filePath.includes( ".rar" )|filePath.includes( ".zip")) {
        return false
    } else {
        return true
    }

}
