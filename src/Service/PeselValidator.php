<?php

declare(strict_types=1);

namespace App\Service;

class PeselValidator
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

        if (strlen($pesel) !== 11) {
            return false;
        } else {
            foreach (str_split($pesel) as $position => $digit) {
                $sum += $digit * $weight[$position];
            }
            return substr(strval($sum % 10), -1, 1) == 0;
        }
    }
}
