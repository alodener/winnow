<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PopUp;
use Str;
use File;
class PopupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $popups = PopUp::orderBy('status','desc')->paginate(10);
        return view('admin.pop-ups.index',compact('popups'));
    }

    public function create()
    {
        return view('admin.pop-ups.create');
    }

    public function store(Request $request)
    {
        if($request->imagem){
            $this->validate(request(),[
                'imagem' => 'required|mimes:jpeg,png,jpg,pdf|max:1024',
            ]);
            if($request->file('imagem')->getSize() > 1048576){
                return redirect()->route('admin.pop-ups.create')->with('warning', 'Imagem maior que 1 MB!');
            }
            $uuid = Str::uuid();
            $imageName = $uuid.'.'.request()->imagem->getClientOriginalExtension();
            request()->imagem->move(public_path('imagem/popups/'), $imageName);
        }

        $popup = new PopUp;
        $popup->title = $request->title;
        $popup->body = $request->body;
        $popup->tipo = $request->tipo;
        $popup->status = $request->status;
        if($request->imagem)
            $popup->img = $imageName;

        $popup->save();

        return redirect()->route('admin.pop-ups.index')->with('success','Inserido com Sucesso');
    }

    public function edit($id)
    {
        $popup = PopUp::find($id);
        return view('admin.pop-ups.edit',compact('popup'));
    }

    public function update(Request $request,$id)
    {
        $popup = PopUp::find($id);
        if($request->imagem){
            $this->validate(request(),[
                'imagem' => 'required|mimes:jpeg,png,jpg,pdf|max:1024',
            ]);
            if($request->file('imagem')->getSize() > 1048576){
                return redirect()->route('admin.pop-ups.edit',$id)->with('warning', 'Imagem maior que 1 MB!');
            }
            File::delete(public_path('imagem/popups/'), $popup->img);
            $uuid = Str::uuid();
            $imageName = $uuid.'.'.request()->imagem->getClientOriginalExtension();
            request()->imagem->move(public_path('imagem/popups/'), $imageName);
        }

        $popup->title = $request->title;
        $popup->body = $request->body;
        $popup->tipo = $request->tipo;
        $popup->status = $request->status;
        if($request->imagem)
            $popup->img = $imageName;

        $popup->save();

        return redirect()->route('admin.pop-ups.edit',$id)->with('success','Editado com Sucesso');
    }

    public function destroy($id)
    {
        $popup = PopUp::find($id);
        File::delete(public_path('imagem/popups/'), $popup->img);
        $popup->delete();
        return redirect()->route('admin.pop-ups.index')->with('success','Deletado com Sucesso');
    }
}
