<?php

declare(strict_types=1);

namespace App\Infrastructure\Console;

use App\Domain\Entity\Operation\OperationCollectionFactory;
use App\Domain\ValueObject\OperationType;
use App\Infrastructure\Validator\OperationCollectionValidator;
use App\Infrastructure\Shared\Helper\JsonInputHelper;
use App\Application\Command\CalculateOperationCollectionTax;
use App\Infrastructure\DTO\OperationResultCollectionDTO;

/**
 * OperationTaxCalculator
 */
class OperationTaxCalculator
{
    /**
     * __construct
     *
     * @param  mixed $taxCalculator
     * @return void
     */
    public function __construct(private CalculateOperationCollectionTax $taxCalculator)
    {
    }

    /**
     * run
     *
     * @return void
     */
    public function run()
    {
        $taxResults = [];

        while (!empty($input = readline("Enter your operation list: "))) {
            $operationCollection = JsonInputHelper::parseJson($input);

            $validator = new OperationCollectionValidator($operationCollection);

            if ($validator->hasErrors()) {
                fwrite(STDOUT, 'This collection structure is incorrect' . PHP_EOL);
                exit();
            }

            $o = OperationCollectionFactory::fromArray($operationCollection);
            $calculatedTaxes = $this->taxCalculator->calculate($o)->toArray();

            $taxesDTO =  new OperationResultCollectionDTO($calculatedTaxes);
            $taxResults[] = $taxesDTO->toArray();
        }

        foreach ($taxResults as $tax) {
            fwrite(STDOUT, json_encode($tax) . PHP_EOL);
        }
    }
}
