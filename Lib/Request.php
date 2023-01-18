<?php

namespace chrisvanlier2005;

class Request

{

    private $joe = "joe";

    private $params = [];

    public function __construct()
    {

        $getParams = $_GET;

        foreach ($getParams as $key => $value){

            $this->$key = $value;

            $this->params[$key] = $value;

        }



    }



    public function has($param){

        if (isset($this->params[$param])){

            return true;

        }

        return false;

    }



    public function all(){

        return $this->params;

    }



    public static function build()

    {

        return new Request();

    }

}
