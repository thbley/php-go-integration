PHP Example to integrate Go using PHP-FFI
------------------------------------------

Go is a statically typed, compiled programming language that offers more performance and concurrency.
Combining PHP and Go gives a lot of new opportunities.

Writing and integrating PHP extensions based on C/C++ can be difficult and time consuming.
This can be made easier and more flexible using Go libraries and PHP-FFI.

Go code can compiled as a shared object file (.so) and loaded in PHP using PHP-FFI.
(see https://www.php.net/manual/en/book.ffi.php)

This example compares the performance of PHP and Go using implementations
of the recursive ackermann function (see https://en.wikipedia.org/wiki/Ackermann_function).
In this example Go 1.14 is 27 times faster than PHP 7.4.

Usage:

    go build -o ackermann.so -buildmode=c-shared ackermann.go

    php ackermann.php

Requirements:

    Go package (https://golang.org/dl/)

    PHP 7.4+

Notes:

PHP-FFI can automatically convert basic Go types (long, char*) into PHP types.
For using more complex data structures, I'm also providing an example (ackermann_json)
using JSON strings as input and output.
