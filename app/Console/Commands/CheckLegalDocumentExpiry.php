<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LegalComplianceService;

class CheckLegalDocumentExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'legal:check-expiry';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all legal documents for expiry and generate notifications';

    /**
     * The legal compliance service instance.
     *
     * @var \App\Services\LegalComplianceService
     */
    protected $legalComplianceService;

    /**
     * Create a new command instance.
     *
     * @param  \App\Services\LegalComplianceService  $legalComplianceService
     * @return void
     */
    public function __construct(LegalComplianceService $legalComplianceService)
    {
        parent::__construct();
        $this->legalComplianceService = $legalComplianceService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking legal document expiry status...');
        
        $this->legalComplianceService->checkDocumentExpiry();
        
        $this->info('Document expiry check completed!');
        
        return 0;
    }
}