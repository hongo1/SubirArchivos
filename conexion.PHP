<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "archivos";
// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Guardar los campos de texto
$campo1 = $_POST['campo1'];
$campo2 = $_POST['campo2'];
$campo3 = $_POST['campo3'];

// Guardar archivos en una carpeta y almacenar la ruta en la base de datos
$archivo1 = $_FILES['archivo1']['name'];
$archivo2 = $_FILES['archivo2']['name'];
$archivo3 = $_FILES['archivo3']['name'];

$target_dir = "uploads/";
$target_file1 = $target_dir . basename($archivo1);
$target_file2 = $target_dir . basename($archivo2);
$target_file3 = $target_dir . basename($archivo3);

// Mover los archivos a la carpeta de destino
move_uploaded_file($_FILES["archivo1"]["tmp_name"], $target_file1);
move_uploaded_file($_FILES["archivo2"]["tmp_name"], $target_file2);
move_uploaded_file($_FILES["archivo3"]["tmp_name"], $target_file3);

// Insertar en la base de datos
$sql = "INSERT INTO archivos (campo1, campo2, campo3, archivo1, archivo2, archivo3) 
        VALUES ('$campo1', '$campo2', '$campo3', '$target_file1', '$target_file2', '$target_file3')";

if ($conn->query($sql) === TRUE) {
    echo "Datos subidos correctamente.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
