<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

class FinanceiroController extends Controller
{
    public function index() {

        return Inertia::render('Financeiro', [
            'financeiro' => [
                'Texto' => 'Financeiro'
            ]
        ]);

    }
}