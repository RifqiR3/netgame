<?php

$result = $_GET['result'];
$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => 'https://steam2.p.rapidapi.com/search/' . $result . '/page/1',
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
    $dataSearch = json_decode($response);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="image/Screenshot 2023-05-05 132259.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title>NetGame Search</title>
</head>

<body style="background-color: #161920;">
    <!-- navbar start  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/steamapi/index.php">
                <img src="image/Screenshot_2023-05-05_132259-removebg-preview.png" alt="" width="45">
                <img src="image/Screenshot_2023-05-05_132325-removebg-preview.png" alt="" width="150">
            </a>
            <form class="formaja" method="POST" action="redirect.php">
                <input name="hasil" style="color: white" class="inputan text1" type="text" placeholder="Search..."
                    aria-label="Search">
                <button class="buttonaja" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <div class="ms-3 collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="news.php">News</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <div class="container mt-5 mb-5">
        <div>
            <h1 style="color: white;" class="fw-bold">SEARCH RESULTS</h1>
            <h5>Top <?php echo count($dataSearch); ?> games, based on your search relevance</h5>
            <table class="top-seller">
                <thead class="utk-thead">
                    <tr>
                        <th class="utk-rank" colspan="2">
                            <span>Rank</span>
                        </th>
                        <th class="utk-price text-end pe-3">Release Date</th>
                        <th class="utk-cocurrent text-end pe-3">
                            <div class="inside-cocur">Review</div>
                        </th>
                        <th class="utk-peak text-end pe-3">
                            <div class="inside-peak">Price</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($dataSearch as $idx => $game) {
                        if (isset($game->reviewSummary) == false) {
                            $game->reviewSummary = 'Coming Soon';
                        } elseif (isset($game->appId) == false) {
                            continue;
                        }

                        if (strpos($game->reviewSummary, 'Positive')) {
                            preg_match('/(\w+\s)?Positive/i', $game->reviewSummary, $matches);
                            $review = isset($matches[0]) ? $matches[0] : '';
                            $review = trim($review);
                            $class = "peak-cell text-positive";
                        } elseif (strpos($game->reviewSummary, 'Negative')) {
                            preg_match('/(\w+\s)?Negative/i', $game->reviewSummary, $matches);
                            $review = isset($matches[0]) ? $matches[0] : '';
                            $review = trim($review);
                            $class = "peak-cell text-negative";
                        } else {
                            preg_match('/(\w+\s)?Mixed/i', $game->reviewSummary, $matches);
                            $review = isset($matches[0]) ? $matches[0] : '';
                            $review = trim($review);
                            $class = "peak-cell text-mixed";
                        }

                        if ($review == '') {
                            $review = 'No User Reviews';
                            $class = "peak-cell text-secondary";
                        }

                        echo '<tr class="table-row">';
                        echo '<td class="rank-cell">' . $idx + 1 . '</td>';
                        echo '
                        <td class="capsule-cell">
                            <a class="tc-item" href="http://localhost/steamapi/app.php?id_app=' . $game->appId . '">
                                <img class="capsule-art"
                                    src="' . $game->imgUrl . '">
                                <div class="game-name game-link">
                                    ' . $game->title . '
                                </div>
                            </a>
                        </td>
                        ';
                        echo '<td class="cocur-cell text-secondary">' . $game->released . '</td>';
                        echo '<td id="review' . $idx . '"class="' . $class . '">' . $review . '</td>';
                        echo '
                        <td class="price-cell">
                            <div class="price-widget">
                                <div class="price-widget-container">
                                    <div class="price-box">
                                        ' . $game->price . '
                                    </div>
                                </div>
                            </div>
                        </td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>

    </script>
</body>

</html>