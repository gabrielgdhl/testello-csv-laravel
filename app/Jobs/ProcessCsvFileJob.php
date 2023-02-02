<?php

namespace App\Jobs;

use App\Services\Files\ProcessCsvFileService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCsvFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $file;
    public function __construct(string $file)
    {
        $this->file = $file;
    }


    /** @throws Exception */
    public function handle()
    {
        (new ProcessCsvFileService)->process($this->file);
    }
}
