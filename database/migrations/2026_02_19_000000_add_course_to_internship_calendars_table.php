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
        if (!Schema::hasColumn('internship_calendars', 'course')) {
            Schema::table('internship_calendars', function (Blueprint $table) {
                $table->string('course')->nullable()->after('description');
                $table->index('course');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('internship_calendars', 'course')) {
            Schema::table('internship_calendars', function (Blueprint $table) {
                $table->dropIndex(['course']);
                $table->dropColumn('course');
            });
        }
    }
};
