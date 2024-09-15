<?


session_start();

$directory = dirname($_SERVER['PHP_SELF']);
if (!isset($_SESSION['erabiltzaile'])) { // if login in session is not set
	header("Location: http://" . $_SERVER['HTTP_HOST'] . $directory);
}

$readonly = "readonly";
if ($_SESSION['erabiltzaile'] == 'admin')
	$readonly = "";

// print_r($_SESSION);

function printHeader()
{
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
<div align='right'><span class='label label-primary'>Kaixo: " . $_SESSION['erabiltzaile'] . "</span> <span class='label label-warning'><a href='index.php?action=logout'>Logout</a></span></div>";
}

function printFooter()
{
	echo "</body></html>";
}


$mysqli = new mysqli("db", "usuario", "J^s6@7vS-iQ", "sgssi");
if ($mysqli->connect_errno) {
	echo "Error al conectarse a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");

printHeader();

if (isset($_POST['action'])) {
    // Handle image upload
    $image_filename = null;
    if (isset($_FILES['animal_image']) && $_FILES['animal_image']['error'] == 0) {
        $upload_dir = 'img/';
        $file_extension = pathinfo($_FILES['animal_image']['name'], PATHINFO_EXTENSION);
        $image_filename = uniqid() . '.' . $file_extension;
        $file_path = $upload_dir . $image_filename;

        if (move_uploaded_file($_FILES['animal_image']['tmp_name'], $file_path)) {
            echo "<b>Image uploaded successfully</b><br>";
        } else {
            echo "<b>Error uploading image</b><br>";
            $image_filename = null;
        }
    }

    // Update the database
    $eguneratu = "UPDATE Zezena
        SET izena='" . $_POST['izena'] . "', 
            `jaiotze-data`='" . $_POST['jaiotze-data'] . "', 
            altuera=" . $_POST['altuera'];
    
    if ($image_filename !== null) {
        $eguneratu .= ", image_filename='" . $image_filename . "'";
    }
    
    $eguneratu .= " WHERE animaliKodea=" . $_POST['id'];

    $emaitzak = $mysqli->query($eguneratu);

    echo "<b>Actualización completada correctamente</b><br>";
    echo "<a href='?'>Volver a la pantalla principal</a>";
} else if (isset($_GET['id'])) {
    $emaitzak = $mysqli->query("SELECT animaliKodea, izena, `jaiotze-data`, altuera, pisua, adarrarenLuzera, image_filename FROM Zezena WHERE animaliKodea=" . $_GET['id']);
    $lerro = $emaitzak->fetch_assoc();
?>
<form name="edit" method="POST" enctype="multipart/form-data">
    Nombre <input type="text" name="izena" value="<?= $lerro['izena'] ?>"> <br>
    Fecha nacimiento <input type="date" name="jaiotze-data" value="<?= $lerro['jaiotze-data'] ?>" <?= $readonly ?>> <br>
    Altura <input type="text" name="altuera" value="<?= $lerro['altuera'] ?>" <?= $readonly ?>> <br>
    Image <input type="file" name="animal_image" accept="image/*"> <br>
    <?php if ($lerro['image_filename']): ?>
        <img src="img/<?= $lerro['image_filename'] ?>" alt="Current Image" style="width: 100px; height: auto;"><br>
    <?php endif; ?>
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
    <input type="submit" value="Guardar">
    <input type="button" value="Cancelar" onclick="location.href='?'">
</form>
<?
} else {
    $emaitzak = $mysqli->query("SELECT animaliKodea, izena, `jaiotze-data`, altuera, pisua, adarrarenLuzera, image_filename FROM Zezena");

    echo "<table class='table table-striped'>
        <thead><tr><th>Toro</th><th>Image</th>
        <th>Fecha Nacimiento</th><th>Altura</th><th>Peso</th><th>Longitud Asta</th>
        </tr></thead><tbody>";
    while ($lerro = $emaitzak->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $lerro['izena'] . "</td>";
        // Image column
        $image_src = $lerro['image_filename'] ? "img/" . $lerro['image_filename'] : "img/toro.png";
        echo "<td><img src='" . $image_src . "' alt='Animal Image' style='width: 100px; height: auto;'></td>";

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
