<?php

use App\Http\Controllers\Dashboard\FinanceiroController;
use App\Http\Controllers\Dashboard\TicketsController;
use App\Http\Controllers\Dashboard\CartController;

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/planos',[App\Http\Controllers\Dashboard\PlanoController::class, 'index'])->name('dashboard.produtos.index');
Route::post('/planos',[App\Http\Controllers\Dashboard\PlanoController::class, 'addPlano'])->name('dashboard.produtos.addPlano');

Route::get('/callback',[App\Http\Controllers\Dashboard\PlanoController::class,'callback']);

Route::get('/afiliados/diretos',[App\Http\Controllers\Dashboard\RedeController::class,'index'])->name('dashboard.redes.diretos');
Route::get('/afiliados/pendentes',[App\Http\Controllers\Dashboard\RedeController::class,'pendentes'])->name('dashboard.redes.pendentes');
Route::get('/afiliados/diretos/rede/{username}',[App\Http\Controllers\Dashboard\RedeController::class,'redeDireto'])->name('dashboard.redes.redeDireto');
Route::get('/afiliados/{nvl1}/nvl2/{nvl2}/nvl3/{nvl3}/nvl4/{nvl4}/nvl5/{nvl5}',
    [App\Http\Controllers\Dashboard\RedeController::class,'rede'])->name('dashboard.redes.rede');

Route::prefix('financeiros')->group(function () {
    Route::get('/', [FinanceiroController::class, 'index']);
    Route::any('/historico-de-transacao', [FinanceiroController::class,'historicoTransacoes'])->name('dashboard.financeiros.historicoTransacoes');
    Route::any('/extratos', [FinanceiroController::class,'extratos2'])->name('dashboard.financeiros.extratos');
    //Route::any('/extratos2', [FinanceiroController::class,'extratos2'])->name('dashboard.financeiros.extratos2');
    Route::get('/ganhos', [FinanceiroController::class.'ganhos']);
    Route::get('/pagamentos', [FinanceiroController::class,'pagamentos'])->name('dashboard.pagamentos.index');
    Route::get('/ver-pagamentos/{id}', [FinanceiroController::class,'verPagamento'])->name('dashboard.verPagamento');
    Route::post('/comprovantes', [FinanceiroController::class,'store'])->name('dashboard.enviarComprovante');
    Route::get('/comprovantes/ver/{id}', [FinanceiroController::class,'comprovanteVer']);
    Route::get('carteira', [FinanceiroController::class,'contaBancaria'])->name('dashboard.contaBancaria');
    Route::post('carteira', [FinanceiroController::class,'contaBancariaSalvar'])->name('dashboard.contaBancariaSalvar');
    Route::post('deletar/conta-bancaria', [FinanceiroController::class,'deletarcontabancaria'])->name('dashboard.deletarcontabancaria');
    Route::get('saques', [App\Http\Controllers\Dashboard\SaqueController::class,'index'])->name('dashboard.saques')->middleware('2fa');
    Route::post('saques', [App\Http\Controllers\Dashboard\SaqueController::class,'fazerSaque'])->name('dashboard.fazerSaque')->middleware('2fa');
});
Route::prefix('pagamentos')->group(function () {
   Route::get('/checkout/{id}',[\App\Http\Controllers\Dashboard\PagamentoController::class,'checkout'])->name('dashboard.pagamentos.checkout');
   Route::get('/checkout/{id}/status',[\App\Http\Controllers\Dashboard\PagamentoController::class,'checkStatus'])->name('dashboard.pagamentos.checkStatus');
});
Route::get('perfil', [App\Http\Controllers\Dashboard\ProfileController::class,'perfil'])->name('dashboard.perfil.index');
Route::post('perfil', [App\Http\Controllers\Dashboard\ProfileController::class,'perfilUpdate'])->name('dashboard.perfil.update');
Route::get('/perfil/documentos-validados',[App\Http\Controllers\Dashboard\ProfileController::class,'validacaoDocumentos'])
    ->name('dashboard.validacaoDocumentos');
Route::post('/perfil/documentos-validados',[App\Http\Controllers\Dashboard\ProfileController::class,'validacaoDocumentosStore'])
    ->name('dashboard.validacaoDocumentosStore');

Route::get('/endereco',[\App\Http\Controllers\Dashboard\ProfileController::class,'endereco'])->name('dashboard.enderecos.index');
Route::post('/endereco',[\App\Http\Controllers\Dashboard\ProfileController::class,'enderecoStore'])->name('dashboard.enderecos.store');

Route::group(['prefix'=>'2fa'], function(){
    Route::get('/', [App\Http\Controllers\LoginSecurityController::class,'show2faForm']);
    Route::post('/generateSecret',[App\Http\Controllers\LoginSecurityController::class,'generate2faSecret'])->name('generate2faSecret');
    Route::post('/enable2fa',[App\Http\Controllers\LoginSecurityController::class,'enable2fa'])->name('enable2fa');
    Route::post('/disable2fa',[App\Http\Controllers\LoginSecurityController::class,'disable2fa'])->name('disable2fa');

    // 2fa middleware
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
});

Route::get('/arquivos',[App\Http\Controllers\Dashboard\ArquivoController::class,'index'])->name('dashboard.arquivos.index');
Route::get('/arquivos/{id}',[App\Http\Controllers\Dashboard\ArquivoController::class,'show'])->name('dashboard.arquivos.show');

//Tickets page routes
Route::prefix('/ticket')->group(function () {
    Route::get('/', [TicketsController::class,'index'])->name('clientTickets');
    Route::get('/{id}', [TicketsController::class,'show'])->name('showClientTicket');
    Route::post('/create', [TicketsController::class,'store'])->name('createClientTicket');
    Route::post('/response/', [TicketsController::class,'storeResponse'])->name('replyClientTicket');
    Route::patch('/update/{id}', [TicketsController::class,'update'])->name("updateClientTicket");
    Route::get('/remove/{id}', [TicketsController::class,'destroy'])->name('removeClientTicket');
});

Route::prefix('cursos')->group(function () {
    Route::get('/',[\App\Http\Controllers\Dashboard\CursoController::class,'index'])->name('dashboard.cursos.index');
    Route::get('/categorias',[\App\Http\Controllers\Dashboard\CursoController::class,'categorias'])->name('dashboard.cursos.categorias');
    Route::get('/categorias/{category_id}',[\App\Http\Controllers\Dashboard\CursoController::class,'getCategoria'])->name('dashboard.cursos.getCategoria');
    Route::get('/{course_id}',[\App\Http\Controllers\Dashboard\CursoController::class,'show'])->name('dashboard.cursos.show');
    Route::get('/{curso}/asssitir',[\App\Http\Controllers\Dashboard\CursoController::class,'assistir'])->name('dashboard.cursos.assistir');
});
