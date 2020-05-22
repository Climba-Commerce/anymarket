<?php


namespace Anymarket;


interface ILogger
{

    public function request(string $url, string  $method, array $header, $data = null): void;

    public function response(int $statusCode, array $headers, string $body): void;

}