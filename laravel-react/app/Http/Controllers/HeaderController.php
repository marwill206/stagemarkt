<?php
namespace App\Http\Controllers;

use Inertia\Inertia;

class HeaderController extends Controller
{
    public function index()
    {
        return Inertia::render('header', [
            'exampleProp' => 'This is a test message from Laravel!',
            'anotherProp' => 12345,
        ]);
    }
}