<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\School;
use App\SchoolApplicationKeyword;
use App\ApplicationPlatform;
use DB;

class UpdateKeyword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $parameters, $keywords;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($parameters, array $keywords)
    {
        $this->parameters = $parameters;
        $this->keywords = $keywords;
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
            $hasSchool = School::where('media_id', $this->parameters['media_id'])->first();

            $applicationPlatform = ApplicationPlatform::where('key', $this->parameters['api_key'])->where(['type' => 'weixiao'])->first();
            $application = $applicationPlatform->application;

            if ($hasSchool) {
                $school = $hasSchool;

                $schoolApplication = $school->schoolApplication()->where('application_id', $application->id)->orderBy('id', 'desc')->first();
                
                $schoolApplication->keyword()->delete();
                
                collect($this->keywords)->each(function ($keyword) use ($schoolApplication) {
                    SchoolApplicationKeyword::create([
                        'school_application_id' => $schoolApplication->id,
                        'keyword' => $keyword,
                    ]);
                });
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            
            throw $th;
        }
    }
}
