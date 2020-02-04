<?php
require("../../dbmysqli/connect.php");
require("../session.php");
?>       
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Formulář pro hardware</title>
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
<h1>Formulář pro přidání HW</h1>
<form action="" method="POST">
    <label for="hw_name">Název:</label>
    <input type="text" name="hw_name" required><br><br>
    <label for="hw_type">Typ hardware:</label>
    <select name="hw_type">
        <option value="0">Počítač</option>
        <option value="1">Notebook</option>
        <option value="2">Monitor</option>
        <option value="3">Síťové prvky</option>
        <option value="4">Příslušenství</option>
    </select>
    <br><br>
    <input type="hidden" name="cr_id_hidden" value="<?php echo $_GET['cr_id']; ?>">
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
    <label>Počet celkem:</label><br>
    <input type="number" name="hw_total" min="1" max="50" required><br><br>
    <label>Počet používaných:</label><br>
    <input type="number" name="hw_used" min="0" max="50" required><br><br>
    <label>Popis:</label><br>
    <textarea name="hw_desc" rows="4" cols="50"></textarea><br><br>
    <input type="submit" id="submit" name="submit" value="Přidat HW">
</form>
</div>
</body>
</html>

<?php
if(isset($_POST['submit']))
{
$cr_id = $_POST['cr_id_hidden'];

$sql = "INSERT INTO hardware (nazev, typ, pocet_celkem, pocet_pouzivanych, vyrobce_id, ucebna_id, popis)
values('$_POST[hw_name]','$_POST[hw_type]','$_POST[hw_total]','$_POST[hw_used]','$_POST[brand]','$cr_id','$_POST[hw_desc]')";
echo $sql;
if (mysqli_query($spojeni, $sql)) {
    header("Location: ../show_cr.php?cr_id=".$cr_id);
} else {
    echo "Chyba: " . mysqli_error($spojeni);
}
mysqli_close($spojeni);
}
?>  



