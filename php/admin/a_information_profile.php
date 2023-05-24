<?php
include("../../PhpConfig/config.php");
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
$choose = NULL;
if (isset($_GET['teacher_id'])) {
    $select = "SELECT * FROM (`teacher` NATURAL JOIN `subject`) NATURAL JOIN `department` WHERE T_id = " . $_GET['teacher_id'];
    $profile_teacher = mysqli_query($conn, $select);
    $profile_teacher2 = mysqli_fetch_assoc($profile_teacher);
    $choose = 'teacher';
}

if (isset($_GET['student'])) {
    $select = "SELECT * FROM `student` NATURAL JOIN `department` WHERE St_id = " . $_GET['student'];
    $profile_student = mysqli_query($conn, $select);
    $profile_student2 = mysqli_fetch_assoc($profile_student);
    $choose = 'student';
}
?>


<!DOCTYPE html>
<html <?php if($_SESSION['LANG']=="en"):?>
    lang="en"
<?php else:?>
    lang="ar" dir="rtl"
<?php endif?>>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information</title>
  <link rel="icon" href="../../images/icon.png">
    <!-- the font icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!-- bootstrab css -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <!-- my css -->
    <link rel="stylesheet" href="../../css/student/s_profile.css">
    <link rel="stylesheet" href="../../css/admin/a_information_profile.css">
    <?php if($_SESSION['LANG'] == "ar"){ ?>
        <link rel="stylesheet" href="../../lang/css/navAR.css">
    <?php } ?>
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
          <a class="nav-link active" href="a_teacher.php"><?= $lang['Teachers'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_students.php"><?= $lang['Students'] ?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link " href="a_tickets.php"><?= $lang['tickets'] ?></a>
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
              <a class="dropdown-item" href="?lang=ar&teacher_id=<?=$_GET['teacher_id']?>">اللغه العربيه</a>
            <?php else : ?>
              <a class="dropdown-item" href="?lang=en&teacher_id=<?=$_GET['teacher_id']?>">English</a>
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
    <?php if ($choose == 'teacher') { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 p-0">
                    <div class="profile-img">
                        <?php if ($profile_teacher2['T_img'] != NULL) {
                            echo " <img src='../../upload/img/" . $profile_teacher2['T_img'] . "' alt='Person' class='infoImage'>";
                        } else {
                            if ($profile_teacher2['T_gender'] == 'male') {
                                echo " <img src='../../images/img_avatar.png' alt='Person' class='infoImage'>";
                            } else {
                                echo " <img src='../../images/img_avatar2.png' alt='Person' class='infoImage'>";
                            }
                        }
                        ?>
                        <h3 class="mt-3 mb-3"><?= $profile_teacher2['T_fname'] ?>
                        </h3>
                        <p><?= $lang['department:'] ?> <?= $profile_teacher2['D_name'] ?></p>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="profile mt-1">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">ID:</th>
                                    <td><?= $profile_teacher2['T_id'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= $lang['full_name'] ?>:</th>
                                    <td><?= $profile_teacher2['T_fname'] . " " . $profile_teacher2['T_lname'] ?>
                                    </td>
                                </tr>
                                <th scope="row"><?= $lang['gender'] ?>:</th>
                                <td><?= $profile_teacher2['T_gender'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= $lang['email'] ?>:</th>
                                    <td><?= $profile_teacher2['T_email'] ?></td>
                                </tr>

                                <tr>
                                    <th scope="row"><?= $lang['phone_number'] ?>:</th>
                                    <td><?= $profile_teacher2['T_phNumber'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= $lang['subject'] ?>:</th>
                                    <td><?= $profile_teacher2['S_name'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <form action="a_teacher.php" method="GET">
                        <input type="hidden" name="Tid" value="<?= $_GET['teacher_id'] ?>">
                        <input type="submit" value="<?= $lang['delete'] ?>" class="btn btn-outline-danger btn-block mt-3 mb-4">
                    </form>
                </div>
            </div>
        </div>
    <?php } elseif ($choose == 'student') { ?>
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 p-0">
                    <div class="profile-img">
                        <?php if ($profile_student2['St_img'] != NULL) {
                            echo " <img src='../../upload/img/" . $profile_student2['St_img'] . "' alt='Person' class='infoImage'>";
                        } else {
                            if ($profile_student2['St_gender'] == 'male') {
                                echo " <img src='../../images/studentAvatar1.jpg' alt='Person' class='infoImage'>";
                            } else {
                                echo " <img src='../../images/studentAvatar2.png' alt='Person' class='infoImage'>";
                            }
                        }
                        ?>
                        <h3 class="mt-3 mb-3"><?= $profile_student2['St_fname'] ?>
                        </h3>
                        <p><?= $lang['department:'] ?><?= $profile_student2['D_name'] ?></p>
                    </div>
                </div>
                <div class="col-md-8 col-12">
                    <div class="profile mt-1">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">ID:</th>
                                    <td><?= $profile_student2['St_id'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= $lang['full_name'] ?>:</th>
                                    <td><?= $profile_student2['St_fname'] . " " . $profile_student2['St_lname'] ?>
                                    </td>
                                </tr>
                                <th scope="row"><?= $lang['gender'] ?>:</th>
                                <td><?= $profile_student2['St_gender'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= $lang['email'] ?>:</th>
                                    <td><?= $profile_student2['St_email'] ?></td>
                                </tr>

                                <tr>
                                    <th scope="row"><?= $lang['phone_number'] ?>:</th>
                                    <td><?= $profile_student2['St_phNumber'] ?></td>
                                </tr>
                                <tr>
                                    <th scope="row"><?= $lang['Date of birth:'] ?>:</th>
                                    <td><?= $profile_student2['St_DOB'] ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button id="show" class="btn btn-outline-info btn-block mt-3 mb-4"><?= $lang['Show all comments'] ?></button>
                </div>
            </div>
        </div>
    <?php } ?>

    <!-- div all comments -->
    <div>
        <div class="comments">
            <div class="cont">
                <div class="">
                    <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                    <h2>All comments:</h2>
                    <hr>
                </div>
                <div id="allcomments">
                    <!-- ************* here write all comments and anwsers **************** -->
                    <?php
                    $commSQL = mysqli_query($conn, "select * from `comment` NATURAL JOIN `student` where St_id = $_GET[student]");
                    while ($res = mysqli_fetch_array($commSQL)) {
                    ?>
                        <div class="comment">
                            <?php if ($res['St_img'] != NULL) {
                                echo " <img src='../../upload/img/" . $res['St_img'] . "' alt='Person' class='comm-img'>";
                            } else {
                                if ($res['St_gender'] == 'male') {
                                    echo " <img src='../../images/studentAvatar1.jpg' alt='Person' class='comm-img'>";
                                } else {
                                    echo " <img src='../../images/studentAvatar2.png' alt='Person' class='comm-img'>";
                                }
                            }
                            ?>
                            <div class="comm-cont">
                                <p class="comm-name"><?= $res['St_fname'] . " " . $res['St_lname'] ?></p>
                                <p class="comm-p"><?= $res['C_comment'] ?></p>
                            </div>
                            <?php
                            $anssSQL = mysqli_query($conn, "select * from `comment` NATURAL JOIN `video` NATURAL JOIN `unit` NATURAL JOIN`teacher` NATURAL JOIN `answer` where C_id = $res[C_id]");
                            while ($res2 = mysqli_fetch_array($anssSQL)) {
                            ?>
                                <div class="answer">
                                    <?php if ($res2['T_img'] != NULL) {
                                        echo " <img src='../../upload/img/" . $res2['T_img'] . "' alt='Person' class='comm-img'>";
                                    } else {
                                        if ($res2['T_gender'] == 'male') {
                                            echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                                        } else {
                                            echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                                        }
                                    }
                                    ?>
                                    <div class="comm-cont">
                                        <p class="comm-name"><?= $res2['T_fname'] . " " . $res2['T_lname'] ?></p>
                                        <p class="comm-p"><?= $res2['A_answer'] ?></p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- bootstrab js -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.min.js" integrity="sha384-VHvPCCyXqtD5DqJeNxl2dtTyhF78xXNXdkwX1CZeRusQfRKp+tA7hAShOK/B/fQ2" crossorigin="anonymous"></script> -->
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <!-- nice scroll -->
    <script src="../../js/jquery.nicescroll.min.js"></script>
    <script>
        $("#allcomments").niceScroll({
            cursorcolor: "#707070",
            cursoropacitymin: 1,
            cursoropacitymin: 1,
            cursorwidth: "7px"
        });
        $(document).on('mouseover', '#allcomments', function() {
            $(this).getNiceScroll().resize();
        });
    </script>
    <!-- my js -->
    <script src="../../js/admin/a_information_profile.js"></script>
</body>

</html>