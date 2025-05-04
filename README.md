# RA Rabin-Karp Search Algorithm PHP Class Package
This class uses the Rabin-Karp algorithm to find occurrences of a given pattern within a standard text string.

# Searching is available in three modes:

1. Searching in ASCII text files
2. Searching in hexadecimal code files
3. Searching in binary code files

* The RabinKarpSearcher class serves to locate occurrences of a specific text pattern within a larger body of standard text. You initialize it with the pattern you're looking for, and then you can search any text string for all instances of that pattern. It's useful for tasks like finding words or phrases in documents, basic text analysis, or implementing simple search functionalities within text-based applications.

* The RabinKarpBase16Searcher class is designed for searching within data that is encoded in hexadecimal format. You provide it with a pattern also in hexadecimal representation, and it will find all occurrences of that byte sequence within a hexadecimal text. This is particularly helpful in scenarios like analyzing binary data represented as hex strings, such as in debugging, reverse engineering, or examining network traffic dumps where data is often viewed in this format.

* Finally, the RabinKarpBinarySearcher class allows you to search for a specific sequence of bytes directly within raw binary data. You provide the pattern as a string of bytes, and it will find all instances of that exact byte sequence within another binary string. This is essential for tasks like analyzing binary files (executables, images, etc.), performing forensic analysis on raw data, or working with low-level data streams where the byte representation is critical.


----------------------------
# What is the Rabin-Karp Algorithm?

The Rabin-Karp algorithm is a string-searching algorithm devised by Michael O. Rabin and Richard M. Karp in 1987. Its main feature is the use of a hash function to find exact matches of a pattern within a text. Instead of directly comparing the pattern with every possible substring in the text (as a brute-force search algorithm would do), Rabin-Karp calculates a hash value for the pattern and then calculates the hash values ​​of substrings of the same length. If the hash values ​​match, there is a high probability that the substrings are identical, and only then is a character-by-character comparison performed to confirm the actual match.

# A Brief History

The Rabin-Karp algorithm was introduced in 1987 by Michael O. Rabin and Richard M. Karp as an alternative to existing string-searching algorithms. Its goal was to improve search efficiency, especially in cases where the pattern or text is very long, or when multiple patterns need to be searched. The key idea was to use hashing to reduce the number of direct string comparisons, which can be costly in terms of computational time.

The algorithm's main innovation lies in its use of a "rolling hash." This technique allows the hash value of the next substring of the text to be calculated efficiently, using the hash value of the previous substring, without having to recalculate the entire hash from scratch at each step. This makes the process of comparing hashes across the text very fast.

Although in the worst case (due to hash collisions, where different strings produce the same hash value) the Rabin–Karp algorithm can have a similar time complexity to brute-force search, in practice and with a well-designed hash function, its average performance is much better, which has made it a useful algorithm in various applications, from text search to plagiarism detection and DNA sequence analysis.

-------------------------------

# Applications

In critical applications, the RA_RabinKarpSearcher (ASCII) class can be used to detect specific patterns in system or application logs, where rapid identification of textual event sequences (such as critical errors or unauthorized access attempts) is crucial for immediate response. It could also be used in systems monitoring the integrity of configuration text files, alerting to unexpected modifications that could compromise system security or functionality.

The RA_RabinKarpBase16Searcher (Hexadecimal) class is valuable in digital forensics and system security. It can be used to search for specific malware signatures or patterns of malicious activity within memory dumps or binary files represented in hexadecimal. In network-level intrusion detection systems (IDS), it could help identify binary patterns in network traffic that match known attack signatures, enabling early threat mitigation.

The RA_RabinKarpBinarySearcher class is essential for low-level security and firmware analysis. It can be used to search for specific byte sequences that represent known vulnerabilities or backdoors in the binary code of operating systems or embedded devices. In industrial control environments or critical systems where unauthorized modifications at the binary level can have serious consequences, this class enables accurate detection of potentially dangerous alterations.

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
    require_once 'path/to/RA_RabinKarpSearcher.php'; // Replace with the actual path
    ?>
    ```

2.  **Instantiate the `RA_RabinKarpSearcher` class:**
    Create an instance of the `RA_RabinKarpSearcher` class, providing the pattern you want to search for as the first argument to the constructor. You can optionally specify a prime number and a base for the hash calculation (default values are 101 and 256, respectively).
    ```php
    $pattern = "your_search_pattern";
    $searcher = new RA_RabinKarpSearcher($pattern);

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
require_once 'RA_RabinKarpSearcher.php';

$text = "ABABDABACDABABCABAB";
$pattern = "ABAB";
$searcher = new RA_RabinKarpSearcher($pattern);
$results = $searcher->search($text);

Note:In each of the classes there are examples of use

if (!empty($results)) {
    echo "Pattern '" . $pattern . "' found at positions: " . implode(", ", $results) . "\n";
} else {
    echo "Pattern '" . $pattern . "' not found.\n";
}
?>
```

## Note: In each of the classes there are examples of use
