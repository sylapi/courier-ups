<?php

declare(strict_types=1);

namespace Sylapi\Courier\Ups;

use Sylapi\Courier\Ups\Entities\Credentials;

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

    private function initializeSession()
    {
        var_dump($this->credentials);
        return $this->client;
    }


}
