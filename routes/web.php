<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\TecnologyComponent;
use App\Livewire\FundComponent;
use App\Livewire\ExpenseComponent;
use App\Livewire\ExpenseTypeComponent;
use App\Livewire\FundStatementComponent;
use App\Livewire\GuaranteeComponent;
use App\Livewire\CreditLineComponent;
use App\Livewire\TimeLimitComponent;
use App\Livewire\InterestComponent;
use App\Livewire\PolicyComponent;
use App\Livewire\UserComponent;
use App\Livewire\CustomerComponent;
use App\Livewire\InvestorComponent;
use App\Livewire\CreditsComponent;
use App\Livewire\CreditListComponent;
use App\Livewire\CreditShowComponent;
use App\Livewire\ArqueoComponent;
use App\Http\Controllers\RetroactiveController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\CronController;
use App\Livewire\ReportRecuperacionComponent;
use App\Livewire\ReportAdelantadosComponent;
use App\Livewire\ReportColocacionComponent;
use App\Livewire\ReportMorososComponent;
use App\Livewire\ReportProyeccionComponent;
use App\Livewire\ReportCreditsComponent;
use App\Livewire\ReportDiaryComponent;
use App\Livewire\ReportDiaryInformComponent;
use App\Livewire\ReportArqueoComponent;
use App\Livewire\ReportCorteComponent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/tecnologias', TecnologyComponent::class)->name('tecnologias');
    Route::get('/fondos', FundComponent::class)->name('fondos');
    Route::get('/tipos-gasto', ExpenseTypeComponent::class)->name('tipo_gastos');
    Route::get('/gastos', ExpenseComponent::class)->name('gastos');
    Route::get('/fondo/{id}', FundStatementComponent::class)->name('fondo-id');
    Route::get('/garantias', GuaranteeComponent::class)->name('garantias');
    Route::get('/lineas-de-credito', CreditLineComponent::class)->name('lineas-de-credito');
    Route::get('/plazos', TimeLimitComponent::class)->name('plazos');
    Route::get('/intereses', InterestComponent::class)->name('intereses');
    Route::get('/politicas', PolicyComponent::class)->name('politicas');
    Route::get('/usuarios', UserComponent::class)->name('usuarios');    
    Route::get('/inversores', InvestorComponent::class)->name('inversores');    
    Route::get('/arqueo', ArqueoComponent::class)->name('arqueo');    

    Route::get('/clientes', CustomerComponent::class)->name('clientes');
    Route::get('/creditos', CreditsComponent::class)->name('creditos');
    Route::get('/creditos/lista', CreditListComponent::class)->name('creditos-lista');
    Route::get('/credito/{id}', CreditShowComponent::class)->name('credito');
    Route::get('/credito/cheques/{id}', [PrintController::class,'imprimir_cheque'])->name('imprimir-cheque');
    Route::get('/reporte/recuperacion', ReportRecuperacionComponent::class)->name('reporte-recuperacion');
    Route::get('/reporte/adelantados', ReportAdelantadosComponent::class)->name('reporte-adelantados');
    Route::get('/reporte/colocacion', ReportColocacionComponent::class)->name('reporte-colocacion');
    Route::get('/reporte/morosos', ReportMorososComponent::class)->name('reporte-morosos');
    Route::get('/reporte/proyeccion', ReportProyeccionComponent::class)->name('reporte-proyeccion');
    Route::get('/reporte/creditos', ReportCreditsComponent::class)->name('reporte-creditos');
    Route::get('/reporte/diario', ReportDiaryComponent::class)->name('reporte-diario');
    Route::get('/reporte/informe-diario', ReportDiaryInformComponent::class)->name('reporte-informe-diario');
    Route::get('/reporte/arqueo', ReportArqueoComponent::class)->name('reporte-arqueo');
    Route::get('/reporte/corte-caja', ReportCorteComponent::class)->name('reporte-corte-caja');

    Route::post('/save/retroactive', [RetroactiveController::class,'save'])->name('save-retroactive');

    Route::get('/print/recibo/{id}', [PrintController::class,'imprimir_recibo'])->name('print-recibo');
    Route::get('/print/recibo/partial/{id}', [PrintController::class,'imprimir_recibo_partial'])->name('print-recibo-partial');
    Route::get('/print/adelanto/{id}', [PrintController::class,'imprimir_adelanto'])->name('print-adelanto');
    Route::get('/print/parcial/{id}', [PrintController::class,'imprimir_parcial'])->name('print-parcial');
    Route::get('/regla-modificada/{id}', [PrintController::class,'reglamodificada'])->name('regla-modificada');
    Route::get('/regla-modificada-word/{id}', [PrintController::class,'reglamodificada_word'])->name('regla-modificada-word');
    Route::get('/regla-general/{id}', [PrintController::class,'reglageneral'])->name('regla-general');
    Route::get('/regla-general-word/{id}', [PrintController::class,'reglageneral_word'])->name('regla-general-word');

    Route::get('/print/reporte/diario/{desde}/{hasta}', [PrintController::class,'print_reporte_diario'])->name('print-reporte-diario');
    Route::get('/export/reporte/diario/{desde}/{hasta}', [PrintController::class,'export_reporte_diario'])->name('export-reporte-diario');

    Route::get('/print/reporte/informe-diario/{desde}/{hasta}', [PrintController::class,'print_reporte_informe_diario'])->name('print-reporte-informe-diario');
    Route::get('/export/reporte/informe-diario/{desde}/{hasta}', [PrintController::class,'export_reporte_informe_diario'])->name('export-reporte-informe-diario');

    Route::get('/print/reporte/arqueo/{date}', [PrintController::class,'print_reporte_arqueo'])->name('print-reporte-arqueo');
    Route::get('/export/reporte/arqueo/{date}', [PrintController::class,'export_reporte_arqueo'])->name('export-reporte-arqueo');

    Route::get('/print/reporte/corte-caja/{desde}/{hasta}/{fondo?}', [PrintController::class,'print_reporte_corte_caja'])->name('print-reporte-corte-caja');
    Route::get('/export/reporte/corte-caja/{desde}/{hasta}/{fondo?}', [PrintController::class,'export_reporte_corte_caja'])->name('export-reporte-corte-caja');

    Route::get('/print/reporte/creditos/clientes/{search?}', [PrintController::class,'print_reporte_creditos_clientes'])->name('print-reporte-creditos-clientes');
    Route::get('/export/reporte/creditos/clientes/{search?}', [PrintController::class,'export_reporte_creditos_clientes'])->name('export-reporte-creditos-clientes');
    
    Route::get('/print/reporte/gastos/{desde}/{hasta}', [PrintController::class,'print_reporte_gastos'])->name('print-reporte-gastos');
    Route::get('/export/reporte/gastos/{desde}/{hasta}', [PrintController::class,'export_reporte_gastos'])->name('export-reporte-gastos');

    Route::get('/print/reporte/clientes/{search?}', [PrintController::class,'print_reporte_clientes'])->name('print-reporte-clientes');
    Route::get('/export/reporte/clientes/{search?}', [PrintController::class,'export_reporte_clientes'])->name('export-reporte-clientes');

    Route::get('/print/reporte/creditos/{asesor?}', [PrintController::class,'print_reporte_creditos'])->name('print-reporte-creditos');
    Route::get('/export/reporte/creditos/{asesor?}', [PrintController::class,'export_reporte_creditos'])->name('export-reporte-creditos');

    Route::get('/print/reporte/morosos', [PrintController::class,'print_reporte_morosos'])->name('print-reporte-morosos');
    Route::get('/export/reporte/morosos', [PrintController::class,'export_reporte_morosos'])->name('export-reporte-morosos');

    Route::get('/print/reporte/proyeccion/{desde}/{hasta}', [PrintController::class,'print_reporte_proyeccion'])->name('print-reporte-proyeccion');
    Route::get('/export/reporte/proyeccion/{desde}/{hasta}', [PrintController::class,'export_reporte_proyeccion'])->name('export-reporte-proyeccion');
   
    Route::get('/print/reporte/recuperacion/{asesor}/{desde}/{hasta}', [PrintController::class,'print_reporte_recuperacion'])->name('print_reporte_recuperacion');
    Route::get('/export/reporte/recuperacion/{asesor}/{desde}/{hasta}', [PrintController::class,'export_reporte_recuperacion'])->name('export_reporte_recuperacion');
   
    Route::get('/print/reporte/adelantados/{asesor}/{desde}/{hasta}', [PrintController::class,'print_reporte_adelantados'])->name('print_reporte_adelantados');
    Route::get('/export/reporte/adelantados/{asesor}/{desde}/{hasta}', [PrintController::class,'export_reporte_adelantados'])->name('export_reporte_adelantados');
    
    Route::get('/print/reporte/colocacion/{asesor}/{desde}/{hasta}', [PrintController::class,'print_reporte_colocacion'])->name('print_reporte_colocacion');
    Route::get('/export/reporte/colocacion/{asesor}/{desde}/{hasta}', [PrintController::class,'export_reporte_colocacion'])->name('export_reporte_colocacion');

    Route::get('/print/reporte/fondo/{id}', [PrintController::class,'print_statement'])->name('print-statement');
    Route::get('/export/reporte/fondo/{id}', [PrintController::class,'export_statement'])->name('export-statement');
    
    Route::get('/crons/mora', [CronController::class,'mora'])->name('cron_mora');
    Route::get('/crons/adelantados', [CronController::class,'adelantados'])->name('cron_adelantados');
});
