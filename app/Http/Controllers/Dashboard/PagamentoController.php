<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Fatura;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Auth;
use App\Classes\Formatacoes;

class PagamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function checkout($pagamento_id)
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'Authorization' => 'Q2xpZW50X0lkXzdlZmRiOGIyLWYyZDktNGVhYS1hNDhmLTdiMTAwMTBiOTVlNzpDbGllbnRfU2VjcmV0X2JLOTNLWjk3dUZmeXZmQU50NS8zaXBjZTZoWk9rUVNOcGdnQWdUUHNja289'
        ];

        $pagamento = Pagamento::find($pagamento_id);
        if(!$pagamento) return redirect()->route('home')->with('warning','Pagamento não existe!');
        $valor =  str_replace('.','', (string) number_format($pagamento->valor,2,'.',''));

        $verificaFatura = Fatura::where('pagamento_id',$pagamento->id)->orderBy('id','desc')->first();
        if($verificaFatura){
            $fatura = Fatura::where('pagamento_id',$pagamento->id)->first();
            $client = new Client();
            //Get one charge
            $request = new \GuzzleHttp\Psr7\Request('GET', "https://api.openpix.com.br/api/openpix/v1/charge/".$fatura->transactionID."", $headers);
            $res = $client->sendAsync($request)->wait();
            $retorno = json_decode($res->getBody(), true);
            if($retorno['charge']['status'] == "EXPIRED"){
                $fatura->delete();
                $pagamento->status = '3';
                $pagamento->save();

                return redirect()->route('dashboard.produtos.index')->with('warning','Fatura Expirada!');
            }
            return view('dashboard.financeiros.checkout',compact('fatura'));
        }else{
            $client = new Client();
            $body = '{
                  "correlationID": "'.$pagamento->id.'",
                  "value": "'.$valor.'",
                  "comment": "",
                  "identifier": "'.$pagamento->planos->name.'",
                  "expiresIn": "3600",
                  "customer": {
                    "name": "'.Auth::user()->name.'",
                    "email": "'.Auth::user()->email.'",
                    "phone": "'.Formatacoes::formata_celular(Auth::user()->celular).'",
                    "taxID": ""
                  }
                }';
            $request = new \GuzzleHttp\Psr7\Request('POST', 'https://api.openpix.com.br/api/openpix/v1/charge?return_existing=true', $headers, $body);
            $res = $client->sendAsync($request)->wait();
            $retorno = json_decode($res->getBody(), true);

            $fatura = new Fatura();
            $fatura->user_id = auth()->id();
            $fatura->pagamento_id = $pagamento_id;
            $fatura->transactionID = $retorno['charge']['transactionID'];
            $fatura->valor = $pagamento->valor;
            $fatura->value = $retorno['charge']['value'];
            $fatura->status = $retorno['charge']['status'];
            $fatura->pixKey = $retorno['charge']['pixKey'];
            $fatura->brCode = $retorno['charge']['brCode'];
            $fatura->paymentLinkUrl = $retorno['charge']['paymentLinkUrl'];
            $fatura->expires_at = date('Y-m-d H:i:s' , strtotime('+1 hours'));
            $fatura->qrCodeImage = $retorno['charge']['qrCodeImage'];
            $fatura->save();

            return view('dashboard.financeiros.checkout',compact('fatura'));
        }
        return $res->getBody();
    }

    public function checkStatus($id)
    {
        $fatura = Fatura::where('transactionID',$id)->first();
        if($fatura){
            if($fatura->status == 'COMPLETED'){
                return 1;
            }
        }
    }
}
