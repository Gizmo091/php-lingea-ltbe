<?php
namespace Zmog\Libs\Lingea;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

abstract class Response {


    /**
     * @throws \Zmog\Libs\Lingea\LingeaException
     */
    final protected static function decodeResponse( GuzzleResponse $Response ):array {
        $result = json_decode( $Response->getBody(), true );
        if ( null === $result || false === $result ) {
            throw new LingeaException( 'Error during decoding translation result.', 0 );
        }
        return $result;
    }

    abstract public static function createFromResponse( GuzzleResponse $Response ) :Response;

    /**
     * @param array $json_decoded_response
     *
     * @throws \Zmog\Libs\Lingea\LingeaException
     * @return void
     */
    abstract protected static function checkResponseData( array $json_decoded_response):void;
}