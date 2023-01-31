<?php

namespace App\Http\Controllers;

use App\Classes\Formatacoes;
use App\Models\ClubeCerto;
use App\Models\Endereco;
use App\Models\IpedUser;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DOMDocument;

class StatusController extends Controller
{
    private const TOKEN = 'e4ee0e953101074ada859b910faf0ce2f669c553';

    public function clubeCerto()
    {
        $clube_users = ClubeCerto::get();
        foreach ($clube_users as $c){
            if($c->status == '0'){
                $endereco = Endereco::where('user_id',$c->user_id)->first();
                if($endereco) {
                    $address = $endereco->rua . " " . $endereco->numero . " " . $endereco->bairro;

                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => 'www.clubecerto.com.br/ws/add.php?user=smartpay&token=smartpay@1691&cnpj=42.913.912/0001-02&name=' . str_replace(" ", "+", $c->users->name) . '&cpf=' . Formatacoes::formata_cpf_cnpj($c->users->cpf) . '&phone=' . $c->users->celular . '&address=' . str_replace(" ", "+", $address) . '&assoc=1691&city=' . $endereco->cidade . '&state=' . $endereco->uf,
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
                        Log::error('user_id: '.$c->user_id, $array['insert']['ERRO']);
                    }else{
                         $clube = ClubeCerto::find($c->id);
                         $clube->status = "1";
                         $clube->save();
                    }
                }
            }
        }
    }

    public function ipedUsers()
    {
        $iped_users = IpedUser::whereNull('iped_user_id')->where('status','0')->get();
        $query = '';
        $c = 1;
        foreach ($iped_users as $i){
            //return $i;
            $array = $i->course_id;
            for($q=0;$q<sizeof($array);$q++){
                $query .= "course_id[]=".$array[$q].(sizeof($array) == $c?"":"&");
                //$query .= "course_id[]=".$array[$q]."&";
                $c += 1;
            }
            //return $query;
            $url = 'https://www.iped.com.br/api/user/set-registration';
            $data = array(
                'token' => self::TOKEN,
                $query,
                //'course_id' => 54828,
                'course_type' => $i->course_type,
                'course_plan' => $i->course_plan,
                'user_id' => '0',
                'user_name' => $i->user_name,
                'user_cpf' => $i->user_cpf,
                'user_email' => $i->user_email,
                'user_password' => $i->user_password,
                'user_country' => $i->user_country,
                'user_genre' => $i->user_genre,
            );
            //return $data;
            // executa requisicao
            $queryStr = http_build_query($data);
            $queryStr = urldecode($queryStr);
            $queryStr = preg_replace('/[[0-9]+]/', '[]', $queryStr);
            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => $queryStr
                )
            );
            //return $options;
            $context = stream_context_create($options);
            $json = file_get_contents($url, false, $context);

            // tratamento para caso de erros de comunicacao
            if (!$json) {
                echo 'Falha ao se comunicar com a API: '.$url;
                exit;
            }

            // converte json em array
            $response = json_decode($json, true);
            if($response['STATE'] == 0){
                Log::error($response['ERROR']);
                return $response['ERROR'];
            }else{
                $ipedUser = IpedUser::find($i->id);
                $ipedUser->iped_user_id = $response['REGISTRATION']['user_data'][0]['user_id'];
                $ipedUser->user_token = $response['REGISTRATION']['user_data'][0]['user_token'];
                $ipedUser->status = "1";
                $ipedUser->save();
            }
        }
    }
}
