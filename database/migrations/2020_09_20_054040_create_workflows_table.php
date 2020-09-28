<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkflowsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'workflows';
    public $table_comment = 'liste des workflows (configurations) du systeme';

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

            $table->string('titre')->comment('titre du workflow');
            $table->string('description')->nullable()->comment('description du workflow');

            $table->foreignId('user_id')->nullable()
                ->comment('référence de l utilisateur')
                ->constrained()->onDelete('set null');

            $table->string('model_type')->nullable()->comment('type du modèle référencé');
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
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
