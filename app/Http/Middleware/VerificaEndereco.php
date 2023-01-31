<?php

namespace App\Http\Middleware;

use App\Models\Pagamento;
use Closure;
use Illuminate\Http\Request;

class VerificaEndereco
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!auth()->user()->isEndereco()) {
            $pagamento = Pagamento::where(['user_id'=>auth()->id(),'status'=>'1'])->first();
            if ($pagamento) return redirect()->route('dashboard.enderecos.index')->with('warning','Cadastre seu Endereço!');
        }
        return $next($request);
    }
}
