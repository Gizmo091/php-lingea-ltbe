<?php

namespace Zmog\Libs\Lingea;


use ReflectionClass;
use WhiteCube\Lingua\Service;
use Zmog\Libs\Lingea\TranslationLanguage\Autodetect;
use Zmog\Libs\Lingea\TranslationLanguage\ISO_639_1;

abstract class TranslationLanguage {

    protected string $_language_code;

    /**
     * @var \WhiteCube\Lingua\Service $_Service
     */
    protected Service $_Service;
    protected function __construct(string $language_code) {
        $this->_language_code = $language_code;
        $this->_Service = call_user_func_array([
                                                   Service::class,
                                                   'createFrom'.(new ReflectionClass($this))->getShortName(),
                                               ], [$this->_language_code]);
        if("" === $this->_Service->toISO_639_1()) {
            throw new LingeaException('Language code "'.$this->_language_code.'" is not a valid code.');
        }
    }



    protected ?string $_lingea_code = null;

    public function lingeaCode(): string {
        if (null === $this->_lingea_code) {
            $this->_lingea_code = $this->_Service->toISO_639_1();
        }
        return $this->_lingea_code;
    }

    public function iso639_1(): string {
        return $this->_Service->toISO_639_1();
    }

    public function iso639_2b(): string {
        return $this->_Service->toISO_639_2b();
    }

    public function iso639_2t(): string {
        return $this->_Service->toISO_639_2t();
    }

    public function iso639_3(): string {
        return $this->_Service->toISO_639_3();
    }

    public function name() :string {
        return $this->_Service->toName();
    }

    public static final function fromCode(string $language_code): ?TranslationLanguage {
        try {
            return new static($language_code);
        }
        catch (LingeaException) {
            return null;
        }
    }

    public static final function fromLingeaCode(string $language_code): ?TranslationLanguage {
        $language_code = strtolower($language_code);
        if (Autodetect::CODE === $language_code) {
            return new Autodetect();
        }
        try {
            return new ISO_639_1($language_code);
        }
        catch (LingeaException) {
            return null;
        }
    }

}