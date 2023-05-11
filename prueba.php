
<?php
// Incluye la librería PHPExcel
require_once 'C:\xampp\htdocs\pruebas\vendor\phpoffice\phpexcel\Classes\PHPExcel.php';

// Obtén el nombre del archivo subido
$file_path = 'C:/xampp/htdocs/pruebas/reporte.xls';

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
$sql = 'INSERT INTO clientes (nombre, apellido, celular, telefono, email, ciudad, fuente, categoria, estado, via, fecha, encargado, comentarios) VALUES (:nombre, :apellido, :celular, :telefono, :email, :ciudad, :fuente, :categoria, :estado, :via, :fecha, :encargado, :comentarios)';

// Prepara la consulta
$stmt = $db->prepare($sql);

// Itera sobre las filas de datos del archivo Excel y las inserta en la base de datos
foreach ($worksheet->getRowIterator() as $row) {
    $nombre = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
    $apellido = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
    $celular = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
    $telefono = $worksheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
    $email = $worksheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
    $ciudad = $worksheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue();
    $fuente = $worksheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue();
    $categoria = $worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue();
    $estado = $worksheet->getCellByColumnAndRow(8, $row->getRowIndex())->getValue();
    $via = $worksheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue();
    $fecha = $worksheet->getCellByColumnAndRow(10, $row->getRowIndex())->getValue();
    $encargado = $worksheet->getCellByColumnAndRow(11, $row->getRowIndex())->getValue();
    $comentarios = $worksheet->getCellByColumnAndRow(12, $row->getRowIndex())->getValue();

    
    // Asigna los valores de las columnas a los parámetros de la consulta
    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':apellido', $apellido);
    $stmt->bindParam(':celular', $celular);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':ciudad', $ciudad);
    $stmt->bindParam(':fuente', $fuente);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':via', $via);
    $stmt->bindParam(':fecha', $fecha);
    $stmt->bindParam(':encargado', $encargado);
    $stmt->bindParam(':comentarios', $comentarios);
    
    // Ejecuta la consulta
    $stmt->execute();
}

// Muestra un mensaje indicando que la importación se realizó correctamente
echo 'Importación completada';
