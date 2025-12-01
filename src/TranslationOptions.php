<?php

namespace Zmog\Libs\Lingea\LTBE;

class TranslationOptions {

    protected array $_options;

    public function __construct(TranslationOption ...$options) {
        $this->_options = $options;
    }


    public function toArray(): array {
        return array_combine(
            array_map( function (TranslationOption $TO) { return $TO::postName(); }, $this->_options ),
            array_map( function (TranslationOption $TO) { return $TO->value(); }, $this->_options ),
        );
    }

}