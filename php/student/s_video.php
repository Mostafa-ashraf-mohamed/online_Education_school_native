<?php
include "../../PhpConfig/config.php";
include "../../PhpConfig/OOP.php";
session_start();
if(isset($_GET['lang'])){
    $_SESSION['LANG']=$_GET['lang'];
  }
  
  
  if($_SESSION['LANG']=="en"){
    include "../../lang/en.php";
  }else{
    include "../../lang/ar.php";
  }
if(isset($_SESSION['user']) && isset($_SESSION['type'])){
    if($_SESSION['type']=="student"){
      $student = $_SESSION['user'];
    }else{
        session_start();
        session_unset();
        session_destroy();
        header("location: ../../index.php");
    }
  
  }else{
    header("location: ../home.php");
}
?>
<?php
$Vid = $_GET['id'];

$select = "SELECT * FROM `video` WHERE V_id = " . $Vid;
$s = mysqli_query($conn, $select);
$ss = mysqli_fetch_assoc($s);

if (isset($_POST['new-comment'])) {
    $ncomm = $_POST['new-comment'];
    $Sid = $student->getId();
    $insert = "INSERT INTO `comment` VALUES (NULL, '$ncomm' , $Vid , $Sid)";
    if (mysqli_query($conn, $insert)) {
        echo "<div class='alert alert-primary' role='alert'>Record insert successfully</div>";
        header("location:s_video.php?id=$Vid");
    } else {
        echo "<div class='alert alert-danger' role='alert'>Error inserting record: </div>";
    }
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
    <!-- the font icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!-- bootestrab css -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
    <!-- navbar -->
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <!-- my css -->
    <link rel="stylesheet" href="../../css/student/s_video.css">
    <?php if($_SESSION['LANG'] == "ar"){ ?>
        <link rel="stylesheet" href="../../lang/css/navAR.css">
    <?php } ?>
    <title>video</title>
  <link rel="icon" href="../../images/icon.png">
</head>

<body>
    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <img src="../../images/logo.jpeg" alt="school logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item active">
          <a class="nav-link active" href="s_home.php"><?=$lang['Home']?></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="s_ticket.php"><?=$lang['Ticket']?></a>
        </li>
        <li class="nav-item">
          <button class="nav-link btn" id="bell"><i class="fas fa-bell"></i></button>
          <div class="notification" id="notification">
            <div class="card card-body" id="card">
              <?php
              $select2 = "SELECT * FROM `comment` WHERE St_id = " . $student->getId() . " ORDER BY C_id DESC";
              $s2 = mysqli_query($conn, $select2);
              ?>
              <!-- ************************************* -->
              <?php foreach ($s2 as $data) { ?>
                <div class="comment">
                  <?php if ($student->getImg() != NULL) {
                    echo " <img src='../../upload/img/" . $student->getImg() . "' alt='Person' class='comm-img'>";
                  } else {
                    if ($student->getGender() == 'male') {
                      echo " <img src='../../images/studentAvatar1.jpg' alt='Person' class='comm-img'>";
                    } else {
                      echo " <img src='../../images/studentAvatar2.png' alt='Person' class='comm-img'>";
                    }
                  }
                  ?>
                  <div class="comm-cont">
                    <p class="comm-name"><?= $student->getFname() . " " . $student->getLname() ?></p>
                    <p class="comm-p"><?= $data['C_comment'] ?></p>
                  </div>
                  <?php
                  $ss1 = "SELECT * FROM `answer` NATURAL JOIN `comment` NATURAL JOIN `video` NATURAL JOIN `unit` NATURAL JOIN `teacher` WHERE C_id = " . $data['C_id'];
                  $ss2 = mysqli_query($conn, $ss1);

                  foreach ($ss2 as $data2) {
                  ?>
                    <div class="answer">
                      <?php if ($data2['T_img'] != NULL) {
                        echo " <img src='../../upload/img/" . $data2['T_img'] . "' alt='Person' class='comm-img'>";
                      } else {
                        if ($data2['T_gender'] == 'male') {
                          echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                        } else {
                          echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                        }
                      }
                      ?>
                      <div class="comm-cont">
                        <p class="comm-name"><?= $data2['T_fname'] . " " . $data2['T_lname'] ?></p>
                        <p class="comm-p"><?= $data2['A_answer'] ?></p>
                      </div>
                    </div>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </li>
        <li class="nav-item dropdown" id="chipART">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <div class="chip">
              <?php if ($student->getImg() != NULL) { ?>
                <img src="../../upload/img/<?= $student->getImg() ?>" alt="Person" width="96" height="96">
                <?php } else {
                if ($student->getGender() == 'male') { ?>
                  <img src="../../images/studentAvatar1.jpg" alt="Person" width="96" height="96">
                <?php } else { ?>
                  <img src="../../images/studentAvatar2.png" alt="Person" width="96" height="96">
              <?php }
              }
              echo $student->getFname();
              ?>
            </div>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="s_profile.php"><?=$lang['profile']?></a>
            <?php if($_SESSION['LANG']=="en"):?>
                            <a class="dropdown-item" href="?lang=ar&id=<?=$_GET['id']?>">اللغه العربيه</a>
                        <?php else:?>
                            <a class="dropdown-item" href="?lang=en&id=<?=$_GET['id']?>">English</a>
                        <?php endif ?>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../home.php?exit=0"><?=$lang['log out']?></a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
    <!-- body -->
    <!-- <br><br><br><br><br><br> -->
    <div class="space"></div>
    <div class="ml-5 mr-5 container-style">
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="cont">
                    <iframe class="video" src="<?= $ss['V_path'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div class="comments">
                    <button id="new" name="new" class="btn btn-block btn-success comm-add"><i class="far fa-comment-alt"></i></button>
                    <div id="all-comments">
                        <?php
                        $select2 = "SELECT * FROM `comment` NATURAL JOIN `student` WHERE V_id = " . $ss['V_id'] . " ORDER BY C_id DESC";
                        $s2 = mysqli_query($conn, $select2);
                        foreach ($s2 as $data2) {
                        ?>
                            <div class="comment">
                                <?php if ($data2['St_img'] != NULL) {
                                    echo " <img src='../../upload/img/" . $data2['St_img'] . "' alt='Person' class='comm-img'>";
                                } else {
                                    if ($data2['St_gender'] == 'male') {
                                        echo " <img src='../../images/studentAvatar1.jpg' alt='Person' class='comm-img'>";
                                    } else {
                                        echo " <img src='../../images/studentAvatar2.png' alt='Person' class='comm-img'>";
                                    }
                                }
                                ?>
                                <div class="comm-cont">
                                    <p class="comm-name"><?= $data2['St_fname'] . " " . $data2['St_lname'] ?></p>
                                    <p class="comm-p"><?= $data2['C_comment'] ?></p>
                                </div>
                                <?php
                                $select3 = "SELECT * FROM `answer` NATURAL JOIN `comment` NATURAL JOIN `video` NATURAL JOIN `unit` NATURAL JOIN `teacher` WHERE C_id = " . $data2['C_id'];
                                $s3 = mysqli_query($conn, $select3);
                                foreach ($s3 as $data3) {
                                ?>
                                    <div class="answer">
                                        <?php if ($data3['T_img'] != NULL) {
                                            echo " <img src='../../upload/img/" . $data3['T_img'] . "' alt='Person' class='comm-img'>";
                                        } else {
                                            if ($data3['T_gender'] == 'male') {
                                                echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                                            } else {
                                                echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                                            }
                                        }
                                        ?>
                                        <div class="comm-cont">
                                            <p class="comm-name"><?= $data3['T_fname'] . " " . $data3['T_lname'] ?></p>
                                            <p class="comm-p"><?= $data3['A_answer'] ?></p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- new comment -->
        <div>
            <div class="back-new-comm">
                <div class="new-comm">
                    <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                    <h2><?=$lang['Add Comment']?>:</h2>
                    <div style="text-align: center;">
                        <hr>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                            <textarea name="new-comment" id="new-comment" cols="65" rows="10"></textarea>
                            <input type="submit" value="<?=$lang['Add Comment']?>" class="btn btn-info btn-block mt-4">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bootestrab js -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script> -->
    <script src="../../js/jquery.min.js"></script>
    <script src="../../js/bootstrap.min.js"></script>
    <script src="../../js/popper.min.js"></script>
    <!-- my js -->
    <script src="../../js/student/s_video.js"></script>
    <!-- navber js -->
    <script src="../../js/student/s_navbar.js"></script>
    <!-- nice scroll -->
    <script src="../../js/jquery.nicescroll.min.js"></script>
    <script>
        $("#all-comments").niceScroll({
            cursorcolor: "#707070",
            cursoropacitymin: 1,
            cursoropacitymin: 1,
            cursorwidth: "7px"
        });
        $(document).on('mouseover', '#all-comments', function() {
            $(this).getNiceScroll().resize();
        });
        $("#card").niceScroll({
            cursorcolor: "#707070",
            cursoropacitymin: 1,
            cursoropacitymin: 1,
            cursorwidth: "7px"
        });
        $(document).on('mouseover', '#card', function() {
            $(this).getNiceScroll().resize();
        });
    </script>
</body>

</html>