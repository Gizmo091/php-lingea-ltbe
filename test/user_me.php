<?php
include dirname( __DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

use Zmog\Libs\Lingea\TranslationApi;

if ($argc <= 1) {
    echo "Usage: php user_me.php <api_key> (<api_url>?)".PHP_EOL;
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
$ResponseUserMe = $TranslationApi->userMe();
var_dump($ResponseUserMe);



