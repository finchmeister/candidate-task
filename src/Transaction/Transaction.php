<?php


namespace App\Transaction;

class Transaction
{
    /**
     * @var int
     */
    protected $merchantId;

    /**
     * @var \DateTimeInterface
     */
    protected $date;

    /**
     * @var float
     */
    protected $amount;

    /**
     * @var string
     */
    protected $currency;

    /**
     * @return int
     */
    public function getMerchantId(): int
    {
        return $this->merchantId;
    }

    /**
     * @param int $merchantId
     * @return Transaction
     */
    public function setMerchantId(int $merchantId): Transaction
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDate(): \DateTimeInterface
    {
        return $this->date;
    }

    /**
     * @param \DateTimeInterface $date
     * @return Transaction
     */
    public function setDate(\DateTimeInterface $date): Transaction
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return Transaction
     */
    public function setAmount(float $amount): Transaction
    {
        $this->amount = $amount;
        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return Transaction
     */
    public function setCurrency(string $currency): Transaction
    {
        $this->currency = $currency;
        return $this;
    }
}