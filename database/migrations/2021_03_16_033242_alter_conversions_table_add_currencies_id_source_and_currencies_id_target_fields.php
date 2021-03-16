<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterConversionsTableAddCurrenciesIdSourceAndCurrenciesIdTargetFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('conversions', function (Blueprint $table) {
            $table->text('source_currency')->nullable()->change();
            $table->text('target_currency')->nullable()->change();

            $table->unsignedBigInteger('currencies_id_source')->after('amount_converted');
            $table->unsignedBigInteger('currencies_id_target')->after('currencies_id_source');

            $table->foreign('currencies_id_source')
                ->references('id')
                ->on('currencies')
                ->onUpdate('cascade')
                ->onDelete(null);

            $table->foreign('currencies_id_target')
                ->references('id')
                ->on('currencies')
                ->onUpdate('cascade')
                ->onDelete(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('conversions', function (Blueprint $table) {
            $table->dropForeign('posts_user_id_foreign');
            $table->dropForeign('posts_user_id_foreign');
        });
    }
}
