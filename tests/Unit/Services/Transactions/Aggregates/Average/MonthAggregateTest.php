<?php

declare(strict_types=1);

use App\Models\Transaction;

use App\Services\Timestamp;
use App\Services\Transactions\Aggregates\Fees\Average\MonthAggregate;
use Carbon\Carbon;
use function Tests\configureExplorerDatabase;

beforeEach(fn () => configureExplorerDatabase());

it('should determine the average fee for the given date range', function () {
    Carbon::setTestNow('2021-01-01 00:00:00');

    Transaction::factory(10)->create([
        'fee'       => '100000000',
        'timestamp' => Timestamp::now()->subDays(30)->unix(),
    ]);

    Transaction::factory(10)->create([
        'fee'       => '200000000',
        'timestamp' => Timestamp::now()->endOfDay()->unix(),
    ]);

    $result = (new MonthAggregate())->aggregate();

    expect($result)->toBeFloat();
    expect($result)->toBe(1.5);
});