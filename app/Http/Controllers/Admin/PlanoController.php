<?php

namespace App\Http\Controllers\Admin;

ini_set('upload_max_filesize', '10M');
ini_set('post_max_size', '10M');
ini_set('max_input_time', 300);
ini_set('max_execution_time', 300);

use App\Http\Controllers\Controller;
use App\Models\ConfigPlano;
use App\Models\SubPlano;
use Illuminate\Http\Request;
use App\Models\Plano;
use Str;
Use Alert;
use Validator;

class PlanoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $planos = Plano::all();
        //toast('Your Post as been submited!','success');
        return view('admin.planos.index',compact('planos'));
    }

    public function create()
    {
        return view('admin.planos.create');
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'imagem' => 'required|mimes:jpeg,png,jpg,pdf|max:20480',
        ]);
        /*if($request->file('imagem')->getSize() > 1048576){
            return redirect()->route('admin.produtos.create')->with('warning', 'Imagem maior que 1 MB!');
        }*/
        $uuid = Str::uuid();
        $imageName = $uuid.'.'.request()->imagem->getClientOriginalExtension();
        request()->imagem->move(public_path('imagem/planos/'), $imageName);

        $plano = new Plano;
        $plano->name = $request->name;
        $plano->body = $request->body;
        $plano->valor = str_replace(array(".", ","), array("", "."), $request->valor);
        $plano->tipo = $request->tipo;
        $plano->imagem = $imageName;
        $plano->status = '1';
        $plano->save();
        return redirect()->route('admin.produtos.index')->with('success', 'Plano Cadastrado com Sucesso!');
    }

    public function edit($id)
    {
        $plano = Plano::find($id);
        return view('admin.planos.edit',compact('plano'));
    }

    public function update(Request $request, $id)
    {

        if($request->imagem != null){
            $this->validate(request(),[
                'imagem' => 'required|mimes:jpeg,png,jpg,pdf|max:20480',
            ]);
            /*if($request->file('imagem')->getSize() > 1048576){
                return redirect()->route('admin.produtos.edit',$id)->with('warning', 'Imagem maior que 1 MB!');
            }*/
            $uuid = Str::uuid();
            $imageName = $uuid.'.'.request()->imagem->getClientOriginalExtension();
            request()->imagem->move(public_path('imagem/planos/'), $imageName);
        }

        $plano = Plano::find($id);
        $plano->name = $request->name;
        $plano->body = $request->body;
        $plano->valor = str_replace(array(".", ","), array("", "."), $request->valor);
        $plano->tipo = $request->tipo;
        if($request->imagem != null){
            $plano->imagem = $imageName;
        }
        $plano->status = '1';
        $plano->save();
        return redirect()->route('admin.produtos.edit',$id)->with('success', 'Plano Editado com Sucesso!');
    }

    public function destroy($id)
    {
        //
    }
}
