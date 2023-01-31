<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $faqs = Faq::orderBy('id','desc')->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $c = new Faq;
        $c->fill($request->all());
        $c->save();
        return redirect()->route('admin.faqs.index')->with('success','FAQ Inserido com Sucesso.');
    }

    public function edit($id)
    {
        $faq = Faq::find($id);
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $faq = Faq::find($id);
        if(!$faq) {
            return redirect()->route('admin.faqs.index')->with('error','FAQ Não Existe.');
        }
        $faq->fill($request->all());
        $faq->update();
        return redirect()->route('admin.faqs.edit',$id)->with('success','FAQ Atualizado com Sucesso.');
    }

    public function destroy($id)
    {
        $faq = Faq::find($id);
        if(!$faq) {
            return redirect()->route('admin.faqs.index')->with('error','FAQ Não Existe.');
        }
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success','FAQ deletado com Sucesso.');
    }
}
