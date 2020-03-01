<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\JobLog;
use App\Misc\TaskStatus;
use App\Misc\TaskType;
use Throwable;

class GetFibonacciSequence implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $number;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $fib = fibonacci($this->number);
            $jobLog = JobLog::findOrFail($this->job->getJobId());
            $jobLog->status = TaskStatus::COMPLETED;
            $jobLog->result = json_encode($fib);
            $jobLog->save();
        } catch (Throwable $ex) {
            $this->failed($ex);
            throw $ex;
        }
    }

    public function failed(\Exception $exception)
    {
        $jobLog = JobLog::find($this->job->getJobId());

        if (empty($jobLog)) {
            JobLog::create([
                'id' => $this->job->getJobId(),
                'type' => TaskType::ISPNAME,
                'status' => TaskStatus::FAILED
            ]);
        } else {
            $jobLog->status = TaskStatus::FAILED;
            $jobLog->save();
        }
    }
}
