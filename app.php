<?php
$id_app = $_GET['id_app'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://steam2.p.rapidapi.com/appDetail/" . $id_app,
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
    $dataApp = json_decode($response);
}

// Access steamapis
// $req = file_get_contents('https://api.steamapis.com/market/app/' . $id_app . '?api_key=' . $apiKeySAPIS);
// $dataSAPIS = json_decode($req);

// Kode scrap screenshot
require_once('scrape/vendor/autoload.php');

// Chromedriver (if started using --port=4444 as above)
$serverUrl = 'http://localhost:4444';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\WebDriverTimeouts;
use Facebook\WebDriver\Chrome\ChromeOptions;
// use Facebook\WebDriver\Exception\ElementNotVisibleException;

// Set Chrome options for headless mode
$options = new ChromeOptions();
$options->addArguments(['--headless']);
$capabilities = DesiredCapabilities::chrome();
// $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

// set webdriver
$driver = RemoteWebDriver::create($serverUrl, $capabilities, 3600000, 3600000);
// $driver->manage()->timeouts()->implicitlyWait(0); // remove timeout
$urlWebsite = 'https://steamdb.info/app/' . $id_app . '/screenshots/';
$driver->get($urlWebsite);

$wait = new WebDriverWait($driver, 10);


// Wait for a few more seconds to ensure the page is fully loaded
sleep(2);

// Screenshot
$screenshot = $driver->findElement(WebDriverBy::className('screenshots'));
$src = $screenshot->findElements(WebDriverBy::cssSelector('a > img'));
$arraySS = array();
foreach ($src as $idx => $sumber) {
    $arraySS[] = $sumber->getAttribute('src');
    // echo $sumber->getAttribute('src');
}

// Review Up
$reviewU = $driver->findElement(WebDriverBy::cssSelector('span.header-thing-good'));
$reviewUp = $reviewU->getText();

// Review Down
$reviewD = $driver->findElement(WebDriverBy::className('header-thing-poor'));
$reviewDown = $reviewD->getText();

// Review Average
$reviewAvg = $driver->findElements(WebDriverBy::className('header-thing-number'));
$arrayRev = array();
$arrayRating = array();
foreach ($reviewAvg as $idx => $rev) {
    $arrayRev[] = $rev->getText();
    $arrayRating[] = $rev->getAttribute('class');
}

// Video
$video = $driver->findElements(WebDriverBy::cssSelector('.screenshots > video'));
$arrayVideo = array();
foreach ($video as $idx => $vid) {
    $arrayVideo[] = $vid->getAttribute('src');
}

$tombolTab = $driver->findElement(WebDriverBy::id('tab-prices'));
$tombolTab->click();
sleep(2);
$harga = $driver->findElements(WebDriverBy::className('table-prices-current'));
// td[data-cc*="id"]

$arrayHarga = array();
foreach ($harga as $idx => $hargas) {
    if ($idx == 1) {
        break;
    } else {
        $hargaFix = $hargas->findElement(WebDriverBy::className('table-prices-converted'));
        $arrayHarga[] = $hargaFix->getText();
    }
}


$driver->get('https://store.steampowered.com/app/' . $id_app);
sleep(5);

// get the current URL
$currentUrl = $driver->getCurrentURL();

// check if the current URL contains 'agecheck'
if (strpos($currentUrl, 'agecheck') !== false) {
    // Replace with the date of birth to bypass the age check
    $date_of_birth = "1990-01-01";
    // Fill in the date of birth fields
    list($year, $month, $day) = explode('-', $date_of_birth);
    $driver->findElement(WebDriverBy::id('ageYear'))->sendKeys($year);
    $driver->findElement(WebDriverBy::id('ageMonth'))->sendKeys($month);
    $driver->findElement(WebDriverBy::id('ageDay'))->sendKeys($day);
    // Submit the form
    $driver->findElement(WebDriverBy::id('view_product_page_btn'))->click();
}

// Pause
// $driver->findElement(WebDriverBy::cssSelector('.highlight_player_item.highlight_movie'))->click();

sleep(2);

$description = $driver->findElement(WebDriverBy::id('aboutThisGame'));
$desc = $description->getAttribute('innerHTML');


$driver->quit();

if ($dataApp->allReviews->summary == '') {
    $dataApp->allReviews->summary = "No User Reviews";
}

