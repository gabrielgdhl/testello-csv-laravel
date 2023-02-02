<?php

namespace App\Services\Files;

use App\Models\Prices;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Rfc4122\UuidV4;
use function PHPUnit\Framework\fileExists;

class ProcessCsvFileService
{
    public const ALLOWED_HEADERS = [
        'from_postcode',
        'to_postcode',
        'from_weight',
        'to_weight',
        'cost'
    ];

    public function process(string $file): void
    {
        $filePath = Storage::path($file);

        if (! fileExists($filePath)) {
            Throw new \Exception('File not found');
        }

        $contentFile = fopen($filePath, 'r');

        $countToHeader = 0;
        while ($row = fgetcsv($contentFile, 0, ';')) {
            if ($countToHeader === 0) {
                $this->validateHeaders($row);
                $countToHeader++;
                continue;
            }

            $this->save($row);
        }
    }

    private function save(array $row): void
    {
        $pricesEntity = new Prices();
        $pricesEntity->from_postcode = $this->isValidPostCode($row[0]);
        $pricesEntity->to_postcode = $this->isValidPostCode($row[1]);
        $pricesEntity->from_weight = $this->isValidDouble($row[2]);
        $pricesEntity->to_weight = $this->isValidDouble($row[3]);
        $pricesEntity->cost = $this->isValidDouble($row[4]);
        $pricesEntity->client_id = UuidV4::uuid4();

        $pricesEntity->save();
    }

    private function isValidPostCode(string $postCode): string
    {
        $postCodeReplaced = str_replace(['.', '-'], '', $postCode);

        if (strlen($postCodeReplaced) ==! 8 && !is_numeric($postCodeReplaced)) {
            Throw new \Exception("Invalid postcode");
        }

        return $postCode;
    }

    private function isValidDouble(string $floatValue): string
    {
        if (is_numeric($floatValue)) {
            Throw new \Exception("Invalid value");
        }

        return number_format(str_replace(",",".",str_replace(".","",$floatValue)), 2, '.', '');
    }

    private function validateHeaders(array $row): void
    {
        $error ='';
        foreach ($row as $header) {
            if (!in_array($header, self::ALLOWED_HEADERS)) {
                $error .= $header.", ";
            }
        }

        if (!empty($error)) {
            Throw new \Exception("Invalid headers ({$error})");
        }
    }

}
