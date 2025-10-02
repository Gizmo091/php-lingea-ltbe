<?php

namespace Zmog\Libs\Lingea\LTBE\TranslationLanguage;

use Zmog\Libs\Lingea\LTBE\TranslationLanguage;

final class Autodetect extends TranslationLanguage {

    const CODE = 'xx';

    /** @noinspection PhpMissingParentConstructorInspection */
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