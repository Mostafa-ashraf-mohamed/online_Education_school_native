<?php
session_start();
?>
<!doctype html 5>
<html>

<head>

  <!--<script>
function message()
    {
      alert("are you sure you want to filter !");
    }
</script>-->
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>report</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">

  <!-- the font icon -->
  <link href="../../css/all.min.css" rel="stylesheet">
  <!-- bootstrab css -->
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->

  <!-- navbar -->
  <link rel="stylesheet" href="../../css/admin/a_teacher.css">
  <link rel="stylesheet" href="../../css/student/s_navbar.css">
  <link rel="stylesheet" href="../../css/admin/a_controls.css">
  <style>
    .container .row .teacherCard p {
      color: #444;
      font-size: 18px;
      text-align: center;
      margin-top: 5px;
      transition: .3s ease-in-out;
    }

    .tablediv {
      width: 1200px;
      height: 300px;
      margin-top: 40px;
      margin-left: 30px;
    }

    .table {
      background-color: #181818;
    }

    .tex1 {
      color: #df4759;
    }

    .tex2 {
      color: #42ba96;
    }
  </style>
</head>

<body>


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
          <a class="nav-link" href="a_teacher.php">Teachers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_students.php">return</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_tickets.php">tickets</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="a_home.php">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
            <div class="chip">
              <img src="../../images/img_avatar.png" alt="Person" width="96" height="96">
              Admin
            </div>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="a_setting.php">Settings</a>
            <a class="dropdown-item" href="#">اللغه العربيه</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="../../index.html">log out</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>

  <span class="filterIcon position-fixed"><i class="fas fa-filter"></i></span>
  <div class="d position-fixed">
    <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" class="con">
      <!--<div>
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      </div>--><br /><br />

      <div class="form-check form-switch">
        <!--<input class="form-check-input" type="checkbox" role="switch" id="gender" checked>-->
        <blockquote class="blockquote">
          <p>gender</p>
        </blockquote>
        <!-- <label class="form-check-label" for="flexSwitchCheckChecked"></label>-->
        <div class="form-check">
          <input class="form-check-input gender" type="radio" name="gender" id="exampleRadios1" value="male">
          <label class="form-check-label" for="exampleRadios1">
            Male
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input gender" type="radio" name="gender" id="exampleRadios1" value="female">
          <label class="form-check-label" for="exampleRadios1">
            Female
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input gender" type="radio" name="gender" id="exampleRadios1" value="all" checked>
          <label class="form-check-label" for="exampleRadios1">
            All
          </label>
        </div>
      </div>

      <div class="form-check form-switch">


        <blockquote class="blockquote">
          <p>specialty</p>
        </blockquote>

        <div class="form-check">
          <input class="form-check-input Scientific" type="radio" name="specialty" id="exampleRadios1" value="literary">
          <label class="form-check-label" for="exampleRadios1">
            literary
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input Scientific" type="radio" name="specialty" id="exampleRadios1" value="scientific">
          <label class="form-check-label" for="exampleRadios1">
            scientific
          </label>
        </div>

        <div class="form-check">
          <input class="form-check-input Scientific" type="radio" name="specialty" id="exampleRadios1" value="all2" checked>
          <label class="form-check-label" for="exampleRadios1">
            All
          </label>
        </div>

      </div>
      <input type="submit" value="Filter" onclick='message()' class="btn btn-outline-info btn-block mt-5">
    </form>
  </div>
  <br />
  <div class="tablediv">
    <?php
    include "../../PhpConfig/delete.php";
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $selectlitmal = "select * from student where D_id = 17 and st_gender = 'male' ";
      $selectlitfem = "select * from student where D_id = 17 and St_gender = 'female'";
      $selectlitall = "select * from student where D_id = 17";

      $selectscimal = "select * from student where D_id = 1 and St_gender = 'male' ";
      $selectscifem = "select * from student where D_id = 1 and St_gender = 'female'";
      $selectsciall = 'select * from student where D_id = 1  ';

      $selectall = 'select * from student ';

      $selectmal = "select * from student where St_gender = 'male' ";
      $selectfem = "select * from student where St_gender = 'female' ";

    ?>
      <br><br>
      <div class="container">

        <table class="table table-dark table-sm">
          <thead class="tex1">
            <tr>

              <th>picture</th>
              <th>First name</th>
              <th>Last name</th>
              <th>email</th>
              <th>gender</th>
              <th>phone number</th>
              <th>password</th>
              <th>Date of Birth</th>
            </tr>
          </thead>
          <tbody class='tex2'>

          <?php


          function disp($rer)
          {


            //$data=$rer->fetch_all(MYSQLI_ASSOC);
            foreach ($rer as $res) {

              echo "<tr>" . "<td>";
              if ($res['St_img'] != NULL) {
                echo " <img width='96px' height='96px' src='../../upload/img/" . $res['St_img'] . "' alt='Person'>";
              } else {
                if ($res['St_gender'] == 'male') {
                  echo " <img width='96px' height='96px' src='../../images/studentAvatar1.jpg' alt='Person'>";
                } else {
                  echo " <img width='96px' height='96px' src='../../images/studentAvatar2.png' alt='Person'>";
                }
              }

              echo "</td>" .
                "<td>" . @$res['St_fname'] . "</td><td>" . @$res['St_lname'] . "</td><td>" .
                @$res['St_email'] . "</td><td>" . @$res['St_gender'] . "</td>" .
                "<td>" . @$res['St_phNumber'] . "</td><td>" . @$res['St_password'] . "</td>" .
                "<td>" . @$res['St_DOB'] . "</td>";
              $sid = @$res['St_id'];

              echo "</tr>";
            }
          }
          //////////////////////////////////////////////////////////////////////////////////
          //


          if ($_POST['specialty'] == 'literary') {
            if ($_POST['gender'] == 'male') {
              //$conn->query($selectlitmal);
              $result = mysqli_query($conn, $selectlitmal);
              disp($result);
            } elseif ($_POST['gender'] == 'female') {


              $result = $conn->query($selectlitfem);
              disp($result);
            } elseif ($_POST['gender'] == 'all') {

              $result = $conn->query($selectlitall);
              disp($result);
            }
          } elseif ($_POST['specialty'] == 'scientific') {
            if ($_POST['gender'] == 'male') {

              $result = mysqli_query($conn, $selectscimal);

              disp($result);
            } elseif ($_POST['gender'] == 'female') {

              $result = mysqli_query($conn, $selectscifem);
              disp($result);
            } elseif ($_POST['gender'] == 'all') {
              $result = mysqli_query($conn, $selectsciall);
              disp($result);
            }
          }

          if ($_POST['gender'] == 'male') {
            if ($_POST['specialty'] == 'all2') {
              $result = mysqli_query($conn, $selectmal);
              disp($result);
            }
          } elseif ($_POST['gender'] == 'female') {
            if ($_POST['specialty'] == 'all2') {
              $result = mysqli_query($conn, $selectfem);
              disp($result);
            }
          } elseif ($_POST['specialty'] == 'all2') {
            if ($_POST['gender'] == 'all') {
              $result = mysqli_query($conn, $selectall);
              disp($result);
            }
          }
        }

          ?>

      </div>
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