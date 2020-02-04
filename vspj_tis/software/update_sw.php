<?php
require("../../dbmysqli/connect.php");
require("../session.php");
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Formulář pro software</title>
    <link rel="stylesheet" type="text/css" href="../css/styl_menu.css">
    <link rel="stylesheet" type="text/css" href="../css/styl_form.css">
</head>
<body>
<div class="menu">
  <a href="../show_cr.php?cr_id=<?php echo $_GET['cr_id'];?>">Zpět</a>
  <div class="menu-right">
    <a href="../logout.php">Odhlásit</a>
  </div>
</div>
<?php
$sw_id = $_GET['id'];
$cr_id = $_GET['cr_id'];
    $sql_select = "SELECT id, nazev, pocet_celkem, pocet_pouzivanych FROM software where id='$sw_id'";
    $res_select = mysqli_query($spojeni, $sql_select);
    if (mysqli_num_rows($res_select) > 0) {
        $radek_sel=mysqli_fetch_assoc($res_select);
    }
?>
<div id="form">
<h1>Formulář pro úpravu SW</h1>
<form action="" method="POST">
    <label>Název:</label>
    <input type="text" name="sw_name" disabled value="<?php echo $radek_sel['nazev'] ?>"><br><br>
    <label>Počet celkem:</label><br>
    <input type="number" name="sw_total" min="1" max="50" required value="<?php echo $radek_sel['pocet_celkem'] ?>"><br><br>
    <label>Počet používaných:</label><br>
    <input type="number" name="sw_used" min="0" max="50" required value="<?php echo $radek_sel['pocet_pouzivanych'] ?>"><br><br>
    <input type="hidden" name="cr_id_hidden" value="<?php echo $cr_id; ?>">
    <input type="hidden" name="sw_id_hidden" value="<?php echo $sw_id; ?>">
    <input type="submit" id="submit" name="submit" value="Aktualizovat SW">
</form>
</div>
</body>
</html>


<?php
if(isset($_POST['submit']))
{
$cr_id = $_POST['cr_id_hidden'];
$sw_id = $_POST['sw_id_hidden'];

$sql_update="UPDATE software SET pocet_pouzivanych='$_POST[sw_used]', pocet_celkem='$_POST[sw_total]' where id='$sw_id'";
echo $sql_update;
if (mysqli_query($spojeni, $sql_update)) {
    header("Location: ../show_cr.php?cr_id=".$cr_id);
} else {
    echo "Chyba: " . mysqli_error($spojeni);
}
mysqli_close($spojeni);
}
?>  




