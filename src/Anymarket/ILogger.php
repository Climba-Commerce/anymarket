<?php


namespace Anymarket;


interface ILogger
{

    public function request(): void;

    public function response(): void;


}