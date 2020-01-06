<?php

namespace Salman\AutoJWT\Commands;

use Illuminate\Console\Command;
use Salman\AutoJWT\Service\AutoJWTService;

class InstallJWT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jwt:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create all Crud operations with a single command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        AutoJWTService::makeThisHappen();

        $this->info('Controller Model and Routes and Jwt Secret published.');
        $this->info('Thanks');
    }
}
