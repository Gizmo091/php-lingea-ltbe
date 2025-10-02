# php-lingea

This repo help you to manage your Lingea api requests. 

[![GitHub release](https://img.shields.io/badge/release-v2.0.0-blue.svg)](https://github.com/Gizmo091/php-lingea/releases/)
![PHP Version](https://img.shields.io/badge/PHP-8.1+-blue.svg)

[comment]: <> (Badge generated with https://naereen.github.io/badges/)

## Warning 

Version >= 2.0.0 is only to call LTBE >= 1.0.0 API revision, if deal with and older version of lingea API, use version 1.x.x


## Installation

```bash
composer require zmog/php-lingea
```

## Usage

```php
<?php

require_once __DIR__ . '/vendor/autoload.php';

$api_key = 'you_api_key';

$TranslationApi = new \Zmog\Libs\Lingea\LTBE\TranslationApi($api_key);
$text = 'Hello, my name is Mathieu.';

$ResponseTranslateSync = $TranslationApi->translateSync($text,\Zmog\Libs\Lingea\LTBE\TranslationLanguage\ISO_639_2b::fromCode('eng'),\Zmog\Libs\Lingea\LTBE\TranslationLanguage\ISO_639_1::fromCode('cs'));
echo "Translation of : $text is : ".PHP_EOL;
echo $ResponseTranslateSync->getResult();
?>
```


## Demo scripts :

```
php test/language.php "my_api_key" ("my_api_url"?)
php test/translate.php "my_api_key" ("my_api_url"?)
```


## Coverage : 

### core_user
![Static Badge](https://img.shields.io/badge/method-GET-blue) ```/api/v1/user/me``` ![Static Badge](https://img.shields.io/badge/include-YES-green)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/user/login ![Static Badge](https://img.shields.io/badge/include-YES-green)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/user/logout ![Static Badge](https://img.shields.io/badge/include-NO-red)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/user/key ![Static Badge](https://img.shields.io/badge/include-NO-red)  

### core_stat
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/stat/summary/ui/current ![Static Badge](https://img.shields.io/badge/include-NO-red)  

### core_features
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/features/enabled ![Static Badge](https://img.shields.io/badge/include-NO-red)  

### translate

![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/translate/ ![Static Badge](https://img.shields.io/badge/include-YES-green)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/translate/{priority} ![Static Badge](https://img.shields.io/badge/include-YES-green)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/translate/result/{request_id} ![Static Badge](https://img.shields.io/badge/include-PARTIAL-yellow)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/translate/requeue/{request_id} ![Static Badge](https://img.shields.io/badge/include-NO-red)  
![Static Badge](https://img.shields.io/badge/method-DELETE-red) /api/v1/translate/{request_id} ![Static Badge](https://img.shields.io/badge/include-NO-red)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/translate/clear ![Static Badge](https://img.shields.io/badge/include-NO-red)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/translate/sync/ ![Static Badge](https://img.shields.io/badge/include-YES-green)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/translate/language/iso ![Static Badge](https://img.shields.io/badge/include-NO-red)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/translate/language/custom ![Static Badge](https://img.shields.io/badge/include-NO-red)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/translate/language/list ![Static Badge](https://img.shields.io/badge/include-YES-green)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/translate/language/detect ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/translate/files/ ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/translate/files/delete/{request_id} ![Static Badge](https://img.shields.io/badge/include-NOT-red)  

### glossary
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/glossary/management/list ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-PUT-yellow) /api/v1/glossary/management/update ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/glossary/management/create ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-DELETE-red) /api/v1/glossary/management/delete/{id} ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-DELETE-red) /api/v1/glossary/management/delete ![Static Badge](https://img.shields.io/badge/include-NOT-red)  

### dict_lookup
![Static Badge](https://img.shields.io/badge/method-POST-green) /api/v1/dict/lookup ![Static Badge](https://img.shields.io/badge/include-NOT-red)  
![Static Badge](https://img.shields.io/badge/method-GET-blue) /api/v1/dict/languages ![Static Badge](https://img.shields.io/badge/include-NOT-red)  


