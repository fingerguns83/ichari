<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use \Iconify\JSONTools\Collection;
use \Iconify\JSONTools\SVG;
use App\Models\Icon;

class initIcons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'icons:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load icons into DB';

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
        $collection = new Collection();
        $collection->loadIconifyCollection('mdi');

        $index = 1;
        $confirm = '';
        foreach($collection->listIcons(true) as $icon){
            $svg = new SVG($collection->getIconData($icon));
            $path = preg_replace('/.*d="/', '', $svg->getSVG());
            $path = preg_replace('/".*/', '', $path);
            echo $icon . PHP_EOL;
            $confirm = readline('=> ');
            if ($confirm == 'y'){
                echo 'Created "' . $icon . '" [' . $index . ']' . PHP_EOL;
                DB::table('icons')
                    ->insert([
                    'name' => $icon,
                    'path' => $path
                ]);
                $confirm = '';
                $index++;
            }
        }
    }
}
