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
        if (!Schema::hasColumn('jobs', 'closed_at')) {
            Schema::table('jobs', function (Blueprint $table) {
                $table->timestamp('closed_at')->nullable()->after('period_end');
                $table->index('closed_at');
            });
        }

        DB::statement("
            UPDATE jobs
            SET closed_at = COALESCE(closed_at, NOW())
            WHERE (
                SELECT COUNT(*)
                FROM applications
                WHERE applications.job_id = jobs.id
                  AND applications.status = 'aprovado'
            ) >= jobs.vacancies
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('jobs', 'closed_at')) {
            Schema::table('jobs', function (Blueprint $table) {
                $table->dropIndex(['closed_at']);
                $table->dropColumn('closed_at');
            });
        }
    }
};
