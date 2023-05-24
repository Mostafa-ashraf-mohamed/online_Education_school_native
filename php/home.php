<?php
if (isset($_GET['exit'])) {
    session_start();
    $lang=$_SESSION['LANG'];
    session_unset();
    session_destroy();
}
?>
<?php
include "../PhpConfig/config.php";
include "../PhpConfig/OOP.php";
session_start();
if(isset($lang)){
    $_SESSION['LANG']=$lang;
}


if(isset($_GET['lang'])){
    $_SESSION['LANG']=$_GET['lang'];
}

if(!isset($_SESSION['LANG'])){
    $_SESSION['LANG']="en";
}

if($_SESSION['LANG']=="en"){
    include "../lang/en.php";
}else{
    include "../lang/ar.php";
}
$F_name = "";
$F_nameerr = false;
$L_name = "";
$L_nameerr = false;
$phone_number = "";
$phone_numbererr = false;
$c_email = "";
$c_emailerr = false;
$c_password = "";
$c_passworderr = false;
$DOB = "";
$DOBerr = false;
$gender = "";
$gendereerr = false;
$department = "";
$departmenterr = false;

$create = false;

$email = "";
$password = "";
$dataBaseRe;
error_reporting(E_ERROR | E_PARSE);
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (strpos($email, '@teacher.school.edu') == true) {
        $showData = "SELECT * FROM `teacher` where T_email ='$email' and T_password='$password' ";/* get all teacher data to list */
        $dataBaseRe = mysqli_query($conn, $showData);
        $rownum = mysqli_num_rows($dataBaseRe);
        $f = mysqli_fetch_assoc($dataBaseRe);
        if ($rownum > 0) {
            $_SESSION['user'] = new Teacher($f['T_id'], $f['T_fname'], $f['T_lname'], $f['T_gender'], $f['T_email'], $f['T_img'], $f['S_id'], $f['T_phNumber'], $f['T_password']);
            $_SESSION['type']="teacher";
            header("location: teacher/t_material.php");
        } else {
            echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-dark w-25 m-auto text-center' role='alert'>username or password wrong</div></div>";
        }
    } elseif ($email == "admin.0@admin.school.edu" && $password == "1234") {
        $_SESSION['type']="admin";
        header("location: admin/a_home.php");
    } else{
        $showData = "SELECT * FROM `student` where St_email ='$email' and St_password='$password' ";/* get all student data to list */
        $dataBaseRe = mysqli_query($conn, $showData);
        $f = mysqli_fetch_assoc($dataBaseRe);
        if (mysqli_num_rows($dataBaseRe) > 0) {

            $showData = "SELECT * FROM `block` where St_id =" . $f['St_id'];/* get all student data to list */
            $dataBaseRe = mysqli_query($conn, $showData);
            if (mysqli_num_rows($dataBaseRe) > 0) {
                $s = mysqli_fetch_assoc($dataBaseRe);
                echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>you are blocked to use our services<br>because this comment \" " . $s['comment'] . " \"</div></div>";
            } else {
                $_SESSION['user'] = new Student($f['St_id'], $f['St_fname'], $f['St_lname'], $f['St_gender'], $f['St_email'], $f['St_DOB'], $f['St_img'], $f['D_id'], $f['St_phNumber'], $f['St_password']);
                $_SESSION['type']="student";
                header("location: student/s_home.php");
            }
        } else {
            echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-danger w-25 m-auto text-center' role='alert'>username or password wrong</div></div>";
        }
    }
} else if (isset($_GET['create'])) {
    $create = true;
    if (isset($_POST['F_name'])) {
        $F_name = test_input($_POST['F_name']);
        if (!preg_match("/^[A-Za-zا-ي ]*$/", $F_name)) {
            $f_namerr = true;
        }
    }
    if (isset($_POST['L_name'])) {
        $L_name = test_input($_POST['L_name']);
        if (!preg_match("/^[A-Za-zا-ي ]*$/", $L_name)) {
            $L_nameerr = true;
        }
    }
    if (isset($_POST['phonenumber'])) {
        $phone_number = test_input($_POST['phonenumber']);
        if (!preg_match("/^[0-9]*$/", $phone_number)) {
            $phone_numbererr = true;
        }
    }
    if (isset($_POST['c_email'])) {
        $c_email = test_input($_POST['c_email']);
        if (!filter_var($c_email, FILTER_VALIDATE_EMAIL)) {
            $c_emailerr = true;
        }
    }
    if (isset($_POST['c_password'])) {
        $c_password = test_input($_POST['c_password']);
        if ($c_password == "") {
            $c_passworderr = true;
        }
    }
    if (isset($_POST['DOB'])) {
        $DOB = test_input($_POST['DOB']);
        $DOB = date('Y-m-d', strtotime($DOB));
        if ($DOB == "") {
            $DOBerr = true;
        }
    }
    if (isset($_POST['gender'])) {
        $gender = test_input($_POST['gender']);
        if ($gender != "female" || $gender != "male") {
            $gendererr = true;
        }
    }
    if (isset($_POST['department'])) {
        $department = test_input($_POST['department']);
    }
    if ($F_nameerr == false && $L_nameerr == false && $phone_numbererr == false && $c_emailerr == false && $departmenteerr == false && $c_passworderr == false && $DOBerr == false && $gendereerr == false && isset($_POST['F_name'])) {
        $showData = "INSERT INTO `student`VALUES (NULL, $phone_number, '$F_name', '$L_name', '$gender','$DOB','','$c_password',$department,'$c_email');";
        $dataBaseRe = mysqli_query($conn, $showData);
        if ($dataBaseRe) {
            header("location: " . $_SERVER['PHP_SELF']);
            echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-success alert-dismissible fade show' role='alert'>
        Email was create.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div></div>";
        } else {
            echo "<div class='w-100 position-absolute' style='margin-top:-83px !important;'><div class='alert alert-denger alert-dismissible fade show' role='alert'>
            " . mysqli_error($conn) . "
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div></div>";
        }
    }
}

