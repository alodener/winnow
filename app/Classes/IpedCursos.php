<?php

namespace App\Classes;

use App\Models\IpedUser;
use Illuminate\Support\Facades\Auth;

class IpedCursos
{
    private const TOKEN = 'e4ee0e953101074ada859b910faf0ce2f669c553';
    public static function getCourses($category_id = null)
    {
        $endpoint = '/api/course/get-courses';

        // valores padrao para busca
        $category_id = $category_id?$category_id:1; // busca padrao pela categoria id 1
        $page = 1; // busca padrao pela pagina 1

        // verifica se possui paginacao na URL
        if (isset($_GET['page']) && $_GET['page'] > 1) {
            $page = (int)$_GET['page'];
        }

        // verifica se possui categoria na URL
        if (isset($_GET['cat']) && $_GET['cat'] > 1) {
            $category_id = (int)$_GET['cat'];
        }

        // monta url e parametros para requisicao
        $url = 'https://www.iped.com.br'.$endpoint;
        $data = array(
            'token' => self::TOKEN,
            'category_id' => $category_id,
            'type' => 1 // somente cursos premium
            ,'page' => $page
        );

        // executa requisicao
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $json = file_get_contents($url, false, $context);

        // tratamento para caso de erros de comunicacao
        if (!$json) {
            echo 'Falha ao se comunicar com a API: '.$url;
            exit;
        }

        // converte json em array
        $response = json_decode($json, true);

        // verifica se a api retornou algum erro
        if ($response && $response['STATE'] != 1) {
            echo $response['ERROR'];
            exit;
        }

        // tratamento para o caso de retornar uma lista vazia
        if (!$response['COURSES']) {
            echo 'Nenhum curso localizado';
            exit;
        }

        // funcao auxiliar para resumo da descricao
        function truncate($text, $chars = 100) {
            if (strlen($text) <= $chars) {
                return $text;
            }
            $text = $text.' ';
            $text = substr($text,0,$chars);
            $text = substr($text,0,strrpos($text,' '));
            $text = $text.'...';
            return $text;
        }

        return $response['COURSES'];
    }

    public static function getCurso($course_id)
    {
        $endpoint = '/api/course/get-courses';

        // verifica se informou o id do curso na URL
        if (!isset($course_id) || (int)$course_id == 0) {
            echo 'Informe o ID do curso';
            exit;
        }

        // reserva id do curso para os parametros da requisicao
        //$course_id = (int)$_GET['id'];

        // monta url e parametros para requisicao
        $url = 'https://www.iped.com.br'.$endpoint;
        $data = array(
            'token' => self::TOKEN
            ,'course_id' => $course_id
            ,'include_topics' => 1
        );

        // executa requisicao
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $json = file_get_contents($url, false, $context);

        // tratamento para caso de erros de comunicacao
        if (!$json) {
            echo 'Falha ao se comunicar com a API: '.$url;
            exit;
        }

        // converte json em array
        $response = json_decode($json, true);

        // verifica se a api retornou algum erro
        if ($response && $response['STATE'] != 1) {
            echo $response['ERROR'];
            exit;
        }

        // tratamento para o caso de retornar uma lista vazia
        if (!$response['COURSES']) {
            echo 'Curso não localizado';
            exit;
        }

        // retorna unico resultado para uma variavel
        $course = current($response['COURSES']);
        // funcao auxiliar para exibir player de video

        return $course;
    }

    public static function getEnvironment($course_id)
    {
        $ipedUser = IpedUser::where('user_id',Auth::id())->first();
        $url = 'https://www.iped.com.br/api/course/get-environment';
        $data = array(
            'token' => self::TOKEN,
            'user_id' => $ipedUser->iped_user_id,
            'course_id' => $course_id,
            'course_layout' => "2",
            'course_activities' => "0",
        );

        // executa requisicao
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $json = file_get_contents($url, false, $context);

        // tratamento para caso de erros de comunicacao
        if (!$json) {
            echo 'Falha ao se comunicar com a API: '.$url;
            exit;
        }

        // converte json em array
        $response = json_decode($json, true);

        return $response;
    }

    public static function getCategories()
    {
        $url = 'https://www.iped.com.br/api/category/get-categories';
        $data = array(
            'token' => self::TOKEN,
        );
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $json = file_get_contents($url, false, $context);
        if (!$json) {
            echo 'Falha ao se comunicar com a API: '.$url;
            exit;
        }
        $response = json_decode($json, true);
        if ($response && $response['STATE'] != 1) {
            echo $response['ERROR'];
            exit;
        }
        if (!$response['CATEGORIES']) {
            echo 'Nenhuma categoria localizada';
            exit;
        }

        return $response;
    }
}
