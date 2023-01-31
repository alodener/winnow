<?php

namespace App\Http\Middleware;

use App\Models\Pagamento;
use Closure;
use Illuminate\Http\Request;

class VerificaDados
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
        if(auth()->user()->cpf == null) {
            $pagamento = Pagamento::where(['user_id'=>auth()->id(),'status'=>'1'])->first();
            if ($pagamento) return redirect()->route('dashboard.perfil.index')->with('warning','Cadaste seu CPF!');
        }elseif(auth()->user()->celular == null) {
            $pagamento = Pagamento::where(['user_id'=>auth()->id(),'status'=>'1'])->first();
            if ($pagamento) return redirect()->route('dashboard.perfil.index')->with('warning','Cadaste seu Celular!');
        }
        return $next($request);
    }
}
