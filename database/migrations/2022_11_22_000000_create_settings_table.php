<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('group')->default(\JalalLinuX\Setting\Models\Setting::DEFAULT_GROUP)->index();
            $table->string('key')->index();

            // Nullable morph with dynamic entity id
            $table->string("entity_type")->nullable();
            $table->string("entity_id")->nullable();
            $table->index(["entity_type", "entity_id"]);

            $table->text('value')->nullable();
            $table->json('validations')->nullable();
            $table->timestamps();

            $table->unique(\JalalLinuX\Setting\Models\Setting::UNIQUE_COLUMNS);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
