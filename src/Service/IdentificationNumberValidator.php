<?php

declare(strict_types=1);

namespace App\Service;

class IdentificationNumberValidator
{
    /**
     * check sum calculation and length of PESEL
     * @param $pesel
     * @return boolean
     */
    public function validatePesel(string $pesel): bool
    {

        $weight = [1, 3, 7, 9, 1, 3, 7, 9, 1, 3, 1];
        $sum = 0;

        // pesel has to have exactly 11 digits
        if (strlen($pesel) !== 11) {
            return false;
        } else {
            foreach (str_split($pesel) as $position => $digit) {
                $sum += $digit * $weight[$position];
            }
            return substr(strval($sum % 10), -1, 1) == 0;
        }
    }

    /**
     * check sum calculation, first number and length of Identifikationsnummer
     * @param $tin
     * @return boolean
     */
    public function validateIdentifikationsnummerl(string $tin): bool
    {
        // Identifikationsnummer has to have 11 digits
        if (strlen($tin) !== 11) {
            return false;
        } else {
            // first digit can't be 0
            if ($tin[0] == "0") {
                return false;
            } else {
                /*checking conditions:
                1) one digit appears twice or thrice times,
                2) one or two digits appear zero times
                3) all other digits appear one time*/

                $tinInArray = str_split($tin);
                $firstTenDigits = $tinInArray;
                $eleventhDigit = array_pop($tinInArray);

                $countDigits = array_count_values($firstTenDigits);
                if (count($countDigits) !== 9 && count($countDigits) !== 8) {
                    return false;
                }

                $product = 10;
                for ($i = 0; $i <= 9; $i++) {
                    $sum = ($tinInArray[$i] + $product) % 10;
                    if ($sum == 0) {
                        $sum = 10;
                    }
                    $product = ($sum * 2) % 11;
                }
                $checksum = 11 - $product;
                if ($checksum == 10) {
                    $checksum = 0;
                }
                if ($tin[10] != $checksum) {
                    return false;
                }
                return true;
            }
        }
    }
}
