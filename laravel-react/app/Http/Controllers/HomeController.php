<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'exampleProp' => 'This is a test message from Laravel!',
            'anotherProp' => 12345,
        ]);
    }
}