<?php

namespace Zmog\Libs\Lingea\TranslationLanguage;

use Zmog\Libs\Lingea\TranslationLanguage;

final class Autodetect extends TranslationLanguage {

    const CODE = 'xx';

    protected function __construct() {}


    public function lingeaCode(): string {
        return self::CODE;
    }

    public function iso639_1(): string {
        return "xx";
    }

    public function iso639_2b(): string {
        return "xxx";
    }
    public function iso639_2t(): string {
        return "xxx";
    }
    public function iso639_3(): string {
        return "xxx";
    }
    public function name(): string {
        return "Autodetect";
    }
}