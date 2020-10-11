<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class LdapAccountImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldapaccount:import';

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
        \Log::info("Cron en cours de traitement...");

        // Tronquage de la table d'importation
        DB::table('ldapaccountimports')->truncate();

        // Exécution de la commande d'importation
        Artisan::call('adldap:import', ['--model' => "\App\LdapAccountImport", '--no-interaction']);

        \Log::info("Traitement termine.");
    }
}
