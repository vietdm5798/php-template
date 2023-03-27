<?php

class Controller
{
    public function __call($name, $arguments)
    {
        Response::badRequest('Action not exist!');
    }
}
