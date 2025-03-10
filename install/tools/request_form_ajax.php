<?php
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$data = json_decode(file_get_contents('php://input'),1);

echo json_encode([
    'success' => true,
]);