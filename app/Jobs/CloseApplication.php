<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\School;
use App\ApplicationPlatform;
use App\SchoolApplication;
use DB;

class CloseApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parameters;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::beginTransaction();

        try {
            $school = School::where('media_id', $this->parameters['media_id'])->first();

            $applicationPlatform = ApplicationPlatform::where('key', $this->parameters['api_key'])->where(['type' => 'weixiao'])->first();
            $application = $applicationPlatform->application;

            $schoolApplications = SchoolApplication::where('school_id', $school->id)->where('application_id', $application->id)->get();
            
            $schoolApplications->each(function ($schoolApplication) {
                $schoolApplication->information()->delete();
                $schoolApplication->delete();
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            throw $th;
        }
    }
}
