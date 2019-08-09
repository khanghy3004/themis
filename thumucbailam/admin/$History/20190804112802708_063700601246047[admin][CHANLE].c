#include <stdio.h>
#include <math.h>

int main() {
    freopen("CHANLE.inp", "r", stdin);
    freopen("CHANLE.out", "w", stdout);
    int n;
    scanf("%ld", &n);
    if(n%2==1) puts("LE") else puts("CHAN");
}