// foreach ($arraySS as $SS) {
//     echo $SS . "\n";
// }
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
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <title><?php echo $dataApp->title; ?></title>
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

    <!-- content start -->
    <div class="container">
        <div class="row">
            <h1 class="text-white mt-5"><?php echo $dataApp->title; ?></h1>
            <div class="col-sm-8">
                <!-- Carousel -->
                <div id="demo" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
                    <!-- Indicators/dots -->
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                        <?php
                        foreach ($arraySS as $idx => $SS) {
                            if ($idx == 0) {
                                continue;
                            } else {
                                echo '<button type="button" data-bs-target="#demo" data-bs-slide-to="' . $idx . '"></button>';
                                if ($idx == count($arraySS) - 1) {
                                    foreach ($arrayVideo as $idxVid => $vid) {
                                        echo '<button type="button" data-bs-target="#demo" data-bs-slide-to="' . $idxVid + count($arraySS) . '"></button>';
                                    }
                                }
                            }
                        }
                        ?>
                    </div>

                    <!-- The slideshow/carousel -->
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <video class="d-block w-100" autoplay controls>
                                <source src="<?php echo $arrayVideo[0]; ?>">
                            </video>
                            <!-- <img src="<?php echo $arraySS[0]; ?>" class="d-block w-100"> -->
                        </div>
                        <?php
                        foreach ($arrayVideo as $idx => $vid) {
                            if ($idx == 0) {
                                continue;
                            }
                            echo '<div class="carousel-item">';
                            echo '<video class="d-block w-100" controls>';
                            echo '<source src="' . $vid . '" type="video/webm">';
                            echo '</video>';
                            echo '</div>';
                        }
                        ?>
                        <?php
                        foreach ($arraySS as $idx => $SS) {
                            echo '<div class="carousel-item">';
                            echo '<img src="' . $SS . '"
                                class="d-block w-100">';
                            echo '</div>';
                        }
                        ?>
                        <script>
                            const video = document.querySelector('video');

                            video.addEventListener('click', () => {
                                if (video.paused) {
                                    video.play();
                                } else {
                                    video.pause();
                                }
                            });
                        </script>
                    </div>

                    <!-- Left and right controls/icons -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>

                <div class="mt-4">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <h5 class="card-title">Play <?php echo $dataApp->title; ?></h5>
                            <p class="card-text"><?php if (isset($arrayHarga[0]) == false || $arrayHarga[0] == 'N/A') {
                                                        echo 'Free To Play';
                                                    } elseif ($dataApp->allReviews->summary == "No User Reviews") {
                                                        echo 'Coming Soon';
                                                    } else {
                                                        echo $arrayHarga[0];
                                                    } ?>
                            </p>
                        </div>
                    </div>
                    <div class="ms-1 d-grid gap-2 d-md-block">
                        <a href="<?php echo 'https://store.steampowered.com/app/' . $id_app; ?>"
                            class="btn btn-transition">Play
                            Game</a>
                    </div>
                </div>



                <div class="mt-1 pb-5 text-white game_area_description">
                    <?php echo $desc; ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card bg-dark" style="width: 25rem;">
                    <img src="<?php echo $dataApp->imgUrl; ?>" class="card-img-top">
                    <div class="card-body text-white">
                        <p>
                            <?php echo $dataApp->description; ?>
                        </p>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="text-secondary">
                                    Review:
                                </p>
                                <p class="text-secondary">
                                    Release Date:
                                </p>
                                <p class="text-secondary">
                                    Developer:
                                    Publisher:
                                </p>
                            </div>
                            <div class="col-sm-8">
                                <?php
                                if (strpos($dataApp->allReviews->summary, "Positive") !== false) {
                                    $classRev = "text-positive";
                                } elseif (strpos($dataApp->allReviews->summary, "Negative") !== false) {
                                    $classRev = "text-positive";
                                } elseif (strpos($dataApp->allReviews->summary, "Mixed") !== false) {
                                    $classRev = "text-mixed";
                                } else {
                                    $classRev = "text-secondary";
                                }
                                ?>
                                <p class="<?php echo $classRev; ?>" id="review">
                                    <?php echo $dataApp->allReviews->summary; ?></p>
                                <p class="text-secondary">
                                    <?php echo $dataApp->released; ?></p>
                                <p class="text-card">
                                    <?php echo $dataApp->developer->name; ?>
                                    <br>
                                    <?php echo $dataApp->publisher->name; ?>
                                </p>
                            </div>
                        </div>
                        <span>
                            Popular user-defined tags for this product:
                        </span>
                        <div class="d-grid gap-2 d-md-block">
                            <?php
                            foreach ($dataApp->tags as $idx => $tag) {
                                if ($idx >= 5) {
                                    break;
                                }
                                echo '<button class="btn btn-sm btn-transition" type="button">' . $tag->name . '</button>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 text-center mb-4" style="width: 423px;">
                    <div class="col-sm-6">
                        <div class="card bg-dark">
                            <div class="card-body text-white">
                                <p style="font-size:22px;" class="<?php echo $arrayRating[0]; ?>">
                                    <?php echo $arrayRev[0]; ?></p>
                                <span style="color:#6c3;"><?php echo $reviewUp; ?></span>
                                <span style="color: #ff683b;"><?php echo $reviewDown; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="ms-1 card bg-dark">
                            <div class="card-body text-white">
                                <p style="font-size:22px; color:#6c3;"><?php echo $arrayRev[1]; ?></p>
                                <span style="color:#6c3;">In-Game</span>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="text-white fst-italic">Reviews</h3>
                <hr class="text-white">
                <?php
                foreach ($dataReview->reviews as $idx => $review) {
                    if ($review->voted_up == 'true') {
                        $revImg = 'https://community.akamai.steamstatic.com/public/shared/images/userreviews/icon_thumbsUp.png?v=1';
                        $revTxt = 'Recommended';
                    } else {
                        $revImg = 'https://community.akamai.steamstatic.com/public/shared/images/userreviews/icon_thumbsDown.png?v=1';
                        $revTxt = 'Not Recommended';
                    }
                    echo '<div class="card bg-dark mt-2 text-white" style="width: 25rem;">';
                    echo '<div class="card-header">';
                    echo '<img src="' . $revImg . '">';
                    echo '<span class="ms-1 fw-bold">' . $revTxt . '</span>';
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<p style="font-size: 13px;" class="card-text">' . $review->review . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>
    </div>
    </div>

    <script>
        // window.onload = function() {
        //     reviewColor();
        // };

        // function reviewColor() {
        //     const review = document.getElementById("review");
        //     if (review.innerText.includes("Positive")) {
        //         review.setAttribute("class", "text-positive");
        //     } else if (review.innerText.includes("Negative")) {
        //         review.setAttribute("class", "text-negative");
        //     } else {
        //         review.setAttribute("class", "text-mixed");
        //     }
        // }
    </script>
    <!-- content end -->
</body>

</html>