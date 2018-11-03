<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Bank;
use App\InterestTransaction;
use App\Transaction;

class DistributeInterest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interest:distribute {bank?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Distribute accrued interest for account(s)';

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

            $this->info($totalCount . ' accounts for bank: ' . $bank->id . ' are queued for processing...');

            // Process each account
            foreach($allAccounts->get() as $account) {
                $interestCat = $account->subscribedCategories()->interestOnly()->first();
                $depositCat = $account->subscribedCategories()->where('category_id', '=', 2)->first();
                $this->info('pizza');
                $this->info(get_class($depositCat));
                $this->info(get_class($interestCat));
                
                
                
                // deposit interest
                $distribution = Transaction::create([
                    'memo' => 'Interest Distribution',
                    'type' => 'deposit',
                    'net_amount' => $interestCat->balance,
                    'split' => [[
                        'category_id' => $depositCat->category_id,
                        'amount' => $interestCat->balance
                    ]],
                    'account_id' => $account->id,
                    'date' => Carbon::now()
                ]);
                
                // deduct interest
                InterestTransaction::create([
                    'amount' => -$interestCat->balance,
                    'category_id' => 1,
                    'account_id' => $account->id
                ]);

                $interestCat->balance = 0;
                $interestCat->updated_at = Carbon::now();
                $interestCat->save();
                
                
            }
            
        }
    }
}