?>
<!DOCTYPE html>
<html 
<?php if($_SESSION['LANG']=="en"):?>
    lang="en"
<?php else:?>
    lang="ar" dir="rtl"
<?php endif?>

>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>online learning</title>
  <link rel="icon" href="../images/icon.png">
    <!-- the font text -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- the font icon -->
    <link href="../css/all.min.css" rel="stylesheet">
    <!-- bootestrab css -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> -->
    <!-- my css -->
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="login">
        <div class="w-100 text-center">
            <h1 class="h1-style mb-4"><?= $lang['login']?></h1>
        </div>
        <div>
        <section >
            <form method="GET">
                <?php if($_SESSION['LANG']=="en"):?>
                    <input type="hidden" name="lang" value="ar">
                <?php else:?>
                    <input type="hidden" name="lang" value="en">
                <?php endif?>
                <button class="btn text-primary" type="submit"><i style="font-size:30px;" class="fas fa-language"></i></button>
            </form>
        </section>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <input type="email" class="form-control my-3" value="<?php echo "$email" ?>" name="email" placeholder="<?= $lang['email']?>" required>
                <input type="password" class="form-control my-3 mb-3" name="password" value="<?php echo "$password" ?>" placeholder="<?= $lang['password']?>" required>
                <input class="btn btn-info btn-block mt-4 mb-2" type="submit" value="<?= $lang['login']?>" />
            </form>
            <div class="w-100 mt-3">
                <center><a href="<?php $_SERVER['PHP_SELF'] ?>?create" class="btn btn-success w-75" id="account"><?= $lang['create new account']?></a></center>
            </div>
        </div>
    </div>
    <!--create new account-->
    <div class="create">
        <div class="cont">
            <i class="far fa-times-circle" id="exit" style="font-size: 30px; text-align: center; cursor: pointer;"></i>
            <h2><?= $lang['Sign Up']?></h2>
            <p><?= $lang['It is quick and easy.']?></p>
            <hr>
            
            <form class="was-validated" action="" method="POST">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <input type="text" name="F_name" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" placeholder="<?= $lang['first name']?>" required>
                        <?php if ($F_nameerr) {
                        ?>
                            <div class="more-ot-alert name">
                                <span class="close-ot-alert">
                                    <i class="fas fa-times-circle closeAl"></i>
                                </span>
                                <p>
                                    <strong>first and Last name</strong> must be for letter only only.
                                </p>
                            </div>
                        <?php  }
                        ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <input type="text" name="L_name" class="form-control is-invalid" aria-describedby="validatedInputGroupPrepend" placeholder="<?= $lang['last name']?>" required>
                        <?php if ($F_nameerr) { ?>
                            <div class="more-ot-alert name">
                                <span class="close-ot-alert">
                                    <i class="fas fa-times-circle closeAl"></i>
                                </span>
                                <p>
                                    <strong>first and Last name</strong> must be for letter only only.
                                </p>
                            </div>
                        <?php } ?>
                    </div>
                    <input type="text" name="phonenumber" class="form-control is-invalid s1" maxlength="11" aria-describedby="validatedInputGroupPrepend" placeholder="<?= $lang['phone number']?>" required />
                    <?php if ($phone_numbererr) {
                    ?>
                        <div class="more-ot-alert phonenumber">
                            <span class="close-ot-alert">
                                <i class="fas fa-times-circle closeAl"></i>
                            </span>
                            <p>
                                <strong>phone_number</strong> number only.
                            </p>
                        </div>
                    <?php  }
                    ?>
                    <input type="email" name="c_email" class="form-control is-invalid s1" aria-describedby="validatedInputGroupPrepend" placeholder="<?= $lang['email']?>" required>
                    <?php if ($c_emailerr) {
                    ?>
                        <div class="more-ot-alert Email">
                            <span class="close-ot-alert">
                                <i class="fas fa-times-circle closeAl"></i>
                            </span>
                            <p>
                                <strong>E-mail</strong> Provide a valid email format.
                            </p>
                        </div>
                    <?php }
                    ?>
                    <input type="password" name="c_password" class="form-control is-invalid s1" aria-describedby="validatedInputGroupPrepend" placeholder="<?= $lang['password']?>" required>
                    <?php if ($c_passworderr) { ?>
                        <div class="more-ot-alert pass">
                            <span class="close-ot-alert">
                                <i class="fas fa-times-circle closeAl"></i>
                            </span>
                            <p>
                                <strong>password</strong> has to be at least one number
                                and at least one letter
                                and it has to be a number, a letter or one of the following: !@#$%
                                and there have to be 8-12 characters.
                            </p>
                        </div>
                    <?php } ?>
                    <label class="style-1"><?= $lang['Date of birth:']?></label>
                    <input type="date" name="DOB" class="form-control is-invalid s2" aria-describedby="validatedInputGroupPrepend" required>
                    <?php if ($DOBerr) {
                    ?>
                        <div class="more-ot-alert DOB">
                            <span class="close-ot-alert">
                                <i class="fas fa-times-circle closeAl"></i>
                            </span>
                            <p>
                                <strong>date of birth</strong> Must be in form of date
                            </p>
                        </div>
                    <?php }
                    ?>
                    <label class="style-2"><?= $lang['Gender:']?></label>
                    <div class="div-1">
                        <label for="male" class="gender"><?= $lang['Male']?></label>
                        <input type="radio" id="male" name="gender" value="male" class="radio">
                    </div>
                    <div class="div-1">
                        <label for="female" class="gender"><?= $lang['Female']?></label>
                        <input type="radio" id="female" name="gender" value="female" class="radio">
                    </div>
                    <?php if ($gendereerr) { ?>
                        <div class="alert alert-denger alert-dismissible fade show" role="alert">
                            <strong>phone_number</strong> must be select.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <?php
                    $showDatadepartment = "SELECT * FROM `department`";
                    $dataBaseReDepartment = mysqli_query($conn, $showDatadepartment);
                    ?>
                    <label class="style-2 mr-2"><?= $lang['department:']?></label>
                    <?php
                    foreach ($dataBaseReDepartment as $DepartmentList) {
                    ?>
                        <div class="div-1">
                            <label for="alme" class="gender"><?php echo $DepartmentList['D_name'] ?></label>
                            <input type="radio" id="alme" name="department" value="<?php echo $DepartmentList['D_id'] ?>" class="radio">
                        </div>
                    <?php } ?>
                    <?php if ($departmenteerr) { ?>
                        <div class="alert alert-denger alert-dismissible fade show" role="alert">
                            <strong>phone_number</strong> must be select.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php } ?>
                    <input class="btn btn-success signup" type="submit" value="Sign Up">
                </div>
            </form>
        </div>
    </div>

    <!-- bootestrab js -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous">
    </script> -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <!-- My JS -->
    <script src="../js/login.js"></script>
    <script>
        <?php if ($create) {
            if ($c_passworderr == true | $c_email == true | $f_namerr == true | $L_nameerr == true | $phone_numbererr == true | $c_emailerr == true | $c_passworderr == true | $DOBerr == true | $gendereerr == true | $departmenterr == true) {
                echo "openAlert();";
            }
            echo "$(create).fadeIn('slow');";
        } ?>
    </script>
</body>

</html>