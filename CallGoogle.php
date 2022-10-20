<?php
require __DIR__ . '/vendor/autoload.php';
$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP Quickstart');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
$client->setAuthConfig('credentials.json');
$client->setAccessType('offline');
$client->setPrompt('select_account consent');
$service = new Google_Service_Sheets($client);
$spreadsheetId = '1bSMs1YJ61pf_gaMCgF3dMzgP1ebj2RUWs51_4rhCYkU';
$range = 'R&D Ô TÔ!B5:R900';
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();
echo json_encode(['result'=>$values,'code'=>200]);
?>