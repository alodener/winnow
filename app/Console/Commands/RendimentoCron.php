<?php

namespace App\Console\Commands;

use App\Models\Financeiro;
use App\Models\Investimento;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RendimentoCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rendimento:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rendimento';

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
        //* * * * * php /home/rollov05/app/artisan schedule:run 1>> /dev/null 2>&1
        $investimentos = Investimento::select('id','user_id','valor','validate_at','tipo')->where('status','1')->get();
        foreach ($investimentos as $i) {
            if($i->validate_at > date('Y-m-d H:i:s')){
                if($i->tipo == '7'){
                    $valor = ($i->valor * 0.35)/100;
                }elseif($i->tipo == '20'){
                    $valor = ($i->valor * 1)/100;
                }

                $in = Investimento::select('id','rendimento')->find($i->id);
                $in->rendimento += $valor;
                $in->save();

                $wallet = Wallet::where('user_id',$i->user_id)->first();
                $wallet->rendimento += $valor;
                $wallet->save();

                $fin = new Financeiro();
                $fin->user_id = $i->user_id;
                $fin->tipo = '2';
                $fin->valor = $valor;
                $fin->descricao = "Rendimento Rollover";
                $fin->investimento_id = $i->id;
                $fin->save();
            }else{
                $vencido = Investimento::find($i->id);
                $vencido->status = "3";
                $vencido->save();
            }
        }
        return Command::SUCCESS;
    }
}
