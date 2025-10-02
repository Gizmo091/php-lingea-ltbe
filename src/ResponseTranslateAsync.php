<?php
namespace Zmog\Libs\Lingea\LTBE;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ResponseTranslateAsync extends Response {

    protected string $_request_id;

    protected function __construct( string $request_id ) {
        $this->_request_id = $request_id;
    }


    public function getRequestId(): string {
        return $this->_request_id;
    }

    /**
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public static function createFromResponse( GuzzleResponse $Response ): ResponseTranslateAsync {
        $result = static::decodeResponse($Response);
        static::checkResponseData($result);
        return new static( $result['request_id'] );
    }

    protected static function checkResponseData( array $json_decoded_response ): void {
        if (!array_key_exists('request_id',$json_decoded_response)) {
            throw new LingeaException('Missing request_id in Response');
        }
    }
}