<?php
include "../../PhpConfig/delete.php";
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
$select = "SELECT * FROM `student` NATURAL JOIN `department`";
$s = mysqli_query($conn, $select);

if (isset($_GET['Sid'])) {
  $Sid = $_GET['Sid'];
  deleteStudent($Sid, $conn);
  header("location: a_students.php");
}
?>

<!DOCTYPE html>
<html <?php if ($_SESSION['LANG'] == "en") : ?> lang="en" <?php else : ?> lang="ar" dir="rtl" <?php endif ?>>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Students</title>
  <link rel="icon" href="../../images/icon.png">
  <!-- the font icon -->
  <link href="../../css/all.min.css" rel="stylesheet">
  <!-- bootstrab css -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="../../css/bootstrap.min.css">
  <!-- navbar -->
  <link rel="stylesheet" href="../../css/student/s_navbar.css">
  <?php if ($_SESSION['LANG'] == "ar") { ?>
    <link rel="stylesheet" href="../../lang/css/navAR.css">
  <?php } ?>
  <style>
    body {
      background-color: #F9F9F9;
    }

    .container .table img {
      float: left;
      margin: auto;
      height: 35px;
      width: 35px;
      border-radius: 50%;
    }
  </style>
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
          <a class="nav-link" href="a_subjects.php"><?= $lang['Subjects'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="a_teacher.php"><?= $lang['Teachers'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="a_students.php"><?= $lang['Students'] ?></a>
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
              <a class="dropdown-item" href="?lang=ar">اللغه العربيه</a>
            <?php else : ?>
              <a class="dropdown-item" href="?lang=en">English</a>
            <?php endif ?>

            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../home.php?exit=0"><?= $lang['log out'] ?></a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <br><br><br><br><br>
  <!-- body -->
  <div class="container">
    <table class="table table-striped table-hover">
      <thead>
        <tr class="text-center">
          <th scope="col">#</th>
          <th scope="col"><?= $lang['image'] ?></th>
          <th scope="col"><?= $lang['full_name'] ?></th>
          <th scope="col"><?= $lang['Email'] ?></th>
          <th scope="col"><?= $lang['Phone'] ?></th>
          <th scope="col"><?= $lang['Gender'] ?></th>
          <th scope="col"><?= $lang['date of birth'] ?></th>
          <th scope="col"><?= $lang['department'] ?></th>
          <th scope="col"><?= $lang['Action'] ?></th>
        </tr>
      </thead>
      <tbody>
        <?php $counter = 1;
        foreach ($s as $data) { ?>
          <tr>
            <th scope="row"><?= $counter ?></th>
            <td>
              <?php if ($data['St_img'] != NULL) {
                echo " <img src='../../upload/img/" . $data['St_img'] . "' alt='Person'>";
              } else {
                if ($data['St_gender'] == 'male') {
                  echo " <img src='../../images/studentAvatar1.jpg' alt='Person'>";
                } else {
                  echo " <img src='../../images/studentAvatar2.png' alt='Person'>";
                }
              }
              ?>
            </td>
            <td><?= $data['St_fname'] . " " . $data['St_lname'] ?></td>
            <td><?= $data['St_email'] ?></td>
            <td>0<?= $data['St_phNumber'] ?></td>
            <td><?= $data['St_gender'] ?></td>
            <td><?= $data['St_DOB'] ?></td>
            <td><?= $data['D_name'] ?></td>
            <td>
              <form action="a_students.php" method="GET">
                <input type="hidden" name="Sid" value="<?= $data['St_id'] ?>">
                <input type="submit" class="btn btn-danger" value="<?= $lang['delete'] ?>">
              </form>
            </td>
          </tr>
        <?php $counter++;
        } ?>
        <a href="admin.php"><button type="button" class="btn btn-success">Report</button></a>
      </tbody>
    </table>
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