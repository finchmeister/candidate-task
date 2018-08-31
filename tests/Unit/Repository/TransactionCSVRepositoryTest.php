<?php

namespace App\Tests\Unit\Repository;

use App\DataSource\LoadCSV;
use App\Repository\TransactionCSVRepository;
use App\Transaction\Transaction;
use PHPUnit\Framework\TestCase;

class TransactionCSVRepositoryTest extends TestCase
{

    public function testGetAllTransactionsForMerchantReturnsCorrectMerchantTransaction(): void
    {
        $transactionMerchant1 = new Transaction();
        $transactionMerchant1->setMerchantId(1);

        $transactionMerchant2 = new Transaction();
        $transactionMerchant2->setMerchantId(2);

        $data = [$transactionMerchant1, $transactionMerchant2];

        $loadCSVMock = $this->createMock(LoadCSV::class);
        $loadCSVMock
            ->expects($this->once())
            ->method('getData')
            ->willReturn($data)
        ;

        $transactionCSVRepository = new TransactionCSVRepository($loadCSVMock);

        $expected = [$transactionMerchant1];

        $this->assertSame(
            $expected,
            $transactionCSVRepository->getAllTransactionsForMerchant(1)
        );
    }

}
