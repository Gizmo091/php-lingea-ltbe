<?php
namespace Zmog\Libs\Lingea\LTBE;

use GuzzleHttp\Psr7\Response;

class ResponseTranslateSync extends ResponseTranslateAsync {

    protected string $_result;

    protected function __construct( string $request_id , string $result) {
        parent::__construct( $request_id );
        $this->_result = $result;
    }

    public function getResult(): string {
        return $this->_result;
    }

    /**
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public static function createFromResponse( Response $Response ): ResponseTranslateSync {
        $result = static::decodeResponse( $Response );
        static::checkResponseData( $result );
        return new static( $result['request_id'], $result['result'] );
    }

    protected static function checkResponseData( array $json_decoded_response ): void {
        parent::checkResponseData($json_decoded_response);
        if (!array_key_exists('result',$json_decoded_response)) {
            throw new LingeaException('Missing result in Response');
        }
    }
}