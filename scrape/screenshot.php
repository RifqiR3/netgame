<?php
require_once('vendor/autoload.php');

// Chromedriver (if started using --port=4444 as above)
$serverUrl = 'http://localhost:4444';

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverWait;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverExpectedCondition;

// Set Chrome options for headless mode
$options = new ChromeOptions();
$options->addArguments(['--headless']);
$capabilities = DesiredCapabilities::chrome();
// $capabilities->setCapability('pageLoadTimeout', 60000);
// $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

// set webdriver
$driver = RemoteWebDriver::create($serverUrl, $capabilities);
$driver->get('https://steamdb.info/app/1669000/screenshots/');

$wait = new WebDriverWait($driver, 10);

// Wait for a few more seconds to ensure the page is fully loaded
sleep(5);


$screenshot = $driver->findElement(WebDriverBy::className('screenshots'));
$src = $screenshot->findElements(WebDriverBy::cssSelector('a > img'));
$arraySS = array();
foreach ($src as $idx => $sumber) {
    $arraySS[] = $sumber->getAttribute('src');
    // echo $sumber->getAttribute('src');
}

$tombolTab = $driver->findElement(WebDriverBy::id('tab-prices'));
$tombolTab->click();
// $driver->manage()->timeouts()->pageLoadTimeout(60);
// if (strpos($driver->getCurrentURL(), 'agecheck') !== false) {
//     // Find the age dropdown element and select the appropriate age
//     $ageDropdown = $driver->findElement(WebDriverBy::name('ageYear'));
//     $ageDropdown->click();
//     $ageDropdown->findElement(WebDriverBy::cssSelector("option[value='1990']"))->click();

//     // Find and click the "View Page" or "Enter" button
//     $enterButton = $driver->findElement(WebDriverBy::id('view_product_page_btn'));
//     $enterButton->click();

//     // Wait until redirected to the original page
//     // Wait for a few more seconds to ensure the page is fully loaded
//     sleep(5);
// }

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

$driver->quit();

// foreach ($arraySS as $SS) {
//     echo $SS . "\n";
// }

if ($arrayHarga[0] == 'N/A') {
    echo 'Free To Play';
} else {
    echo $arrayHarga[0];
}