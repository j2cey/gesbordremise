<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowExecActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_exec_actions';
    public $table_comment = 'Instance des actions effectuées/a effectuer par le workflow';

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

            $table->string('model_type')->nullable()->comment('type du modele');
            $table->string('model_field')->nullable()->comment('champs du modele');
            $table->bigInteger('model_id')->nullable()->comment('id du modele');

            $table->string('rawvalue')->nullable()->comment('valeur initiale de l action');
            $table->string('setvalue')->nullable()->comment('valeur assignée par l acteur');
            $table->boolean('current')->default(false)->comment('determine si cette action est celle qu il faut traiter maintenant');

            $table->unsignedBigInteger('prev_exec_id')->nullable()->comment('id de l action precedente le cas échéant');
            $table->foreign('prev_exec_id')
                ->references('id')
                ->on('workflow_exec_actions')
                ->onDelete('set null');

            $table->unsignedBigInteger('next_exec_id')->nullable()->comment('id de l action suivante le cas échéant');
            $table->foreign('next_exec_id')
                ->references('id')
                ->on('workflow_exec_actions')
                ->onDelete('set null');

            $table->string('motif_rejet')->nullable()->comment('motif rejet le cas échéant');
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
            $table->dropForeign(['prev_exec_id']);
            $table->dropForeign(['next_exec_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
