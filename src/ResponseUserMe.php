<?php
namespace Zmog\Libs\Lingea\LTBE;

use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ResponseUserMe extends Response {

    protected string $_username;
    protected string $_email;
    protected string $_first_name;
    protected string $_last_name;
    protected string $_is_superuser;

    protected function __construct( string $username, string $email, string $first_name, string $last_name, bool $is_superuser ) {
        $this->_username = $username;
        $this->_email = $email;
        $this->_first_name = $first_name;
        $this->_last_name = $last_name;
        $this->_is_superuser = $is_superuser;
    }


    public function getUsername(): string {
        return $this->_username;
    }

    public function getEmail(): string {
        return $this->_email;
    }

    public function getFirstName(): string {
        return $this->_first_name;
    }

    public function getLastName(): string {
        return $this->_last_name;
    }

    public function getIsSuperuser(): bool {
        return $this->_is_superuser;
    }

    /**
     * @throws \Zmog\Libs\Lingea\LTBE\LingeaException
     */
    public static function createFromResponse( GuzzleResponse $Response ): ResponseUserMe {
        $result = static::decodeResponse($Response);
        static::checkResponseData($result);
        return new static( $result['username'], $result['email'], $result['first_name'], $result['last_name'], $result['is_superuser'] );
    }

    protected static function checkResponseData( array $json_decoded_response ): void {
        if (!array_key_exists('username',$json_decoded_response)) {
            throw new LingeaException('Missing username in Response');
        }
        if (!array_key_exists('email',$json_decoded_response)) {
            throw new LingeaException('Missing email in Response');
        }
        if (!array_key_exists('first_name',$json_decoded_response)) {
            throw new LingeaException('Missing first_name in Response');
        }
        if (!array_key_exists('last_name',$json_decoded_response)) {
            throw new LingeaException('Missing last_name in Response');
        }
        if (!array_key_exists('is_superuser',$json_decoded_response)) {
            throw new LingeaException('Missing is_superuser in Response');
        }
    }
}