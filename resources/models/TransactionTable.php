<?php

/**
 * Source of transactions, can read data.csv directly for simplicty sake, 
 * should behave like a database (read only)
 *
 */
class TransactionTable
{
    protected $merchantId;

    protected $date;

    protected $amount;

    protected $currency;
}

