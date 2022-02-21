<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared\Helper;

use App\Infrastructure\Exceptions\Shared\Helper\InvalidJsonInputException;

class JsonInputHelper
{
    public static function parseJson(string $jsonData): array
    {
        $decodedData = json_decode(
            $jsonData,
            true
        );

        if (is_null($decodedData)) {
            throw new InvalidJsonInputException("This json data seems to be in the wrong format");
        }

        return $decodedData;
    }
}
