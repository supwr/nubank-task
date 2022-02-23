<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Entity\Operation\OperationCollectionFactory;
use App\Domain\ValueObject\OperationType;
use App\Infrastructure\Validator\OperationCollectionValidator;
use App\Infrastructure\Shared\Helper\JsonInputHelper;
use App\Application\Command\CalculateOperationCollectionTax;
use App\Infrastructure\DTO\OperationResultCollectionDTO;
use App\Infrastructure\Shared\Stream\{
    InputStreamInterface,
    OutputStreamInterface
};

/**
 * OperationTaxCalculator
 */
class OperationTaxCalculator
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(
        private CalculateOperationCollectionTax $taxCalculator,
        private InputStreamInterface $inputStream,
        private OutputStreamInterface $outputStream
    ) {
    }

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $taxResults = [];

        while (true) {
            $input = $this->inputStream->prompt("Enter your operation list: ");

            if (empty($input)) {
                break;
            }

            $operationCollection = JsonInputHelper::parseJson($input);

            $validator = new OperationCollectionValidator($operationCollection);

            if ($validator->hasErrors()) {
                $this->outputStream->output('This collection structure is incorrect');
                exit();
            }

            $o = OperationCollectionFactory::fromArray($operationCollection);
            $calculatedTaxes = $this->taxCalculator->calculate($o)->toArray();

            $taxesDTO =  new OperationResultCollectionDTO($calculatedTaxes);
            $taxResults[] = $taxesDTO->toArray();
        }

        foreach ($taxResults as $tax) {
            $this->outputStream->output(json_encode($tax));
        }
    }
}
