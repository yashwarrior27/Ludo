<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\Game;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TimmerCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'timmer-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try
        {
            DB::beginTransaction();

            $games=Game::where('status','1')->get();

            foreach($games as $key=>$game)
            {
                if(empty($game->room_code) && $game->room_code_timer <= time())
                {
                    $game->status='5';
                    $game->comment='timeup for room code';
                    $game->save();

                    Transaction::where('type_id',$game->id)->where('trans',1)->update(['status'=>0]);
                }
                else if(!empty($game->accepter_timer) && $game->accepter_timer<=time())
                {
                    $game->status='5';
                    $game->comment='timeup for accepted room code';
                    $game->save();

                    Transaction::where('type_id',$game->id)->where('trans',1)->update(['status'=>0]);
                }
            }
            DB::commit();

            echo 'Success done';
        }
       catch(\Exception $e)
       {
          DB::rollBack();
        echo $e->getMessage();
       }
    }
}
