<?php
include "config.php";
?>
<?php
function deleteAnswer($C_id, $conn)
{
    $sql = "DELETE FROM answer WHERE C_id=$C_id;";
    $testIfCor = mysqli_query($conn, $sql);
    if ($testIfCor) {
        return true;
    } else {
        echo "Answer" . mysqli_error($conn);
    }
    return false;
}
function deleteComment($C_id, $conn)
{
    $select = "SELECT * FROM `comment` where C_id=$C_id";
    $SelectCom = mysqli_query($conn, $select);
    if ($SelectCom) {
        foreach ($SelectCom as $data) {
            deleteAnswer($data['C_id'], $conn);
            $sql = "DELETE FROM comment WHERE C_id=" . $data['C_id'];
            $testIfCor = mysqli_query($conn, $sql);
            if (!$testIfCor) {
                echo "del Comment:" . mysqli_error($conn);
            }
        }
    } else {
        echo "Comment" . mysqli_error($conn);
    }
}
function deleteVideo($V_id, $conn)
{
    $select = "SELECT * FROM `comment` NATURAL JOIN `video` where V_id=$V_id";
    $SelectVid = mysqli_query($conn, $select);
    if ($SelectVid) {
        foreach ($SelectVid as $data) {
            deleteComment($data['C_id'], $conn);
        }
        $sql = "DELETE FROM video WHERE V_id=" . $V_id;
        $testIfCor = mysqli_query($conn, $sql);
        if (!$testIfCor) {
            echo "del video:" . mysqli_error($conn);
        }
    } else {
        echo "video" . mysqli_error($conn);
    }
}
function deletePDF($M_id, $conn)
{
    $select = "SELECT * FROM `material`  where M_id=" . $M_id;
    $SelectPDFToDel = mysqli_query($conn, $select);
    foreach ($SelectPDFToDel as $data) {
        $filename = "C:/xampp\htdocs\AAST\web project\upload\PDF/" . $data['M_path'];
        if (!unlink($filename)) {
            echo 'The file ' . $data['M_path'] . ' cant deleted successfully!';
        }
    }
    $sql = "DELETE FROM material where M_id=" . $M_id;
    $testIfCor = mysqli_query($conn, $sql);
    if (!$testIfCor) {
        echo "del material:" . mysqli_error($conn);
    }
}
function deleteUnit($U_id, $conn)
{
    $select = "SELECT * FROM `video` NATURAL JOIN `unit`  where U_id=$U_id";
    $Selectunit = mysqli_query($conn, $select);
    if ($Selectunit) {
        foreach ($Selectunit as $data) {
            deleteVideo($data['V_id'], $conn);
        }
    }

    $select = "SELECT * FROM `material` NATURAL JOIN `unit`  where U_id=$U_id";
    $Selectmaterial = mysqli_query($conn, $select);
    if ($Selectmaterial) {
        foreach ($Selectmaterial as $data) {
            deletePDF($data['M_id'], $conn);
        }
    }

    if ($Selectmaterial && $Selectunit) {
        $sql = "DELETE FROM unit WHERE U_id=" . $U_id;
        $testIfCor = mysqli_query($conn, $sql);
        if (!$testIfCor) {
            echo "del unit:" . mysqli_error($conn);
        }
    }
}
function deleteTeacher($T_id, $conn)
{
    $select = "SELECT * FROM `teacher` NATURAL JOIN `unit`  where T_id=$T_id";
    $SelectTeacher = mysqli_query($conn, $select);
    if ($SelectTeacher) {
        foreach ($SelectTeacher as $data) {
            deleteUnit($data['U_id'], $conn);
        }
        $select = "SELECT * FROM `teacher`  where T_id=$T_id";
        $SelectTeacher = mysqli_query($conn, $select);
        $proImgName = "C:/xampp\htdocs\aast\web project\upload\img/" . mysqli_fetch_assoc($SelectTeacher)['T_img'];
        if (file_exists($proImgName)) {
            if (!unlink($proImgName)) {
                echo 'The file ' . mysqli_fetch_assoc($SelectTeacher)['T_img'] .' cant deleted successfully!';
            }
        }
        $sql = "DELETE FROM teacher WHERE T_id=" . $T_id;
        $testIfCor = mysqli_query($conn, $sql);
        if (!$testIfCor) {
            echo "del teacher:" . mysqli_error($conn);
            return false;
        }
    }
}
function deleteSubject($S_id, $conn)
{
    $select = "SELECT * FROM `subject` NATURAL JOIN `teacher`  where S_id=$S_id";
    $Selectsubject = mysqli_query($conn, $select);
    if ($Selectsubject) {
        foreach ($Selectsubject as $data) {
            deleteTeacher($data['T_id'], $conn);
        }
        $sql = "DELETE FROM subject WHERE S_id=" . $S_id;
        $testIfCor = mysqli_query($conn, $sql);
        if (!$testIfCor) {
            echo "del subject:" . mysqli_error($conn);
        }
    }
}
function deleteDepartment($D_id, $conn)
{
    $select = "SELECT * FROM `department` NATURAL JOIN `subject`  where D_id=$D_id";
    $Selectdepartment = mysqli_query($conn, $select);
    if ($Selectdepartment) {
        foreach ($Selectdepartment as $data) {
            deleteSubject($data['S_id'], $conn);
        }
    }
    $select = "SELECT * FROM `department` NATURAL JOIN `student`  where D_id=$D_id";
    $Selectdepartment = mysqli_query($conn, $select);
    if ($Selectdepartment) {
        foreach ($Selectdepartment as $data) {
            deleteStudent($data['St_id'], $conn);
        }
    }
    $sql = "DELETE FROM department WHERE D_id=" . $D_id;
    $testIfCor = mysqli_query($conn, $sql);
    if (!$testIfCor) {
        echo "del department:" . mysqli_error($conn);
    }
}
function deleteStudent($St_id, $conn)
{
    $select = "SELECT * FROM `comment`  where St_id=$St_id";
    $SelectStudent = mysqli_query($conn, $select);
    if ($SelectStudent) {
        foreach ($SelectStudent as $data) {
            deleteComment($data['C_id'], $conn);
        }
    }
    $select = "SELECT * FROM `student`  where St_id=$St_id";
    $SelectStudent = mysqli_query($conn, $select);
    $proImgName = "C:/xampp\htdocs\aast\web project\upload\img/" . mysqli_fetch_assoc($SelectStudent)['St_img'];
    if (file_exists($proImgName)) {
        if (!unlink($proImgName)) {
            echo 'The file ' . mysqli_fetch_assoc($SelectStudent)['St_img'] .' cant deleted successfully!';
        }
    }
    deleteTicket($St_id, $conn);
    deleteBlock($St_id, $conn);
    $sql = "DELETE FROM student WHERE St_id=" . $St_id;
    $testIfCor = mysqli_query($conn, $sql);
    if (!$testIfCor) {
        echo "del student:" . mysqli_error($conn);
    }
}

function deleteTicket($St_id, $conn)
{
    $select = "SELECT * FROM `ticket`  where St_id=$St_id";
    $SelectTickets = mysqli_query($conn, $select);
    if ($SelectTickets) {
        foreach ($SelectTickets as $data) {
            $sql = "DELETE FROM ticket WHERE Ti_id=" . $data['Ti_id'];
            $testIfCor = mysqli_query($conn, $sql);
            if (!$testIfCor) {
                echo "del Ticket:" . mysqli_error($conn);
            }
        }
    }
}

function deleteBlock($St_id, $conn)
{
    $sql = "DELETE FROM block WHERE St_id=" . $St_id;
    $testIfCor = mysqli_query($conn, $sql);
    if (!$testIfCor) {
        echo "del Block:" . mysqli_error($conn);
    }
}
?>