<?php

namespace Zmog\Libs\Lingea\LTBE\TranslationOptions;

use Zmog\Libs\Lingea\LTBE\TranslationOption;

class SplitOnNewlines extends TranslationOption {

    public function __construct( bool $value) {
        parent::__construct( $value );
    }

    public static function postName() :string {
        return 'split_on_newlines';
    }

}