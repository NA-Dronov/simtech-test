<?php

namespace App\Jobs;

use App\IpProviders\IpProvider;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\JobLog;
use App\Misc\TaskStatus;
use App\Misc\TaskType;
use Throwable;

class GetIspname implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $ip;
    private $ipProvider;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(IpProvider $ipProvider, string $ip)
    {
        $this->ip = $ip;
        $this->ipProvider = $ipProvider;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $ispname = $this->ipProvider->getIspName($this->ip);
            $jobLog = JobLog::findOrFail($this->job->getJobId());
            $jobLog->status = TaskStatus::COMPLETED;
            $jobLog->result = json_encode($ispname);
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
