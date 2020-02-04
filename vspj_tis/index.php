<?php
    require("../dbmysqli/connect.php");
    require("session.php");
?>

<!DOCTYPE html>
<html lang="cs">
    <meta charset="UTF-8">
    <title>Přihlášení</title>
<style>    
body {
  background-color: #00004d;
}

#uname, #passwd {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #bbb;
  border-radius: 4px;
  box-sizing: border-box;
}

#login {
  width: 100%;
  background-color: #00004d;
  color: white;
  padding: 12px 18px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  font-weight:bold;
}

#login:hover {
  background-color: #000099;
}

#log_form {
  text-align: center;
  background-color: #e3e3e3;
  width: 30%;
  margin: 0 auto;
  padding: 18px;
}

form {     
  font-size: 20px;
  
}
h1 {
  text-align: center;
  color: white;
}
</style>
<body> 
<h1>Seznam HW a SW v učebnách</h1>
<div id="log_form">
<h2>Přihlášení</h2>
<hr>
  <form action="" method="post">
    <input type="text" id="uname" name="uname" placeholder="jméno" required>
    <input type="password" id="passwd" name="passwd" placeholder="heslo" required>
    <input type="submit" name="login" id="login" value="Přihlásit">
    Jméno a heslo: admin (lze mazat)<br>
    Jméno a heslo: test (nelze mazat)<br>
    <?php
      $msg = '';
      
      if (isset($_POST['login'])) {	
        $username = $_POST['uname'];
        $password = $_POST['passwd'];

        $sql_usr = "SELECT * FROM uzivatele WHERE username ='".$username."' AND password='".$password."' LIMIT 1";
        $res_usr = mysqli_query($spojeni, $sql_usr);
        if(mysqli_num_rows($res_usr) == 1 ) {
            $_SESSION['username'] = $username;  
            header("Location: list_cr.php");
            
        } else {
            echo '<span style="color:red;"><b>Špatně zadané jméno nebo heslo.</b></span>';
            echo ""; 
        }
    }
mysqli_close($spojeni);
?>
  </form>
</div>

</body>
</html>

