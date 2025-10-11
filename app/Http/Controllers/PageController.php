<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function developers()
    {
        return view('pages.developers');
    }

    /**
     * Muestra la página de comparación de proyectos.
     */
    public function compare()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Obtenemos todos los proyectos del usuario para pasarlos al selector.
        $projects = $user->projects()->get();

        return view('pages.compare', compact('projects'));
    }
}
