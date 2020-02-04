<?php
    require("../dbmysqli/connect.php");
    require("session.php");
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Seznam učeben</title>
    <link rel="stylesheet" type="text/css" href="css/styl_menu.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/styl_content.css">
    <style>
    .insert_btn {
        display: block;
        width: 45%;
        border: 1px solid green;
        background-color: #00FF00;
        padding: 14px 28px;
        font-size: 16px;
        border-radius: 5px;
        cursor: pointer;
        text-align: center;
        margin: 0 auto;
    }
    
    .insert_btn:hover {
        background-color: #20D71F;
    }
    
    #seznam {
        width: 100%;
        font-size: 18px;
        margin: 0 auto;
        border-left: 2px solid black;
        border-bottom: 2px solid black;
        border-collapse: collapse;
    }
    
    th, td {           
        text-align: center;
        padding: 10px;
    }
    
    th{
        background-color: #000080;
        cursor: pointer;
        color: white;
    }
    
    tr:nth-child(odd) {
        background-color: white;
    }
    
    tr:nth-child(even) {
        background-color: #87CEFA;
    }
    
    #vyhledani {
        text-align: center;
        font-size: 16px;
        padding: 10px 65px;
        border: 1px solid #222529;
        margin-bottom: 12px; 
    }
    
    #hledat{
        float:left;
    }
    
    #list {
        width: 70%;
        text-align: center;
        margin: 0 auto;
        padding: 0 8px;
    }
    </style>
</head>
<body>
<div class="menu">
  <div class="menu-right">
    <a href="logout.php">Odhlásit</a>
  </div>
</div>

<div id="list">
<h1>Seznam učeben</h1>
<?php
$sql_cr = "select id, oznaceni, nazev from ucebny";

$res_cr = mysqli_query($spojeni, $sql_cr);

if (mysqli_num_rows($res_cr) > 0) {
echo "<div id='hledat'><input type='text' id='vyhledani' onkeyup='filtrujUcebnu()' placeholder='Hledat učebnu dle názvu..' title='Zadej název učebny'></div>";
echo "<table id='seznam'><tr><th>Označení</th><th onclick='seradTabulku()'>Název</th>";
if($_SESSION['username'] == 'admin') {
    echo "<th width='10%'>Smazat</th></tr>";  
    while ($radek_cr = mysqli_fetch_assoc($res_cr)):
    echo "<td style='text-align: center'><a title='Zobrazit učebnu' href='show_cr.php?cr_id=" . $radek_cr["id"] . "'>" . $radek_cr["oznaceni"] . "</a></td>";
    echo "<td style='text-align: center'>" . $radek_cr["nazev"] . "</td>";
    echo "<td style='text-align: center'><a title='Smazat učebnu' href='./classroom/delete_cr.php/?id=" . $radek_cr["id"] . "'><i class='material-icons' style='font-size:24px; color:black;'>delete</i></a></td></tr>";
endwhile;  
} else{
    echo "</tr>";
    while ($radek_cr = mysqli_fetch_assoc($res_cr)):
    echo "<td style='text-align: center'><a title='Zobrazit učebnu' href='show_cr.php?cr_id=" . $radek_cr["id"] . "'>" . $radek_cr["oznaceni"] . "</a></td>";
    echo "<td style='text-align: center'>" . $radek_cr["nazev"] . "</td></tr>";
endwhile;
}
echo "</table><br>";
}
?>

<a href="classroom/insert_cr.php" style="text-decoration: none">
    <button type="button" class="insert_btn"><b>Přidat učebnu</b></button>
</a>
</div>

<script>
    function filtrujUcebnu() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("vyhledani");
        filter = input.value.toUpperCase();
        table = document.getElementById("seznam");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>

<script>
function seradTabulku() {
  var table, rows, switching, i, x, y, switchcount = 0, shouldSwitch, direct;
  table = document.getElementById("seznam");
  direct = "asc"; 
  switching = true;
  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[1];
      y = rows[i + 1].getElementsByTagName("TD")[1];
      if (direct == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      } else if (direct == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;      
    } else {
      if (switchcount == 0 && direct == "asc") {
        direct = "desc";
        switching = true;
      }
    }
  }
}
</script>
</body>
</html>