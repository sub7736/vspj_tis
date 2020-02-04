<?php
require("../dbmysqli/connect.php");
require("session.php");
$sql_cr = "select id, nazev, oznaceni, zodpovedna_osoba,
           CASE zodpovedna_osoba
           when 'JJ' then 'PhDr. Jarmila Jahodová'
           when 'MM' then 'doc. Milan Mikulášek'
           when 'PP' then 'Mgr. Petra Pavlíková'
           when 'TT' then 'Ing. Tomáš Tošovský'
           when 'VV' then 'Mgr. Vladimír Veselý'
           end as 'zodpovedna_osoba'
           from ucebny where ";

    $cr_id = $_GET['cr_id'];
    $sql_cr .= "id='$cr_id'";

$res_cr = mysqli_query($spojeni, $sql_cr);
if (mysqli_num_rows($res_cr) > 0) {
    $radek_cr = mysqli_fetch_assoc($res_cr);
    $id_cr = $radek_cr['id'];
    $nazev_cr = $radek_cr['nazev'];
    $oznaceni_cr = $radek_cr['oznaceni'];
    $zodp_osoba = $radek_cr['zodpovedna_osoba'];

} else {
    echo "Nepodařilo se vyhledat ID učebny!";
    return -1;
}
?>
<html lang="cs">
<head>
<title>Stránka učebny</title>
<link rel="stylesheet" type="text/css" href="css/styl_menu.css">
<link rel="stylesheet" type="text/css" href="css/styl_content.css">
</head>
<style>
.paticka {
    left: 0;
    bottom: 0;
    width: 100%;
    text-align: center;
    margin: 0 auto;
}

.insert_btn {
    width: 45%;
    border: 1px solid grey;
    padding: 7px 14px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    margin: 0px 5px;
    display: inline-block;
}

.btn_sw {
    background-color: #ff9966;    
}

.btn_sw:hover {
    background-color: #ff7733;    
}

.btn_hw {
    background-color: #ecc113;    
}

.btn_hw:hover {
    background-color: #ccad33;    
}

#buttons {
    width: 80%;
    margin: 0 auto;
}

table {
    width: 100%;
}

p {
    font-size: 18px;
    font-style: normal;
}

</style>
<body>
<div class="menu">
  <a href="list_cr.php">Zpět</a>
  <div class="menu-right">
    <a href="logout.php">Odhlásit</a>
  </div>
</div>
<div id="content">
<h1>Učebna <?php echo $oznaceni_cr . " - " . $nazev_cr . "<br><p>(Zodpovědná osoba: <i>" . $zodp_osoba . "</i>)</p>" ?></h1>

<div id="buttons">
<a href="hardware/form_hw.php?cr_id=<?php echo $id_cr; ?>" style="text-decoration: none"><button type="button" class="insert_btn btn_hw"><b>Přidat HW</b></button></a>
<a href="software/form_sw.php?cr_id=<?php echo $id_cr; ?>" style="text-decoration: none"><button type="button" class="insert_btn btn_sw"><b>Přidat SW</b></button></a>
</div>


<?php
$sql_hw = "select id, nazev, pocet_celkem, pocet_pouzivanych, typ, vyrobce_id, popis,
           CASE typ 
           WHEN 0 then 'Počítač' 
           WHEN 1 then 'Notebook' 
           WHEN 2 then 'Monitor' 
           WHEN 3 then 'Síťové prvky' 
           WHEN 4 then 'Příslušenství' 
           end as 'typ' 
           from hardware where ucebna_id='$id_cr'";

$sql_sw = "select id, nazev, licence, pocet_celkem, pocet_pouzivanych, vyrobce_id, popis,
           CASE licence
           when 0 then 'Neomezená'
           when 1 then 'Omezená - 1 PC/server'
           when 2 then 'Omezená - 30-denní verze'
           end as 'licence'
           from software where ucebna_id='$id_cr'";

$res_hw = mysqli_query($spojeni, $sql_hw);
$res_sw = mysqli_query($spojeni, $sql_sw);

