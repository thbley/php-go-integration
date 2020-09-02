/**
 * Example library to provide a go implementation of the recursive ackermann function.
 * This library can be loaded in PHP using PHP-FFI (https://www.php.net/manual/en/book.ffi.php).
 *
 * 2 variants of the function are provided:
 *
 * ackermann(n, m) using integers as input and output
 * ackermann_json using json strings as input and output
 *
 * examples:
 *   println(ackermann(3, 11));
 *   println(C.GoString(ackermann_json(C.CString("[3, 11]"))));
 *
 * compiling: go build -o ackermann.so -buildmode=c-shared ackermann.go
 */
package main

import "C"
import "encoding/json"

func main() {
}

//export ackermann
func ackermann(n int, m int) int {
	if n == 0 {
		return m + 1
	} else if m == 0 {
		return ackermann(n-1, 1)
	}
	return ackermann(n-1, ackermann(n, m-1))
}

//export ackermann_json
func ackermann_json(input *C.char) *C.char {
	var params [2]int

	err := json.Unmarshal([]byte(C.GoString(input)), &params)
	if err != nil {
		panic(err)
	}

	result := ackermann(params[0], params[1])

	data, err := json.Marshal(result)
	if err != nil {
		panic(err)
	}

	return C.CString(string(data))
}
