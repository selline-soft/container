<?php
namespace Selline\Di\Exceptions;
use Throwable;

class NotInstantiableException extends ServiceNotFoundException
{
    /**
     * Конструктор.
     * @param string $message имя класса
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = sprintf("Class is not instantiable: %s", $message);
        parent::__construct($message, $code, $previous);
    }
}