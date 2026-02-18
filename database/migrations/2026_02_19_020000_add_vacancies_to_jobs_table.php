<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('jobs', 'vacancies')) {
            Schema::table('jobs', function (Blueprint $table) {
                $table->unsignedTinyInteger('vacancies')->default(1)->after('area');
            });
        }

        DB::table('jobs')->whereNull('vacancies')->update(['vacancies' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jobs', 'vacancies')) {
            Schema::table('jobs', function (Blueprint $table) {
                $table->dropColumn('vacancies');
            });
        }
    }
};
