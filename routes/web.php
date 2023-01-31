<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\SiteController::class,'index'])->name('site.index');
Route::get('/politica-de-privacidade', [App\Http\Controllers\SiteController::class,'privacidade'])->name('site.privacidade');
Route::get('/a-empresa', [App\Http\Controllers\SiteController::class,'empresa'])->name('site.empresa');
Route::get('/contato', [App\Http\Controllers\SiteController::class,'contato'])->name('site.contato');
Route::get('/faq', [App\Http\Controllers\SiteController::class,'faq'])->name('site.faq');
Route::get('/termos-de-uso', [App\Http\Controllers\SiteController::class,'termos'])->name('site.termos');
Route::get('/politica-de-cookies', [App\Http\Controllers\SiteController::class,'cookies'])->name('site.cookies');
Route::get('/download', [App\Http\Controllers\SiteController::class,'downloadArquivo'])->name('site.downloadArquivo');

Route::get('/mg/config', [App\Http\Controllers\SiteController::class, 'config']);
Route::get('/ref/{id}', [App\Http\Controllers\SiteController::class, 'indicacao']);
Route::post('/ref', [App\Http\Controllers\SiteController::class, 'registerIndicacao'])->name('registerIndicacao');

Route::get('/config/pagamentos',[\App\Http\Controllers\VerificaFaturaController::class,'pagamentos'])->name('config.pagamentos');
Route::get('/config/pagamentos-vencidos',[\App\Http\Controllers\VerificaFaturaController::class,'pagamentosVencido'])->name('config.pagamentos.vencidos');
Route::get('/config/iped-users',[\App\Http\Controllers\StatusController::class,'ipedUsers'])->name('config.iped.users');
Route::get('/config/clube-certo',[\App\Http\Controllers\StatusController::class,'clubeCerto'])->name('config.clubeCerto');
Route::get('/config/teste', function (){
    $countUsers = User::count();
    //$countUsers = User::where('indicacao',Auth::user()->username)->count();
    echo "Faturas:". \App\Models\Pagamento::where('status','1')->count()."</br>";
    echo "Usuarios:". User::count()."</br>";
    $matriz = array('educlube');
    $conta = 1;
    for($a=0;$a<=$countUsers;$a++){
        //echo $matriz[$a]. "<br/>";
        if(empty($matriz[$a])){
            break;
        }else{
            $users = User::select('id','username','indicacao')->where('indicacao',$matriz[$a])->get();
            foreach ($users as $user){
                $pagamento = \App\Classes\VerificaUserAtivo::verificaPagamento($user->id);
                if($pagamento){
                    echo "id: ".$user->id." ". $user->username. " S <br/>";
                    $conta += 1;
                    array_push($matriz,$user->username);
                    if($conta == 1) break;
                }
            }
        }
    }
    echo "Total: ".$conta;
});

Auth::routes(['verify' => true]);
require __DIR__.'/dashboard.php';
require __DIR__.'/admin.php';
