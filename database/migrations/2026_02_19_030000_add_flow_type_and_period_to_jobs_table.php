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
        Schema::table('jobs', function (Blueprint $table) {
            if (!Schema::hasColumn('jobs', 'flow_type')) {
                $table->string('flow_type')->default('continuous')->after('vacancies');
                $table->index('flow_type');
            }

            if (!Schema::hasColumn('jobs', 'period_start')) {
                $table->date('period_start')->nullable()->after('flow_type');
            }

            if (!Schema::hasColumn('jobs', 'period_end')) {
                $table->date('period_end')->nullable()->after('period_start');
            }
        });

        DB::table('jobs')->whereNull('flow_type')->update(['flow_type' => 'continuous']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs', function (Blueprint $table) {
            if (Schema::hasColumn('jobs', 'period_end')) {
                $table->dropColumn('period_end');
            }

            if (Schema::hasColumn('jobs', 'period_start')) {
                $table->dropColumn('period_start');
            }

            if (Schema::hasColumn('jobs', 'flow_type')) {
                $table->dropIndex(['flow_type']);
                $table->dropColumn('flow_type');
            }
        });
    }
};
