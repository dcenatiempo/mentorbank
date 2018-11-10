<?php

use Faker\Generator as Faker;

$factory->define(App\Account::class, function (Faker $faker) {
    return [
        'id' => $faker->randomNumber(),
        'created_at' => '2017-10-03 16:59:09',
        'updated_at' => '2017-11-03 16:59:09',
        'deleted_at' => null,
        'balance' => 54,
        'monthly_transactions' => 3,
        'total_transactions' => 24,
        'notifications' => true,
        'goal_balance' => null,
        'low_balance_alert' => null,
        'view' => 0,
        'interest_rate' => 10,
        'rate_interval' => 'week',
        'frequency' => 'P1W',
        'distribution_day' => 1,
        'last_distribution' => '2017-12-25 16:59:09',
        'next_distribution' => '2018-01-01 16:59:09',
        'allow_negative_balance' => false,
        'overdraft_fee' => 0,
        'credit_interest_rate' => 0,
        'bank_id' => 1,
        'account_holder_id' => 1
    ];
});
