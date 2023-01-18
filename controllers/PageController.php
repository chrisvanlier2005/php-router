<?php
namespace App\Controllers;
require_once "Lib/Controller.php";
use chrisvanlier2005\Controller;
use chrisvanlier2005\Request;
use chrisvanlier2005\Router;
use Page;

class PageController extends Controller
{
    public $layout = "page";

    public function index()
    {
        return $this->view('index');
    }
    public function show(Request $request, $id)
    {
        return $this->view("show", [
            "page" => [
                "title" => "This is the title",
                "content" => "This is the content"
            ],
            "request" => $request,
            "id" => $id
        ]);
    }
}