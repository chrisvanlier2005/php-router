<?php

namespace chrisvanlier2005;

class Request

{


    private $params = [];

    public function __construct()
    {
        foreach ($_GET as $key => $value) {
            $this->$key = $value;
            $this->params[$key] = $value;
        }
        foreach ($_POST as $key => $value) {
            $this->$key = $value;
            $this->params[$key] = $value;
        }
    }

    public static function build()
    {
        return new Request();
    }

    public function has($param): bool
    {

        return isset($this->params[$param]);

    }

    public function all(): array
    {
        return $this->params;
    }

}
