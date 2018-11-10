<?php

namespace Tests\Unit;

use App;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    protected $account;

    protected function setUp() {
        parent::setup();

        $this->account = factory(\App\Account::class)->make();
    }

    public function testChangeFrequency1() {
        $this->account->fill([
            'frequency' => 'P2W',
            'distribution_day' => 1,
            'last_distribution' => new Carbon('2017-12-25'),
            'next_distribution' => new Carbon('2018-01-01'),
        ]);

        $today = new Carbon('2017-12-31');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-01-08');
    }

    public function testChangeFrequency2() {
        $this->account->fill([
            'frequency' => 'P2W',
            'distribution_day' => 2,
            'last_distribution' => new Carbon('2017-12-25'),
            'next_distribution' => new Carbon('2018-01-01'),
        ]);

        $today = new Carbon('2017-12-31');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-01-09');
    }

    public function testChangeFrequency3() {
        $this->account->fill([
            'frequency' => 'P1W',
            'distribution_day' => 3,
            'last_distribution' => new Carbon('2017-12-25'),
            'next_distribution' => new Carbon('2018-01-01'),
        ]);

        $today = new Carbon('2017-12-31');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-01-03');
    }

    public function testChangeFrequency4() {
        $this->account->fill([
            'frequency' => 'P1W',
            'distribution_day' => 1,
            'last_distribution' => new Carbon('2017-12-01'),
            'next_distribution' => new Carbon('2018-01-01'),
        ]);

        $today = new Carbon('2017-12-13');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2017-12-18');
    }

    public function testChangeFrequency5() {
        $this->account->fill([
            'frequency' => 'P1M',
            'distribution_day' => 2,
            'last_distribution' => new Carbon('2017-12-01'),
            'next_distribution' => new Carbon('2017-12-15'),
        ]);

        $today = new Carbon('2017-12-14');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-01-02');
    }

    public function testChangeFrequency6() {
        $this->account->fill([
            'frequency' => 'P1M',
            'distribution_day' => 31,
            'last_distribution' => new Carbon('2018-01-31'),
            'next_distribution' => new Carbon('2018-02-07'),
        ]);

        $today = new Carbon('2018-02-08');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-02-28');
    }

    public function testChangeFrequency7() {
        $this->account->fill([
            'frequency' => 'P1M',
            'distribution_day' => 31,
            'last_distribution' => new Carbon('2018-02-28'),
            'next_distribution' => new Carbon('2018-03-07'),
        ]);

        $today = new Carbon('2018-03-06');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-03-31');
    }

    public function testChangeFrequency8() {
        $this->account->fill([
            'frequency' => 'P1M',
            'distribution_day' => 30,
            'last_distribution' => new Carbon('2018-03-31'),
            'next_distribution' => new Carbon('2018-04-07'),
        ]);

        $today = new Carbon('2018-04-06');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-04-30');
    }

    public function testChangeFrequency9() {
        $this->account->fill([
            'frequency' => 'P1M',
            'distribution_day' => 31,
            'last_distribution' => new Carbon('2018-04-30'),
            'next_distribution' => new Carbon('2018-04-30'),
        ]);

        $today = new Carbon('2018-04-30');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-05-31');
    }

    public function testChangeFrequency10() {
        $this->account->fill([
            'frequency' => 'P1W',
            'distribution_day' => 1,
            'last_distribution' => new Carbon('2018-04-30'),
            'next_distribution' => new Carbon('2018-04-30'),
        ]);

        $today = new Carbon('2018-04-30');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-05-07');
    }

    public function testChangeFrequency11() {
        $this->account->fill([
            'frequency' => 'P2M',
            'distribution_day' => 31,
            'last_distribution' => new Carbon('2018-06-30'),
            'next_distribution' => new Carbon('2018-07-07'),
        ]);

        $today = new Carbon('2018-07-06');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-08-31');
    }

    public function testChangeFrequency12() {
        $this->account->fill([
            'frequency' => 'P2M',
            'distribution_day' => 31,
            'last_distribution' => new Carbon('2018-07-31'),
            'next_distribution' => new Carbon('2018-08-07'),
        ]);

        $today = new Carbon('2018-08-06');

        $newNextDist = $this->account->calculateNextDistribution($today);
        // Log::debug($newNextDist->toDateString());

        $this->assertTrue($newNextDist->toDateString() == '2018-09-30');
    }
}
