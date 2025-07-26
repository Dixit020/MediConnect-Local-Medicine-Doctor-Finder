<?php
$response = file_get_contents("https://jsonplaceholder.typicode.com/users");
$doctors = json_decode($response, true);

foreach ($doctors as $doc) {
  echo "Doctor Name: " . $doc['name'] . "<br>";
}
?>
