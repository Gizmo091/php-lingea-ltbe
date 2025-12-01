<?php
include dirname( __DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

use Zmog\Libs\Lingea\LTBE\TranslationApi;
use Zmog\Libs\Lingea\LTBE\TranslationLanguage\ISO_639_1;
use Zmog\Libs\Lingea\LTBE\TranslationLanguage\ISO_639_2b;
use Zmog\Libs\Lingea\LTBE\TranslationOptions;
use Zmog\Libs\Lingea\LTBE\TranslationOptions\KeepNewlines;

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
$text_long = ['Bonjour, je suis Mathieu, le développeur qui à créé ce repo.',' Et j\'ajoute une phrase avec deux saut de ligne en celle-ci et la précédente.'];
$To_lng = ISO_639_2b::fromCode('eng');
$ResponseTranslateSync = $TranslationApi->translateSync($text,$From_lng,$To_lng);
echo $ResponseTranslateSync->getRequestId().PHP_EOL;
echo $ResponseTranslateSync->getResult().PHP_EOL;
$ResponseTranslateAsync = $TranslationApi->translateAsync($text,$From_lng,$To_lng);
echo $ResponseTranslateAsync->getRequestId().PHP_EOL;



$ResponseTranslateSync = $TranslationApi->translateSync(implode(PHP_EOL,$text_long),$From_lng,$To_lng, new TranslationOptions(new KeepNewlines(true), new TranslationOptions\UseIsoCodes(true), new TranslationOptions\UseSentenceSplitter(false)));
echo $ResponseTranslateSync->getRequestId().PHP_EOL;
var_dump(explode(PHP_EOL,$ResponseTranslateSync->getResult()));
echo PHP_EOL;

