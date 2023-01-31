<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Arquivo;
use Illuminate\Http\Request;

class ArquivoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        $arquivos = Arquivo::orderBy('id','desc')->paginate(20);
        return view('dashboard.arquivos.index',compact('arquivos'));
    }

    public function show($id)
    {
        $arquivo = Arquivo::findOrFail($id);
        if($arquivo != null){
            $arquivo->download += 1;
            $arquivo->save();
        }
        //$this->authorize('visualizar', $arquivo);
        return response()->download(public_path('files/'.$arquivo->name));
    }
}
