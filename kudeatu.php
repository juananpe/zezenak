<?


session_start();

$directory = dirname($_SERVER['PHP_SELF']);
if (!isset($_SESSION['erabiltzaile'])) { // if login in session is not set
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $directory);
}
 
$readonly = "readonly";
if($_SESSION['erabiltzaile']=='admin')
  $readonly = "";

// print_r($_SESSION);

function printHeader(){
	echo "<!doctype html>
		<html>
		<head>
		<meta charset='utf-8' />
	    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='icon' href='../../favicon.ico'>
    <title> Zezenak kudeatzeko aplikazioa - Login </title>
    <!-- Bootstrap core CSS -->
    <link href='dist/css/bootstrap.min.css' rel='stylesheet'>
    <!-- Custom styles for this template -->
    <link href='signin.css' rel='stylesheet'>
			</head><body role='document'>
<div align='right'><span class='label label-primary'>Kaixo: ".$_SESSION['erabiltzaile'] ."</span> <span class='label label-warning'><a href='index.php?action=logout'>Logout</a></span></div>";
}

function printFooter(){
	echo "</body></html>";
}


$mysqli = new mysqli("db", "usuario", "J^s6@7vS-iQ", "sgssi");
if ($mysqli->connect_errno) {
	echo "Error al conectarse a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

printHeader();

if (isset($_POST['action'])){
	$eguneratu = "UPDATE Zezena
		SET izena='".$_POST['izena']."', `jaiotze-data`='".$_POST['jaiotze-data']."', altuera=".$_POST['altuera']." WHERE animaliKodea=" . $_POST['id'] ;
	$emaitzak = $mysqli->query($eguneratu);
	echo "<b>Actualización completada correctamente</b><br>";
	echo "<a href='?'>Volver a la pantalla principal</a>";
} else if (isset($_GET['id'])) {
	$emaitzak = $mysqli->query("SELECT animaliKodea, izena, `jaiotze-data`, altuera, pisua, adarrarenLuzera FROM Zezena WHERE animaliKodea=" . $_GET['id'] );
	$lerro = $emaitzak->fetch_assoc();	
	?>
<form name="edit" method="POST">
	Nombre <input type="text" name="izena" value="<?=$lerro['izena'] ?>"> <br>
	Fecha nacimiento <input type="date" name="jaiotze-data" value="<?=$lerro['jaiotze-data'] ?>" <?=$readonly?>> <br>
	Altura <input type="text" name="altuera" value="<?=$lerro['altuera'] ?>" <?=$readonly ?>> <br>
	<input type="hidden" name="action" value="save">
	<input type="hidden" name="id" value="<?=$_GET['id']?>">
	<input type="submit" value="Guardar">
	<input type="button" value="Cancelar" onclick="location.href='?'">
</form>
<?
}else{
	$emaitzak = $mysqli->query("SELECT animaliKodea, izena, `jaiotze-data`, altuera, pisua, adarrarenLuzera FROM Zezena");

	echo "<table class='table table-striped'>
		<thead><tr><th>Toro</th>
		<th>Fecha Nacimiento</th><th>Altura</th><th>Peso</th><th>Longitud Asta</th>
		</tr></thead><tbody>";
	while ($lerro = $emaitzak->fetch_assoc()) {
		echo "<tr>";
		echo "<td>" . $lerro['izena'] . "</td>";
		echo "<td>" . $lerro['jaiotze-data'] . "</td>";
		echo "<td>" . $lerro['altuera'] . "</td>";
		echo "<td>" . $lerro['pisua'] . "</td>";
		echo "<td>" . $lerro['adarrarenLuzera'] . "</td>";
		echo "<td><a href='?id=" . $lerro['animaliKodea'] . "'>Editar</a></td>";
		echo "</tr>\n";
	}
	echo "</tbody></table>";

}
	printFooter();

