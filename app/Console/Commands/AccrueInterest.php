<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Bank;
use App\InterestTransaction;

class AccrueInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interest:accrue {bank?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate daily accrued interest for account(s)';

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
        // Grab the bank(s) for processing
        if ($this->argument('bank')) {
            $banks = Bank::where('id', '=', $this->argument('bank'));
        } else {
            $banks = Bank::all();
        }
        
        if (!$banks) {
            $this->info('No banks available for processing');
            return;
        }

        $this->info($banks->count() . " Banks queued for processing...");

        // Process each bank
        foreach($banks as $bank) {

            // Grab the accounts for each bank
            $allAccounts = $bank->accounts();
            if (!$allAccounts) {
                $this->info('No accounts for bank id: ' . $bank->id);
                return;
            }
            $totalCount = $allAccounts->count();

            $validAccounts = $allAccounts->canAccrueInterest();
            if (!$validAccounts) {
                $this->info('0 of '. $totalCount . ' accounts are valid to accrue interest for bank id: ' . $bank->id);
                return;
            }
            $validCount = $validAccounts->count();

            $this->info($validCount . ' of ' . $totalCount . ' accounts for bank: ' . $bank->id . ' are queued for processing...');

            // Process each account
            foreach($validAccounts->get() as $account) {
                $todaysAccruedInterest = $account->getDailyAccruedInterest();

                $this->info($todaysAccruedInterest);
                //TODO: what to do with the interest???
                InterestTransaction::create([
                    'amount' => $todaysAccruedInterest,
                    'category_id' => 1,
                    'account_id' => $account->id
                ]);
            }
            
        }
    }
}
