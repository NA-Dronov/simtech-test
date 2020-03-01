<?php

namespace App\Http\Controllers;

use App\JobLog;
use App\Misc\TaskStatus;
use App\Misc\TaskType;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function status($id)
    {
        $jobLog = JobLog::find($id);
        if (!isset($jobLog)) {
            return response()->json(["error" => "required task not found"], 404);
        }

        $data = [];

        if ($jobLog->status == TaskStatus::PENDING) {
            $data['status'] = 'pending';
        } elseif ($jobLog->status == TaskStatus::FAILED) {
            $data['status'] = 'failed';
        } else {
            switch ($jobLog->type) {
                case TaskType::FIBONACCI:
                    $data['fibonacci_sequence'] = json_decode($jobLog['result']);
                    break;
                case TaskType::ISPNAME:
                    $data['ispname'] = json_decode($jobLog['result']);
                    break;
            }

            $jobLog->delete();
        }

        return response()->json($data, 200);
    }
}
