<?php declare(strict_types=1);

namespace Example\Domain\Contracts;

use Flunt\Contract;

final class CPFContract extends Contract
{
    public function hasMinLen(string $cpf, string $property, string $message): self
    {
        if (strlen($cpf) != 11) {
            $this->notifications[$property][] = $message;
        }
        return $this;
    }

    public function validFormat(string $cpf, string $property, string $message): self
    {
        // Verify if was informed a repeated sequence of digits like as sample 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            $this->notifications[$property][] = $message;
        }
        return $this;
    }

    public function validDocument(string $cpf, string $property, string $message): self
    {
        if ($this->notifications) {
            return $this;
        }
        // Calculation to validate the document
        $cpf = str_split($cpf);
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                $this->notifications[$property][] = $message;
            }
        }
        return $this;
    }
}
