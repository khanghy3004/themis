#include <bits/stdc++.h>

using namespace std;


int main() {
    freopen ("BCFACT.inp", "r", stdin);
    freopen ("BCFACT.out", "w", stdout);
    long long i, n, gt;
    while(n!=0)
    {
        gt = 1;
        cin >> n;
        for(i=1;i<=n;i++)
            gt*=i;
        if(n!=0)
            cout << gt << endl;
    }
}
