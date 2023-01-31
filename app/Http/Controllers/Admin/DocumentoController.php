<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImgDocumento;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\ComprovanteStatus;
use File;

class DocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']);
    }

    public function index()
    {
    	$documentos = ImgDocumento::where('status','0')->paginate(10);
    	return view('admin.documentos.index', compact('documentos'));
    }

    public function verificados()
    {
    	$documentos = ImgDocumento::where('status','1')->paginate(10);
    	return view('admin.documentos.verificados', compact('documentos'));
    }

    public function aprovarDocumento(Request $request,$id)
    {
        $c = ImgDocumento::find($id);
        $user = User::find($c->user_id);
        if($request->status == '1'){
            $c->status = $request->status;
            $c->update();
            $data = array(
                'name'=> $user->name,
                'email'=> $user->email,
                'subject'=> strtoupper($c->tipo).' Aprovado',
                'message'=> "Seu Documento ".strtoupper($c->tipo)." foi Aprovado!",
            );
            //Mail::to($user->email)->send(new ComprovanteStatus($data));
            /*$n = new Notification;
            $n->user_id = $c->user_id;
            $n->title = "Comprovante Aprovado";
            $n->description = "Seu Comprovante foi Aprovado!";
            $n->readed = "0";
            $n->save();*/

            return back()->with('success', 'Aprovado com Sucesso!');
        }elseif($request->status == '3'){
            File::delete(public_path('imagem/documentos').$c->img);
            $c->delete();
            $data = array(
                'name'=> $user->name,
                'email'=> $user->email,
                'subject'=> strtoupper($c->tipo).' Rejeitado',
                'message'=> "Seu Documento ".strtoupper($c->tipo)." foi rejeitado!",
            );
            //Mail::to($user->email)->send(new ComprovanteStatus($data));
            /*$n = new Notification;
            $n->user_id = $c->user_id;
            $n->title = "Comprovante Rejeitado";
            $n->description = "Seu Comprovante foi Rejeitado!";
            $n->readed = "0";
            $n->save();*/
            return back()->with('success', 'Rejeitado com Sucesso!');
        }
        return back()->with('success', 'OK!');
    }
}
