<?php

namespace chrisvanlier2005;

use ReflectionMethod;

class Router
{
    private static $routerInstance;
    public $registeredRoutes = [];
    private $prefixStack = [];
    private $success = false;
    public function __construct()
    {
        self::$routerInstance = $this;
    }

    public static function Get($url, $callback)
    {
        self::$routerInstance->register($url, $callback, "GET");
        self::$routerInstance->execute();
    }

    public function register($url, $callback, $method)
    {
        $url = $this->getPrefixUrl() . $url;
        $parameters = $this->extractParameters($url);
        $this->registeredRoutes[] = ['url' => $url, 'callback' => $callback, 'method' => $method, 'checked' => false, 'params' => $parameters];
    }

    public function extractParameters($url)
    {
        $parameters = [];
        $url = explode("/", $url);
        foreach ($url as $key => $value)
        {
            if (str_contains($value, "{") && str_contains($value, "}"))
            {
                $parameters[substr($value, 1, -1)] = $key;
            }
        }
        return $parameters;
    }

    public function execute()
    {
        $url = "/";
        if (isset($_GET['q'])){
            $url .= $_GET['q'];
        }
        if ($url == "")
        {
            $url = "/";
        }
        if (!str_ends_with($url, "/"))
        {
            $url .= "/";
        }

        foreach ($this->registeredRoutes as $key => $route)
        {
            if(!str_ends_with($route['url'], "/")){
                $route['url'] .= "/";
            }


            if ($route["checked"])
            {
                continue;
            }
            if ($this->urlParameterMatch($route["url"], $url, $key)[0] && $route['method'] == $_SERVER['REQUEST_METHOD'])
            {
                $params = $this->urlParameterMatch($route["url"], $url, $key)[1];
                if ($params == null)
                {
                    $params = [];
                }
                $callback = $route['callback'];
                // check if the callback is a class (controller)
                if (is_array($callback))
                {
                    // TODO: Make reflection available for all classes and not just the router
                    $controller = new $callback[0]();
                    $reflection = new ReflectionMethod($controller, $callback[1]);
                    $parameters = $reflection->getParameters();
                    $data = [];
                    foreach ($parameters as $index => $parameter)
                    {
                        $data[] = $parameter->getName();
                    }
                    if (in_array("request", $data))
                    {
                        $params = [new Request] + $params;
                    }
                    $result = $controller->{$callback[1]}(...$params);
                } else
                {

                    $result = $callback(...$params);
                }
                $this->success = true;
                $this->registeredRoutes[$key]["checked"] = true;
            }
        }
    }

    public function urlParameterMatch($registeredUrl, $requestedUrl, $key)
    {
        $requestedUrl = explode('/', $requestedUrl);
        array_shift($requestedUrl);
        $registeredUrl = explode('/', $registeredUrl);
        array_shift($registeredUrl);

        //remove last / from both arrays
        array_pop($requestedUrl);
        array_pop($registeredUrl);
        $matches = true;
        $matchesFalsifiedAt = "";
        $requestParams = [];
        if (count($requestedUrl) != count($registeredUrl))
        {
            $matches = false;
            $matchesFalsifiedAt = "Count does not match";
        }
        if (!$matches)
        {
            return [false];
        }
        for ($i = 0; $i < count($registeredUrl); $i++)
        {
            $parameterMatch = false;
            if (str_contains($registeredUrl[$i], "{") && str_contains($registeredUrl[$i], "}"))
            {
                // request part is a parameter
                $parameter = substr($registeredUrl[$i], 1, -1);
                // checken of de parameter in de geristreerde parameters staat.
                // get the parameters for the registered url
                $parameters = $this->registeredRoutes[$key]['params'];
                $value = $requestedUrl[$i];
                $requestParams[$parameter] = $value;
                $parameterMatch = true;
                $this->success = true;

                continue;
            }
            if ($registeredUrl[$i] == $requestedUrl[$i])
            {
                continue;
            }
            if ($registeredUrl[$i] != $requestedUrl[$i])
            {
                $matches = false;
                $matchesFalsifiedAt = "Url does not match";
                break;
            }
            $matches = false;

        }
        return [$matches, $requestParams];

    }

    public static function Post($url, $callback)
    {
        self::$routerInstance->register($url, $callback, "POST");
        self::$routerInstance->execute();

    }

    public static function Put($url, $callback)
    {
        self::$routerInstance->register($url, $callback, "PUT");
        self::$routerInstance->execute();

    }

    public static function Delete($url, $callback)
    {
        self::$routerInstance->register($url, $callback, "DELETE");
        self::$routerInstance->execute();
    }

    public static function prefix($prefix, $callback)
    {
        self::$routerInstance->addPrefix($prefix);
        $callback();
        self::$routerInstance->removePrefix();
    }

    public function addPrefix($prefix)
    {
        $this->prefixStack[] = $prefix;
    }

    public function removePrefix()
    {
        array_pop($this->prefixStack);
    }

    public function getPrefixUrl()
    {
        $url = "";
        if (is_array($this->prefixStack) && count($this->prefixStack) <= 0)
        {
            return $url;
        }
        foreach ($this->prefixStack as $prefix)
        {
            $url .= $prefix;
        }
        return $url;
    }

    public static function notFound($callback){
        if(!self::$routerInstance->success){
            $callback();
        }
    }
}




/* a new instance of the Router and store it in the `Router::routerInstance` variable (constructor behavior) */
new Router();