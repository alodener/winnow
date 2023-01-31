<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Arquivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ArquivoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
        $arquivos = Arquivo::orderBy('id','desc')->paginate(20);
        return view('admin.arquivos.index',compact('arquivos'));
    }

    public function store(Request $request)
    {
        $tamanho = request()->arquivo->getSize();
        $imageName = request()->arquivo->getClientOriginalName();
        request()->arquivo->move(public_path('files/'), $imageName);
        $a = new Arquivo();
        $a->name = $imageName;
        $a->tipo = request()->arquivo->getClientOriginalExtension();
        $a->tamanho = $tamanho;
        $a->save();
        return redirect()->route('admin.arquivos.index')->with('success','Arquivo salvo com sucesso!');
    }

    public function show($id)
    {
        $arquivo = Arquivo::findOrFail($id);
        //$this->authorize('visualizar', $arquivo);
        return response()->download(public_path('files/'.$arquivo->name));
    }

    public function destroy($id)
    {
        $arquivo = Arquivo::findOrFail($id);
        File::delete(public_path('files/'.$arquivo->name));
        $arquivo->delete();
        return redirect()->route('admin.arquivos.index')->with('success','Arquivo deletado com sucesso!');
    }
}
