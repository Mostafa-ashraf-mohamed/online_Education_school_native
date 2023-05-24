const exit = document.querySelector("#exit");
const account = document.querySelector("#account");
const create = document.querySelector(".create");

$(create).hide();

account.addEventListener('click', function () {
  $(create).fadeIn("slow");
});

exit.addEventListener('click', function () {
  $(create).fadeOut("slow");
});

/*=======================*/
function closeAlert() {
  setTimeout(function () {
    $(".more-ot-alert").fadeOut("fast");
  }, 100);
}

function openAlert() {
  $(".more-ot-alert").fadeIn("fast");
  // IE8 animation polyfill
  if ($("html").hasClass("lt-ie9")) {
    var speed = 300;
    var times = 3;
    var loop = setInterval(anim, 300);

    function anim() {
      times--;
      if (times === 0) {
        clearInterval(loop);
      }
      $(".more-ot-alert").animate({
        left: 450
      }, speed).animate({
        left: 440
      }, speed);
      //.stop( true, true ).fadeIn();
    };
    anim();
  };
  $(".closeAl").on("click", function () {
    closeAlert()
  });
}