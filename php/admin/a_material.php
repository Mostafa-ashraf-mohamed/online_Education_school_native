<?php
include "../../PhpConfig/config.php";
session_start();
if (isset($_GET['lang'])) {
  $_SESSION['LANG'] = $_GET['lang'];
}

if ($_SESSION['LANG'] == "en") {
  include "../../lang/en.php";
} else {
  include "../../lang/ar.php";
}
if (isset($_SESSION['type'])) {
  if ($_SESSION['type'] != "admin") {
    session_start();
    session_unset();
    session_destroy();
    header("location: ../../index.php");
  }
} else {
  header("location: ../home.php");
}
?>
<?php
$Sid = $_GET['id'];

$Tid = NULL;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $Tid = $_POST['Tid'];
}
?>

<!DOCTYPE html>
<html <?php if ($_SESSION['LANG'] == "en") : ?> lang="en" <?php else : ?> lang="ar" dir="rtl" <?php endif ?>>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- the font icon -->
  <link href="../../css/all.min.css" rel="stylesheet">
  <!-- bootestrab css -->
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
  <!-- navbar -->
  <link rel="stylesheet" href="../../css/student/s_navbar.css">
  <!-- my css -->
  <link rel="stylesheet" href="../../css/student/s_material.css">
  <?php if ($_SESSION['LANG'] == "ar") { ?>
    <link rel="stylesheet" href="../../lang/css/navAR.css">
  <?php } ?>
  <title>materials</title>
  <link rel="icon" href="../../images/icon.png">
</head>

<body>
  <!-- navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">
      <img src="../../images/logo.jpeg" alt="school logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="a_subjects.php"><?= $lang['Subjects'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="a_teacher.php"><?= $lang['Teachers'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_students.php"><?= $lang['Students'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_tickets.php"><?= $lang['tickets'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="a_home.php"><?= $lang['Home'] ?></a>
        </li>
        <li class="nav-item dropdown" id="chipAR">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <div class="chip">
              <img src="../../images/avataradmin.png" alt="Person" width="96" height="96">
              Admin
            </div>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="a_setting.php"><?= $lang['Settings'] ?></a>
            <?php if ($_SESSION['LANG'] == "en") : ?>
              <a class="dropdown-item" href="?lang=ar&id=<?= $_GET['id'] ?>">اللغه العربيه</a>
            <?php else : ?>
              <a class="dropdown-item" href="?lang=en&id=<?= $_GET['id'] ?>">English</a>
            <?php endif ?>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../home.php?exit=0"><?= $lang['log out'] ?></a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <!-- section chapters -->
  <br><br><br>
  <div>
    <div class="row ml-5 mr-5">
      <div class="col-12 col-sm-9">
        <?php if ($Tid != NULL) { ?>
          <section>
            <?php
            $select = "SELECT * FROM `unit` WHERE T_id = $Tid";
            $s = mysqli_query($conn, $select);
            foreach ($s as $data) { ?>
              <div class="chapter">
                <h4 class="s_h4"><?= $lang['chapter'] ?> <?= $data['U_number'] ?></h4>
                <?php
                $select2 = "SELECT * FROM `video` WHERE U_id = " . $data['U_id'];
                $s2 = mysqli_query($conn, $select2);
                foreach ($s2 as $data2) { ?>
                  <div class="video">
                    <a class="btn" href="a_video.php?id=<?= $data2['V_id'] ?>">
                      <img src="../../images/youtube-video.jpg" class="pdfimg" alt="...">
                      <span class="my-span"><?= $data2['V_name'] ?></span>
                    </a>
                  </div>
                <?php } ?>
                <?php
                $select3 = "SELECT * FROM `material` WHERE U_id = " . $data['U_id'];
                $s3 = mysqli_query($conn, $select3);
                foreach ($s3 as $data3) { ?>
                  <div class="pdf">
                    <button class="btn">
                      <img src="../../images/pdf.png" class="pdfimg" alt="PDF:">
                      <a href="../../upload/PDF/<?= $data3['M_path'] ?>" download><span class="my-span"><?php echo $data3['M_name'] ?></span></a>
                    </button>
                  </div>
                <?php } ?>
              </div>
            <?php } ?>
          </section>
        <?php } else { ?>
          <p class="display-4 mt-5"><?= $lang['Choose Teacher'] ?> ...</p>
        <?php } ?>
      </div>
      <div class="col-3">
        <h4 class="m-5"> <?= $lang['Teachers'] ?>: </h4>
        <nav class="rightSlide">
          <ul>
            <?php $select = "SELECT * FROM `teacher` WHERE S_id= $Sid";
            $s = mysqli_query($conn, $select);
            foreach ($s as $data) { ?>
              <li>
                <?php
                if ($data['T_img'] != NULL) {
                  echo " <img src='../../upload/img/" . $data['T_img'] .
                    "' alt='Person' class='TIMG'>";
                } else {
                  if ($data['T_gender'] == 'male') {
                    echo " <img src='../../images/img_avatar.png' alt='Person' class='TIMG'>";
                  } else {
                    echo " <img src='../../images/img_avatar2.png' alt='Person' class='TIMG'>";
                  }
                }
                ?>
                <div class="cont">
                  <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <input type="hidden" name="Tid" value="<?= $data['T_id'] ?>">
                    <input type="submit" value="<?= $data['T_fname'] . " " . $data['T_lname'] ?>" class="btn-block btn">
                  </form>
                </div>
              </li>
            <?php  } ?>
          </ul>
        </nav>
      </div>
    </div>
  </div>

  <!-- bootstrab js -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script> -->
  <script src="../../js/jquery.min.js"></script>
  <script src="../../js/bootstrap.min.js"></script>
  <script src="../../js/popper.min.js"></script>
  <!-- nice scroll -->
  <script src="../../js/jquery.nicescroll.min.js"></script>
  <script>
    $("body").niceScroll({
      cursorcolor: "#707070",
      cursoropacitymin: 1,
      cursoropacitymin: 1,
      cursorwidth: "10px",
      zindex: "auto" | [1000]
    });
  </script>
</body>

</html>