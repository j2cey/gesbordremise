<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        /**
         * Importation des comptes LDAP
         */
        /*$schedule->command('adldap:import', [
            '--model' => "\App\LdapAccountImport",
            '--no-interaction',
        ])->dailyAt('01:00');*/

        /**
         * Synchronisation des comptes LDAP importés
         */
        /*$schedule->command('ldapaccount:sync')
            ->dailyAt('02:00');*/

        /**
         * Importation des Bordereaux de Remise
         */
        $schedule->command('borderemise:importfiles')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
