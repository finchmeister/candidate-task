<?php


namespace App\Command;

use App\Repository\TransactionRepositoryInterface;
use App\Transaction\CurrencyConverterInterface;
use App\Transaction\Transaction;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Assert\Assertion;


class MerchantTransactionCommand extends Command
{
    /**
     * @var TransactionRepositoryInterface
     */
    private $transactionRepository;
    /**
     * @var CurrencyConverterInterface
     */
    private $currencyConverter;

    public function __construct(
        TransactionRepositoryInterface $transactionRepository,
        CurrencyConverterInterface $currencyConverter

    ) {
        parent::__construct();
        $this->transactionRepository = $transactionRepository;
        $this->currencyConverter = $currencyConverter;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:merchant-transactions')
            ->addArgument(
                'merchantId',
                InputArgument::REQUIRED,
                'Id of the merchant e.g., "1", "2"'
            )
            ->setHelp('Returns a table of transactions for the given merchant in GBP');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $merchantId = $input->getArgument('merchantId');
        $this->validateMerchantId($merchantId);

        $merchantTransactions = $this->transactionRepository->getAllTransactionsForMerchant($merchantId);

        if ($merchantTransactions === []) {
            $output->writeln(sprintf('No transactions found for merchant %s', $merchantId));
            return;
        }

        $merchantTransactionsInGBP = $this->currencyConverter->convertTransactionsToGBP($merchantTransactions);

        $this->renderTransactionTable($output, $merchantTransactionsInGBP);
    }

    /**
     * @param $merchantId
     */
    private function validateMerchantId($merchantId): void
    {
        if ((int) $merchantId === 0) {
            throw new \InvalidArgumentException('merchantId must be an int');
        }
    }

    /**
     * @param OutputInterface $output
     * @param Transaction[] $merchantTransactions
     */
    public function renderTransactionTable(
        OutputInterface $output,
        array $merchantTransactions
    ): void {
        $table = new Table($output);

        $table->setHeaders(
            ['Merchant', 'Date', 'Value', 'Currency']
        );

        foreach ($merchantTransactions as $transaction) {
            $table->addRow([
                (string)$transaction->getMerchantId(),
                (string)$transaction->getDate()->format('Y-m-d'),
                (string)$transaction->getAmount(),
                (string)$transaction->getCurrency(),
            ]);
        }

        $table->render();
    }
}
