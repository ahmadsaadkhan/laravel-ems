<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('breakouts', function (Blueprint $table) {
            $table->text('backup_breakout_url')->nullable()->after('breakout_url');
            $table->string('backup_breakout_label')->nullable()->after('breakout_label');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('breakouts', function (Blueprint $table) {
            $table->text('backup_breakout_url')->nullable()->after('breakout_url');
            $table->string('backup_breakout_label')->nullable()->after('breakout_label');
        });
    }
};
