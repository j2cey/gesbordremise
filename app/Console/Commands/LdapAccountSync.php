<?php

namespace App\Console\Commands;

use App\Traits\LDAP\LdapImportTrait;
use Illuminate\Console\Command;

class LdapAccountSync extends Command
{
    use LdapImportTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ldapaccount:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronise les comptes LDAP importés';

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
        $this->importLdapAccounts();
        \Log::info("Traitement termine.");
    }
}
