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
<div id="form">
<h1>Formulář pro přidání SW</h1>
<form action="" method="post">
    <label>Název:</label>
    <input type="text" name="sw_name" required><br><br>
    <label>Typ licence:</label>
    <select name="sw_licence">
        <option value="0">Neomezená</option>
        <option value="1">Omezená - 1 PC/server</option>
         <option value="2">Omezená - 30denní verze</option>
    </select>
    <br><br>
    <?php
$sql_brand = "SELECT id, nazev FROM vyrobce ORDER BY nazev ASC";
$res_brand = mysqli_query($spojeni, $sql_brand);
?>
<label>Výrobce:</label>
<select name="brand">
<?php                                  
if (mysqli_num_rows($res_brand) > 0) {
    while ($radek_vyrobce = mysqli_fetch_assoc($res_brand)):
        echo "<option value='".$radek_vyrobce['id']."'>".$radek_vyrobce['nazev']."</option>";
    endwhile;
}
?> 
</select><br><br>
    <input type="hidden" name="cr_id_hidden" value="<?php echo $_GET["cr_id"]; ?>">
    <label>Počet celkem:</label><br>
    <input type="number" name="sw_total" min="1" max="50" required><br><br>
    <label>Počet používaných:</label><br>
    <input type="number" name="sw_used" min="0" max="50" required><br><br>
    <label>Popis:</label><br>
    <textarea name="sw_desc" rows="4" cols="50"></textarea><br><br>
    <input type="submit" id="submit" name="submit" value="Přidat SW">
</form>
</div>
</body>
</html>

<?php
if(isset($_POST['submit']))
{
$cr_id = $_POST['cr_id_hidden'];

$sql = "INSERT INTO software (nazev, licence, pocet_celkem, pocet_pouzivanych, vyrobce_id, ucebna_id, popis)
values('$_POST[sw_name]','$_POST[sw_licence]','$_POST[sw_total]','$_POST[sw_used]','$_POST[brand]','$cr_id','$_POST[sw_desc]')";
echo $sql;
if (mysqli_query($spojeni, $sql)) {
    header("Location: ../show_cr.php?cr_id=".$cr_id);
} else {
    echo "Chyba: " . mysqli_error($spojeni);
}
mysqli_close($spojeni);
}
?>  

