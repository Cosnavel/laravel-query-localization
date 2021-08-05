<?php

namespace Cosnavel\LaravelQueryLocalization\Exceptions;

use Exception;

class LanguagePreferenceException extends Exception
{
    public function __construct()
    {
        parent::__construct('Column language_preference not found for users table');
    }
}
