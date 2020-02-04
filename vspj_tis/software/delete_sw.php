<?php
require("../../dbmysqli/connect.php");
require("../session.php");
$id = $_GET["id"];
$cr_id = $_GET["cr_id"]; 
$sql = "DELETE FROM software where id='$id'";

if (mysqli_query($spojeni, $sql)) {
    header("Location: ../show_cr.php?cr_id=".$cr_id."");
} else {
    echo "Chyba: " . mysqli_error($spojeni);
}
mysqli_close($spojeni);

?>


