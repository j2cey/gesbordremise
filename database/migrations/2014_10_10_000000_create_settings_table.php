<?php

use App\Traits\Migrations\BaseMigrationTrait;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    use BaseMigrationTrait;

    public $table_name = 'settings';
    public $table_comment = 'System s custom settings.';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();

            //$table->string('group')->comment('groupe');
            $table->string('name')->comment('clé');
            $table->string('value')->nullable()->comment('valeur');
            $table->string('type')->default("string")->comment('type de la donnée (valeur)');
            $table->string('array_sep')->default(",")->comment('séparateur de tableau le cas échéant');
            $table->string('description')->nullable()->comment('description');

            $table->foreignId('group_id')->nullable()
                ->comment('reference du goupe de l entée (le cas échéant)')
                ->constrained('settings')->onDelete('set null');

            $table->timestamps();
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
            $table->dropForeign(['group_id']);
        });
        Schema::dropIfExists($this->table_name);
    }
}
