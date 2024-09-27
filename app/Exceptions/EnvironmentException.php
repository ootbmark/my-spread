<?php


namespace App\Exceptions;


class EnvironmentException extends \RuntimeException
{
    public static function missing(string $key): self
    {
        throw new self("The env variable with the specified key is missing: $key");
    }

    public static function invalid(string $key): self
    {
        throw new self("The env variable with the specified key is not valid: $key");
    }
}
