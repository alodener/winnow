<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investimento;
use App\Models\Pagamento;
use App\Models\Plano;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is_admin']);
    }

    public function index()
    {
        $pagPendentes = Pagamento::where('status','0')->orderBy('id','desc')->limit(10)->get();

        $users = User::select('id','name','username','email','ativo','created_at')->orderBy('id','desc')->limit(10)->get();
        $userCount = User::count();
        $planosvendidos = Pagamento::where('status','1')->where('valor','>',0.00)->whereNull('voucher_id')->count();
        $planosvoucher = Pagamento::where('status','1')->whereNotNull('voucher_id')->count();
        $vendas = DB::select("
                            SELECT SUM(valor) AS valor, DATE_FORMAT(created_at, '%M %Y') AS data
                            FROM pagamentos WHERE status = 1 AND voucher_id IS NULL GROUP BY data ORDER BY data ASC
                            ");
        return view('admin.index',compact('pagPendentes','users','userCount','vendas','planosvendidos','planosvoucher'));
    }
}
