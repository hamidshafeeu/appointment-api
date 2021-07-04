<?php

namespace App\Console\Commands;

use App\Models\Slot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ImportSlotCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:slot {file : Location of the file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $file = $this->argument('file');
        if(File::exists( $file )) {
            
            $slots = $this->withProgressBar(json_decode(File::get($file)), function ($slot) {
                Slot::updateOrCreate([
                    'center_id' => $slot->center_id,
                    'date' => $slot->date,
                    'start' => $slot->start,
                ], (array)$slot);
            });

            $this->info(PHP_EOL. count($slots)." slots updated. Summary follows");

            collect($slots)->groupBy('center_id')->each(function($k, $v) {
                $k->groupBy('date')->each(function($_k, $_v) use ($v) {
                    
                    $this->info("Center: $v, Date: $_v, Count:".count($_k));
                });
            });

            return 0;
        }

        $this->warn("File `{$file}` not found!");
    }
}
