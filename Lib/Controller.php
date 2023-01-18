<?php

namespace chrisvanlier2005;
class Controller
{
    public $layout;

    public function view($name, $data = [])
    {
        str_replace('.', '/', $name);
        $path = "views/$name.php";
        if (file_exists($path))
        {
            foreach ($data as $key => $value)
            {
                $$key = $value;
            }

            if ($this->layout == "default")
            {
                require_once $path;
                return true;
            }

            $layoutPath = "views/layouts/{$this->layout}.php";
            if (file_exists($layoutPath))
            {
                $yield = $path;
                require_once $layoutPath;
            } else
            {
                echo "Layout not found";
            }
            return true;

        } else
        {
            echo "view not found";
            return false;
        }
        return false;
    }

    public function index()
    {

    }
}