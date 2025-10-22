<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Laravel\Fortify\Features;

class HomeController extends Controller
{
    public function __invoke()
    {
        return Inertia::render('home', [
            'canRegister' => Features::enabled(Features::registration()),
        ]);
    }
}
