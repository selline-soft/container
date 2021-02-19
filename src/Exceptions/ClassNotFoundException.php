<?php
namespace Selline\Di\Exceptions;
use Psr\Container\NotFoundExceptionInterface;
use Exception;

class ClassNotFoundException extends Exception implements NotFoundExceptionInterface
{

}