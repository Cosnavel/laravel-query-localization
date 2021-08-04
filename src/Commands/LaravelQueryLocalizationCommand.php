<?php

namespace Cosnavel\LaravelQueryLocalization\Commands;

use Illuminate\Console\Command;

class LaravelQueryLocalizationCommand extends Command
{
    public $signature = 'laravel-query-localization';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
