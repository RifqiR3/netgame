<?php

$hasil = $_POST['hasil'];
$string = "%20";
$encoded_string = rawurlencode($string);
$hasil = str_replace(' ', $encoded_string, $hasil);
header('Location: requestSearch.php?result=' . $hasil);
exit();