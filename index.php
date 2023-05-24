<?php
include "PhpConfig/config.php";
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>School home page</title>
  <link rel="icon" href="images/icon.png">
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- the font icon -->
  <link href="css/all.min.css" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/aos.css" rel="stylesheet">
  <link href="assets/bootstrap.min.css" rel="stylesheet">

  <!--  Main CSS File -->
  <link href="assets/style.css" rel="stylesheet">

</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
      <h1 class="logo me-auto"><a href="index.php"><img src="images/logo.jpeg" alt="school logo"></a></h1>
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#courses">Courses</a></li>
          <li><a href="#trainers">Trainers</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

      <a href="php/home.php" class="get-started-btn">Get Started</a>

    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex justify-content-center align-items-center">
    <div class="container position-relative" data-aos="zoom-in" data-aos-delay="100">
      <h1>Learning Today,<br>Leading Tomorrow</h1>
      <h2>We are school online</h2>
      <a href="php/home.php" class="btn-get-started">Get Started</a>
    </div>
  </section><!-- End Hero -->

  <main id="main">

    <!-- ======= About Section ======= -->
    <section id="about" class="about">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-left" data-aos-delay="100">
            <img src="images/about.jpg" class="img-fluid" alt="">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content">
            <h3>Learning Today,Leading Tomorrow on Online school</h3>
            <p class="fst-italic">
            Studying online at your own convenience allows you to no longer worry about class location when choosing what to learn next. By taking an online course, you can really focus on the subject you are interested in and choose from the variety of online courses and programs.
            </p>
            <ul>
              <li><i class="bi bi-check-circle"></i> Online school will give you the fast easy way to learn</li>
              <li><i class="bi bi-check-circle"></i> Online school will answer your question fast by our teacher</li>
              <li><i class="bi bi-check-circle"></i> In Online school you will find a great number of Learing contant</li>
            </ul>
            <p>
            Studying online at your own convenience allows you to no longer worry about class location when choosing what to learn next
            </p>

          </div>
        </div>

      </div>
    </section><!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="counts" class="counts section-bg">
      <div class="container">

        <div class="row counters">

          <!-- php need acess on database to know how many course and teacher and student we have -->
          <?php
          $rows = mysqli_query($conn, "SELECT * FROM `student`");
          $num = mysqli_num_rows($rows);
          ?>
          <div class="col-lg-4 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?= $num ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Students</p>
          </div>

          <?php
          $rows = mysqli_query($conn, "SELECT * FROM `subject`");
          $num = mysqli_num_rows($rows);
          ?>
          <div class="col-lg-4 col-6 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?= $num ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>subjects</p>
          </div>

          <?php
          $rows = mysqli_query($conn, "SELECT * FROM `teacher`");
          $num = mysqli_num_rows($rows);
          ?>
          <div class="col-lg-4 col-12 text-center">
            <span data-purecounter-start="0" data-purecounter-end="<?= $num ?>" data-purecounter-duration="1" class="purecounter"></span>
            <p>Teachers</p>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Why Us Section ======= -->
    <section id="why-us" class="why-us">
      <div class="container" data-aos="fade-up">

        <div class="row">
          <div class="col-lg-4 d-flex align-items-stretch">
            <div class="content">
              <h3>Why Choose teacher?</h3>
              <!-- reason why we choose teacher -->
              <p>
                Studying online at your own convenience allows you to no longer worry about class location when choosing
                what to learn next. By taking an online course, you can really focus on the subject you are interested
                in and choose from the variety of online courses and programs.
              </p>
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                  <i class="fab fa-etsy"></i>
                    <h4>Easy to learn</h4>
                    <p>Online school will give you the fast easy way to learn</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                  <i class="fas fa-question"></i>
                    <h4>answer your question </h4>
                    <p>Online school will answer your question fast by our teacher</p>
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch">
                  <div class="icon-box mt-4 mt-xl-0">
                  <i class="fab fa-leanpub"></i>
                    <h4>online courses and programs</h4>
                    <p>in Online school you will find a great number of Learing contant</p>
                  </div>
                </div>
              </div>
            </div><!-- End .content-->
          </div>
        </div>

      </div>
    </section><!-- End Why Us Section -->

    <!-- ======= Popular Courses Section ======= -->
    <section id="courses" class="courses">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Department</h2>
          <p>available Department</p>
        </div>

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
            <div class="carousel-item active">
              <div class="row" data-aos="zoom-in" data-aos-delay="100">

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                  <div class="course-item">
                    <img src="images/shutterstock_582084685.jpg" class="img-fluid" alt="...">
                    <div class="course-content">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>علمي</h4> <!-- esm el course-->
                        <p class="price">$Free</p>
                      </div>


                    </div>
                  </div>
                </div> <!-- End Course Item-->

                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
                  <div class="course-item">
                    <img src="images/course6.jpg" class="img-fluid" alt="...">
                    <div class="course-content">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>أدبي</h4>
                        <p class="price">$Free</p>
                      </div>


                    </div>
                  </div>
                </div> <!-- End Course Item-->
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-lg-0">
                  <div class="course-item">
                    <img src="images/InkediAag6newcoursescomingsoon.jpg" class="img-fluid" alt="...">
                    <div class="course-content">
                      <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>more courses coming soon</h4>
                        <p class="price">$Free</p>
                      </div>

                    </div>
                  </div>
                </div> <!-- End Course Item-->

              </div>

              <!-- start course item  -->
              <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <!-- End Course Item-->

              </div>

            </div>
    </section>



    <!-- End Popular Courses Section -->

    <!-- ======= Trainers Section ======= -->
    <section id="trainers" class="trainers">
      <div class="container" data-aos="fade-up">

        <div class="row" data-aos="zoom-in" data-aos-delay="100">
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="images/trainers/trainer-1.jpg" class="img-fluid" alt="">
              <div class="member-content">
                <h4>Ahmmed Khaled</h4>
                <span>department - 1</span>


              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="images/trainers/trainer-2.jpg" class="img-fluid" alt="">
              <div class="member-content">
                <h4>mona Adel</h4>
                <span>department - 2</span>

              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="member">
              <img src="images/trainers/trainer-3.jpg" class="img-fluid" alt="">
              <div class="member-content">
                <h4>Ali Hassan</h4>
                <span>علمي - كيمياء</span>

              </div>
            </div>
          </div>






        </div>

      </div>
    </section><!-- End Trainers Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>School</h3>
            <p>
              A108 Adam Street <br>
              Nasr City, NY 535022<br>
              Cairo <br><br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <strong>Phone:</strong> +1 5589 55488 55<br>
            <strong>Email:</strong> onlin@school.edu<br>

          </div>

        </div>
      </div>
    </div>

    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>your company</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
          Designed by 000000</a>
        </div>
      </div>
       <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="#" class="twitter"><i class="fab fa-twitter"></i></a>
        <a href="#" class="facebook"><i class="fab fa-facebook"></i></a>
        <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
        <a href="#" class="linkedin"><i class="fab fa-linkedin"></i></a>
        <a href="#" class="google-plus"><i class="fab fa-skype"></i></a>
      </div> 
    </div>

  </footer><!-- End Footer -->
  <div id="preloader"></div>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="fas fa-arrow-up"></i></a> <!-- Vendor JS Files -->


  <script src="assets/aos.js"></script>
  <script src="assets/purecounter.js"></script>
  <script src="assets/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/main.js"></script>

</body>

</html>