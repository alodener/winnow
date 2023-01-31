<?php

namespace App\Console\Commands;

use App\Models\Financeiro;
use App\Models\Investimento;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BonusRedeCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bonusrede:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Bonus de Rede';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $investimentos = Investimento::select('id','user_id','valor','validate_at')->where('status','1')->get();
        foreach ($investimentos as $i) {
            if($i->validate_at > date('Y-m-d H:i:s')){
                $nvl1 = User::select('id','username','indicacao')->where('username',$i->users->indicacao)->first();
                if(isset($nvl1)){
                    $valor = ($i->valor * 2)/100;

                    $wallet = Wallet::where('user_id',$nvl1->id)->first();
                    $wallet->saldo_indicacao += $valor;
                    $wallet->save();

                    $fin = new Financeiro();
                    $fin->user_id = $nvl1->id;
                    $fin->investimento_id = $i->id;
                    $fin->tipo = '2';
                    $fin->valor = $valor;
                    $fin->descricao = "Ganho Mensal Nivel 1 de ".$i->users->username;
                    $fin->save();

                    $nvl2 = User::select('id','username','indicacao')->where('username',$nvl1->indicacao)->first();
                    if(isset($nvl2)){
                        $valor = ($i->valor * 1)/100;

                        $wallet = Wallet::where('user_id',$nvl2->id)->first();
                        $wallet->saldo_indicacao += $valor;
                        $wallet->save();

                        $fin = new Financeiro();
                        $fin->user_id = $nvl2->id;
                        $fin->investimento_id = $i->id;
                        $fin->tipo = '2';
                        $fin->valor = $valor;
                        $fin->descricao = "Ganho Mensal Nivel 2 de ".$i->users->username;
                        $fin->save();

                        $nvl3 = User::select('id','username','indicacao')->where('username',$nvl2->indicacao)->first();
                        if(isset($nvl3)){
                            $valor = ($i->valor * 1)/100;

                            $wallet = Wallet::where('user_id',$nvl3->id)->first();
                            $wallet->saldo_indicacao += $valor;
                            $wallet->save();

                            $fin = new Financeiro();
                            $fin->user_id = $nvl3->id;
                            $fin->investimento_id = $i->id;
                            $fin->tipo = '2';
                            $fin->valor = $valor;
                            $fin->descricao = "Ganho Mensal Nivel 3 de ".$i->users->username;
                            $fin->save();

                            $nvl4 = User::select('id','username','indicacao')->where('username',$nvl3->indicacao)->first();
                            if(isset($nvl4)){
                                $valor = ($i->valor * 0.5)/100;

                                $wallet = Wallet::where('user_id',$nvl4->id)->first();
                                $wallet->saldo_indicacao += $valor;
                                $wallet->save();

                                $fin = new Financeiro();
                                $fin->user_id = $nvl4->id;
                                $fin->investimento_id = $i->id;
                                $fin->tipo = '2';
                                $fin->valor = $valor;
                                $fin->descricao = "Ganho Mensal Nivel 4 de ".$i->users->username;
                                $fin->save();

                                $nvl5 = User::select('id','username','indicacao')->where('username',$nvl4->indicacao)->first();
                                if(isset($nvl5)){
                                    $valor = ($i->valor * 0.5)/100;

                                    $wallet = Wallet::where('user_id',$nvl5->id)->first();
                                    $wallet->saldo_indicacao += $valor;
                                    $wallet->save();

                                    $fin = new Financeiro();
                                    $fin->user_id = $nvl5->id;
                                    $fin->investimento_id = $i->id;
                                    $fin->tipo = '2';
                                    $fin->valor = $valor;
                                    $fin->descricao = "Ganho Mensal Nivel 5 de ".$i->users->username;
                                    $fin->save();
                                }
                            }
                        }
                    }
                }
            }else{
                $vencido = Investimento::find($i->id);
                $vencido->status = "3";
                $vencido->save();
            }
        }
        return Command::SUCCESS;
    }
}
