<?php


namespace App\Services;


class QuizStatusCheck
{
    public static function status($reports)
    {
        $status = [
            'LOW' => 0,
            'MEDIUM' => 0,
            'HIGH' => 0,
        ];

        foreach ($reports as $report) {

            if ($report->status) {
                if ($report->status == 'low' || $report->status == 'LOW') {
                    $status['LOW']++;
                }
                if ($report->status == 'medium' || $report->status == 'MEDIUM') {
                    $status['MEDIUM']++;
                }
                if ($report->status == 'high' || $report->status == 'HIGH') {
                    $status['HIGH']++;
                }
            }

        }

        $max = max($status);

        if ($max) $top_student = array_search(max($status), $status);

        else $top_student = '';

        return $top_student;

    }

    public static function statusEffort($reports)
    {
        $statusEffort = [
            'LOW' => 0,
            'MEDIUM' => 0,
            'HIGH' => 0,
        ];

        foreach ($reports as $report) {

            if ($report->status_effort) {

                if ($report->status == 'low' || $report->status == 'LOW') {
                    $statusEffort['LOW']++;
                }
                if ($report->status == 'medium' || $report->status == 'MEDIUM') {
                    $statusEffort['MEDIUM']++;
                }
                if ($report->status == 'high' || $report->status == 'HIGH') {
                    $statusEffort['HIGH']++;
                }

            }

        }

        $max = max($statusEffort);

        if ($max) $top_student = array_search(max($statusEffort), $statusEffort);

        else $top_student = '';

        return $top_student;

    }
}
