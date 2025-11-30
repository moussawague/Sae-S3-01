<?php

namespace sae\Exceptions;

class AuthentificationException extends \Exception {

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function getType(): string
    {
        return "danger";
    }
}
