PHP example to integrate Go using PHP-FFI
------------------------------------------

Go is a statically typed, compiled programming language that offers more performance and concurrency.
Combining PHP and Go gives a lot of new opportunities.

Writing and integrating PHP extensions based on C/C++ can be difficult and time consuming.
This can be made easier and more flexible using Go libraries and PHP-FFI.

Go code can compiled as a shared object file (.so) and loaded in PHP using PHP-FFI
(see https://www.php.net/manual/en/book.ffi.php).

This example compares the performance of PHP and Go using implementations
of the recursive ackermann function (see https://en.wikipedia.org/wiki/Ackermann_function).

In this example Go 1.14 is
- 27 times faster than PHP 7.4 with OpCache disabled
- 9 times faster than PHP 7.4 with Opcache enabled
- 5 times faster than PHP 8.0 with OpCache and JTT enabled

Usage:

    go build -o ackermann.so -buildmode=c-shared ackermann.go

    php -dffi.enable=1 ackermann.php

    or:

    docker build -t php-ffi .
    docker run -it --rm -v $(pwd):/code php-ffi php /code/ackermann.php

Example output (php7.4 -dopcache.enable_cli=0 -dffi.enable=1 ackermann.php):

PHP
- result: 16381
- time: 13.0677s
Go
- result: 16381
- time: 0.4877s
Go (using json as input/output)
- result: 16381
- time: 0.4826s

Example output (php7.4 -dopcache.enable_cli=1 -dffi.enable=1 ackermann.php):

    PHP
    - result: 16381
    - time: 4.3119s
    Go
    - result: 16381
    - time: 0.4876s
    Go (using json as input/output)
    - result: 16381
    - time: 0.4840s

Example output (php8.0 -dopcache.enable=1 -dopcache.enable_cli=1 -dopcache.jit=1205 -dopcache.jit_buffer_size=64M -dffi.enable=1 ackermann.php):

PHP
- result: 16381
- time: 2.5359s
Go
- result: 16381
- time: 0.4857s
Go (using json as input/output)
- result: 16381
- time: 0.4825s

Requirements:

    Go package (https://golang.org/dl/)
    PHP 7.4+ with FFI extension enabled

Notes:

PHP-FFI can automatically convert basic Go types (long, char*) into PHP types.
For using more complex data structures, I'm also providing an example (ackermann_json())
using JSON strings as input and output.

References

- https://www.php.net/manual/en/book.ffi.php
- http://snowsyn.net/2016/09/11/creating-shared-libraries-in-go/
- https://blog.claudiupersoiu.ro/2019/12/23/a-bit-of-php-go-ffi-and-holiday-spirit/lang/en/
