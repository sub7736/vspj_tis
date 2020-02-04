<?php
require("../../dbmysqli/connect.php");
require("../session.php");

$id_cr = $_GET["id"];
$sql_sw = "DELETE FROM software where ucebna_id='$id_cr'";
$sql_hw = "DELETE FROM hardware where ucebna_id='$id_cr'";
$sql_cr = "DELETE FROM ucebny where id='$id_cr'";
if (mysqli_query($spojeni, $sql_sw)) {
    if (mysqli_query($spojeni, $sql_hw)) {
        if (mysqli_query($spojeni, $sql_cr)) {
            mysqli_close($spojeni);
            header("Location: ../../list_cr.php");
        } else {
            echo "Chyba: " . mysqli_error($spojeni);
        }
    } else {
        echo "Chyba: " . mysqli_error($spojeni);
    }
} else {
    echo "Chyba: " . mysqli_error($spojeni);
}
mysqli_close($spojeni);
?>