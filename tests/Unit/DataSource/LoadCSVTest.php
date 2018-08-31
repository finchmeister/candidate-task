<?php

namespace App\Tests\Unit\DataSource;

use App\DataSource\LoadCSV;
use App\Transaction\Transaction;
use PHPUnit\Framework\TestCase;

class LoadCSVTest extends TestCase
{

    public const CSV_PATH = __DIR__.'/test_data.csv';

    public function testGetData(): void
    {
        $loadCSV = new LoadCSV(self::CSV_PATH);
        $data = $loadCSV->getData();

        $this->assertCount(2, $data);

        $this->assertTransactionObject(
            1,
            new \DateTime('01/05/2010'),
            50.0,
            'GBP',
            $data[0]
        );

        $this->assertTransactionObject(
            2,
            new \DateTime('02/05/2010'),
            66.1,
            'USD',
            $data[1]
        );
    }

    protected function assertTransactionObject(
        int $expectedMerchantId,
        \DateTimeInterface $expectedDate,
        float $expectedValue,
        string $expectedCurrency,
        Transaction $transaction
    ) {
        $this->assertSame($expectedMerchantId, $transaction->getMerchantId());
        $this->assertEquals($expectedDate, $transaction->getDate());
        $this->assertSame($expectedValue, $transaction->getAmount());
        $this->assertSame($expectedCurrency, $transaction->getCurrency());
    }
}
