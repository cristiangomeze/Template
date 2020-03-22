<?php

namespace Thepany\Template\Exceptions;

use Exception;
use Throwable;

class CannotConvertException extends Exception implements TemplateException
{
    /**
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct(
        $message = 'Could not convert "docx" to "pdf". Make sure the command to do this works and your application has the necessary permissions to use the cmd.',
        $code = 0,
        Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
