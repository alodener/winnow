<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Curso;
use Illuminate\Http\Request;
use App\Models\Aula;
use App\Models\Plano;
use App\Models\Modulo;
use Illuminate\Support\Str;

class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
        $cursos = Plano::all();
        return view('admin.cursos.index',compact('cursos'));
    }

    public function create()
    {
        return view('admin.cursos.create');
    }

    public function store(Request $request)
    {
        $curso = new Curso();
        $curso->name = $request->name;
        $curso->slug = Str::slug($request->name);
        $curso->description = $request->descripiton;
        $curso->body = $request->body;
        $curso->save();

        return redirect()->route('admin.cursos.aulas.create',$curso->id)->with('success','Curso Criado com Sucesso, Agora adicione as aulas!');
    }

    public function aulaCreate($id)
    {
        $curso = Curso::find($id);
    }

    public function show($slug)
    {
        $curso = Plano::where('slug',$slug)->first();
        $modulos = Modulo::where('plano_id',$curso->id)->get();
        return view('admin.cursos.show',compact('curso','modulos'));
    }

    public function categorias()
    {
        $categorias = Categoria::all();
        return view('admin.cursos.categorias.index',compact('categorias'));
    }

    public function categoriaStore(Request $request)
    {
        $cat = new Categoria();
        $cat->name = $request->name;
        $cat->slug = Str::slug($request->name);
        $cat->name;
        $cat->save();

        return redirect()->route('admin.cursos.categorias.index')->with('success','Categoria Salva com Sucesso!');
    }

    public function deleteCategoria($id)
    {
        $cat = Categoria::find($id)->delete();
        return redirect()->route('admin.cursos.categorias.index')->with('success','Categoria Deletada com Sucesso!');
    }
}
