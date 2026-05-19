<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Client::paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function createFile()
    {
        $file_name = Str::random(32) . '.txt';
        Storage::disk('public')->put($file_name, Str::random(128));
        return redirect()->route('home')->with('message', $file_name . ' - File created successfully');
    }

    public function listFiles()
    {
        $files = Storage::disk('public')->files();
        return view('clients.files', compact('files'));
    }

    public function deleteFiles()
    {
        Storage::disk('public')->delete(Storage::disk('public')->files());
        return redirect()->route('home')->with('message', 'All files deleted successfully');
    }
}
