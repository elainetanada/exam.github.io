<?php
/*
 * Response Service class.
 */
namespace App\Services;

class ResponseService {
    
    private $statusCode;
    private $headers;
    private $content;

    public function __construct($content, $statusCode = 200, $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send()
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo $this->content;
    }
}