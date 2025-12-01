<?php

namespace Zmog\Libs\Lingea\LTBE;

abstract class TranslationOption {

    private mixed  $_value;

    public function __construct(mixed $value) {
        $this->_value = $value;
    }

    public function value(): mixed {
        return $this->_value;
    }
    abstract public static function postName() : string;


}