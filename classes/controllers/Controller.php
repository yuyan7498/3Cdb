<?php

class Controller
{
    protected $container;

    public function __construct()
    {
        global $container;
        $this->container = $container;
    }

    protected function responseJson($response, $result) {
        $response = $response->withHeader('Content-type', 'application/json');
        $response = $response->withJson($result);
        return $response;
    }
}