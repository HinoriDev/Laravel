<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function showView(): View
    {
        // ---------------------------------------
        // método 1
        /*
        $data = [
            'name' => "João Ribeiro",
            'phone' => "123456789"
        ];
        return view('admin.newPage3', $data);
        */

        // ---------------------------------------
        // método 2
        /*
        return view('admin.newPage3', [
            'name' => "João Ribeiro",
            'phone' => "123456789"
        ]);
        */

        // ---------------------------------------
        // método 3
        /*
        return view('admin.newPage3')
                ->with('name', "João Ribeiro")
                ->with('phone', '123456789');
        */

        // ---------------------------------------
        // método 4
        $name = "João";
        $phone = "123000000";

        return view('admin.newPage3', compact('name', 'phone'));
    }
}
