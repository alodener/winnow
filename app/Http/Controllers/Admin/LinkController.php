<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $links = Link::orderBy('id','desc')->get();
        return view('admin.links.index',compact('links'));
    }

    public function store(Request $request)
    {
        $this->validate(request(),[
            'name'=> ['required', 'string', 'max:191', 'unique:links'],
            'link'=> ['required', 'string', 'max:191', 'unique:links'],
        ]);

        $link = new Link();
        $link->name = $request->name;
        $link->link = $request->link;
        $link->save();

        return redirect()->route('admin.links.index')->with('success','Link cadastrado com Sucesso!');
    }

    public function edit($id)
    {
        $link = Link::find($id);
        if(!$link) return redirect()->route('admin.links.index')->with('warning','Link não existe!');
        return view('admin.links.edit',compact('link'));
    }

    public function update(Request $request, $id)
    {
        $link = Link::find($id);
        if(!$link) return redirect()->route('admin.links.index')->with('warning','Link não existe!');

        if($link->name != $request->name){
            $this->validate(request(),[
                'name'=> ['required', 'string', 'max:191', 'unique:links'],
            ]);
        }elseif ($link->link != $request->link){
            $this->validate(request(),[
                'link'=> ['required', 'string', 'max:191', 'unique:links'],
            ]);
        }

        $link->name = $request->name;
        $link->link = $request->link;
        $link->save();

        return redirect()->route('admin.links.index')->with('success','Link Editado com Sucesso!');
    }

    public function destroy($id)
    {
        Link::find($id)->delete();
        return response()->json(['success']);
    }
}
