<?php

namespace App\Models\Groups\Managers;

/**
 * Class ResponseManager
 * @package App\Models\Groups\Managers
 */
class Messenger
{
    private $headers;

    public function send201Response()
    {
        header("HTTP/1.1 201 Created");
        $this->prepareHeaders();
        exit;
    }

    public function send204Response()
    {
        header("HTTP/1.1 204 No Content");
        $this->prepareHeaders();
        exit;
    }

    public function send400Response()
    {
        header("HTTP/1.1 400 Bad Request");
        header("X-RESPONSE-MESSAGE: Unknown Action");
        exit;
    }

    public function send404Response()
    {
        header("HTTP/1.1 404 Not Found");
        header("Refresh:1; url=/groups");
        $this->prepareHeaders();
        exit;
    }

    public function send405Response()
    {
        header("HTTP/1.1 405 Method is not allowed");
        header("Refresh:1; url=/groups");
        $this->prepareHeaders();
        exit;
    }

    public function send406Response()
    {
        header("HTTP/1.1 406 Not Acceptable");
        $this->prepareHeaders();
        exit;
    }

    public function send503Response()
    {
        $this->prepareHeaders();
        header("HTTP/1.1 503 Service Unavailable");
        header("Rerty-After: 15 minutes");
        exit;
    }

    /**
     * @param array $response
     * @throws \Exception
     */
    public function sendNewJSONResponse(array $response)
    {
        $this->prepareHeaders();
        header("Content-Type: application/json");
        echo json_encode($response);
        exit;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header)
    {
        $this->headers[] = $header;
    }


    private function prepareHeaders()
    {
        if (!empty($this->headers)) {
            if (headers_sent()) {
                exit;
            } else {
                foreach ($this->headers as $header) {
                    header($header);
                }
            }
        }
    }
}
