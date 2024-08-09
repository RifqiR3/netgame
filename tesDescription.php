<?php

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://steam2.p.rapidapi.com/appReviews/1774580/limit/20/*",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "X-RapidAPI-Host: steam2.p.rapidapi.com",
        "X-RapidAPI-Key: xxx"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
    echo "cURL Error #:" . $err;
} else {
    $dataReview = json_decode($response);
    // echo '<pre>';
    // echo print_r($dataReview);
    // echo '</pre>';
}

foreach ($dataReview->reviews as $idx => $review) {
    echo $review->review . "\n";
    if ($review->voted_up == 'true') {
        echo 'Recommended';
    } else {
        echo 'Not Recommended';
    }
}
