<!DOCTYPE html>  
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Archivos y Datos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('fondo.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: #FFD700;
        }
        h2 {
            margin-top: 20px;
            color: #fae001;
        }
        table {
            background-color: rgba(33, 37, 41, 0.8);
            color: #FFD700;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
        th {
            background-color: #343a40;
            color: #FFD700;
        }
        .custom-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .custom-header img {
            height: 80px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .btn-danger {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con imágenes -->
        <div class="custom-header">
            <a href="index.HTML">
                <img src="abinbev.png" alt="AB InBev">
            </a>
            <h2 class="text-center">Consulta de Embarques</h2>
            <a href="index.HTML">
                <img src="logo gpo modelo.png" alt="Grupo Modelo">
            </a>
        </div>

        <!-- Formulario de búsqueda -->
        <form method="POST" class="mt-4">
            <div class="input-group">
                <input type="text" name="embarque" class="form-control" placeholder="Ingrese el embarque a buscar" required>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Tabla de datos -->
        <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-dark">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Embarque</th>
                        <th>Archivo 1</th>
                        <th>Archivo 2</th>
                        <th>Archivo 3</th>
                        <th>Acciones</th> 
                    </tr>
                </thead>
                <tbody>
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

                    // Configuración de paginación
                    $recordsPerPage = 10; // Número de registros por página
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página actual
                    $startFrom = ($page - 1) * $recordsPerPage; // Índice de inicio

                    // Comprobar si se ha enviado el formulario de búsqueda
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['embarque'])) {
                        $embarqueBuscado = $conn->real_escape_string($_POST['embarque']);
                        $sql = "SELECT * FROM archivos WHERE campo3 = '$embarqueBuscado' LIMIT $startFrom, $recordsPerPage";
                        $sqlCount = "SELECT COUNT(*) as total FROM archivos WHERE campo3 = '$embarqueBuscado'";
                    }
                    

                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fecha'])) {
                        $embarqueBuscado = $conn->real_escape_string($_POST['fecha']);
                        $sql = "SELECT * FROM archivos WHERE campo1 = '$embarqueBuscado' LIMIT $startFrom, $recordsPerPage";
                        $sqlCount = "SELECT COUNT(*) as total FROM archivos WHERE campo1 = '$embarqueBuscado'";
                    }


                     elseif (isset($_GET['eliminar'])) {
                        // Código para eliminar embarque
                        $embarqueEliminar = $conn->real_escape_string($_GET['eliminar']);
                        $sqlEliminar = "DELETE FROM archivos WHERE campo3 = '$embarqueEliminar'";
                        if ($conn->query($sqlEliminar) === TRUE) {
                            echo "<div class='alert alert-success'>Embarque eliminado correctamente.</div>";
                        } else {
                            echo "<div class='alert alert-danger'>Error al eliminar: " . $conn->error . "</div>";
                        }
                        // Mostrar todos los registros después de eliminar
                        $sql = "SELECT * FROM archivos LIMIT $startFrom, $recordsPerPage";
                        $sqlCount = "SELECT COUNT(*) as total FROM archivos";
                    } else {
                        $sql = "SELECT * FROM archivos LIMIT $startFrom, $recordsPerPage";
                        $sqlCount = "SELECT COUNT(*) as total FROM archivos";
                    }

                    $result = $conn->query($sql);
                    $totalRecordsResult = $conn->query($sqlCount);
                    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage); // Total de páginas

                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["campo1"]. "</td>
                                    <td>" . $row["campo2"]. "</td>
                                    <td>" . $row["campo3"]. "</td>
                                    <td><a href='" . $row["archivo1"]. "' class='btn btn-warning'>Archivo 1</a></td>
                                    <td><a href='" . $row["archivo2"]. "' class='btn btn-warning'>Archivo 2</a></td>
                                    <td><a href='" . $row["archivo3"]. "' class='btn btn-warning'>Archivo 3</a></td>
                                    <td><a href='?eliminar=" . $row["campo3"] . "' class='btn btn-danger'>Eliminar</a></td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No hay datos disponibles</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Paginador -->
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <a href="index.HTML">
            <input type="submit" value="Volver" class="btn btn-danger">
        </a>

        <a href="https://docs.google.com/spreadsheets/d/1WUMixERXl9fC5v6IrjK2PHJeGGC2pSRJmNwzwpFIi6Q/edit?usp=sharing">
            <div class="text-center">
            <input type="submit" value="registro de unidades" class="btn btn-info">
        </div>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
