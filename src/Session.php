<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Ups\Entities\Credentials;
use GuzzleHttp\Client;

class Session
{
    private $credentials;
    private $client;
    private $token;

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
        if($this->token === null) {
            $this->checkToken();
        }

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

    private function token(): ?string
    {
        return $this->token;   
    }
    

    public function login(): void
    {
        /**
         * @var Credentials $credentials
         */
        $credentials = $this->credentials;
    
        // Create a new HTTP client with the base URL and headers for authentication
        $client = new Client([
            'base_uri' => $credentials->getApiUrl(),
            'headers'  => [
                'Accept'        => 'application/json',
                'Content-Type'  => 'application/x-www-form-urlencoded',
                'Authorization' => ' Basic ' . base64_encode($credentials->getLogin().':'.$credentials->getPassword()),
            ],
        ]);        
    
        // Make a POST request to obtain the access token
        $stream = $client->request(
            'POST',
            '/security/v1/oauth/token',
            [ 
                'form_params' => [
                    'grant_type' => 'client_credentials',
                ],
            ]
        );
    
        // Decode the response and calculate the expiration time of the token
        $result = json_decode($stream->getBody()->getContents(), true);
        $result['expiration_time'] =  time() + $result['expires_in'];
    
        // Save the token data to a JSON file
        file_put_contents($this->tokenFilePath(), json_encode($result));
    
        // Set the current token for future use
        $this->token = $result['access_token'];
    }
    
    // Generate the file path where the token information will be stored
    private function tokenFilePath() {
        /**
         * @var Credentials $credentials
         */
        $credentials = $this->credentials;
        return sys_get_temp_dir() . '/'.md5($credentials->getLogin().':'.$credentials->getPassword()).'.json';
    }
    
    // Check if a valid token exists; if not or if expired, perform a new login
    private function checkToken():void {
    
        if (file_exists($this->tokenFilePath())) {
            $data = json_decode(file_get_contents($this->tokenFilePath()), true);
    
            if ($data && isset($data['expiration_time'])) {
                $currentTime = time();
    
                // If the token is still valid, use it; otherwise, perform a new login
                if ($currentTime < $data['expiration_time'] - 600) {
                    $this->token = $data['access_token'];
                } else {
                    $this->login();
                }
            } else {
                // If the token file is corrupt or missing relevant information, perform a new login
                $this->login();
            }
        } else {
            // If the token file does not exist, perform a new login
            $this->login();
        }
    }

}
