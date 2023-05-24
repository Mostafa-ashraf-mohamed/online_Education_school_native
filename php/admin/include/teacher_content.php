<div class="col-12 col-lg-4 d-flex justify-content-center">
    <a href="a_information_profile.php?teacher_id=<?= $res['T_id']?>" class="btn">
        <div class="teacherCard">
            <?php if ($res['T_img'] != NULL) {
                echo " <img src='../../upload/img/" . $res['T_img'] . "' alt='Person' class='card-img-top'>";
            } else {
                if ($res['T_gender'] == 'male') {
                    echo " <img src='../../images/img_avatar.png' alt='Person' class='card-img-top'>";
                } else {
                    echo " <img src='../../images/img_avatar2.png' alt='Person' class='card-img-top'>";
                }
            }
            ?>
            <div class="teacherBody">
                <i class="text-info fas fa-info-circle"></i>
            </div>
            <p class="text-center">
                <?php
                echo $res['T_fname'] . ' ' . $res['T_lname'];
                ?>
            </p>
        </div>
    </a>
</div>