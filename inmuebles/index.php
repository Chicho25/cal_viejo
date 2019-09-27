<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['user'])) {
  $loginUsername=$_POST['user'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "NIVEL";
  $MM_redirectLoginSuccess = "home/inicio.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conexion, $conexion);
  	//echo $_POST['recordar'];
  $LoginRS__query=sprintf("SELECT * FROM usuarios_master WHERE ACTIVO=1 AND `ALIAS`=%s AND PASSWORD=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $conexion) or die(mysql_error());
  $row_GRUPO = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'NIVEL');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['u']= $loginUsername;
	$_SESSION['i']=$row_GRUPO['ID_USUARIO']; 
	$_SESSION['n']=$row_GRUPO['NOMBRES'];  
	$_SESSION['a']=$row_GRUPO['APELLIDOS'];      
        
        $_SESSION['partidasUser']=$row_GRUPO['partidasUser'];  
		

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	if (isset($_POST['recordar']) && !empty($_POST['recordar'])&& $_POST['recordar']=='1')
		
		{
			
		echo  '<script language="javascript">alert("Hay Cookie");location.href="home/inicio.php";</script>';
		setcookie("inicio",$row_GRUPO['ID_USUARIO'],time()+86400);		
		}
   header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
	  	
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>.:: Inicio</title>
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script src="css/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="css/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body style="background-image:url(img/Body1.jpg); background-repeat:repeat-x;">
<div id="logo"></div>
<div id="base_inicio">
  <form id="identificacion" name="login" method="post" action="<?php echo $loginFormAction; ?>" autocomplete="on">
  <!--<form method="POST" name="login" action="<?php echo $loginFormAction; ?>" autocomplete="on">-->
    <table width="298" height="167" border="0" cellpadding="0" cellspacing="6">
      <tr>
        <td height="28" colspan="2" align="center" class="txt_1"> Identifícate</td>
      </tr>
      <tr>
        <td width="41%" height="24" class="txt_2"><img src="img/checkmark1.png" width="16" height="16" /> Usuario:</td>
        <td width="59%">
          <label for="usuario"></label>
          <input type="text" name="user" id="user" />
        </td>
      </tr>
      <tr>
        <td height="24" class="txt_2"><img src="img/checkmark1.png" width="16" height="16" /> Clave:</td>
        <td>
          <label for="clave"></label>
          <input type="password" name="password" id="password" />
        </td>
      </tr>
      <tr>
        <td rowspan="2" align="center" valign="top"><p>
          <input name="recordar" type="checkbox" id="recordar" value="1" />
        <a href="#" class="txt_4"><span class="txt_3"><span class="txt_1" style="font-size: 12px; font-weight: normal;">Recordar usuario</span></span></a></p></td>
        <td valign="middle"><a href="usuarios/new.php" class="txt_4">Olvidé mis Datos</a></td>
      </tr>
      <tr>
        <td height="36" valign="top"><input name="entrar" type="submit" id="entrar" value="Entrar" /></td>
      </tr>
    </table>
  </form>
</div>

</body>
</html>