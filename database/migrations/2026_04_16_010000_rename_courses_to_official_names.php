<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $courseMap = [
        'Engenharia Agronômica' => 'Agronomia',
        'Agroindústria' => 'Tecnologia em Agroindústria',
        'Análise e Desenvolvimento de Sistemas (ADS)' => 'Tecnologia em Análise e Desenvolvimento de Sistemas (ADS)',
        'Química' => 'Licenciatura em Química',
        'Ciências Biológicas' => 'Licenciatura em Ciências Biológicas',
    ];

    public function up(): void
    {
        foreach ($this->courseMap as $oldName => $newName) {
            DB::table('students')
                ->where('course', $oldName)
                ->update(['course' => $newName]);

            DB::table('users')
                ->where('coordinator_course', $oldName)
                ->update(['coordinator_course' => $newName]);

            DB::table('jobs')
                ->where('area', $oldName)
                ->update(['area' => $newName]);

            DB::table('internship_calendars')
                ->where('course', $oldName)
                ->update(['course' => $newName]);

            DB::table('top_hiring_companies')
                ->where('course', $oldName)
                ->update(['course' => $newName]);
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->courseMap, true) as $oldName => $newName) {
            DB::table('students')
                ->where('course', $newName)
                ->update(['course' => $oldName]);

            DB::table('users')
                ->where('coordinator_course', $newName)
                ->update(['coordinator_course' => $oldName]);

            DB::table('jobs')
                ->where('area', $newName)
                ->update(['area' => $oldName]);

            DB::table('internship_calendars')
                ->where('course', $newName)
                ->update(['course' => $oldName]);

            DB::table('top_hiring_companies')
                ->where('course', $newName)
                ->update(['course' => $oldName]);
        }
    }
};
