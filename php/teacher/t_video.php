<?php
include "../../PhpConfig/OOP.php";
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
if (isset($_SESSION['user']) && isset($_SESSION['type'])) {
    if ($_SESSION['type'] == "teacher") {
        $teacher = $_SESSION['user'];
    } else {
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
if (isset($_GET['id'])) {
    $showData = "SELECT * FROM `video` natural join `unit` where T_id = " . $teacher->getid() . " and V_id= $_GET[id]";
    $dataBaseRe = mysqli_query($conn, $showData);
    $videoData = mysqli_fetch_assoc($dataBaseRe);
    if (!(mysqli_num_rows($dataBaseRe) > 0)) {
        header("location: t_material.php");
    }
} else {
    header("location: t_material.php");
}
?>
<?php
if (isset($_POST['stCIDD'])) {
    deleteComment($_POST['stCIDD'], $conn);
}
if (isset($_POST['stIDB'])) {
    $insert_Block = "INSERT INTO `block` VALUES (NULL,$_POST[stIDB],'$_POST[Tname]','$_POST[Comment]')";
    $mih = mysqli_query($conn, $insert_Block);
    if ($mih) {
        deleteComment($_POST['DAB'], $conn);
        header("location: t_video.php?id=$_GET[id]");
    } else {
        echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>failed to Block contact with admin</div></div>";
    }
}
if (isset($_POST['AIDD'])) {
    $sql = "DELETE FROM `answer` WHERE A_id= $_POST[AIDD]";
    $testIfCor = mysqli_query($conn, $sql);
    if ($testIfCor) {
        header("location: t_video.php?id=$_GET[id]");
    } else {
        echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>failed to delete contact with admin</div></div>";
    }
}
if (isset($_POST['cid']) & isset($_POST['answerContant'])) {
    $answerContant = test_input($_POST['answerContant']);
    $insert_Answer = "INSERT INTO `answer` VALUES (NULL,'$answerContant',$_POST[cid])";
    $mihs = mysqli_query($conn, $insert_Answer);
    if ($mihs) {
        header("location: t_video.php?id=$_GET[id]");
    } else {
        echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>failed to add answer contact with admin</div></div>";
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
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
        integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
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
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#"><img src="../../images/logo.jpeg" alt="school"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="t_material.php"><?=$lang['material']?></a>
                </li>
                <!-- dd -->
                <li class="nav-item">
                    <button class="nav-link btn" id="bell"><i class="fas fa-bell"></i></button>
                    <div class="notification" id="notification">
                        <div class="card card-body" id="card">
                            <?php
                            $select2 = "SELECT * FROM `comment`NATURAL JOIN `student` NATURAL JOIN `video` NATURAL JOIN `unit` WHERE T_id = " . $teacher->getId();
                            $s2 = mysqli_query($conn, $select2);
                            $counter = 0;
                            ?>
                            <!-- ************************************* -->
                            <?php
                            foreach ($s2 as $data) {
                                $ss1 = "SELECT * FROM `answer` NATURAL JOIN `comment` WHERE C_id = " . $data['C_id'];
                                $ss2 = mysqli_query($conn, $ss1);
                                $numrow = mysqli_num_rows($ss2);
                                if ($numrow == 0) {
                                    $counter = 1; ?>
                                    <div class="comment">
                                        <a href="t_video.php?id=<?= $data['V_id'] ?>" style="text-decoration: none;">
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
                                        </a>
                                    </div>
                            <?php }
                            }
                            if ($counter == 0) {
                                echo "<div class='text-center w-100'><p class='display-5 text-danger mt-3'>".$lang['no Comments']."</p></div>";
                            }
                            ?>
                        </div>
                    </div>
                </li>
                <!-- ff -->
                <li class="nav-item dropdown " id="chipART">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                        <div class="chip">
                            <?php if ($teacher->getImg() != NULL) { ?>
                                <img src="../../upload/img/<?= $teacher->getImg() ?>" alt="Person" width="96" height="96">
                                <?php } else {
                                if ($teacher->getGender() == 'male') { ?>
                                    <img src="../../images/img_avatar.png" alt="Person" width="96" height="96">
                                <?php } else { ?>
                                    <img src="../../images/img_avatar2.png" alt="Person" width="96" height="96">
                            <?php }
                            }
                            echo $teacher->getFname();
                            ?>
                        </div>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="t_profile.php"><?=$lang['profile']?></a>
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
                    <iframe class="video" src="<?= $videoData['V_path'] ?>" title="<?= $videoData['V_name'] ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                    </iframe>
                </div>
            </div>
            <div class="col-md-5 col-12">

                <div id="all-comments">
                    <!-- ************************************* -->
                    <?php
                    $showData = "SELECT * FROM `comment` natural join `student` where  V_id= $_GET[id]";
                    $dataBaseRe = mysqli_query($conn, $showData);
                    foreach ($dataBaseRe as $commentAndAns) {
                    ?>
                        <div class="comment">
                            <?php
                            if ($commentAndAns['St_img'] != NULL) {
                                echo " <img src='../../upload/img/" . $commentAndAns['St_img'] .
                                    "' alt='Person' class='comm-img'>";
                            } else {
                                if ($commentAndAns['St_gender'] == 'male') {
                                    echo " <img src='../../images/studentAvatar1.jpg' alt='Person' class='comm-img'>";
                                } else {
                                    echo " <img src='../../images/studentAvatar2.png' alt='Person' class='comm-img'>";
                                }
                            }
                            ?>
                            <div class="comm-cont">
                                <p class="comm-name"><?= $commentAndAns['St_fname'] . " " . $commentAndAns['St_lname'] ?></p>
                                <p class="comm-p">
                                    <?= $commentAndAns['C_comment'] ?>
                                </p>
                            </div>
                            <div class="action">
                                <i class="far fa-comment-dots Pointer" id="<?= $commentAndAns['C_id'] ?>" onclick="getid(this)"></i>
                                <i class="fas fa-ellipsis-h Pointer" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                                </i>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="t_student_profile.php?id=<?= $commentAndAns['St_id'] ?>"><?=$lang['profile']?></a>
                                    <form action="t_video.php?id=<?= $_GET['id'] ?>" method="POST">
                                        <input type="hidden" name="stCIDD" value="<?= $commentAndAns['C_id'] ?>">
                                        <button class="dropdown-item" type="submit"><?=$lang['delete']?></button>
                                    </form>
                                    <form action="t_video.php?id=<?= $_GET['id'] ?>" method="POST">
                                        <input type="hidden" name="stIDB" value="<?= $commentAndAns['St_id'] ?>">
                                        <input type="hidden" name="Comment" value="<?= $commentAndAns['C_comment'] ?>">
                                        <input type="hidden" name="Tname" value="<?= $teacher->getFname() . " " . $teacher->getLname() ?>">
                                        <input type="hidden" name="DAB" value="<?= $commentAndAns['C_id'] ?>">
                                        <button class="dropdown-item" type="submit"><?=$lang['block']?></button>
                                    </form>
                                </div>
                            </div>
                            <?php
                            $showData = "SELECT * FROM `answer` where  C_id= $commentAndAns[C_id]";
                            $dataBaseReAnswer = mysqli_query($conn, $showData);
                            foreach ($dataBaseReAnswer as $Answer) {
                            ?>
                                <div class="answer">
                                    <?php
                                    if ($teacher->getImg() != NULL) {
                                        echo " <img src='../../upload/img/" . $teacher->getImg() .
                                            "' alt='Person' class='comm-img'>";
                                    } else {
                                        if ($teacher->getGender() == 'male') {
                                            echo " <img src='../../images/img_avatar.png' alt='Person' class='comm-img'>";
                                        } else {
                                            echo " <img src='../../images/img_avatar2.png' alt='Person' class='comm-img'>";
                                        }
                                    } ?>
                                    <div class="comm-cont">
                                        <p class="comm-name"><?= $teacher->getFname() . " " . $teacher->getLname() ?></p>
                                        <p class="comm-p"><?= $Answer['A_answer'] ?></p>
                                        <div class="action float-right">
                                            <form action="t_video.php?id=<?= $_GET['id'] ?>" method="POST">
                                                <input type="hidden" name="AIDD" value="<?= $Answer['A_id'] ?>">
                                                <button class="border-0 btn btn-outline-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Add answer -->
    <div class="back-new-comm">
        <div class="new-comm">
            <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
            <h2><?=$lang['add_Answer']?></h2>
            <div style="text-align: center;">
                <hr>
                <form action="t_video.php?id=<?= $_GET['id'] ?>" method="POST">
                    <input type="hidden" name="cid" id="C_id" value="">
                    <textarea name="answerContant" id="new-comment" cols="65" rows="10"></textarea>
                    <button class="btn btn-info btn-block mt-4" type="submit"><?=$lang['add_Answer']?></button>
                </form>

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
    <script src="../../js/teacher/t_video.js"></script>
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
    </script>
</body>

</html>