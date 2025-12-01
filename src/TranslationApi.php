<?php

namespace Zmog\Libs\Lingea\LTBE;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SetCookie;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Zmog\Libs\Lingea\LTBE\TranslationOptions\UseIsoCodes;

class TranslationApi {

    const API_DEFAULT_URL = '"http://lingea.localapi.com:8000"';

    protected string $_api_key;
    protected string $_api_url;


    public function __construct(string $api_key, ?string $api_url = null) {
        $this->_api_key = $api_key;
        $this->_api_url = $api_url ?? self::API_DEFAULT_URL;
    }

    protected function headers(): array {
        return [
            'X-API-Key' => $this->_api_key,
        ];
    }

    protected function endpoint(string $endpoint_uri): string {
        $url = trim( $this->_api_url );
        if (!str_ends_with( $url, '/' )) {
            $url = $url . '/';
        }
        $url .= ( !str_starts_with( $endpoint_uri, '/' ) ) ? $endpoint_uri : substr( $endpoint_uri, 1 );
        return $url;
    }


    /**
     * @return ResponseUserMe
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function userMe(): ResponseUserMe {
        $Request = new Request( 'GET', $this->endpoint( '/api/v1/user/me' ), $this->headers() );
        $Client  = new Client( [] );
        try {
            $Response = $Client->send( $Request );
        }
        catch (GuzzleException $e) {
            throw new LingeaException( 'Error retrieving user/me.', 0, $e );
        }

        return ResponseUserMe::createFromResponse( $Response );
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function userLogin(string $username, string $password): CookieJar {
        $Client = new Client( [] );

        try {
            $Response = $Client->request( 'POST', $this->endpoint( '/api/v1/user/login' ), [
                'headers' => $this->headers(),
                'body'    => json_encode( [
                                              "username" => $username,
                                              "password" => $password,
                                          ] ),
            ] );
        }
        catch (Exception $e) {
            throw new LingeaException( 'Error ' . $e->getMessage(), 0, $e );
        }

        if ($Response->getStatusCode() !== 200) {
            throw new LingeaException( 'Error ' . $Response->getStatusCode() . ' : ' . $Response->getReasonPhrase() );
        }

        $headerSetCookies = $Response->getHeader( 'Set-Cookie' );

        $cookies         = [];
        $csrftoken_found = false;
        $sessionid_found = false;
        foreach ($headerSetCookies as $header) {
            $cookie = SetCookie::fromString( $header );
            switch ($cookie->getName()) {
                case 'csrftoken':
                    $csrftoken_found = true;
                    break;
                case 'sessionid':
                    $sessionid_found = true;
                    break;
            }
            $cookie->setDomain( 'YOUR_DOMAIN' );

            $cookies[] = $cookie;
        }

        if (false === $csrftoken_found) {
            throw new LingeaException( 'Error retrieving cookies, missing csrftoken.' );
        }
        if (false === $sessionid_found) {
            throw new LingeaException( 'Error retrieving cookies, missing sessionid.' );
        }

        return new CookieJar( false, $cookies );
    }

    public function userLogout() {
        throw new Exception( 'Missing method definition' );
    }


    /**
     * @return \Zmog\Libs\Lingea\LTBE\TranslationPair[]
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function getTranslationPairs(): array {
        $Request = new Request( 'GET', $this->endpoint( '/api/v1/translate/language/pairs/iso' ), $this->headers() );
        $Client  = new Client( [] );
        try {
            $Response = $Client->send( $Request );
        }
        catch (GuzzleException $e) {
            throw new LingeaException( 'Error retrieving translation pair.', 0, $e );
        }
        $body           = (string)$Response->getBody();
        $language_pairs = json_decode( $body, true );
        if (null === $language_pairs || false === $language_pairs) {
            throw new LingeaException( 'Error decoding translation pair.', 0 );
        }
        $supported_language_a = [];


        foreach ($language_pairs as $pair) {
            $from = TranslationLanguage::fromLingeaCode( $pair[ 0 ] );
            $to   = TranslationLanguage::fromLingeaCode( $pair[ 1 ] );

            if (null !== $from && null !== $to) {
                $supported_language_a[] = new TranslationPair( TranslationLanguage::fromLingeaCode( $pair[ 0 ] ), TranslationLanguage::fromLingeaCode( $pair[ 1 ] ) );
            }
        }
        return $supported_language_a;
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function translate(string $text, TranslationLanguage $from_lng, TranslationLanguage $to_lng): ResponseTranslateSync {
        return $this->translateSync( $text, $from_lng, $to_lng );
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function translateSync(array|string $text, TranslationLanguage $from_lng, TranslationLanguage $to_lng, ?TranslationOptions $Options = null): ResponseTranslateSync {
        $Client  = new Client( [] );
        $Options = $Options ?? new TranslationOptions( new UseIsoCodes( true ) );

        try {
            $Response = $Client->request( 'POST', $this->endpoint( '/api/v1/translate/sync/' ), [
                'headers' => $this->headers(),
                'body'    => json_encode( array_merge( [
                                                           "source_language" => $from_lng->iso639_1(),
                                                           "target_language" => $to_lng->iso639_1(),
                                                           "content"         => $text,
                                                       ], $Options->toArray() ) ),
            ] );
        }
        catch (Exception $e) {
            throw new LingeaException( 'Error ' . $e->getMessage(), 0, $e );
        }

        if ($Response->getStatusCode() !== 200) {
            throw new LingeaException( 'Error ' . $Response->getStatusCode() . ' : ' . $Response->getReasonPhrase(), $Response->getStatusCode() );
        }

        return ResponseTranslateSync::createFromResponse( $Response );
    }


    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function translateAsync(string $text, TranslationLanguage $from_lng, TranslationLanguage $to_lng, ?string $priority = null, ?TranslationOptions $Options = null): ResponseTranslateAsync {
        $Client = new Client( [] );
        $Options = $Options ?? new TranslationOptions( new UseIsoCodes( true ) );

        if (null !== $priority) {
            if (!in_array( $priority, [ 'low',
                                        'mid',
                                        'high' ] )) {
                throw new LingeaException( '$priority must be "low" ,"mid" or "high".' );
            }
        }

        try {
            $Response = $Client->request( 'POST', $this->endpoint( $priority ? "/api/v1/translate/$priority" : '/api/v1/translate/' ), [
                'headers' => $this->headers(),
                'body'    => json_encode(  array_merge( [
                                                            "source_language" => $from_lng->iso639_1(),
                                                            "target_language" => $to_lng->iso639_1(),
                                                            "content"         => $text,
                                                        ], $Options->toArray() )  ),
            ] );
        }
        catch (Exception $e) {
            throw new LingeaException( 'Error ' . $e->getMessage(), 0, $e );
        }

        if ($Response->getStatusCode() !== 200) {
            throw new LingeaException( 'Error ' . $Response->getStatusCode() . ' : ' . $Response->getReasonPhrase() );
        }

        return ResponseTranslateAsync::createFromResponse( $Response );
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public function translateResult(string $request_id): ResponseTranslateResult {
        // Sample : f373d694-4953-4d97-86af-b632116b6fa9
        if (!preg_match( '/^([a-f0-9]+-){4}[a-f0-9]+$/', $request_id )) {
            throw new LingeaException( 'Invalid request_id.' );
        }

        $Request = new Request( 'GET', $this->endpoint( "/api/v1/translate/result/$request_id" ), $this->headers() );
        $Client  = new Client( [] );
        try {
            $Response = $Client->send( $Request );
        }
        catch (GuzzleException $e) {
            throw new LingeaException( 'Error retrieving translation result.', 0, $e );
        }

        if ($Response->getStatusCode() !== 200) {
            throw new LingeaException( 'Error ' . $Response->getStatusCode() . ' : ' . $Response->getReasonPhrase() );
        }

        return ResponseTranslateResult::createFromResponse( $Response );
    }

}