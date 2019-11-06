<?php
if (isset($_POST['submit'])) {
    $budova = $_POST['budova'];
    $c_ucebny = $_POST['cislo_ucebny'];
    echo "<p>Budova: $budova</p>";
    echo "<p>Číslo učebny: $c_ucebny</p>";
} else {
    echo "Chyba při odeslání formuláře.";
}
?>


