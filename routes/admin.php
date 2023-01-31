<?php
use App\Http\Controllers\Admin\PagamentoController;
use App\Http\Controllers\Admin\TicketsController;
use App\Http\Controllers\Admin\UserController;

Route::group(['as'=>'admin.', 'prefix'=>'admin'],function () {
    Route::get('/', [App\Http\Controllers\Admin\HomeController::class,'index'])->name('index');
    /**USERS*/
    Route::resource('/users', 'App\Http\Controllers\Admin\UserController');
    Route::post('/users/{id}/ativacao',[UserController::class,'ativacao'])->name('users.ativacao');
    Route::post('/contato-users',[UserController::class,'contatoUser'])->name('contato.users');
    Route::any('/search/users',[UserController::class,'searchUser'])->name('users.search');
    Route::get('/users/{id}/bonus',[UserController::class,'bonus'])->name('users.bonus');
    Route::post('/users/{id}/inserir-bonus',[UserController::class,'inserirBonus'])->name('users.inserirBonus');
    Route::post('/selecionar-bonus',[UserController::class,'selecionarBonus'])->name('selecionarBonus');
    Route::post('/users/{id}/ativacao-por-fatura',[UserController::class,'ativacaoPorFatura'])->name('users.ativacaoPorFatura');
    Route::post('/users/{id}/ativacao-por-voucher',[UserController::class,'ativacaoPorVoucher'])->name('users.ativacaoPorVoucher');
    Route::get('/users/{id}/financeiro',[UserController::class,'financeiro'])->name('users.financeiro');
    Route::get('/users/{id}/faturas',[UserController::class,'faturas'])->name('users.faturas');
    Route::post('/users/{id}/faturas',[UserController::class,'faturaStatus'])->name('users.faturaStatus');
    Route::get('/users/{id}/saques',[UserController::class,'saques'])->name('users.saques');
    Route::get('/users/{id}/indicacoes',[UserController::class,'indicacoes'])->name('users.indicacoes');
    Route::get('/users/{id}/saldo',[UserController::class,'saldo'])->name('users.saldo');
    Route::post('/users/{id}/saldo',[UserController::class,'saldoUpdate'])->name('users.saldoUpdate');
    Route::get('/users/{id}/investimentos',[UserController::class,'investimentos'])->name('users.investimentos');
    Route::post('/users/{id}/investimentos',[UserController::class,'investimentosStore'])->name('users.investimentos.store');
    Route::get('/users/{id}/logar',[UserController::class,'logar'])->name('users.logar');
    Route::get('/users/{id}/inativar',[UserController::class,'inativar'])->name('users.inativar');

    /**Planos*/
    Route::resource('/produtos', 'App\Http\Controllers\Admin\PlanoController');

    Route::resource('/faqs', 'App\Http\Controllers\Admin\FaqController');

    Route::get('documentos/pendentes', [App\Http\Controllers\Admin\DocumentoController::class, 'index'])->name('documentos.index');
    Route::post('documentos/{id}', [App\Http\Controllers\Admin\DocumentoController::class, 'aprovarDocumento'])->name('documentos.aprovarDocumento');
    Route::get('documentos/verificados', [App\Http\Controllers\Admin\DocumentoController::class, 'verificados'])->name('documentos.verificados');

    //PAGAMENTOS
    Route::get('pagamentos', [PagamentoController::class, 'index'])->name('pagamentos.index');
    Route::get('pagamentos/pendentes', [PagamentoController::class, 'pendentes'])->name('pagamentos.pendentes');
    Route::get('pagamentos/pendentes/{id}', [PagamentoController::class, 'show'])->name('pagamentos.show');
    Route::get('pagamentos/ativos', [PagamentoController::class, 'ativos'])->name('pagamentos.ativos');
    Route::get('pagamentos/comprovantes', [PagamentoController::class, 'comprovantes'])->name('pagamentos.comprovantes');
    Route::post('pagamentos/comprovantes/pesquisar', [PagamentoController::class, 'comprovantes'])->name('comprovantes.search');
    Route::post('pagamentos/comprovantes/{id}', [PagamentoController::class, 'aprovarComprovante'])->name('pagamentos.aprovarComprovante');
    Route::post('pagamentos/ativar-por-voucer/{id}', [PagamentoController::class, 'ativarPorVoucher'])->name('pagamentos.ativarPorVoucher');
    Route::post('pagamentos/ativar-fatura/{id}', [PagamentoController::class, 'pagamento'])->name('pagamentos.ativarFatura');
    Route::post('/pagamentos/deletar/{id}',[PagamentoController::class,'destroy'])->name('pagamentos.delete');
    Route::get('/pagamentos/{id}',[PagamentoController::class,'editFatura'])->name('pagamentos.edit');
    Route::post('/pagamentos/{id}',[PagamentoController::class,'updateFatura'])->name('pagamentos.update');

    //SAQUES
    Route::get('saques', [App\Http\Controllers\Admin\SaqueController::class, 'index'])->name('saques.index');
    Route::get('saques/exibir/{id}', [App\Http\Controllers\Admin\SaqueController::class, 'show'])->name('saques.show');
    Route::post('saques/aprovar/{id}', [App\Http\Controllers\Admin\SaqueController::class, 'aprovar'])->name('saques.aprovar');
    Route::post('saques/reprovar/{id}', [App\Http\Controllers\Admin\SaqueController::class, 'reprovar'])->name('saques.reprovar');
    Route::post('saques/estornar/{id}', [App\Http\Controllers\Admin\SaqueController::class, 'estornar'])->name('saques.estornar');
    Route::get('saques/aprovados', [App\Http\Controllers\Admin\SaqueController::class, 'aprovados'])->name('saques.aprovados');

    Route::get('configuracoes', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'index'])->name('configuracoes.index');
    Route::post('configuracoes', [App\Http\Controllers\Admin\ConfiguracaoController::class, 'store'])->name('configuracoes.store');

    Route::get('/configuracoes/sistema',[App\Http\Controllers\Admin\ConfiguracaoController::class,'configSistema'])->name('configuracoes.sistema.index');
    Route::post('/configuracoes/sistema',[App\Http\Controllers\Admin\ConfiguracaoController::class,'configSistemaStore'])->name('configuracoes.sistema.store');
    Route::get('/configuracoes/conversao',[\App\Http\Controllers\Admin\ConfiguracaoController::class,'conversao']);

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index')->middleware('auth');

    Route::get('2fa', [App\Http\Controllers\Admin\TwoFAController::class, 'index'])->name('2fa.index');
    Route::get('2fa/{id}', [App\Http\Controllers\Admin\TwoFAController::class, 'ver'])->name('2fa.ver');
    Route::post('2fa/{id}', [App\Http\Controllers\Admin\TwoFAController::class, 'delete'])->name('2fa.delete');

    Route::resource('/arquivos','App\Http\Controllers\Admin\ArquivoController');

    /**FINANCEIROS*/
    Route::get('/financeiros',[App\Http\Controllers\Admin\FinanceiroController::class,'index'])->name('financeiros.index');
    Route::get('/financeiros/pagamentos',[App\Http\Controllers\Admin\FinanceiroController::class,'pagamentos'])->name('financeiros.pagamentos');

    /**TICKETS*/
    Route::prefix('tickets')->group(function (){
        Route::get('/',[TicketsController::class,'index'])->name('adminTickets');
        Route::get('/{id}/',[TicketsController::class,'show'])->name('adminShowTicket');
        Route::post('/storeResponse',[TicketsController::class,'store'])->name('adminStoreResponseTicket');
        Route::patch('/update/{id}/',[TicketsController::class,'update'])->name('adminUpdateTicket');
        Route::get('/remove/{id}/',[TicketsController::class,'destroy'])->name('adminRemoveTicket');
    });

    /**LINKS*/
    Route::resource('/links','App\Http\Controllers\Admin\LinkController');
    Route::get('/links/deletar/{id}',[\App\Http\Controllers\Admin\LinkController::class,'destroy'])->name('links.deletar');

    /**Categorias dos Cursos*/
    Route::get('/cursos/categorias',[App\Http\Controllers\Admin\CursoController::class,'categorias'])->name('cursos.categorias.index');
    Route::get('/cursos/categorias/create',[App\Http\Controllers\Admin\CursoController::class,'categorias'])->name('cursos.categorias.create');
    Route::post('/cursos/categorias',[App\Http\Controllers\Admin\CursoController::class,'categoriaStore'])->name('cursos.categorias.store');
    Route::get('/cursos/categorias/{id}',[App\Http\Controllers\Admin\CursoController::class,'categoriaEdit'])->name('cursos.categorias.edit');
    Route::post('/cursos/categorias/{id}/update',[App\Http\Controllers\Admin\CursoController::class,'categoriaUpdate'])->name('cursos.categorias.update');
    Route::delete('/cursos/categorias/{id}',[App\Http\Controllers\Admin\CursoController::class,'deleteCategoria'])->name('cursos.categorias.delete');

    /**CURSOS*/
    Route::get('/cursos/{id}/aulas',[App\Http\Controllers\Admin\CursoController::class,'aulaCreate'])->name('cursos.aulas.create');
    Route::resource('/cursos','App\Http\Controllers\Admin\CursoController');

    /**CLUBE CERTO*/
    Route::get('/clubecerto/users',[\App\Http\Controllers\Admin\ClubeCertoController::class,'index'])->name('clubecerto.index');
    Route::post('/clubecerto/ativar/{id}',[\App\Http\Controllers\Admin\ClubeCertoController::class,'ativar'])->name('clubecerto.ativar');
    Route::post('/clubecerto/inativar/{id}',[\App\Http\Controllers\Admin\ClubeCertoController::class,'inativar'])->name('clubecerto.inativar');
});
