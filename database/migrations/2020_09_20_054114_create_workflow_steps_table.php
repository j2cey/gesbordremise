<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowStepsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_steps';
    public $table_comment = 'liste des étapes d un workflow';

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

            $table->string('titre')->comment('titre de l étape');
            $table->integer('posi')->default(0)->comment('position de l étape dans le workflow');
            $table->string('description')->nullable()->comment('description de l étape');

            $table->foreignId('workflow_id')->nullable()
                ->comment('référence du workflow parent')
                ->constrained()->onDelete('set null');

            $table->foreignId('role_id')->nullable()
                ->comment('référence du profile de l acteur potentiel')
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
            $table->dropForeign(['workflow_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
