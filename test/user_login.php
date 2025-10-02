<?php
include dirname( __DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

use Zmog\Libs\Lingea\LTBE\TranslationApi;

if ($argc < 5 ) {
    echo "Usage: php user_login.php <api_key> <api_url> <username> <userpassword>".PHP_EOL;
    exit(1);
}
$api_key = $argv[1];
if (filter_var($argv[2], FILTER_VALIDATE_URL)) {
    $api_url = $argv[2];
} else {
    echo "Error: Invalid URL provided: {$argv[2]}" . PHP_EOL;
    echo "Please provide a valid URL as the second argument" . PHP_EOL;
    exit( 1 );
}

$username = $argv[3];
$userpassword = $argv[4];

$TranslationApi = new TranslationApi($api_key,$api_url);
$CookieJar = $TranslationApi->userLogin($username,$userpassword);
echo "csrftoken : ".PHP_EOL;
echo $CookieJar->getCookieByName('csrftoken')->getValue().PHP_EOL;
echo "sessionid : ".PHP_EOL;
echo $CookieJar->getCookieByName('sessionid')->getValue().PHP_EOL;



