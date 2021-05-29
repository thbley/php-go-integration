<?php
/*
 * This script integrates Go code into PHP.
 *
 * Go code is compiled as a shared object file (.so) and loaded in PHP using PHP-FFI.
 * (https://www.php.net/manual/en/book.ffi.php)
 *
 * Performance of PHP and Go is compared using implementations
 * of the recursive ackermann function (https://en.wikipedia.org/wiki/Ackermann_function).
 *
 * PHP-FFI can automatically convert basic Go types (long, char*) into PHP types.
 * For using more complex data structures, I'm also providing an example using JSON strings as input and output.
 *
 * Usage:
 * go build -o ackermann.so -buildmode=c-shared ackermann.go
 * php -dopcache.enable_cli=1 -dffi.enable=1 -dopcache.jit_buffer_size=32M ackermann.php
 *
 * Example output:
 * PHP
 * - result: 16381
 * - time: 3.2073s
 * Go
 * - result: 16381
 * - time: 0.4876s
 * Go (using json as input/output)
 * - result: 16381
 * - time: 0.4840s
 *
 * In this example Go 1.16 is 9 times faster than PHP 8.0.
 *
 * Go is a statically typed, compiled programming language that offers more performance and concurrency.
 * Combining PHP and Go gives a lot of new opportunities.
 *
 * Writing and integrating PHP extensions based on C/C++ can be difficult and time consuming.
 * This can be made easier and more flexible using Go libraries and PHP-FFI.
 */

error_reporting(E_ALL);

function ackermann(int $n, int $m): int {
    if ($n == 0) {
        return $m + 1;
    } else if ($m == 0) {
        return ackermann($n - 1, 1);
    } else {
        return ackermann($n - 1, ackermann($n, $m - 1));
    }
}

$start = microtime(true);
echo 'PHP' . PHP_EOL;
echo '- result: ' . ackermann(3, 11) . PHP_EOL;
echo '- time: ' . number_format(microtime(true) - $start, 4) . 's' . PHP_EOL;


$ffi = FFI::cdef('long ackermann(long p0, long p1);', __DIR__ . '/ackermann.so');

$start = microtime(true);
echo 'Go' . PHP_EOL;
echo '- result: ' . $ffi->ackermann(3, 11) . PHP_EOL;
echo '- time: ' . number_format(microtime(true) - $start, 4) . 's' . PHP_EOL;
unset($ffi);

$ffi = FFI::cdef('char* ackermann_json(char* p0);', __DIR__ . '/ackermann.so');

$start = microtime(true);
$result = $ffi->ackermann_json(json_encode([3, 11]));
echo 'Go (using json as input/output)' . PHP_EOL;
echo '- result: ' . json_decode(FFI::string($result)) . PHP_EOL;
echo '- time: ' . number_format(microtime(true) - $start, 4) . 's' . PHP_EOL;
FFI::free($result);
unset($ffi);
