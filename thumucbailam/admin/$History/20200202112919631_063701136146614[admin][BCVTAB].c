#include <stdio.h>

int main() {
    freopen("BCVTAB.inp", "r", stdin);
    freopen("BCVTAB.out", "w", stdout);
    long long x,y;
    scanf("%lld",&x);
    scanf("%lld",&y);

    printf("%lld",x+y);
    return 0;
}
