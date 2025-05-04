<?php
/* Author: ROBERTO ALEMAN, VENTICS.COM*/
class RA_RabinKarpBinarySearcher
{
    private $pattern; // El patrón binario (string de bytes)
    private $patternLength;
    private $prime;
    private $base;
    private $patternHash;

    public function __construct(string $pattern, int $prime = 101, int $base = 256)
    {
        $this->pattern = $pattern;
        $this->patternLength = strlen($pattern);
        $this->prime = $prime;
        $this->base = $base;
        $this->patternHash = $this->calculateHash($pattern);
    }

    private function calculateHash(string $binaryData): int
    {
        $hash = 0;
        for ($i = 0; $i < strlen($binaryData); $i++) {
            $byteValue = ord($binaryData[$i]);
            $hash = ($this->base * $hash + $byteValue) % $this->prime;
        }
        return $hash;
    }

    public function search(string $binaryText): array
    {
        $textLength = strlen($binaryText);
        $occurrences = [];

        if ($this->patternLength > $textLength) {
            return $occurrences;
        }

        $firstChunk = substr($binaryText, 0, $this->patternLength);
        $textHash = $this->calculateHash($firstChunk);

        if ($this->patternHash === $textHash && $this->pattern === $firstChunk) {
            $occurrences[] = 0;
        }

        $power = 1;
        for ($i = 0; $i < $this->patternLength - 1; $i++) {
            $power = ($power * $this->base) % $this->prime;
        }

        for ($i = $this->patternLength; $i < $textLength; $i++) {
            $outgoingByteValue = ord($binaryText[$i - $this->patternLength]);
            $incomingByteValue = ord($binaryText[$i]);

            // Recalcular el hash de la ventana deslizante
            $textHash = ($this->base * ($textHash - $outgoingByteValue * $power) + $incomingByteValue) % $this->prime;

            // Asegurarse de que el hash sea positivo
            if ($textHash < 0) {
                $textHash += $this->prime;
            }

            $currentChunk = substr($binaryText, $i - $this->patternLength + 1, $this->patternLength);

            // Comparar los hashes y verificar la coincidencia binaria
            if ($this->patternHash === $textHash && $this->pattern === $currentChunk) {
                $occurrences[] = $i - $this->patternLength + 1;
            }
        }

        return $occurrences;
    }
}

// Ejemplo de uso con datos binarios:
$binaryText = "\x41\x42\x41\x42\x44\x41\x42\x43\x41\x42\x41\x42"; // Representación hexadecimal de "ABAB DABCABAB"
$binaryPattern = "\x41\x42\x41\x42";                               // Representación hexadecimal de "ABAB"

$searcherBinary = new RA_RabinKarpBinarySearcher($binaryPattern);
$resultadosBinary = $searcherBinary->search($binaryText);

if (!empty($resultadosBinary)) {
    echo "El patrón binario fue encontrado en las siguientes posiciones (en bytes): " . implode(", ", $resultadosBinary) . "<br/>";
} else {
    echo "El patrón binario no fue encontrado en el texto binario.<br/>";
}

$binaryText2 = file_get_contents(__FILE__); // Buscar el propio código fuente como binario (ejemplo)
$binaryPattern2 = "RA_RabinKarpBinarySearcher";

$searcherBinary2 = new RA_RabinKarpBinarySearcher($binaryPattern2);
$resultadosBinary2 = $searcherBinary2->search($binaryText2);

if (!empty($resultadosBinary2)) {
    echo "El patrón '" . $binaryPattern2 . "' fue encontrado en las siguientes posiciones (en bytes) dentro de este archivo: " . implode(", ", $resultadosBinary2) . "<br/>";
} else {
    echo "El patrón '" . $binaryPattern2 . "' no fue encontrado en este archivo.<br/>";
}

?>