if (mysqli_num_rows($res_hw) > 0) {
    echo "<h3>Seznam používaného/dostupného HW:</h3>";
    echo "<table id='seznam_hw'><tr><th>Název</th><th>Celkem</th><th>Používaných</th><th>Typ</th><th>Výrobce</th><th>Popis</th><th>Upravit</th>";
    if($_SESSION['username'] == 'admin') {
    echo "<th>Smazat</th></tr>";
    } else{
        echo "</tr>";
    }
    while ($radek_hw = mysqli_fetch_assoc($res_hw)):
        echo "<tr><td style='text-align: center'>" . $radek_hw["nazev"] . "</td>";
        echo "<td style='text-align: center'>" . $radek_hw["pocet_celkem"] . "</td>";
        echo "<td style='text-align: center'>" . $radek_hw["pocet_pouzivanych"] . "</td>";
        echo "<td style='text-align: center'>" . $radek_hw["typ"] . "</td>";
        $sql_brand = "select nazev, odkaz from vyrobce where id='" . $radek_hw["vyrobce_id"] . "'";
        $res_brand = mysqli_query($spojeni, $sql_brand);
        if (mysqli_num_rows($res_brand) > 0) {
            $radek_vyrobce = mysqli_fetch_assoc($res_brand);
            echo "<td style='text-align: center'><a href='" . $radek_vyrobce["odkaz"] . "'>" . $radek_vyrobce["nazev"] . "</a></td>";
        }
        echo "<td style='text-align: center'>" . $radek_hw["popis"] . "</td>";
        echo "<td style='text-align: center'><a href='hardware/update_hw.php?id=" . $radek_hw["id"] . "&cr_id=" . $id_cr . "'>Upravit</a></td>";
        if($_SESSION['username'] == 'admin') {
            echo "<td style='text-align: center'><a href='hardware/delete_hw.php?id=" . $radek_hw["id"] . "&cr_id=" . $id_cr . "'>Smazat</a></td></tr>";
        } else{
            echo "</tr>";
        }        
    endwhile;
    echo "</table>";
}

if (mysqli_num_rows($res_sw) > 0) {
    echo "<h3>Seznam používaného/dostupného SW:</h3>";
    echo "<table id='seznam_sw'><tr><th>Název</th><th>Celkem</th><th>Používaných</th><th>Licence</th><th>Výrobce</th><th>Popis</th><th>Upravit</th>";
    if($_SESSION['username'] == 'admin') {
    echo "<th>Smazat</th></tr>";
    } else{
    echo "</tr>";
    }
    while ($radek_sw = mysqli_fetch_assoc($res_sw)):
        echo "<tr><td style='text-align: center'>" . $radek_sw["nazev"] . "</td>";
        echo "<td style='text-align: center'>" . $radek_sw["pocet_celkem"] . "</td>";
        echo "<td style='text-align: center'>" . $radek_sw["pocet_pouzivanych"] . "</td>";
        echo "<td style='text-align: center'>" . $radek_sw["licence"] . "</td>";
        $sql_brand = "select nazev, odkaz from vyrobce where id='" . $radek_sw["vyrobce_id"] . "'";
        $res_brand = mysqli_query($spojeni, $sql_brand);
        if (mysqli_num_rows($res_brand) > 0) {
            $radek_vyrobce = mysqli_fetch_assoc($res_brand);
            echo "<td style='text-align: center'><a href='" . $radek_vyrobce["odkaz"] . "'>" . $radek_vyrobce["nazev"] . "</a></td>";
        }
        echo "<td style='text-align: center'>" . $radek_sw["popis"] . "</td>";
        echo "<td style='text-align: center'><a href='software/update_sw.php?id=" . $radek_sw["id"] . "&cr_id=" . $id_cr . "'>Upravit</a></td>";
        if($_SESSION['username'] == 'admin') {
            echo "<td style='text-align: center'><a href='software/delete_sw.php?id=" . $radek_sw["id"] . "&cr_id=" . $id_cr . "'>Smazat</a></td></tr>";        
        } else{
            echo "</tr>";
        }
    endwhile;
    echo "</table>";
}

$sql_brand_all = "SELECT vyrobce.nazev, vyrobce.kontakt FROM hardware INNER JOIN vyrobce ON vyrobce.id=hardware.vyrobce_id where ucebna_id='$id_cr'
                  UNION 
                  SELECT vyrobce.nazev, vyrobce.kontakt FROM software INNER JOIN vyrobce ON vyrobce.id=software.vyrobce_id where ucebna_id='$id_cr' ORDER BY nazev";

$res_brand_all = mysqli_query($spojeni, $sql_brand_all);
if (mysqli_num_rows($res_brand_all) > 0){
    echo "<h3>Kontakty na dodavatele vybavení:</h3><div class='paticka'>";
    echo "<table id='seznam_vyrobce'><!--tr><th>Výrobce</th><th>Kontakt</th></tr-->";
    while($radek_brand_all = mysqli_fetch_assoc($res_brand_all)){
        echo "<tr><td style='text-align: center'>".$radek_brand_all['nazev']."</td>";
        echo "<td style='text-align: center'>".$radek_brand_all['kontakt']."</td></tr>";
    }
    echo "</table></div><br><br>";
}
mysqli_close($spojeni);
?>
</div>

</body>

</html>


