<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Test;
class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $test = Test::first();
        if($test){
            $test->update([
                'count' => $test->count + 1
            ]);
        }else{
            Test::create([
                'count' => 1
            ]);
        }
    }
}
