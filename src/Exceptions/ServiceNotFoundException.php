<?php
namespace Selline\Di\Exceptions;
use Psr\Container\NotFoundExceptionInterface;
use Exception;

class ServiceNotFoundException extends Exception implements NotFoundExceptionInterface
{
}