<?php

namespace App\Tests\Unit\Transaction;

use App\Transaction\CurrencyConverter;
use App\Transaction\CurrencyExchangeRateInterface;
use App\Transaction\Transaction;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    protected const EXCHANGE_RATE = 0.5;

    public function testConvertTransactionToGBP(): void
    {
        $transaction = new Transaction();
        $transaction->setAmount(5);
        $transaction->setCurrency('USD');

        $currencyExchangeRateService = $this->createMock(CurrencyExchangeRateInterface::class);
        $currencyExchangeRateService
            ->expects($this->once())
            ->method('getExchangeRateToGBP')
            ->willReturn(self::EXCHANGE_RATE);

        $currencyConverter = new CurrencyConverter($currencyExchangeRateService);

        $currencyConverter->convertTransactionToGBP($transaction);

        $this->assertSame('GBP', $transaction->getCurrency());
        $this->assertSame(10.0, $transaction->getAmount());
    }

    public function testConvertTransactionsToGBP(): void
    {
        $transaction1 = new Transaction();
        $transaction1->setAmount(5);
        $transaction1->setCurrency('USD');

        $transaction2 = new Transaction();
        $transaction2->setAmount(10);
        $transaction2->setCurrency('EUR');

        $transactions = [$transaction1, $transaction2];

        $currencyExchangeRateService = $this->createMock(CurrencyExchangeRateInterface::class);
        $currencyExchangeRateService
            ->expects($this->exactly(2))
            ->method('getExchangeRateToGBP')
            ->willReturn(self::EXCHANGE_RATE);

        $currencyConverter = new CurrencyConverter($currencyExchangeRateService);

        $convertedTransactions = $currencyConverter->convertTransactionsToGBP($transactions);

        $this->assertSame('GBP', $convertedTransactions[0]->getCurrency());
        $this->assertSame(10.0, $convertedTransactions[0]->getAmount());

        $this->assertSame('GBP', $convertedTransactions[1]->getCurrency());
        $this->assertSame(20.0, $convertedTransactions[1]->getAmount());
    }

    /**
     * @dataProvider dataProviderTestConvert
     * @param $expected
     * @param float $amount
     * @param float $exchangeRate
     */
    public function testConvert($expected, float $amount, float $exchangeRate): void
    {
        $this->assertSame($expected, CurrencyConverter::convert($amount, $exchangeRate));
    }

    public function dataProviderTestConvert(): array
    {
        return [
            [10.0, 5, 0.5],
            [33.33, 10, 0.3],
        ];
    }
}
