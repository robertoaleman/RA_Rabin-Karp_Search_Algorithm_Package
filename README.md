# RA_RabinKarpSearcher
This class uses the Rabin-Karp algorithm to find occurrences of a given pattern within a standard text string.

#Searching is available in three modes:

* Searching in ASCII text files
* Searching in hexadecimal code files
* Searching in binary code files

The documentation explains how to use each type of search and its purpose.
--------------
# Documentation for Rabin-Karp Searcher Classes (PHP)

This document provides instructions on how to use the three Rabin-Karp searcher classes implemented in PHP: `RabinKarpSearcher` for standard text, `RabinKarpBase16Searcher` for hexadecimal encoded data, and `RabinKarpBinarySearcher` for raw binary data.

## 1. `RabinKarpSearcher` (Standard Text Search)

This class is used to find occurrences of a given pattern within a standard text string.

**Usage:**

1.  **Include the class file:**
    ```php
    <?php
    require_once 'path/to/RabinKarpSearcher.php'; // Replace with the actual path
    ?>
    ```

2.  **Instantiate the `RabinKarpSearcher` class:**
    Create an instance of the `RabinKarpSearcher` class, providing the pattern you want to search for as the first argument to the constructor. You can optionally specify a prime number and a base for the hash calculation (default values are 101 and 256, respectively).
    ```php
    $pattern = "your_search_pattern";
    $searcher = new RabinKarpSearcher($pattern);

    // You can also specify prime and base:
    // $searcher = new RabinKarpSearcher($pattern, 131, 512);
    ```

3.  **Perform the search:**
    Call the `search()` method of the `$searcher` object, passing the text you want to search within as the argument. This method will return an array containing the starting indices (0-based) of all occurrences of the pattern in the text.
    ```php
    $text = "the_text_to_search_within";
    $results = $searcher->search($text);

    if (!empty($results)) {
        echo "Pattern found at positions: " . implode(", ", $results) . "\n";
    } else {
        echo "Pattern not found.\n";
    }
    ```

**Example:**

```php
<?php
require_once 'RabinKarpSearcher.php';

$text = "ABABDABACDABABCABAB";
$pattern = "ABAB";
$searcher = new RabinKarpSearcher($pattern);
$results = $searcher->search($text);

if (!empty($results)) {
    echo "Pattern '" . $pattern . "' found at positions: " . implode(", ", $results) . "\n";
} else {
    echo "Pattern '" . $pattern . "' not found.\n";
}
?>
