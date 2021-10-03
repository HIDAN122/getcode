<?php

namespace App\Console\Commands;

use App\Imports\MembersImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Excel;

class ImportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import';

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
        \Maatwebsite\Excel\Facades\Excel::import(new MembersImport(),'storage/app/getcode.csv');
    }
}
