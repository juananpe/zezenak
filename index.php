<?
session_start();

// print_r($_SESSION);

$error="";

function go($nora){
$uneko_zerbitzaria  = $_SERVER['HTTP_HOST'];
$uneko_karpeta   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
header("Location: http://$uneko_zerbitzaria$uneko_karpeta/$nora");
exit;
}

if (isset($_GET['action']) && $_GET['action']=='logout'){
	unset($_SESSION['erabiltzaile']);
	session_destroy();
}
if (isset($_SESSION['erabiltzaile'])){
	go("kudeatu.php");
}else{
	if (isset($_POST['login']) && isset($_POST['password'])){
		if ($_POST['login'] == 'admin' && $_POST['password']=='P4ssw0rd'){
			$_SESSION['erabiltzaile']='admin';
			go("kudeatu.php");
		}else if ($_POST['login'] == 'user' && $_POST['password']=='P4ssw0rd'){
			$_SESSION['erabiltzaile']='user';
			go("kudeatu.php");
		}else{
			$error = "Credenciales incorrectas";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="eus">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../favicon.ico">
    <title> Zezenak kudeatzeko aplikazioa - Login </title>
    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
  </head>

  <body>
    <div class="container">

      <form class="form-signin"  action="?action=kautotu" method="POST">
        <h2 class="form-signin-heading">Panel de control</h2>
        <label for="login" class="sr-only">Login</label>
        <input type="text" id="inputEmail" class="form-control" placeholder="Login" required autofocus name="login">
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required name="password">
	<? if ($error!='') { ?><div class="alert alert-danger" role="alert"><label><?=$error?></label></div> <? } ?>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Identificarse</button>
      </form>

    </div> <!-- /container -->

  </body>
</html>

