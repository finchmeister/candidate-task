<?php


namespace App\Repository;


use App\DataSource\LoadCSV;
use App\Transaction\Transaction;

class TransactionCSVRepository implements TransactionRepositoryInterface
{

    /**
     * @var LoadCSV
     */
    private $loadCSV;

    public function __construct(
        LoadCSV $loadCSV
    ) {
        $this->loadCSV = $loadCSV;
    }

    /**
     * @param int $merchantId
     * @return Transaction[]
     */
    public function getAllTransactionsForMerchant(int $merchantId): array
    {
        return array_filter($this->loadCSV->getData(), function (Transaction $transaction) use ($merchantId) {
            return $transaction->getMerchantId() === $merchantId;
        });
    }

}