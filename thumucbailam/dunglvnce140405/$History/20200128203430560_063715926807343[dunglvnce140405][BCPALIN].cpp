#include <bits/stdc++.h>

using namespace std;

int check(int a[], int len) {
    for (int i=0; i<=len/2; i++) {
        if (a[i]!=a[len-1-i]) return 0;
    }
    return 1;
}
int main() {
    freopen ("BCPALIN.inp", "r", stdin);
    freopen ("BCPALIN.out", "w", stdout);
    int t, n, a[20];
    cin >> t;
    while(t--) {
        cin >> n;
        int k=0;
        while(n>0) {
            int temp=n%10;
            a[k]=temp;
            ++k;
            n/=10;
        }
        if(check(a, k)==1) puts("YES");
        else puts("NO");
    }
}
