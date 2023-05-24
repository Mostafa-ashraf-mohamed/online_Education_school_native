<?php
include "../../PhpConfig/delete.php";
session_start();
if(isset($_GET['lang'])){
    $_SESSION['LANG']=$_GET['lang'];
  }
  
  if($_SESSION['LANG']=="en"){
    include "../../lang/en.php";
  }else{
    include "../../lang/ar.php";
  }
if(isset($_SESSION['type'])){
    if($_SESSION['type']!="admin"){
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

if (isset($_POST['deleteID'])) {
    deleteComment($_POST['deleteID'], $conn);
}

if (isset($_POST['BlockID'])) {
    $St_id = $_POST['BlockID'];
    $comment = $_POST['comment'];
    $sql = "INSERT INTO block VALUES (NULL,$St_id,'admin','$comment')";
    if (!mysqli_query($conn, $sql)) {
        echo "error" . mysqli_error($conn);
    } else {
        echo "<div class='alert alert-primary'> Blocked </div>";
    }
}
?>

<!DOCTYPE html >
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
    <link rel="stylesheet" href="../../css/teacher/t_video.css">
    <?php if($_SESSION['LANG'] == "ar"){ ?>
        <link rel="stylesheet" href="../../lang/css/navAR.css">
    <?php } ?>
    <title>video</title>
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
                    <a class="nav-link active" href="a_subjects.php"><?=$lang['Subjects']?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="a_teacher.php"><?=$lang['Teachers']?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_students.php"><?=$lang['Students']?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="a_tickets.php"><?=$lang['tickets']?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="a_home.php"><?=$lang['Home']?></a>
                </li>
                <li class="nav-item dropdown" id="chipAR">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <div class="chip">
                            <img src="../../images/avataradmin.png" alt="Person" width="96" height="96">
                            Admin
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="a_setting.php"><?=$lang['Settings']?></a>
                        <?php if($_SESSION['LANG']=="en"):?>
                            <a class="dropdown-item" href="?lang=ar">اللغه العربيه</a>
                        <?php else:?>
                            <a class="dropdown-item" href="?lang=en">English</a>
                        <?php endif ?>
                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../home.php?exit=0"><?=$lang['log out']?></a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

  
    <!-- body -->
    <div class="space"></div>
    <div class="ml-5 mr-5 container-style">
        <div class="row">
            <div class="col-md-7 col-12">
                <div class="cont">
                    <iframe class="video" src="<?= $ss['V_path'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div id="all-comments">
                    <?php
                    $select = "SELECT * FROM `comment` NATURAL JOIN `student` WHERE V_id = " . $ss['V_id'] . " ORDER BY C_id DESC";
                    $s = mysqli_query($conn, $select);
                    foreach ($s as $data) {
                        $s3 = mysqli_query($conn, "SELECT * FROM `block` WHERE St_id = " . $data['St_id']);
                        if (mysqli_num_rows($s3) == 0) {
                    ?>
                            <div class="comment">
                                <?php if ($data['St_img'] != NULL) {
                                    echo " <img src='../../upload/img/" . $data['St_img'] . "' alt='Person' class='comm-img'>";
                                } else {
                                    if ($data['St_gender'] == 'male') {
                                        echo " <img src='../../images/studentAvatar1.jpg' alt='Person' class='comm-img'>";
                                    } else {
                                        echo " <img src='../../images/studentAvatar2.png' alt='Person' class='comm-img'>";
                                    }
                                }
                                ?>
                                <div class="comm-cont">
                                    <p class="comm-name"><?= $data['St_fname'] . " " . $data['St_lname'] ?></p>
                                    <p class="comm-p"><?= $data['C_comment'] ?></p>
                                </div>
                                <div class="action">
                                    <i class="fas fa-ellipsis-h" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                    </i>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="a_information_profile.php?student=<?= $data['St_id'] ?>"><?=$lang['profile']?></a>
                                        <form action="a_video.php?id=<?= $Vid ?>" method="POST">
                                            <input type="hidden" name="deleteID" value="<?= $data['C_id'] ?>">
                                            <input type="submit" class="dropdown-item" value="<?=$lang['delete']?>">
                                        </form>
                                        <form action="a_video.php?id=<?= $Vid ?>" method="POST">
                                            <input type="hidden" name="BlockID" value="<?= $data['St_id'] ?>">
                                            <input type="hidden" name="comment" value="<?= $data['C_comment'] ?>">
                                            <input type="submit" class="dropdown-item" value="<?=$lang['block']?>">
                                        </form>
                                    </div>
                                </div>
                                <?php
                                $select2 = "SELECT * FROM `answer` NATURAL JOIN `comment` NATURAL JOIN `video` NATURAL JOIN `unit` NATURAL JOIN `teacher` WHERE C_id = " . $data['C_id'];
                                $s2 = mysqli_query($conn, $select2);
                                foreach ($s2 as $data2) {
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
                    <?php }
                    } ?>
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
    </script>
</body>

</html>