<?php
// Make sure we get Sheet Id
$sheetId = $_GET["sheetId"] ?? exit("Sheet Id is Missing in the Url, please check the link");

// Load data from Sheet
require_once 'sheet-loader.php';
$data = getData($sheetId);

$data['base_1_col'] = $data['bases']['position']['base_1'] === "1" ? "#ffff00" : "#999999";
$data['base_2_col'] = $data['bases']['position']['base_2'] === "1" ? "#ffff00" : "#999999";
$data['base_3_col'] = $data['bases']['position']['base_3'] === "1" ? "#ffff00" : "#999999";

echo json_encode($data);
exit;
