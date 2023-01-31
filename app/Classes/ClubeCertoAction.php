<?php

namespace App\Classes;

use App\Models\ClubeCerto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ClubeCertoAction
{
    public static function ativar($user_id)
    {
        $user = ClubeCerto::where('user_id',$user_id)->first();
        if(!$user){
            Log::error('user_id: '.$user_id.' Não existe');
            if(Auth::check()) return redirect()->back()->with('warning','Não Cadastrado');
        }else{
            if($user->clube_user_id == null){
                $clubeUserId = self::search($user->user_id);
            }else{
                $clubeUserId = $user->clube_user_id;
            }
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'www.clubecerto.com.br/ws/edit.php?user=smartpay&token=smartpay@1691&cnpj=42.913.912/0001-02&&assoc=1691&id='.$clubeUserId.'&active=1',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            if(isset($array['insert']['ERRO'])){
                Log::error('user_id: '.$user->user_id." ".$array['insert']['ERRO']);
                if(Auth::check()) return redirect()->route('admin.clubecerto.index')->with('warning',$array['insert']['ERRO']);
            }else{
                $user->status = "1";
                $user->save();
                if(Auth::check()) return redirect()->route('admin.clubecerto.index')->with('success','Ativo com Sucesso!');
            }
        }
    }
    public static function inativar($user_id)
    {
        $user = ClubeCerto::where('user_id',$user_id)->first();
        if(!$user){
            Log::error('user_id: '.$user_id.' Não existe');
            if(Auth::check()) return redirect()->back()->with('warning','Não Cadastrado');
        }else{
            if($user->clube_user_id == null){
                $clubeUserId = self::search($user->user_id);
            }else{
                $clubeUserId = $user->clube_user_id;
            }
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'www.clubecerto.com.br/ws/edit.php?user=smartpay&token=smartpay@1691&cnpj=42.913.912/0001-02&&assoc=1691&id='.$clubeUserId.'&active=0',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            if(isset($array['insert']['ERRO'])){
                Log::error('user_id: '.$user->user_id." ".$array['insert']['ERRO']);
                if(Auth::check()) return redirect()->route('admin.clubecerto.index')->with('warning',$array['insert']['ERRO']);
            }else{
                $user->status = "3";
                $user->save();
                if(Auth::check()) return redirect()->route('admin.clubecerto.index')->with('success','Inativo com Sucesso!');
            }
        }
    }

    public static function search($user_id)
    {
        $user = ClubeCerto::where('user_id',$user_id)->first();
        if(!$user){
            Log::error('user_id: '.$user_id.' Não existe');
            if(Auth::check()) return redirect()->back()->with('warning','Não Cadastrado');
        }else {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'www.clubecerto.com.br/ws/search.php?user=smartpay&token=smartpay@1691&cnpj=42.913.912/0001-02&cpf=' . Formatacoes::formata_cpf_cnpj($user->users->cpf) . '&assoc=42.913.912/0001-02',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $xml = simplexml_load_string($response);
            $json = json_encode($xml);
            $array = json_decode($json, TRUE);
            if (isset($array['insert']['ERRO'])) {
                Log::error('user_id: ' . $user->user_id . " " . $array['insert']['ERRO']);
                if (Auth::check()) return redirect()->route('admin.clubecerto.index')->with('warning', $array['insert']['ERRO']);
            } else {
                $user->clube_user_id = $array['response']['id'];
                $user->save();
                return $array['response']['id'];
            }
        }
    }
}
