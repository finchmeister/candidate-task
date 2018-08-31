<?php


namespace App\Repository;

use App\Transaction\Transaction;

interface TransactionRepositoryInterface
{

    /**
     * Could be a doctrine implementation, or in this case, a csv data source
     * @param int $merchantId
     * @return Transaction[]
     */
    public function getAllTransactionsForMerchant(int $merchantId): array;

}