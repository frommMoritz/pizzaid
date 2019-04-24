<?php
$baseUrl = 'https://www.online-pizza.de/shop.php?shop_id=3083284&kat_id={{categorie}}';
$categories = [
    '20050',
    '20051',
    '20052',
    '20053',
    '20054',
    '20055',
    '20056',
    '20057',
    '20058',
    '20059',
    '20060',
    '20061',
    '20062',
    '20063',
    '20064',
    '20065',
];
$shopUrl = '';
$expr = '/<a href="add_warenkorb\.php\?speise_id=(\d*)\&kat_id=(\d*)(.*)" class="speisekarte-artikel-name" rel="nofollow">(.*)<\/a>/m';
$csvFile = 'pizzas.csv';
$fp = fopen($csvFile, 'w');
$matchCount = 0;
fputcsv($fp, ['speise_id', 'kat_id', 'name']);
foreach ($categories as $categorie) {
    $url = str_replace('{{categorie}}', $categorie, $baseUrl);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $response = utf8_encode($response);
    $matchCount += preg_match_all($expr, $response, $matches,  PREG_SET_ORDER);
    foreach ($matches as $match) {
        fputcsv($fp, [$match[1], $match[2], $match[4]]);
    }
    exit;
}
fclose($fp);
echo $matchCount . " matches found\n";
