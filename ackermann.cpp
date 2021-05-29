// g++ -O3 -std=c++11 -o ackermann ackermann.cpp && time ./ackermann

#include <iostream>
 
unsigned int ackermann(unsigned int m, unsigned int n) {
  if (m == 0) {
    return n + 1;
  }
  if (n == 0) {
    return ackermann(m - 1, 1);
  }
  return ackermann(m - 1, ackermann(m, n - 1));
}
 
int main() {
  std::cout << ackermann(3, 11);
}
 
