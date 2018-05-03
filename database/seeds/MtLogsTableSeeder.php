<?php

use Illuminate\Database\Seeder;
use App\Models\MtLog;

class MtLogsTableSeeder extends Seeder
{
    public function run()
    {
        $mt_logs = factory(MtLog::class)->times(50)->make()->each(function ($mt_log, $index) {
            if ($index == 0) {
                // $mt_log->field = 'value';
            }
        });

        MtLog::insert($mt_logs->toArray());
    }

}

