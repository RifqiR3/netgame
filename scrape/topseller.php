<?php
require_once('vendor/autoload.php');

// Chromedriver (if started using --port=4444 as above)
$serverUrl = 'http://localhost:4444';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\WebDriverExpectedCondition;

// Set Chrome options for headless mode
$options = new ChromeOptions();
$options->addArguments(['--headless']);
$capabilities = DesiredCapabilities::chrome();
$capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

// set webdriver
$driver = RemoteWebDriver::create($serverUrl, $capabilities);
$wait = new WebDriverWait($driver, 10);

$driver->get('https://store.steampowered.com/charts/mostplayed');

// Wait for a few more seconds to ensure the page is fully loaded
sleep(5);

// Parse ID Game
$id_game = $driver->findElements(WebDriverBy::cssSelector('td > a'));
$arrayID = array();
foreach ($id_game as $id) {
    $link = $id->getAttribute('href');
    $parseLink = $link;
    $pattern = '/\/app\/(\d+)\//';
    if (preg_match($pattern, $parseLink, $matches)) {
        $arrayID[] = $matches[1];
    }
}

// Game rank    
$rank_game = $driver->findElements(WebDriverBy::className('_34h48M_x9S-9Q2FFPX_CcU'));
$arrayRank = array();
foreach ($rank_game as $rank) {
    $arrayRank[] = $rank->getText();
}

// Game name
$game_name = $driver->findElements(WebDriverBy::className('_1n_4-zvf0n4aqGEksbgW9N'));
$arrayGame = array();
foreach ($game_name as $game) {
    $arrayGame[] = $game->getText();
}

// Price Game StoreSalePriceWidgetContainer
$price_game = $driver->findElements(WebDriverBy::className(' _2s-O5T3qJJYR2AUq4b9jIN'));
$arrayPrice = array();
foreach ($price_game as $game) {
    try {
        $priceTrue = $game->findElement(WebDriverBy::className('_3j4dI1yA7cRfCvK8h406OB'));
        $arrayPrice[] = $priceTrue->getText();
    } catch (NoSuchElementException $e) {
        $arrayPrice[] = '';
    }
}

// Current Player
$cr_player = $driver->findElements(WebDriverBy::className('_3L0CDDIUaOKTGfqdpqmjcy'));
$arrayPlayer = array();
foreach ($cr_player as $player) {
    $arrayPlayer[] = $player->getText();
}

// Peak player
$pk_player = $driver->findElements(WebDriverBy::className('yJB7DYKsuTG2AYhJdWTIk'));
$arrayPeak = array();
foreach ($pk_player as $peak) {
    $arrayPeak[] = $peak->getText();
}

// Move page after click link
$link = $driver->findElement(WebDriverBy::cssSelector('a[href="/charts/"]'));
$link->click();

// wait for the element on the next page
$wait = new WebDriverWait($driver, 10); // wait up to 10 seconds
$element = $wait->until(
    WebDriverExpectedCondition::presenceOfElementLocated(WebDriverBy::className('TY7Qbq7FuibkQDpXGPxsj'))
);

// Switch to new window
$handles = $driver->getWindowHandles();
$lastHandle = end($handles);
$driver->switchTo()->window($lastHandle);

// Elements from second page
// Peak online
$playerstatus = $driver->findElements(WebDriverBy::className('TY7Qbq7FuibkQDpXGPxsj'));
$arrayStatus = array();
foreach ($playerstatus as $stat) {
    $arrayStatus[] = $stat->getText();
}

$driver->quit();

// Print AppID from link
// foreach ($arrayID as $appID) {
//     echo $appID . "\n";
// }


// Print rank game
// foreach ($arrayRank as $ranks) {
//     echo $ranks;
// }

// Print game name
// foreach ($arrayGame as $games) {
//     echo $games . "\n";
// }


// Print game price
// foreach ($arrayPrice as $price) {
//     echo $price . "\n";
// }

// Print current player
// foreach ($arrayPlayer as $playernow) {
//     echo $playernow . "\n";
// }

// Print peak player
// foreach ($arrayPeak as $peak) {
//     echo $peak . "\n";
// }

