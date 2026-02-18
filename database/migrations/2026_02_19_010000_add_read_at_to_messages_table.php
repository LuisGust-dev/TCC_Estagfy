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
        if (!Schema::hasColumn('messages', 'read_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->timestamp('read_at')->nullable()->after('message');
                $table->index('read_at');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('messages', 'read_at')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropIndex(['read_at']);
                $table->dropColumn('read_at');
            });
        }
    }
};
