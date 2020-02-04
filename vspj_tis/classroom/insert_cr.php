<?php
require("../../dbmysqli/connect.php");
require("../session.php");
?>
<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Formulář pro učebny</title>
    <link rel="stylesheet" type="text/css" href="../css/styl_menu.css">
    <link rel="stylesheet" type="text/css" href="../css/styl_form.css">
</head>
<body>
<div class="menu">
  <a href="../list_cr.php">Zpět</a>
  <div class="menu-right">
    <a href="../logout.php">Odhlásit</a>
  </div>
</div>
<div id="form">
<form action="" method="post">
    <label>Označení učebny:</label><br>
    <input type="text" name="label_cr" required><br>
    <label>Název učebny:</label><br>
    <input type="text" name="name_cr" required><br>
    <label>Zodpovědná osoba:</label><br>
    <select name="resp_person">
        <option value="VV">Mgr. Vladimír Veselý</option>
        <option value="JJ">PhDr. Jarmila Jahodová</option>
        <option value="TT">Ing. Tomáš Tošovský</option>
        <option value="PP">Mgr. Petra Pavlíková</option>
        <option value="MM">doc. Milan Mikulášek</option>
    </select><br><br>
    <input type="submit" name="submit" value="Přidat učebnu!">
</form>
</div>
</body>
</html>
<?php
if (isset($_POST["submit"])) {
    $sql = "INSERT INTO ucebny (oznaceni, nazev, zodpovedna_osoba)
values('$_POST[label_cr]','$_POST[name_cr]','$_POST[resp_person]')";


    if (mysqli_query($spojeni, $sql)) {
        header("Location: ../list_cr.php");
    } else {
        echo "<br>Chyba: " . mysqli_error($spojeni)."<br><br>";
    }
    mysqli_close($spojeni);
}
?>


