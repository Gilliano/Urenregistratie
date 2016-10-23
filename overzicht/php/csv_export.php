<?php
require_once '../../main/php/main.php';

// Setup params
$array = $_SESSION['csv_array'];
$filename = "uren_export_".date("d-m-Y").".csv";

// disable caching
$now = gmdate("D, d M Y H:i:s");
header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
header("Last-Modified: {$now} GMT");

// force download
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");

// disposition / encoding on response body
header("Content-Disposition: attachment;filename={$filename}");
header("Content-Transfer-Encoding: binary");

// Create csv
ob_start();
$df = fopen("php://output", 'w');
fputcsv($df, array_keys(reset($array)));
foreach ($array as $row)
    fputcsv($df, $row);
fclose($df);
echo ob_get_clean();

?>