#include <stdio.h>

int main() {
    freopen("CHANLE.inp", "r", stdin);
    freopen("CHANLE.out", "w", stdout);
    int n;
    scanf("%d", &n);
    printf((n%2 == 0) ? "CHAN" : "LE");
    return 0;
}
