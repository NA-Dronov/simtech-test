<?php

namespace App\Http\Controllers;

use App\Http\Requests\FibonacciRequest;
use App\Http\Requests\IpRequest;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function fibonacci(FibonacciRequest $request)
    {
        $res = $request->validated();
        $jobId = generateTask('F', $res);
        if (!empty($jobId)) {
            return response()->json(['task_id' => $jobId], 200);
        } else {
            return response()->json(['error' => 'error processing task'], 500);
        }
    }

    public function ip(IpRequest $request)
    {
        $res = $request->validated();
        $jobId = generateTask('I', $res);
        if (!empty($jobId)) {
            return response()->json(['task_id' => $jobId], 200);
        } else {
            return response()->json(['error' => 'error processing task'], 500);
        }
    }
}
