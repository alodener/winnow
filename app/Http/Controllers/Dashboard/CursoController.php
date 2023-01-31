<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\IpedCursos;
use App\Http\Controllers\Controller;
use App\Models\Aula;
use App\Models\AulaAssistida;
use App\Models\Categoria;
use App\Models\Curso;
use App\Models\IpedUser;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Auth;

class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth',]);
    }

    public function index()
    {
        $cursos = IpedCursos::getCourses();
        return view('dashboard.cursos.index', compact('cursos'));
    }

    public function show($slug)
    {
        $course = IpedCursos::getCurso($slug);
        //if(!$curso) return redirect()->route('dashboard.cursos.index')->with('warning','Curso não encontrado!');
        return view('dashboard.cursos.show',compact('course'));
    }

    public function assistir($course_id)
    {
        $pagamento = Pagamento::where(['user_id'=>auth()->id(),'status'=>'1'])->orderBy('id','desc')->first();
        if (!$pagamento) return redirect()->route('dashboard.produtos.index')->with('warning','Você não está apito para assistir, adquira um Plano!');

        $ipedUser = IpedUser::select('iped_user_id')->where('user_id',auth()->id())->first();
        if(!$ipedUser->iped_user_id) return redirect()->route('dashboard.cursos.index')->with('info','Estamos preparando o seu Ambiente de Cursos!');

        $course = IpedCursos::getEnvironment($course_id);
        if(isset($course['ERROR'])) return redirect()->route('dashboard.cursos.index')->with('warning',$course['ERROR']);
        return view('dashboard.cursos.assistir',compact('course'));
    }
    public function categorias()
    {
        $categorias = IpedCursos::getCategories();
        return view('dashboard.cursos.categorias',compact('categorias'));
    }

    public function getCategoria($category_id)
    {
        $cursos = IpedCursos::getCourses($category_id);
        return view('dashboard.cursos.index', compact('cursos'));
    }
}
