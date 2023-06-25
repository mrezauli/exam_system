<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Modules\Exam\Examination;

class NewLineCountRemoveJob extends Job implements SelfHandling
{
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    function countStringWithoutNewlineTab($string) {
        $stringWithoutNewlineTab = str_replace(["\n", "\t", "\r", "\a", "\e", "\f", "\R"], '', $string);
        return mb_strlen($stringWithoutNewlineTab, 'UTF-8');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $examinations = Examination::where('id', 311)->get();
        // Perform the bulk update
        $examinations->each(function ($examination) {
            //$examination->total_words = $this->countStringWithoutNewlineTab($examination->original_text);
            $examination->typed_words = $this->countStringWithoutNewlineTab($examination->answered_text);
            // Set other attributes as needed
            $examination->save();
        });
        //dd('done');
    }
}
