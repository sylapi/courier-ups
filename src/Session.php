<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Ups\Entities\Credentials;
use GuzzleHttp\Client;

class Session
{
    private $credentials;
    private $client;

    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public function client()
    {
        if (!$this->client) {
            $this->client = $this->initializeSession();
        }

        return $this->client;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    private function initializeSession()
    {
        /**
         * @var Credentials $credentials
         */
        $credentials = $this->credentials;
        $this->client = new Client([
            'base_uri' => $credentials->getApiUrl(),
            'headers'  => [
                'Content-Type'  => 'application/json',
                'Authorization' => 'Bearer '.$this->token(),
                'transId' =>  $credentials->getTransId(),
                'transactionSrc' => $credentials->getTransactionSrc(),
            ],
        ]);

        return $this->client;
    }

    private function token()
    {
        return 'token';   
    }
    

}
