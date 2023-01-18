<?php
namespace App\Controllers;
require_once "Lib/Controller.php";
use chrisvanlier2005\Controller;
use chrisvanlier2005\Request;
use chrisvanlier2005\Router;

class UserController extends Controller
{
    public $layout = "page";
    public function index()
    {
        return $this->view('user');
    }
    public function show(Request $request, $id)
    {
        echo "this is the user show";
    }
}