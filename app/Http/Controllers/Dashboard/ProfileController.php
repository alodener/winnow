<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Endereco;
use App\Models\ImgDocumento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Alert;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function perfil()
    {
        return view('dashboard.perfil.index');
    }

    public function perfilUpdate(Request $request)
    {
        $data = $request->all();
        $data['celular'] = preg_replace('/[^0-9]/', '', $request->celular);
        $data['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);

        $validator = Validator::make($data,[
            'name' => ['required', 'string', 'max:255'],
            'celular' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'max:255','unique:users,cpf,'.auth()->id()],
        ]);

        if ($validator->fails()) {
            return back()->with('warning', $validator->messages()->all()[0])->withInput();
        }

        if ($data['password'] != null){
            $this->validate($request,['password' => 'min:8|confirmed',]);
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }
        $user = User::find(Auth::id());

        $user->update($data);

        if($user){
            return redirect('/perfil')->with('success','Atualizado com Sucesso');
        }
        return redirect('/perfil')->with('warning','Ouve um Erro...');
    }

    public function validacaoDocumentos()
    {
        $img_doc = ImgDocumento::where('user_id', Auth::id())->get();
        return view('dashboard.perfil.documentos_validos', compact('img_doc'));
    }

    public function validacaoDocumentosStore(Request $request)
    {
        $img_doc = ImgDocumento::where('user_id', Auth::id())->where('tipo',$request->tipo)->first();
        if(!$img_doc){
            $this->validate(request(),[
                'imagem' => 'required|mimes:jpeg,png,jpg,pdf|max:5120',
            ]);
            $uuid = Str::uuid();
            $imageName = $uuid.'.'.request()->imagem->getClientOriginalExtension();
            request()->imagem->move(public_path('imagem/documentos/'), $imageName);

            $documento = new ImgDocumento;
            $documento->id = $uuid;
            $documento->user_id = $user = Auth::id();
            $documento->tipo = $request->tipo;
            $documento->img = $imageName;
            $documento->status = '0';
            $documento->save();
            return redirect()->route('dashboard.validacaoDocumentos')->with('success', 'Documento Enviado com Sucesso!');
        }else{
            return redirect()->route('dashboard.validacaoDocumentos')
                ->with('warning', 'O documento do tipo '.$request->tipo.' já foi inserido');
        }
    }

    public function endereco()
    {
        $endereco = Endereco::where('user_id',Auth::id())->first();
        return view('dashboard.perfil.endereco', compact('endereco'));
    }

    public function enderecoStore(Request $request)
    {
        //dd($request->all());
        $this->validate(request(),[
            'cep' => 'required',
            'rua' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'uf' => 'required',
        ]);
        if($request->n){
            $this->validate(request(),[
                'n' => 'numeric'
            ]);
        }
        $endereco = Endereco::where('user_id',\Auth::id())->first();
        if($endereco){
            $endereco->cep = preg_replace('/[^0-9]/', '', $request->cep);
            $endereco->rua = $request->rua;
            $endereco->numero = $request->n;
            $endereco->bairro = $request->bairro;
            $endereco->cidade = $request->cidade;
            $endereco->uf = $request->uf;
            $endereco->complemento = $request->complemento;
            $endereco->save();

            return redirect()->route('dashboard.enderecos.index')->with('success','Endereço Atualizado com Sucesso!');
        }else{
            $endereco = new Endereco();
            $endereco->user_id = \Auth::id();
            $endereco->cep = preg_replace('/[^0-9]/', '', $request->cep);
            $endereco->rua = $request->rua;
            $endereco->numero = $request->n;
            $endereco->bairro = $request->bairro;
            $endereco->cidade = $request->cidade;
            $endereco->uf = $request->uf;
            $endereco->complemento = $request->complemento;
            $endereco->save();
            return redirect()->route('dashboard.enderecos.index')->with('success','Endereço Salvo com Sucesso!');
        }
    }
}
