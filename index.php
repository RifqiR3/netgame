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

<body style="background-color: #161920;">
    <div id="konten">
        <div class="loader-wrapper">
            <span class="loader"><span class="loader-inner"></span></span>
        </div>
    </div>

    <script>
    addEventListener('load', function() {
        const chart = new XMLHttpRequest();
        chart.onload = function() {
            document.getElementById('konten').textContent = '';
            document.getElementById('konten').innerHTML = this.responseText;
        };
        chart.open('GET', 'http://localhost/steamapi/scrape/topseller.php');
        chart.send();
    });
    </script>

</body>

</html>