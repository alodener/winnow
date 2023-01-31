<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\CatProduto;
use App\Models\Img;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
        $produtos = Product::orderBy('id','desc')->paginate(10);
        return view('admin.produtos.index',compact('produtos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('admin.produtos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'img1,img2,img3,img4,img5' => ['max:300'],
            'price' => ['required'],
            'description' =>['required','string'],
            'body' =>['required','string'],
        ]);
        $produto = new Product();
        $produto->name = $request->name;
        $produto->slug = (string) Str::of($request->name)->slug('-').substr('-'.Str::uuid(), 0,8).'-_TB';
        $produto->price = $request->price;
        //$produto->price_before = str_replace(array(".", ","), array("", "."), $request->price_before);
        $produto->description = $request->description;
        $produto->body = $request->body;
        $produto->qtd = $request->qtd;
        $produto->dimensoes = [
            'peso' => $request->peso,
            'comprimento' => $request->comprimento,
            'altura' => $request->altura,
            'largura' => $request->largura,
        ];
        //$produto->destaque = $request->destaque;
        //$produto->lancamento = $request->lancamento;
        //$produto->especial = $request->especial??0;
        $produto->save();
        //Imagem
        if($request->img1){
            $uiid = Str::uuid();
            $img1 = $uiid.'.'.request()->img1->getClientOriginalExtension();
            request()->img1->move(public_path('images/produtos/'), $img1);
            if($request->img2) {
                $uiid = Str::uuid();
                $img2 = $uiid . '.' . request()->img2->getClientOriginalExtension();
                request()->img2->move(public_path('images/produtos/'), $img2);
            }
            if($request->img3) {
                $uiid = Str::uuid();
                $img3 = $uiid . '.' . request()->img3->getClientOriginalExtension();
                request()->img3->move(public_path('images/produtos/'), $img3);
            }
            if($request->img4) {
                $uiid = Str::uuid();
                $img4 = $uiid . '.' . request()->img4->getClientOriginalExtension();
                request()->img4->move(public_path('images/produtos/'), $img4);
            }
            if($request->img5) {
                $uiid = Str::uuid();
                $img5 = $uiid . '.' . request()->img5->getClientOriginalExtension();
                request()->img5->move(public_path('images/produtos/'), $img5);
            }
            //dd($produto->id);
            $imagem = new Img();
            $imagem->product_id = $produto->id;
            $imagem->img1 = $img1;
            $imagem->img2 = $img2??null;
            $imagem->img3 = $img3??null;
            $imagem->img4 = $img4??null;
            $imagem->img5 = $img5??null;
            $imagem->save();
        }

        foreach ($request->categorias as $c) {
            $categoria = new CatProduto();
            //$categoria->categoria_id = $request->categoria_id;
            $categoria->categoria_id = $c[0];
            $categoria->produto_id = $produto->id;
            $categoria->save();
        }
        return redirect()->route('admin.produtos.index')->with('success','Produto Cadastrado com Sucesso!');
    }

    public function edit($id)
    {
        $produto = Product::find($id);
        $categorias = Categoria::all();
        return view('admin.produtos.edit',compact('produto','categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'img1,img2,img3,img4,img5' => ['max:300'],
            'price' => ['required'],
            'description' =>['required','string'],
            'body' =>['required','string'],
        ]);
        $produto = Product::find($id);
        if($request->name !== $produto->name){
            $produto->name = $request->name;
            $produto->slug = (string) Str::of($request->name)->slug('-').substr('-'.Str::uuid(), 0,8).'-_TB';
        }
        $produto->price = $request->price;
        //$produto->price_before = str_replace(array(".", ","), array("", "."), $request->price_before);
        $produto->description = $request->description;
        $produto->body = $request->body;
        $produto->qtd = $request->qtd;
        $produto->dimensoes = [
            'peso' => $request->peso,
            'comprimento' => $request->comprimento,
            'altura' => $request->altura,
            'largura' => $request->largura,
        ];
        //$produto->destaque = $request->destaque;
        //$produto->lancamento = $request->lancamento;
        //$produto->especial = $request->especial??0;
        $produto->save();
        //Imagem
        if($request->img1){
            File::delete(public_path(public_path('images/produtos/'), $produto->images[0]['img1']));
            $uiid = Str::uuid();
            $img1 = $uiid.'.'.request()->img1->getClientOriginalExtension();
            request()->img1->move(public_path('images/produtos/'), $img1);
            if($request->img2) {
                File::delete(public_path(public_path('images/produtos/'), $produto->images[0]['img2']));
                $uiid = Str::uuid();
                $img2 = $uiid . '.' . request()->img2->getClientOriginalExtension();
                request()->img2->move(public_path('images/produtos/'), $img2);
            }
            if($request->img3) {
                File::delete(public_path(public_path('images/produtos/'), $produto->images[0]['img3']));
                $uiid = Str::uuid();
                $img3 = $uiid . '.' . request()->img3->getClientOriginalExtension();
                request()->img3->move(public_path('images/produtos/'), $img3);
            }
            if($request->img4) {
                File::delete(public_path(public_path('images/produtos/'), $produto->images[0]['img4']));
                $uiid = Str::uuid();
                $img4 = $uiid . '.' . request()->img4->getClientOriginalExtension();
                request()->img4->move(public_path('images/produtos/'), $img4);
            }
            if($request->img5) {
                File::delete(public_path(public_path('images/produtos/'), $produto->images[0]['img5']));
                $uiid = Str::uuid();
                $img5 = $uiid . '.' . request()->img5->getClientOriginalExtension();
                request()->img5->move(public_path('images/produtos/'), $img5);
            }
            //dd($produto->id);
            $imagem = Img::where('product_id',$id)->first();
            $imagem->product_id = $produto->id;
            $imagem->img1 = $img1;
            $imagem->img2 = $img2??null;
            $imagem->img3 = $img3??null;
            $imagem->img4 = $img4??null;
            $imagem->img5 = $img5??null;
            $imagem->save();
        }
        CatProduto::where('produto_id',$id)->delete();
        foreach ($request->categorias as $c) {
            $categoria = new CatProduto();
            //$categoria->categoria_id = $request->categoria_id;
            $categoria->categoria_id = $c[0];
            $categoria->produto_id = $produto->id;
            $categoria->save();
        }
        return redirect()->route('admin.produtos.edit',$id)->with('success','Produto Editado com Sucesso!');
    }
}
