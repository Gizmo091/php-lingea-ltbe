<?php

namespace Zmog\Libs\Lingea\LTBE\TranslationOptions;

use Zmog\Libs\Lingea\LTBE\TranslationOption;

class UseIsoCodes extends TranslationOption {

    public function __construct( bool $value) {
        parent::__construct( $value );
    }

    public static function postName() :string {
        return 'use_iso_codes';
    }

}