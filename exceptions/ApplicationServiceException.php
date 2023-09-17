<?php
class ApplicationServiceException extends Exception
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        $newMessage = 'Applicationエラー' . $message;
        parent::__construct($newMessage, 600, $previous);
    }
}
