<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\School;
use App\SchoolKeyword;
use DB;

class UpdateKeyword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $mediaId, $keywords;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mediaId, array $keywords)
    {
        $this->mediaId = $mediaId;
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
            $hasSchool = School::where('media_id', $this->mediaId)->first();
    
            if ($hasSchool) {
                $school = $hasSchool;
                $school->keyword()->delete();
                
                collect($this->keywords)->each(function ($keyword) use ($school) {
                    SchoolKeyWord::create([
                        'school_id' => $school->id,
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
