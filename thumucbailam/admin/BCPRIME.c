#include <stdio.h>
#include <math.h>

int main() {
    freopen("BCPRIME.inp", "r", stdin);
    freopen("BCPRIME.out", "w", stdout);
    long n,i;
    int kt = 0;
    scanf("%ld", &n);
    if (n<2) puts("NO");
    else {
        for (i=2;i<=sqrt(n);i++) if (n%i==0) kt++;
        if (kt==0) puts("YES"); else puts("NO");
    }
}
