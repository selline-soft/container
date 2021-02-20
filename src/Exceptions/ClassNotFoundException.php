<?php
namespace Selline\Di\Exceptions;
use Psr\Container\NotFoundExceptionInterface;
use Exception;
use Throwable;

class ClassNotFoundException extends Exception implements NotFoundExceptionInterface
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Class not found: %s", $message);
        parent::__construct($message, $code, $previous);
    }
}