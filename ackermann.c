// gcc -O3 -o ackermann ackermann.c && time ./ackermann

#include <stdio.h>
 
int ackermann(int m, int n)
{
        if (!m) return n + 1;
        if (!n) return ackermann(m - 1, 1);
        return ackermann(m - 1, ackermann(m, n - 1));
}
 
int main()
{
	printf("%d", ackermann(3, 11));
}
