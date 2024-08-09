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
            <a class="navbar-brand" href="#">
                <img src="image/Screenshot_2023-05-05_132259-removebg-preview.png" alt="" width="45">
                <img src="image/Screenshot_2023-05-05_132325-removebg-preview.png" alt="" width="150">
            </a>
            <form class="formaja">
                <input style="color: white" class="inputan text1" type="text" placeholder="Search..." aria-label="Search">
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
                <h5 style="font-size:30px; font-weight:350;" class="text-end"><?php echo $arrayStatus[1]; ?></h5>
                <h5 style="color: #70c3ff; font-size:15px;" class="text-end fw-bolder">ONLINE NOW</h5>
            </div>
            <div class="col-sm-6">
                <h5 style="font-size:30px; font-weight:350;" class="text-start"><?php echo $arrayStatus[0]; ?></h5>
                <h5 style="color: #82ff01; font-size:15px;" class="text-start fw-bolder">PEAK ONLINE</h5>
            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div>
            <h1 style="color: white;" class="fw-bold">MOST PLAYED</h1>
            <h5>Top 10 played games, by current player</h5>
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
                <tbody>
                    <?php
                    foreach ($arrayID as $idx => $value) {
                        if ($idx >= 10) {
                            break;
                        }
                        echo '<tr class="table-row">';
                        echo '<td class="rank-cell">' . $arrayRank[$idx] . '</td>';
                        echo '
                                <td class="capsule-cell">
                                    <a class="tc-item" href="http://localhost/steamapi/app.php' . $value . '">
                                        <img class="capsule-art" src="https://cdn.akamai.steamstatic.com/steam/apps/' . $value . '/capsule_231x87.jpg?t=1668125812">
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
                        echo '</tr>';
                    }
                    ?>
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

</html>