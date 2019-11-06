
<?php
require("../dbmysqli/connect.php");
$cr = $_GET['cr'];
?>
<html lang="cs">
<head><title>Učebna <?php echo $cr; ?></title></head>
<body>


<?php
echo "<h1>Učebna " . $cr . "</h1>";
$sql_cr = "select * from ucebny where oznaceni='$cr'";
$res_cr = mysqli_query($spojeni, $sql_cr);
if (mysqli_num_rows($res_cr) > 0) {
    $radek_cr = mysqli_fetch_assoc($res_cr);
    $id_cr = $radek_cr['id'];

} else {
    echo "Nepodařilo se vyhledat ID učebny!";
    return -1;
}
//mysqli_close($spojeni);
//// TODO - připojení k DB
////  funkce($sql_dotaz) {return $result OR echo; return -1}
//// sql_dotaz = "select * from ucebny where oznaceni='$cr'"
//// result = mysqli_num_rows($res_cr) > 0
//// ve funkci bude if (mysqli_num_rows($res)>0) return $res; else return -1
//// na konci mysqli.close();

$sql_hw = "select * from hardware where ucebna_id='$id_cr'";
$res_hw = mysqli_query($spojeni, $sql_hw);
//echo $sql_hw;
if (mysqli_num_rows($res_hw) > 0) {
    echo "<h3>Seznam používaného/dostupného HW:</h3>";
    echo "<table width='800' border='1' style='border-collapse: collapse'><tr><th>Název</th><th>Celkem</th><th>Používaných</th><th>Typ</th><th>Výrobce ID</th><th>Popis</th></tr>";
    while($radek_hw = mysqli_fetch_assoc($res_hw)):
        echo "<tr><td style='text-align: center'>".$radek_hw["nazev"]."</td>";
        echo "<td style='text-align: center'>".$radek_hw["pocet_celkem"]."</td>";
        echo "<td style='text-align: center'>".$radek_hw["pocet_pouzivanych"]."</td>";
        echo "<td style='text-align: center'>".$radek_hw["typ"]."</td>";
        echo "<td style='text-align: center'>".$radek_hw["vyrobce_id"]."</td>";
        echo "<td style='text-align: center'>".$radek_hw["popis"]."</td></tr>";
    endwhile;
}
mysqli_close($spojeni);

//$i=0;
//// zahlavi tabulky pro vysledky
//
//echo "<TABLE BORDER=0  >";
////echo "<TR>";
//echo "<TR BGCOLOR=aqua VALIGN=TOP>";
//echo "<TH >ID učebny</TH>";
//echo "<TH >Označení</TH>";
//echo "<TH >Název</TH>";
//echo "<TH></TH>";
//echo "<TH></TH></TR>";
//
//if (mysqli_num_rows($vysledek) > 0)
//{
//
//    while ($radek = mysqli_fetch_assoc($vysledek)):
//
//        if (($i%2)==1)    // sude aliche radky maji jinou platnost
//            echo "<TR VALIGN=TOP BGCOLOR=SILVER>";
//        else
//            echo "<TR VALIGN=TOP>";
//
//        $oc=$radek["id"];
//        echo "<TD  ALIGN=CENTER>".$radek["id"]. "</TD>";
//        echo "<TD  ALIGN=CENTER>".$radek["oznaceni"]. "</TD>";
//        echo "<TD  ALIGN=CENTER>".$radek["nazev"]. "</TD>";
//
//        $i=$i+1;
//    endwhile;
//} else {
//    echo "0 nalezených záznamů";
//}
//
//
//
//echo"</TABLE>";
//
//mysqli_close($spojeni);
?>


</body>

</html>


