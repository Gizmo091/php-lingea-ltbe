<?php
include dirname( __DIR__).DIRECTORY_SEPARATOR."vendor".DIRECTORY_SEPARATOR."autoload.php";


use Zmog\Libs\Lingea\LTBE\TranslationApi;
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


$bench = function(callable $callable,string $label, int $iteration = 1) {
    $i = $iteration;
    $durations = 0;
    while($i-- > 0) {
        $start = microtime(true);
        $callable();
        $end      = microtime(true);
        $duration = $end - $start;
        //echo $label.' took '.$duration." seconds".PHP_EOL;
        $durations+= $duration;
    }
    echo "=> Average for $iteration iterations of $label : ".($durations/$iteration)." seconds ".PHP_EOL;
};


$sentences_a = [
    "Réfugiés aux étages des maisons, les habitants du village de Faenza (Italie) sont pris au piège, impossible de sortir sans les pompiers.",
    "Dans les rues inondées, mardi 16 mai, les secouristes étaient ralentis par la pluie qui s’était abattue toute la nuit sur le secteur.",
    "Au total, 5 000 personnes ont été évacuées.",
    "Ces pluies record ont touché 23 communes, transformant les rues de la petite ville de Cesena en rivière.",
    "En moins de 24 heures, il est tombé l’équivalent de trois mois de pluie, faisant déborder 14 rivières de la région.",
    "L'eau est montée si vite dans un immeuble, que des voisins ont été obligés de secourir une mère et son bébé à la nage, in extremis.",
    "Un habitant se dit inquiet par la situation actuelle dans sa ville.",
    "Mercredi 17 mai au matin, le trafic des trains a été suspendu en direction de la région de Bologne et l’une des autoroutes a été fermée.",
    "C’est la seconde vague d’inondations meurtrières en moins d’un mois dans la région."
    ];

$bench_p_fn = function(string $language_code) use ($api_key,$api_url,$sentences_a) {
    $From_lng = ISO_639_2b::fromCode("fre");
    $TranslationApi = new TranslationApi($api_key,$api_url);
    $To_lng = ISO_639_2b::fromCode($language_code);
    $text = implode(' ',$sentences_a);
    return function() use ($TranslationApi,$From_lng,$To_lng,$text) {
        $TranslationApi->translateSync($text,$From_lng,$To_lng);
    };
};

$iteration = 10;
foreach (['eng','rus',/*'ara','hun','ita','pol','por','spa','tur','ukr'*/] as $lng_code) {
    $bench($bench_p_fn($lng_code),"Translate To $lng_code",$iteration);
}
