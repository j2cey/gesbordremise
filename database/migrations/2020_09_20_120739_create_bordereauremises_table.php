<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBordereauremisesTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'bordereauremises';
    public $table_comment = 'bordereaux de remise';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->baseFields();

            $table->string('fichier_source')->nullable()->comment('fichier source du bordereau');
            $table->timestamp('date_remise')->nullable()->comment('date de remise');
            $table->string('numero_transaction')->nullable()->comment('numéro de transaction');
            $table->string('localisation')->nullable()->comment('localisation');
            $table->string('changement_dernier_tarif')->nullable()->comment('changement dernier tarif');
            $table->string('classe_paiement')->nullable()->comment('classe de paiement');
            $table->string('mode_paiement')->nullable()->comment('mode de paiement');
            //TODO changer type montant_total en integer
            $table->string('montant_total')->nullable()->comment('montant total');
            $table->string('scan_bordereau')->nullable()->comment('fichier scan du bordereau');
            $table->timestamp('date_depot_agence')->nullable()->comment('date de depot agence');
            $table->timestamp('date_effectif')->nullable()->comment('date effective');
            $table->timestamp('date_valeur')->nullable()->comment('date valeur');
        });
        $this->setTableComment($this->table_name,$this->table_comment);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->table_name, function (Blueprint $table) {
            $table->dropBaseForeigns();
        });
        Schema::dropIfExists($this->table_name);
    }
}
