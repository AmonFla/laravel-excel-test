<?php

namespace App\Console\Commands;

use App\Imports\UserImport as ImportUserImport;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class UserImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user-import';

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
        dump(Storage::disk('public')->path('users.xls'));
        Excel::import(new ImportUserImport, Storage::disk('public')->path('users.xls'));
    }
}
