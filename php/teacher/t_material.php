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
if(isset($_SESSION['user']) && isset($_SESSION['type'])){
    if($_SESSION['type']=="teacher"){
        $teacher = $_SESSION['user'];
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
$showData = "SELECT * FROM `unit` where T_id = " . $teacher->getid();
$dataBaseRe = mysqli_query($conn, $showData);
$rownum = mysqli_num_rows($dataBaseRe);
?>
<?php
if (isset($_GET['createChapter'])) {
    $rownum++;
    $insert_unit = "INSERT INTO `unit` VALUES (NULL,$rownum," . $teacher->getid() . ")";
    mysqli_query($conn, $insert_unit);
    header("location: t_material.php");
}
?>
<?php
$link = "";
$title = "";
$Unit_id = "";
if (isset($_POST['link']) & isset($_POST['title']) & isset($_POST['Unit_id'])) {
    $link = $_POST['link'];
    $title = $_POST['title'];
    $Unit_id = $_POST['Unit_id'];
    $link = test_input($link);
    $title = test_input($title);
    if ($link != "" & $title != "" & $Unit_id != "") {
        $insert_video = "INSERT INTO `video` VALUES (NULL,'$link','$title',$Unit_id)";
        mysqli_query($conn, $insert_video);
        header("location: t_material.php");
    }
}
?>
<?php
if (isset($_POST['PDFtital'])) {
    $PDFtital = $_POST['PDFtital'];
    $PDFtital = test_input($PDFtital);
    $Unit_idPDF = $_POST['Unit_idPDF'];
    if (substr($_FILES['PDFfile']['name'], ".PDF" || ".pdf" || ".doc" || ".docx" || ".pdf" || ".ppt" || ".pptx" || ".pptm") == true & $PDFtital != "" & $Unit_idPDF != "") {
        $file_name = $_POST['PDFtital'] . time() . $_POST['Unit_idPDF'] . $_FILES['PDFfile']['name'];
        $file_path = $_FILES['PDFfile']['tmp_name'];
        $location = "..\..\upload\PDF/";
        $mih = move_uploaded_file($file_path, $location . $file_name);
        if ($mih) {
            $insert_PDF = "INSERT INTO `material` VALUES (NULL,'$file_name','$PDFtital',$Unit_idPDF)";
            mysqli_query($conn, $insert_PDF);
            header("location: t_material.php");
        } else {
            echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>failed to upload</div></div>";
        }
    } else {
        echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>This extension is not valid</div></div>";
    }
}
if (isset($_GET['delUni'])) {
    deleteUnit($_GET['delUni'], $conn);
    $select = "SELECT * FROM `unit`  where T_id =" . $teacher->getid();
    $Selectsort = mysqli_query($conn, $select);
    $i = 1;
    if ($Selectsort) {
        foreach ($Selectsort as $data) {
            $select = "UPDATE `unit` SET U_number = $i WHERE U_id = " . $data['U_id'];
            $SelectsortS = mysqli_query($conn, $select);
            if (!$SelectsortS) {
                echo "SelectsortS: " . mysqli_error($conn);
            }
            $i++;
        }
    } else {
        echo "Selectsort " . mysqli_error($conn);
    }
    header("location: t_material.php");
}
if (isset($_GET['delPDF'])) {
    deletePDF($_GET['delPDF'], $conn);
    header("location: t_material.php");
}
if (isset($_GET['delVid'])) {
    deleteVideo($_GET['delVid'], $conn);
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
    <link rel="stylesheet" href="../../css/student/s_material.css">
    <link rel="stylesheet" href="../../css/teacher/t_material.css">
    <?php if($_SESSION['LANG'] == "ar"){ ?>
        <link rel="stylesheet" href="../../lang/css/navAR.css">
    <?php } ?>
    <title>materials</title>
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

    <!-- section chapters -->
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php foreach ($dataBaseRe as $data) { ?>
                    <section>
                        <!-- ********************************************************* -->
                        <div class="chapter">
                            <div class="d-flex justify-content-between">
                                <h4 class="d-inline-block"><?=$lang['chapter']?> <?php echo $data['U_number'] ?></h4>
                                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                                    <div class="text-right d-inline-block">
                                        <input type="hidden" name="delUni" value="<?php echo $data['U_id'] ?>">
                                        <button type="submit" class="btn">
                                            <i class="fas fa-times my-i"></i>
                                        </button>
                                    </div>
                                </form>

                            </div>
                            <?php
                            $showVideoFData = "SELECT * FROM `video` where U_id = " . $data['U_id'];
                            $video = mysqli_query($conn, $showVideoFData);
                            foreach ($video as $datavideo) {
                            ?>
                                <div class="video">

                                    <form class=" d-inline" action="t_video.php" method="GET">
                                        <input type="hidden" name="id" value="<?php echo $datavideo['V_id'] ?>">
                                        <button type="submit" class="btn d-inline-block">
                                            <img src="../../images/youtube-video.jpg" class="pdfimg" alt="video:">
                                            <span class="my-span"><?php echo $datavideo['V_name'] ?></span>
                                        </button>
                                    </form>

                                    <div class="dropdown text-right d-inline-block">
                                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                                            <i class="fas fa-ellipsis-h my-i my-i2 pdfimg1" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"></i>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <input type="hidden" name="delVid" value="<?php echo $datavideo['V_id'] ?>">
                                                <button class="dropdown-item"><?=$lang['remove']?></button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            $showPDFData = "SELECT * FROM `material` where U_id = " . $data['U_id'];
                            $PDF = mysqli_query($conn, $showPDFData);
                            foreach ($PDF as $dataPDF) {
                            ?>
                                <div class="pdf">
                                    <input type="hidden" name="path" value="<?php echo $dataPDF['M_path'] ?>">
                                    <input type="hidden" name="namePDF" value="<?php echo $dataPDF['M_name'] ?>">
                                    <button type="submit" class="btn">
                                        <img src="../../images/pdf.png" class="pdfimg" alt="pdf:">
                                        <a href="../../upload/PDF/<?php echo $dataPDF['M_path'] ?>" download><span class="my-span"><?php echo $dataPDF['M_name'] ?></span></a>

                                    </button>
                                    <div class="dropdown text-right d-inline-block">
                                        <form class="d-inline" action="<?php $_SERVER['PHP_SELF'] ?>" method="GET">
                                            <i class="fas fa-ellipsis-h my-i my-i2 pdfimg1" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"></i>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <input type="hidden" name="delPDF" value="<?php echo $dataPDF['M_id'] ?>">
                                                <button class="dropdown-item"><?=$lang['remove']?></button>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                            <button onclick="$(backGround).fadeIn('slow'); getid(this);" id="<?php echo $data['U_id']; ?>" class="btn btn-outline-success add-m"><i class="fas fa-plus-circle"></i></button>
                        </div>
                    </section>
                <?php } ?>
                <!-- button -->

                <a href="<?php $_SERVER['PHP_SELF'] ?>?createChapter" class="btn btn-outline-info w-100 mb-5 mt-3"><?=$lang['add_Chapter']?></a>
            </div>
        </div>
    </div>
    <!-- new material -->
    <div class="back-ground">
        <div class="cont">
            <div class="choose text-center">
                <div class="text-right">
                    <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
                </div>
                <p class="text-danger text-center mt-4" style="font-size: 40px;"><?=$lang['add_Content']?></p>
                <button class="btn btn-outline-success mr-5" id="btn-video"><?=$lang['video']?></button>
                <button class="btn btn-outline-success" id="btn-file"><?=$lang['file']?></button>
            </div>
        </div>
        <div class="cont video hidden" id="panel-video">
            <i class="fas fa-arrow-right float-right" id="arrow-video"></i>
            <div class="text-center">
                <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                    <label for="link" class="text-center"><?=$lang['link youtube']?></label>
                    <input type="text" name="link" placeholder="youtube link example:https://www.youtube.com/embed/-gn2mo7t5hM" class="form-control mt-2" id="link">
                    <label for="title" class="text-center"><?=$lang['title']?></label>
                    <input type="text" name="title" placeholder="<?=$lang['video title']?>" class="form-control mt-2" id="ttitle ">
                    <input type="hidden" class="U_id" name="Unit_id" value="">
                    <input type="submit" class="btn btn-primary w-50 mt-4" value="<?=$lang['upload']?>">
                </form>
            </div>
        </div>
        <div class="cont file hidden" id="panel-file">
            <div class="Fcontainer">
                <i class="fas fa-arrow-right float-right" id="arrow-file"></i>
                <h3 class="d-inline-block"><?=$lang['upload_your_File']?></h3>
                <div class="drag-area">
                    <form action="<?php $_SERVER['PHP_SELF'] ?>" class="text-center" method="POST" enctype="multipart/form-data">
                        <div class="icon">
                            <i class="fas fa-file-pdf"></i><i class="mr-1 ml-1 fas fa-file-powerpoint"></i><i class="fas fa-file-word"></i>
                        </div>
                        <span class="header">  <?=$lang['Drag & Drop']?></span> <br>
                        <span class="header">  <?=$lang['or']?><span class="button"><?=$lang['browse']?></span> </span> <br>
                        <span class="support"><?=$lang['Supports']?>: PDF,PPT,doc,rar,zip </span>
                        <div class="form-group">
                            <label for="PDFTitle" class="mt-3" style="font-size: 20px; font-weight: bold;"><?=$lang['title']?></label>
                            <input type="text" class="form-control" name="PDFtital" id="PDFTitle">
                        </div>
                        <input type="file" name="PDFfile" id="input" hidden>
                        <input type="hidden" class="U_id" name="Unit_idPDF" value="">
                        <input type="submit" class="btn btn-primary w-50 mt-4" value="<?=$lang['upload']?>">
                    </form>
                </div>
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
    <!-- my js -->
    <script src="../../js/teacher/t_material.js"></script>
    <script src="../../js/student/s_navbar.js"></script>
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