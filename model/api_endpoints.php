<?php
$apiEndpoints = [
    ['endpoint' => "<a href='./API/coobapi.php?APIKey={$_SESSION['key']}'>/API/coobapi?APIKey={apiKey}</a>", 'request_type' => 'GET', 'description' => 'An API key is required to use these endpoints'],
    ['endpoint' => "<a href='./API/coobapi.php?APIKey={$_SESSION['key']}&length=20'>/API/coobapi?APIKey={apiKey}&length={length}</a>", 'request_type' => 'GET', 'description' => 'Get a scramble of a specified length, default scramble length is 20']
];

foreach ($apiEndpoints as $endpoint) {
    echo '<tr>';
    echo '<td>' . $endpoint['endpoint'] . '</td>';
    echo '<td>' . $endpoint['request_type'] . '</td>';
    echo '<td>' . $endpoint['description'] . '</td>';
    echo '</tr>';
}


?>
