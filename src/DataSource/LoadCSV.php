<?php


namespace App\DataSource;

use App\Transaction\Transaction;
use League\Csv\Reader;

/**
 * Reads the CSV data source into TransactionObjects
 *
 * Class LoadCSV
 * @package App\DataSource
 */
class LoadCSV
{
    /**
     * @var null|array
     */
    public $data;
    /**
     * @var string
     */
    private $csvPath;

    public function __construct(
        string $csvPath
    ) {
        $this->csvPath = $csvPath;
    }

    public function readCSV()
    {
        if ($this->data === null) {
            $this->data = Reader::createFromPath($this->csvPath)
                ->setHeaderOffset(0)
                ->setDelimiter(';')
            ;
        }
        return $this->data;
    }

    public function convertRowToTransaction(array $row): Transaction
    {
        $transaction = new Transaction();
        $transaction
            ->setMerchantId((int)$row['merchant'])
            ->setDate(new \DateTime($row['date']));

        $amount = (float)$row['value'];
        $transaction
            ->setCurrency($row['currency'])
            ->setAmount($amount)
        ;
        return $transaction;
    }

    /**
     * @return Transaction[]
     */
    public function getData(): array
    {
        if ($this->data === null) {
            $csv = $this->readCSV();
            $this->data = [];
            foreach ($csv as $row) {
                $this->data[] = $this->convertRowToTransaction($row);
            }
        }
        return $this->data;
    }

}
