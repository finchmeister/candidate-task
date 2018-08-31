<?php

namespace App\Tests\Integration\Command;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class MerchantTransactionCommandTest extends KernelTestCase
{

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testNonIntegerTransactionType(): void
    {
        $this->executeMerchantTransactionsCommand('bob');
    }

    public function testNoTransactionsForMerchantId(): void
    {
        $output = $this->executeMerchantTransactionsCommand(3);
        $this->assertContains('No transactions found for merchant 3', $output);
    }

    public function testTransactionsForMerchantOutput(): void
    {
        $output = $this->executeMerchantTransactionsCommand(2);
        $expectedOutput = <<<EOT
+----------+------------+-------+----------+
| Merchant | Date       | Value | Currency |
+----------+------------+-------+----------+
| 2        | 2010-01-05 | 85.84 | GBP      |
| 2        | 2010-02-05 | 13.33 | GBP      |
| 2        | 2010-02-05 | 6.5   | GBP      |
| 2        | 2010-04-05 | 7.22  | GBP      |
+----------+------------+-------+----------+
EOT;

        $this->assertContains($expectedOutput, $output);
    }

    protected function executeMerchantTransactionsCommand($merchantId): string
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $application = new Application($kernel);

        $command = $application->find('app:merchant-transactions');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            'merchantId' => $merchantId,
        ));

        return $commandTester->getDisplay();
    }
}
