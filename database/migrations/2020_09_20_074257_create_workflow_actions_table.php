<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowActionsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_actions';
    public $table_comment = 'action de workflow';

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

            $table->string('titre')->comment('intitule de l action');

            $table->foreignId('workflow_action_type_id')->nullable()
                ->comment('référence du type d action')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_step_id')->nullable()
                ->comment('référence de l étape de workflow parent')
                ->constrained()->onDelete('set null');

            $table->foreignId('workflow_object_field_id')->nullable()
                ->comment('référence du champs d objet')
                ->constrained()->onDelete('set null');
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
            $table->dropForeign(['workflow_step_id']);
            $table->dropForeign(['workflow_action_type_id']);
            $table->dropForeign(['workflow_object_field_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
