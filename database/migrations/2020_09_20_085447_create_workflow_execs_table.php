<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowExecsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflow_execs';
    public $table_comment = 'Instance d exeution d un workflow';

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

            $table->foreignId('workflow_id')->nullable()
                ->comment('référence du workflow')
                ->constrained()->onDelete('set null');

            $table->integer('prev_step')->nullable()->comment('étape précédant l étape courrante');
            $table->integer('curr_step')->nullable()->comment('étape courrante');
            $table->integer('next_step')->nullable()->comment('étape suivant l étape courrante');

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
            $table->dropForeign(['workflow_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
