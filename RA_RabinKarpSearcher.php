<?php
/* Author: ROBERTO ALEMAN, VENTICS.COM*/
class RA_RabinKarpSearcher
{
    private $pattern;
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

    private function calculateHash(string $text): int
    {
        $hash = 0;
        for ($i = 0; $i < strlen($text); $i++) {
            $hash = ($this->base * $hash + ord($text[$i])) % $this->prime;
        }
        return $hash;
    }

    public function search(string $text): array
    {
        $textLength = strlen($text);
        $occurrences = [];

        if ($this->patternLength > $textLength) {
            return $occurrences;
        }

        $textHash = $this->calculateHash(substr($text, 0, $this->patternLength));

        if ($this->patternHash === $textHash && $this->pattern === substr($text, 0, $this->patternLength)) {
            $occurrences[] = 0;
        }

        $power = 1;
        for ($i = 0; $i < $this->patternLength - 1; $i++) {
            $power = ($power * $this->base) % $this->prime;
        }

        for ($i = $this->patternLength; $i < $textLength; $i++) {
            // Recalcular el hash de la ventana deslizante
            $textHash = ($this->base * ($textHash - ord($text[$i - $this->patternLength]) * $power) + ord($text[$i])) % $this->prime;

            // Asegurarse de que el hash sea positivo
            if ($textHash < 0) {
                $textHash += $this->prime;
            }

            // Comparar los hashes y verificar la coincidencia (para evitar colisiones)
            if ($this->patternHash === $textHash && $this->pattern === substr($text, $i - $this->patternLength + 1, $this->patternLength)) {
                $occurrences[] = $i - $this->patternLength + 1;
            }
        }

        return $occurrences;
    }
}

// Ejemplo de uso:
$text = "ABABDABACDABABCABAB";
$pattern = "ABAB";
$searcher = new RA_RabinKarpSearcher($pattern);
$resultados = $searcher->search($text);

if (!empty($resultados)) {
    echo "El patrón '" . $pattern . "' fue encontrado en las siguientes posiciones: " . implode(", ", $resultados) . "<br/>";
} else {
    echo "El patrón '" . $pattern . "' no fue encontrado en el texto.<br/>";
}

$text2 = "el veloz murciélago hindú comía feliz cardillo y kiwi";
$pattern2 = "murciélago";
$searcher2 = new RA_RabinKarpSearcher($pattern2);
$resultados2 = $searcher2->search($text2);

if (!empty($resultados2)) {
    echo "El patrón '" . $pattern2 . "' fue encontrado en las siguientes posiciones: " . implode(", ", $resultados2) . "<br/>";
} else {
    echo "El patrón '" . $pattern2 . "' no fue encontrado en el texto.<br/>";
}

?>