<?php
include dirname( __DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";

use Zmog\Libs\Lingea\TranslationApi;
use Zmog\Libs\Lingea\TranslationLanguage\ISO_639_1;
use Zmog\Libs\Lingea\TranslationLanguage\ISO_639_2b;
use Zmog\Libs\Lingea\TranslationLanguage\Name;


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


$iso_639_2b = ISO_639_2b::fromCode('fre');
echo "From \"fre\" ISO_639_2b code to linguea code ".$iso_639_2b->lingeaCode().PHP_EOL;
// echo "fr"

$iso_639_1 = ISO_639_1::fromCode('fr');
echo "From \"fr\" ISO_639_1 code to linguea code ". $iso_639_1->lingeaCode().PHP_EOL;
// echo "fr"

$name = Name::fromCode('french');
echo "From \"french\" name code to linguea code ". $name->lingeaCode().PHP_EOL;
// echo "fr"

$TranslationApi = new TranslationApi($api_key,$api_url);
$Pairs          = $TranslationApi->getTranslationPairs();
foreach($Pairs as $Pair) {
    echo $Pair->getFrom()->name().' -> '.$Pair->getTo()->name().PHP_EOL;
}