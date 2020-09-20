<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowExecObjectsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_exec_objects';
    public $table_comment = 'Instance des objets modifier/a modifier par le workflow';

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

            $table->foreignId('workflow_exec_id')->nullable()
                ->comment('référence de l execution de workflow')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_action_id')->nullable()
                ->comment('référence de l action')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_status_id')->nullable()
                ->comment('référence du statut')
                ->constrained()->onDelete('set null');

            $table->bigInteger('model_id')->nullable()->comment('id du modele');

            $table->json('report')->comment('rapport d exécution');
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
            $table->dropForeign(['workflow_exec_id']);
            $table->dropForeign(['workflow_status_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
