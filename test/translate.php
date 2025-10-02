<?php
include dirname( __DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

use Zmog\Libs\Lingea\LTBE\TranslationApi;
use Zmog\Libs\Lingea\LTBE\TranslationLanguage\ISO_639_1;
use Zmog\Libs\Lingea\LTBE\TranslationLanguage\ISO_639_2b;

if ($argc <= 1) {
    echo "Usage: php language.php <api_key> (<api_url>?)".PHP_EOL;
    exit(1);
}
$api_key = $argv[1];
$api_url = null;
if ($argc >= 3) {
    if (filter_var($argv[2], FILTER_VALIDATE_URL)) {
        $api_url = $argv[2];
    } else {
        echo "Error: Invalid URL provided: {$argv[2]}" . PHP_EOL;
        echo "Please provide a valid URL as the second argument" . PHP_EOL;
        exit( 1 );
    }
}

$TranslationApi = new TranslationApi($api_key,$api_url);
$From_lng = ISO_639_2b::fromCode('fre');
$text = 'Bonjour, je suis Mathieu, le développeur qui à créé ce repo.';
$To_lng = ISO_639_2b::fromCode('eng');
$ResponseTranslateSync = $TranslationApi->translateSync($text,$From_lng,$To_lng);
echo $ResponseTranslateSync->getRequestId().PHP_EOL;
echo $ResponseTranslateSync->getResult().PHP_EOL;
$ResponseTranslateAsync = $TranslationApi->translateAsync($text,$From_lng,$To_lng);
echo $ResponseTranslateAsync->getRequestId().PHP_EOL;
$To_lng = ISO_639_2b::fromCode('rus');
$ResponseTranslateSync = $TranslationApi->translateSync($text,$From_lng,$To_lng);
echo $ResponseTranslateSync->getRequestId().PHP_EOL;
echo $ResponseTranslateSync->getResult().PHP_EOL;
$ResponseTranslateAsync = $TranslationApi->translateAsync($text,$From_lng,$To_lng);
echo $ResponseTranslateAsync->getRequestId().PHP_EOL;
$To_lng = ISO_639_1::fromCode('cs');
$ResponseTranslateSync = $TranslationApi->translateSync($text,$From_lng,$To_lng);
echo $ResponseTranslateSync->getRequestId().PHP_EOL;
echo $ResponseTranslateSync->getResult().PHP_EOL;
$ResponseTranslateAsync = $TranslationApi->translateAsync($text,$From_lng,$To_lng);
echo $ResponseTranslateAsync->getRequestId().PHP_EOL;



