<?php include("../../PhpConfig/config.php");
session_start();

if(isset($_GET['lang'])){
    $_SESSION['LANG']=$_GET['lang'];
}


if($_SESSION['LANG']=="en"){
    include "../../lang/en.php";
}else{
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

<!DOCTYPE html>
<html <?php if($_SESSION['LANG']=="en"):?>
    lang="en"
<?php else:?>
    lang="ar" dir="rtl"
<?php endif?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- CSS File -->
    <link href="../../css/admin/a_home.css" rel="stylesheet">

    <!-- bootstrab css -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="../../css/bootstrap.min.css">
    
    <!-- icon -->
    <link href="../../css/all.min.css" rel="stylesheet">
    <!--css links-->
    <link rel="stylesheet" href="../../css/admin/a_teacher.css">
    <link rel="stylesheet" href="../../css/student/s_navbar.css">
    <link rel="stylesheet" href="../../css/admin/a_controls.css">
    <?php if($_SESSION['LANG'] == "ar"){ ?>
        <link rel="stylesheet" href="../../lang/css/navAR.css">
    <?php } ?>
    <title>teacher list</title>
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
                    <a class="nav-link" href="a_subjects.php"><?=$lang['Subjects']?></a>
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
                    <a class="nav-link active" href="a_home.php"><?=$lang['Home']?></a>
                </li>
                <li class="nav-item dropdown " id="chipAR">
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

    <br><br><br><br><br>


    <!-- End Page Title -->
    <div class="container main">
        <section class="section dashboard">
            <div class="row">

                <!-- Left side columns -->
                <div class="col-lg-8">
                    <div class="row">

                        <!-- Sales Card -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card info-card sales-card">

                                <div class="card-body">
                                    <h5 class="card-title"><?=$lang['Students']?> </h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user-friends"></i>
                                        </div>
                                        <div class="px-3">
                                            <!-- php code hereeeeeeeeeeeeeeeeeeeeeeeeee -->
                                            <?php
                                            $rows = mysqli_query($conn, "SELECT * FROM `student`");
                                            $num = mysqli_num_rows($rows);
                                            ?>
                                            <h6><?= $num ?></h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Sales Card -->

                        <!-- Revenue Card -->
                        <div class="col-xl-4 col-md-6">
                            <div class="card info-card revenue-card">
                                <?php
                                $rows = mysqli_query($conn, "SELECT * FROM `department`");
                                $num = mysqli_num_rows($rows);
                                ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?=$lang['Departments']?> </h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-code-branch"></i>
                                        </div>
                                        <div class="px-3">
                                            <h6><?= $num ?></h6>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div><!-- End Revenue Card -->

                        <!-- Customers Card -->
                        <div class="col-md-12 col-xl-4">

                            <div class="card info-card customers-card">
                                <?php
                                $rows = mysqli_query($conn, "SELECT * FROM `teacher`");
                                $num = mysqli_num_rows($rows);
                                ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?=$lang['Teachers']?></h5>

                                    <div class="d-flex align-items-center">
                                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-chalkboard-teacher"></i>
                                        </div>
                                        <div class="px-3">
                                            <h6><?= $num ?></h6>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- End Customers Card -->

                        <!-- Reports -->
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <h5 class="card-title"><?=$lang['Report about materials & videos']?></h5>

                                    <!-- Line Chart -->
                                    <div id="reportsChart"></div>
                                    <?php
                                    $teachers = mysqli_query($conn, "SELECT * FROM `teacher`");
                                    ?>
                                    <script>
                                        document.addEventListener(
                                            "DOMContentLoaded", () => {
                                                new ApexCharts(document
                                                    .querySelector(
                                                        "#reportsChart"), {
                                                        series: [{
                                                            name: '<?=$lang['number of materials']?>',
                                                            data: [
                                                                <?php foreach ($teachers as $data) {
                                                                    $materials = mysqli_query($conn, "SELECT * FROM `teacher` NATURAL JOIN `unit` NATURAL JOIN `material` WHERE T_id = " . $data['T_id']);
                                                                    $num = mysqli_num_rows($materials);
                                                                    echo $num . ",";
                                                                } ?>
                                                            ],
                                                        }, {
                                                            name: '<?=$lang['number of videos']?>',
                                                            data: [
                                                                <?php foreach ($teachers as $data) {
                                                                    $videos = mysqli_query($conn, "SELECT * FROM `teacher` NATURAL JOIN `unit` NATURAL JOIN `video` WHERE T_id = " . $data['T_id']);
                                                                    $num = mysqli_num_rows($videos);
                                                                    echo $num . ",";
                                                                } ?>
                                                            ]
                                                        }],
                                                        chart: {
                                                            height: 350,
                                                            type: 'area',
                                                            toolbar: {
                                                                show: false
                                                            },
                                                        },
                                                        markers: {
                                                            size: 4
                                                        },
                                                        colors: ['#4154f1',
                                                            '#ff771d'
                                                        ],
                                                        fill: {
                                                            type: "gradient",
                                                            gradient: {
                                                                shadeIntensity: 1,
                                                                opacityFrom: 0.3,
                                                                opacityTo: 0.4,
                                                                stops: [0,
                                                                    90,
                                                                    100
                                                                ]
                                                            }
                                                        },
                                                        dataLabels: {
                                                            enabled: false
                                                        },
                                                        stroke: {
                                                            curve: 'smooth',
                                                            width: 2
                                                        }
                                                    }).render();
                                            });
                                    </script>
                                    <!-- End Line Chart -->

                                </div>

                            </div>
                        </div><!-- End Reports -->

                        <!-- Top Selling -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><?=$lang['number of teachers']?></h5>

                                    <!-- Bar Chart -->
                                    <canvas id="barChart" style="max-height: 400px;"></canvas>
                                    <script>
                                        <?php $subjects = mysqli_query($conn, "SELECT * FROM `subject`"); ?>
                                        document.addEventListener(
                                            "DOMContentLoaded", () => {
                                                new Chart(document
                                                    .querySelector(
                                                        '#barChart'), {
                                                        type: 'bar',
                                                        data: {
                                                            labels: [
                                                                <?php
                                                                foreach ($subjects as $data) {
                                                                    echo "\"" . $data['S_name'] . "\",";
                                                                } ?>
                                                            ],
                                                            datasets: [{
                                                                label: ' <?=$lang['number of teachers']." , ".$lang['Subjects']?>',
                                                                data: [
                                                                    <?php
                                                                    foreach ($subjects as $data) {
                                                                        $teachers = mysqli_query($conn, "SELECT * FROM `teacher` WHERE S_id = " . $data['S_id']);
                                                                        $num = mysqli_num_rows($teachers);
                                                                        echo $num . ",";
                                                                    } ?>
                                                                ],
                                                                backgroundColor: [
                                                                    'rgba(255, 99, 132, 0.2)'
                                                                ],
                                                                borderColor: [
                                                                    'rgb(255, 99, 132)'
                                                                ],
                                                                borderWidth: 1
                                                            }]
                                                        },
                                                        options: {
                                                            scales: {
                                                                y: {
                                                                    beginAtZero: true
                                                                }
                                                            }
                                                        }
                                                    });
                                            });
                                    </script>
                                    <!-- End Bar CHart -->

                                </div>
                            </div>
                        </div><!-- End Top Selling -->

                    </div>
                </div><!-- End Left side columns -->

                <!-- Right side columns -->
                <div class="col-lg-4">

                    <!-- Website Traffic -->
                    <div class="card">

                        <div class="card-body pb-0">
                            <h5 class="card-title"><?=$lang['number of Department']?></h5>

                            <div id="trafficChart" style="min-height: 400px;" class="echart"></div>

                            <script>
                                document.addEventListener("DOMContentLoaded",
                                    () => {
                                        echarts.init(document.querySelector(
                                            "#trafficChart")).setOption({
                                            tooltip: {
                                                trigger: 'item'
                                            },
                                            legend: {
                                                top: '5%',
                                                left: 'center'
                                            },
                                            series: [{
                                                name: 'Access From',
                                                type: 'pie',
                                                radius: ['40%',
                                                    '70%'
                                                ],
                                                avoidLabelOverlap: false,
                                                label: {
                                                    show: false,
                                                    position: 'center'
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: '18',
                                                        fontWeight: 'bold'
                                                    }
                                                },
                                                labelLine: {
                                                    show: false
                                                },
                                                data: [
                                                    <?php
                                                    $departments = mysqli_query($conn, "SELECT * FROM `department`");
                                                    foreach ($departments as $data) {
                                                        $studants = mysqli_query($conn, "SELECT * FROM `student` WHERE D_id = " . $data['D_id']);
                                                        $num = mysqli_num_rows($studants);
                                                    ?>, {
                                                            value: <?= $num ?>,
                                                            name: '<?= $data['D_name'] ?>'
                                                        },
                                                    <?php } ?>
                                                ]
                                            }]
                                        });
                                    });
                            </script>

                        </div>
                    </div><!-- End Website Traffic -->

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?=$lang['Gender']?></h5>

                            <!-- Pie Chart -->
                            <canvas id="pieChart" style="max-height: 400px;"></canvas>
                            <script>
                                document.addEventListener("DOMContentLoaded",
                                    () => {
                                        new Chart(document.querySelector(
                                            '#pieChart'), {
                                            type: 'pie',
                                            data: {
                                                labels: [
                                                    '<?=$lang['female']?>',
                                                    '<?=$lang['male']?>'
                                                ],
                                                datasets: [{
                                                    label: 'My First Dataset',
                                                    data: [
                                                        <?php
                                                        $males = mysqli_query($conn, "SELECT * FROM `student` WHERE St_gender = 'male'");
                                                        $numMales = mysqli_num_rows($males);
                                                        $females = mysqli_query($conn, "SELECT * FROM `student` WHERE St_gender = 'female'");
                                                        $numFemales = mysqli_num_rows($females);

                                                        echo $numFemales . "," . $numMales;
                                                        ?>
                                                    ],
                                                    backgroundColor: [
                                                        'rgb(255, 99, 132)',
                                                        'rgb(54, 162, 235)'
                                                    ],
                                                    hoverOffset: 4
                                                }]
                                            }
                                        });
                                    });
                            </script>
                            <!-- End Pie CHart -->

                        </div>
                    </div>

                </div><!-- End Right side columns -->

            </div>
        </section>
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
    <!-- <script>
                $("body").niceScroll({
                  cursorcolor: "#707070",
                  cursoropacitymin: 1,
                  cursoropacitymin: 1,
                  cursorwidth: "10px",
                  zindex: "auto" | [1000]
                });
                $(document).on('mouseover', 'body', function() {
                  $(this).getNiceScroll().resize();
                });
              </script> -->

    <script src="assets/chart.min.js"></script>
    <script src="assets/apexcharts.min.js"></script>
    <script src="assets/echarts.min.js"></script>

</body>

</html>