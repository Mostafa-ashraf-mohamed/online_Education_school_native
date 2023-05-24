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
$Did = $student->getDid();

$select = "SELECT * FROM `department` WHERE D_id = $Did";
$s = mysqli_query($conn, $select);
$ss = mysqli_fetch_assoc($s);


if (isset($_POST['old']) & isset($_POST['new'])) {
    $fname = test_input($_POST['fn']);
    $lname = test_input($_POST['ln']);
    $phone = test_input($_POST['phone']);
    $old = test_input($_POST['old']);
    $new = test_input($_POST['new']);

    if ($old == $student->getPassword()) {
        $student->setFname($fname);
        $student->setLname($lname);
        $student->setPhNumber($phone);
        $student->setPassword($new);

        $id = $student->getId();
        $update = "UPDATE `student` SET St_fname = '$fname' , St_lname = '$lname' , St_phNumber = $phone , St_password = '$new' WHERE St_id = $id";
        // $s = mysqli_query($conn,$update);
        if (mysqli_query($conn, $update)) {
            echo "<div class='alert alert-primary' role='alert'>Record updated successfully</div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>Error updating record: </div>";
        }
    } else {
        echo "<div class='alert alert-danger'>password is wrong</div>";
    }
}

$lengthPass = strlen($student->getPassword());

?>
<?php
if (isset($_POST['SubmitproImage'])) {
    if (substr($_FILES['proImage']['name'], ".jpg" || ".jpeg" || ".png" || ".PNG" || ".JPG" || ".JPEG") == true) {
        $file_name = $student->getId()."profile" . time() . $_FILES['proImage']['name'];
        $file_path = $_FILES['proImage']['tmp_name'];
        $location = "..\..\upload\img/";
        $mih = move_uploaded_file($file_path, $location . $file_name);
        if ($mih) {
            $proImgName = "C:/xampp\htdocs\aast\web project\upload\img/" . $student->getImg();
            if (file_exists($proImgName)) {
                if (!unlink($proImgName)) {
                    echo 'The file ' . $student->getImg() .
                        ' cant deleted successfully!';
                }
            }
            $UPDATE_proImg = "UPDATE `student` SET St_img = '$file_name' where St_id=".$student->getId();
            mysqli_query($conn, $UPDATE_proImg);
            $student->setImg($file_name);
            header("location: s_profile.php");
        } else {
            echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>failed to upload</div></div>";
        }
    } else {
        echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>This extension is not valid</div></div>";
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
    <title>Profile</title>
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
    <?php if($_SESSION['LANG'] == "ar"){ ?>
        <link rel="stylesheet" href="../../lang/css/navAR.css">
    <?php } ?>
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
        <li class="nav-item ">
          <a class="nav-link " href="s_home.php"><?=$lang['Home']?></a>
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

    <br><br><br><br><br>
    <!-- body -->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-12 p-0">
                <div class="profile-img">

                    <?php if ($student->getImg() != NULL) { ?>
                        <img src="../../upload/img/<?= $student->getImg() ?>" alt="Person" class="image" id="imgedit">
                        <?php } else {
                        if ($student->getGender() == 'male') { ?>
                            <img src="../../images/studentAvatar1.jpg" alt="Person" class="image" id="imgedit">
                        <?php } else { ?>
                            <img src="../../images/studentAvatar2.png" alt="Person" class="image" id="imgedit">
                    <?php }
                    } ?>
                    <!-- imgEdit -->
                    <form action="s_profile.php" method="POST" enctype="multipart/form-data">
                        <input type="file" id="input" name="proImage" onchange="readURL(this);" hidden>
                        <button type="submit" id="proImgSub" name="SubmitproImage" class="btn btn-primary mt-2" hidden>Save</button>
                    </form>
                    <button id="proImgCan" class="btn btn-danger mt-2" hidden>cancel</button>
                    <h3 class="mt-3 mb-3"><?php echo $student->getFname(); ?></h3>
                    <p><?=$lang['department']?>: <?php echo $ss['D_name'] ?></p>
                </div>
            </div>
            <div class="col-md-8 col-12">
                <div class="profile">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th scope="row"><?=$lang['full_name']?>:</th>
                                <td><?php echo $student->getFname() . " " . $student->getLname(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=$lang['Email']?>:</th>
                                <td><?php echo $student->getEmail(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=$lang['date of birth']?>:</th>
                                <td><?php echo $student->getDOB(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=$lang['Gender']?>:</th>
                                <td><?php echo $student->getGender(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=$lang['phone number']?>:</th>
                                <td><?php echo $student->getPhNumber(); ?></td>
                            </tr>
                            <tr>
                                <th scope="row"><?=$lang['Password']?>:</th>
                                <td><?php for ($i = 0; $i < $lengthPass; $i++) echo "*" ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-center">
                    <button id="edit" name="edit" class="btn btn-info my-btn"><i class="fas fa-user-edit"></i></button>
                </div>
            </div>
        </div>
    </div>

    <!-- edit -->
    <div class="back-edit">
        <div class="edit">
            <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
            <h3 class="text-danger"><?=$lang['edit_my_data']?></h3>
            <hr>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <table class="table-edit">
                    <tr>
                        <th><label for="fn"><?=$lang['first name']?>:</label></th>
                        <td><input type="text" id="fn" name="fn" class="form-control" value="<?php echo $student->getFname(); ?>"></td>
                    </tr>
                    <tr>
                        <th> <label for="ln"><?=$lang['last name']?>:</label></th>
                        <td><input type="text" id="ln" name="ln" class="form-control" value="<?php echo $student->getLname(); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="phone"><?=$lang['phone number']?>:</label></th>
                        <td><input type="text" id="phone" name="phone" class="form-control" value="<?php echo $student->getPhNumber(); ?>"></td>
                    </tr>
                    <tr>
                        <th><label for="old"><?=$lang['Old Password']?>:</label></th>
                        <td><input type="password" id="old" name="old" class="form-control"></td>
                    </tr>
                    <tr>
                        <th><label for="new"><?=$lang['New Password']?>:</label></th>
                        <td><input type="password" id="new" name="new" class="form-control"></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button name="save" id="save" class="btn btn-info btn-block mt-4"><?=$lang['save']?></button>
                        </td>
                    </tr>
                </table>
            </form>
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
    <script src="../../js/student/s_profile.js"></script>
    <!-- navber js -->
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