// Print all
// foreach ($arrayID as $index => $value) {
//     echo  $value . "," . $arrayRank[$index] . "," . $arrayGame[$index] . "," . $arrayPrice[$index] . "," . $arrayPlayer[$index] . "," . $arrayPeak[$index] . "\n";
// }

// echo $arrayPeak[0];

echo '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/bootstrap.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="image/Screenshot 2023-05-05 132259.png">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <title>Home</title>
</head>

<body style=" background-color: #161920;">

    <!-- navbar start  -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="http://localhost/steamapi/index.php">
                <img src="image/Screenshot_2023-05-05_132259-removebg-preview.png" alt="" width="45">
                <img src="image/Screenshot_2023-05-05_132325-removebg-preview.png" alt="" width="150">
            </a>
            <form class="formaja" method="POST" action="redirect.php">
                <input name="hasil" style="color: white" class="inputan text1" type="text" placeholder="Search..." aria-label="Search">
                <button class="buttonaja" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </form>
            <div class="ms-3 collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
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

    <!-- body start -->
    <div class="containergweh">
        <div class="mt-3 mb-3 texthome">
            <h1 class="fw-bold">Comprehensive Steam catalog.</h1>
        </div>
        <div>
            <h5 style="color: white;">
                This third-party website gives you better insight into the <a href="https://store.steampowered.com/">Steam</a> platform and everything in its
                database. <a href="">Look through our frequently asked questions</a> to learn more about NetGame, <a href="">join our Discord</a>.
            </h5>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-6">
                <h5 style="font-size:30px; font-weight:350;" class="text-end">';
echo $arrayStatus[1];
echo '</h5>
<h5 style="color: #70c3ff; font-size:15px;" class="text-end fw-bolder">ONLINE NOW</h5>
</div>
<div class="col-sm-6">
    <h5 style="font-size:30px; font-weight:350;" class="text-start">';
echo $arrayStatus[0];
echo '</h5>
<h5 style="color: #82ff01; font-size:15px;" class="text-start fw-bolder">PEAK ONLINE</h5>
</div>
</div>
</div>
<div class="container mt-5">
    <div>
        <h1 style="color: white;" class="fw-bold">MOST PLAYED</h1>
        <h5>Top 90 played games, by current player</h5>
        <table class="top-seller">
            <thead class="utk-thead">
                <tr>
                    <th class="utk-rank" colspan="2">
                        <span>Rank</span>
                    </th>
                    <th class="utk-price text-end pe-3">Price</th>
                    <th class="utk-cocurrent text-end pe-3">
                        <div class="inside-cocur">Current Players</div>
                    </th>
                    <th class="utk-peak text-end pe-3">
                        <div class="inside-peak">Peak Today</div>
                    </th>
                </tr>
            </thead>
            <tbody>';
foreach ($arrayID as $idx => $value) {
    if ($idx >= 90) {
        break;
    }
    echo '<tr class="table-row">';
    echo '<td class="rank-cell">' . $arrayRank[$idx] . '</td>';
    echo '
                    <td class="capsule-cell">
                        <a class="tc-item" href="http://localhost/steamapi/app.php?id_app=' . $value . '">
                            <img class="capsule-art"
                                src="https://cdn.akamai.steamstatic.com/steam/apps/' . $value . '/capsule_231x87.jpg?t=1668125812">
                            <div class="game-name game-link">
                                ' . $arrayGame[$idx] . '
                            </div>
                        </a>
                    </td>';
    echo '
                    <td class="price-cell">
                        <div class="price-widget">
                            <div class="price-widget-container">
                                <div class="price-box">
                                    ' . $arrayPrice[$idx] . '
                                </div>
                            </div>
                        </div>
                    </td>
                    ';
    echo '<td class="cocur-cell">' . $arrayPlayer[$idx] . '</td>';
    echo '<td class="peak-cell">' . $arrayPeak[$idx] . '</td>';
    echo '
                </tr>';
}
echo '
            </tbody>
        </table>
    </div>
</div>
</div>


<div class="mt-5"></div>

<!-- // Show the loader -->
<!-- <div class=".loader-wrapper">;
        <div class="loader"></div>;
    </div>;
    <script>
    $(window).on("load", function() {
        $(".loader-wrapper").fadeOut("slow");
    });
    </script> -->
<!-- body end -->
</body>

</html>';
