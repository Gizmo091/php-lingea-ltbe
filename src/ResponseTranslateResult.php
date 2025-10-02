<?php
namespace Zmog\Libs\Lingea\LTBE;

use GuzzleHttp\Psr7\Response;

class ResponseTranslateResult extends \Zmog\Libs\Lingea\LTBE\Response {

    protected string $_status;
    protected ?array $_result;

    protected function __construct( ?string $status , array $result) {
        $this->_status = $status;
        $this->_result = $result;
    }

    public function isPending() : bool {
        return $this->_status === 'pending';
    }

    public function getStatus(): string {
        return $this->_status;
    }


    public function getResult(): array {
        return $this->_result;
    }

    /**
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public static function createFromResponse( Response $Response ): ResponseTranslateResult {
        $result = static::decodeResponse( $Response );
        static::checkResponseData( $result );
        return new static( $result['status'], $result['result'] );
    }

    protected static function checkResponseData( array $json_decoded_response ): void {
        if (!array_key_exists('status',$json_decoded_response)) {
            throw new LingeaException('Missing status in Response');
        }
        if (!array_key_exists('result',$json_decoded_response)) {
            throw new LingeaException('Missing result in Response');
        }
    }
}