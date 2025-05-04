<?php
/* Author: ROBERTO ALEMAN, VENTICS.COM*/
class RA_RabinKarpBase16Searcher
{
    private $pattern;
    private $patternLength;
    private $prime;
    private $base;
    private $patternHash;

    public function __construct(string $pattern, int $prime = 101)
    {
        $this->pattern = $this->sanitizeBase16Pattern($pattern);
        $this->patternLength = strlen($this->pattern) / 2; // Cada byte se representa con 2 caracteres hex
        $this->prime = $prime;
        $this->base = 16; // Base para hexadecimal
        $this->patternHash = $this->calculateHash($this->pattern);
    }

    private function sanitizeBase16Pattern(string $pattern): string
    {
        // Eliminar cualquier carácter no hexadecimal y convertir a mayúsculas
        return strtoupper(preg_replace('/[^0-9A-F]/', '', $pattern));
    }

    private function hexToDec(string $hex): int
    {
        return hexdec($hex);
    }

    private function calculateHash(string $hexText): int
    {
        $hash = 0;
        for ($i = 0; $i < strlen($hexText); $i += 2) {
            $byte = substr($hexText, $i, 2);
            $decimalValue = $this->hexToDec($byte);
            $hash = ($this->base * $hash + $decimalValue) % $this->prime;
        }
        return $hash;
    }

    public function search(string $hexText): array
    {
        $sanitizedHexText = $this->sanitizeBase16Pattern($hexText);
        $textLength = strlen($sanitizedHexText) / 2;
        $occurrences = [];

        if ($this->patternLength > $textLength) {
            return $occurrences;
        }

        $firstHexChunk = substr($sanitizedHexText, 0, $this->patternLength * 2);
        $textHash = $this->calculateHash($firstHexChunk);

        if ($this->patternHash === $textHash && $this->compareHexSubstrings($firstHexChunk, $this->pattern)) {
            $occurrences[] = 0;
        }

        $power = 1;
        for ($i = 0; $i < $this->patternLength - 1; $i++) {
            $power = ($power * $this->base) % $this->prime;
        }

        for ($i = $this->patternLength * 2; $i < strlen($sanitizedHexText); $i += 2) {
            $outgoingHexByte = substr($sanitizedHexText, $i - $this->patternLength * 2, 2);
            $incomingHexByte = substr($sanitizedHexText, $i, 2);

            $outgoingDecValue = $this->hexToDec($outgoingHexByte);
            $incomingDecValue = $this->hexToDec($incomingHexByte);

            // Recalcular el hash de la ventana deslizante
            $textHash = ($this->base * ($textHash - $outgoingDecValue * $power) + $incomingDecValue) % $this->prime;

            // Asegurarse de que el hash sea positivo
            if ($textHash < 0) {
                $textHash += $this->prime;
            }

            $currentHexChunk = substr($sanitizedHexText, $i - $this->patternLength * 2 + 2, $this->patternLength * 2);

            // Comparar los hashes y verificar la coincidencia
            if ($this->patternHash === $textHash && $this->compareHexSubstrings($currentHexChunk, $this->pattern)) {
                $occurrences[] = ($i / 2) - $this->patternLength + 1;
            }
        }

        return $occurrences;
    }

    private function compareHexSubstrings(string $hexSubstr1, string $hexSubstr2): bool
    {
        return $hexSubstr1 === $hexSubstr2;
    }
}

// Ejemplo de uso con Base16:
$hexText = "41BABA44C141BAB2"; // Representación hexadecimal de "ABABA.A.B" (aproximadamente)
$hexPattern = "41BA";      // Representación hexadecimal de "AB"
$searcherBase16 = new RA_RabinKarpBase16Searcher($hexPattern);
$resultadosBase16 = $searcherBase16->search($hexText);

if (!empty($resultadosBase16)) {
    echo "El patrón hexadecimal '" . $hexPattern . "' fue encontrado en las siguientes posiciones (en bytes): " . implode(", ", $resultadosBase16) . "<br/>";
} else {
    echo "El patrón hexadecimal '" . $hexPattern . "' no fue encontrado en el texto hexadecimal.<br/>";
}

$hexText2 = "74686520717569636B2062726F776E20666F78"; // "the quick brown fox" en hex
$hexPattern2 = "717569636B";                               // "quick" en hex
$searcherBase16_2 = new RA_RabinKarpBase16Searcher($hexPattern2);
$resultadosBase16_2 = $searcherBase16_2->search($hexText2);

if (!empty($resultadosBase16_2)) {
    echo "El patrón hexadecimal '" . $hexPattern2 . "' fue encontrado en las siguientes posiciones (en bytes): " . implode(", ", $resultadosBase16_2) . "<br/>";
} else {
    echo "El patrón hexadecimal '" . $hexPattern2 . "' no fue encontrado en el texto hexadecimal.<br/>";
}

?>