
<?php
// Incluye la librería PHPExcel
require_once 'C:\xampp\htdocs\pruebas\vendor\phpoffice\phpexcel\Classes\PHPExcel.php';

// Obtén el nombre del archivo subido
$file_path = 'C:/xampp/htdocs/pruebas/prueba.xlsx';

// Carga el archivo Excel utilizando PHPExcel
$objPHPExcel = PHPExcel_IOFactory::load($file_path);

// Conecta a la base de datos utilizando PDO
$dsn = 'mysql:host=localhost;dbname=prueba';
$username = 'root';
$password = '';

try {
    $db = new PDO($dsn, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Error al conectar a la base de datos: ' . $e->getMessage();
}

// Obtiene la hoja activa
$worksheet = $objPHPExcel->getActiveSheet();

// Crea una consulta SQL para insertar los datos en la tabla 'clientes'
$sql = 'INSERT INTO clientes (nombre, apellido, email) VALUES (:nombre, :apellido, :email)';

// Prepara la consulta
$stmt = $db->prepare($sql);

// Itera sobre las filas de datos del archivo Excel y las inserta en la base de datos
foreach ($worksheet->getRowIterator() as $row) {
    $nombre = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
    $apellido = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
    $email = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();

    // Asigna los valores de las columnas a los parámetros de la consulta
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':email', $email);

    // Ejecuta la consulta
    $stmt->execute();
}

// Muestra un mensaje indicando que la importación se realizó correctamente
echo 'Importación completada';
