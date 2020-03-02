<?php

namespace App\Http\Controllers;

use App\Http\Requests\FibonacciRequest;
use App\Http\Requests\IpRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function fibonacci(FibonacciRequest $request)
    {
        $validation = Validator::make($request->all(), ['int' => 'required|integer|max:9999']);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->jsonSerialize()], 500);
        }

        $jobId = generateTask('F', $validation->validated());
        if (!empty($jobId)) {
            return response()->json(['task_id' => $jobId], 200);
        } else {
            return response()->json(['error' => 'error processing task'], 500);
        }
    }

    public function ip(IpRequest $request)
    {
        $validation = Validator::make($request->all(), ['ip' => 'required|string|ip']);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()->jsonSerialize()], 500);
        }

        $jobId = generateTask('I', $validation->validated());
        if (!empty($jobId)) {
            return response()->json(['task_id' => $jobId], 200);
        } else {
            return response()->json(['error' => ['task' => 'error processing task']], 500);
        }
    }
}
