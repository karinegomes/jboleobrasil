<?php

use App\Models\Order;

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('test', function() {
        $embarques = \App\Models\Embarque::intervaloDataPagamentoEmbarquesAtivos('2017-03-01', '2017-03-15', 'todos', 'todos');
    });

    //Route::get('pos-venda/{idEmpresa}/controle-pagamento/{min}/{max}', 'PosVendaController@controlePagamento');

    Route::group(['middleware' => ['auth', 'ptbr']], function () {
        Route::get('/', 'HomeController@index');

        Route::resource('agenda', 'AgendaController', ['only' => ['index', 'show']]);
        Route::resource('finance', 'FinanceController', ['only' => ['index', 'show']]);
        Route::resource('item', 'ItemController', ['only' => ['index', 'edit', 'update']]);
        Route::resource('client', 'ClientController', ['except' => ['index', 'show']]);
        Route::resource('interaction', 'InteractionController');
        Route::resource('order', 'OrderController', ['except' => ['show']]);
        Route::resource('product', 'ProductController');

        Route::resource('company', 'CompanyController');
        Route::post('companies/{company}/documents', 'DocumentController@store')->name('companies.documents.store');

        Route::resource('user', 'UserController', ['only' => ['edit', 'update']]);
        Route::resource('document', 'DocumentController', ['only' => ['show', 'destroy']]);
        Route::resource('appointment', 'AppointmentController', ['only' => ['index', 'store', 'destroy', 'show', 'update']]);
        Route::resource('embarques', 'EmbarqueController', ['only' => ['index', 'destroy']]);
        Route::resource('pos-venda', 'PosVendaController', ['only' => ['index']]);
        Route::resource('periodo-cobranca', 'PeriodoCobrancaController', ['only' => ['index', 'destroy']]);

        Route::resource('motoristas', 'MotoristaController', ['parameters' => ['motoristas' => 'motorista']]);
        Route::get('ajax/motoristas/table-data', 'MotoristaController@tableData');
        Route::get('ajax/motoristas/{motorista}/dados-bancarios', 'MotoristaController@getDadosBancarios')
            ->name('ajax.motoristas.dados-bancarios');
        Route::post('motoristas/{motorista}/documents', 'DocumentController@store')->name('motoristas.documents.store');

        Route::resource('ordens-frete', 'OrdemDeFreteController', ['parameters' => ['ordens-frete' => 'ordemFrete']]);
        Route::get('ajax/ordens-frete/table-data', 'OrdemDeFreteController@tableData');
        Route::post('ordens-frete/{ordemFrete}/finalizar', 'OrdemDeFreteController@finalizar')
            ->name('ordens-frete.finalizar');
        Route::get('ordens-frete/{ordemFrete}/relatorio', 'OrdemDeFreteController@gerarRelatorio')
            ->name('ordens-frete.relatorio');

        Route::get('appointment/filter', 'AppointmentController@filter');
        Route::post('appointment/view_notification', 'AppointmentController@viewNotification');

        Route::get('endereco/cep', 'AddressController@buscarCEP');

        Route::get('order/{tipo}/{id}', 'OrderController@show');

        Route::get('contrato/{id}/resumo', 'OrderController@resumo');
        Route::post('contrato/{id}/cancelar', 'OrderController@cancelarPedidoAjax');

        // -------------------- EMBARQUE --------------------
        Route::get('contrato/{id}/embarque/adicionar', 'EmbarqueController@create');
        Route::get('embarque/{id}', 'EmbarqueController@show');
        Route::get('embarque/{id}/editar', 'EmbarqueController@edit');
        Route::get('embarques/relatorio', 'EmbarqueController@imprimirRelatorio');
        Route::post('contrato/{id}/embarque', 'EmbarqueController@store');
        Route::post('embarque/{id}', 'EmbarqueController@update');

        // -------------------- PÓS-VENDA --------------------
        Route::get('pos-venda/relatorio/{idEmpresa}', 'PosVendaController@imprimirRelatorio');
        Route::get('pos-venda/{idEmpresa}/controle-pagamento/{min}/{max}', 'PosVendaController@controlePagamento');
        Route::get('ajax/pos-venda/controle-pagamento', 'PosVendaController@controlePagamentoAjax');
        Route::get('pos-venda/resumo-pagamentos/{intervalo}', 'PosVendaController@resumoPagamentos');
        Route::get('pos-venda/periodo/{intervalo}', 'PeriodoCobrancaController@intervalo');

        Route::post('pos-venda/salvar-periodo', 'PeriodoCobrancaController@salvarPeriodo');

        // -------------------- BAIXA --------------------
        Route::get('pos-venda/{idEmpresa}/controle-pagamento/{idEmbarque}/baixa/criar', 'BaixaController@create');
        Route::get('pos-venda/{idEmpresa}/controle-pagamento/{idEmbarque}/baixa/editar', 'BaixaController@edit');
        Route::get('baixa/{idEmpresa}', 'BaixaController@baixasPorEmpresaAjax');
        Route::get('baixa/{id}/visualizar', 'BaixaController@show');

        Route::post('pos-venda/{idEmpresa}/controle-pagamento/{idEmbarque}/baixa/criar', 'BaixaController@store');
        Route::post('pos-venda/{idEmpresa}/controle-pagamento/{idEmbarque}/baixa/editar', 'BaixaController@update');

        Route::delete('baixa/{id}', 'BaixaController@destroy');

        // -------------------- CLIENTES --------------------
        Route::get('ajax/clientes/comissao/{periodo}', 'CompanyController@getClientesComissaoPeriodo');

        Route::group(['middleware' => 'admin'], function () {
            Route::resource('user', 'UserController', ['except' => ['edit', 'update']]);
            Route::resource('category', 'CategoryController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('package', 'PackageController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('group', 'GroupController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('incoterm', 'IncotermController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('measure', 'MeasureController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('doctype', 'DocTypeController', ['only' => ['index', 'store', 'destroy']]);
            Route::resource('carrier', 'CarrierController', ['only' => ['index', 'store', 'destroy']]);
        });
    });
});
