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

// Obtener el embarque seleccionado
if (isset($_GET['embarque'])) {
    $embarque = $conn->real_escape_string($_GET['embarque']);
    $sql = "SELECT * FROM archivos WHERE campo3 = '$embarque'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Registro no encontrado.";
        exit();
    }
}

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nuevoEmbarque = $conn->real_escape_string($_POST['embarque']);
    
    // Subir nuevos archivos (si se reemplazan)
    $nuevoArchivo1 = $_FILES['archivo1']['name'] ? 'uploads/' . basename($_FILES['archivo1']['name']) : $row['archivo1'];
    $nuevoArchivo2 = $_FILES['archivo2']['name'] ? 'uploads/' . basename($_FILES['archivo2']['name']) : $row['archivo2'];
    $nuevoArchivo3 = $_FILES['archivo3']['name'] ? 'uploads/' . basename($_FILES['archivo3']['name']) : $row['archivo3'];

    // Mover archivos a la carpeta de destino si fueron subidos
    if ($_FILES['archivo1']['name']) {
        move_uploaded_file($_FILES['archivo1']['tmp_name'], $nuevoArchivo1);
    }
    if ($_FILES['archivo2']['name']) {
        move_uploaded_file($_FILES['archivo2']['tmp_name'], $nuevoArchivo2);
    }
    if ($_FILES['archivo3']['name']) {
        move_uploaded_file($_FILES['archivo3']['tmp_name'], $nuevoArchivo3);
    }

    // Actualizar el registro en la base de datos
    $sql = "UPDATE archivos SET campo3 = '$nuevoEmbarque', archivo1 = '$nuevoArchivo1', archivo2 = '$nuevoArchivo2', archivo3 = '$nuevoArchivo3' WHERE campo3 = '$embarque'";

    if ($conn->query($sql) === TRUE) {
        echo "Registro actualizado correctamente.";
        header("Location: consulta.php"); // Redirigir a la página de consulta
        exit();
    } else {
        echo "Error al actualizar: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Embarque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /*footer {
            background-color: yellow;
            color: black;
            padding: 20px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }*/
        body {
            background-image: url('abinbev.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: #FFD700;
        }
        .container {
            background-color: rgba(33, 37, 41, 0.9);
            padding: 30px;
            border-radius: 10px;
            margin-top: 50px;
            color: #FFD700;
        }
        h2 {
            color: #fae001;
            margin-bottom: 30px;
        }
        label {
            color: #fae001;
        }
        .form-control {
            background-color: #343a40;
            color: #FFD700;
            border: 1px solid #FFD700;
        }
        .form-control:focus {
            background-color: #343a40;
            color: #FFD700;
            border-color: #fae001;
        }
        .btn-primary {
            background-color: #343a40;
            border-color: #FFD700;
            color: #FFD700;
        }
        .btn-primary:hover {
            background-color: #fae001;
            color: #343a40;
        }
        .btn-secondary {
            background-color: #343a40;
            border-color: #FFD700;
            color: #FFD700;
        }
        .btn-secondary:hover {
            background-color: #fae001;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Editar Embarque: <?= $row['campo3'] ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="embarque" class="form-label">Nuevo Embarque</label>
                <input type="text" class="form-control" id="embarque" name="embarque" value="<?= $row['campo3'] ?>" required>
            </div>

            <div class="mb-3">
                <label for="archivo1" class="form-label">Reemplazar Certificado de Calidad</label>
                <input type="file" class="form-control" id="archivo1" name="archivo1">
            </div>

            <div class="mb-3">
                <label for="archivo2" class="form-label">Reemplazar Orden de Transporte</label>
                <input type="file" class="form-control" id="archivo2" name="archivo2">
            </div>

            <div class="mb-3">
                <label for="archivo3" class="form-label">Reemplazar Archivo 3</label>
                <input type="file" class="form-control" id="archivo3" name="archivo3">
            </div>

            <button type="submit" class="btn btn-success">Guardar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
  <path d="M11 2H9v3h2z"/>
  <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
</svg></button>
            <a href="consulta.php" class="btn btn-danger">Cancelar <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
</svg></a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <footer>
        &copy; 2024 Departamento de logística. Todos los derechos reservados.
    </footer> -->
</body>
</html>
