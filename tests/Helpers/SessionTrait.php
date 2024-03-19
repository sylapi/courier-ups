<?php

namespace Sylapi\Courier\Ups\Tests\Helpers;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Sylapi\Courier\Ups\Session;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Client as HttpClient;

trait SessionTrait
{
    /**
     * @param array<array<string,mixed>> $responseMockFiles
     */
    private function getSession(array $responseMockFiles): Session
    {
        
        $responseMocks = [];

        foreach ($responseMockFiles as $mock) {
            $output = file_get_contents($mock['file']);
            $responseMocks[] = new Response($mock['code'], [], $output);
        }

        $mock = new MockHandler($responseMocks);

        $handlerStack = HandlerStack::create($mock);
        $client = new HttpClient(['handler' => $handlerStack]);

        $sessionMock = $this->createMock(Session::class);
        $sessionMock->method('client')->willReturn($client);

         return $sessionMock;
    }
}
