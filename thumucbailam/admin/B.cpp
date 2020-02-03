#include <bits/stdc++.h>

using namespace std;

bool use[10];
long long a[10];
long long h[10];
int g[10];
vector<int> p;
int n;
long long ans = 1000000000000000007;
long long k;

void sinhHoanVi(int cur) {
    if (cur == n) {
        long long res = 0;
        for (int i = 0; i < n; ++i) res += a[g[i]]*h[i];
        res = abs(k-res);
        if (res < ans) {
            ans = res;
            p.clear();
            for (int i = 0; i < n; ++i) p.push_back(g[i]);
        }
    } else {
        for (int tmp = 0; tmp < n; ++tmp) {
            if (!use[tmp]) {
                use[tmp] = 1;
                g[cur] = tmp;
                sinhHoanVi(cur+1);
                use[tmp] = 0;
            }
        }
    }
}

int main() {

    freopen("B.inp", "r", stdin);
    freopen("B.out", "w", stdout);

    cin >> n >> k;
    for (int i = 0; i < n; ++i) cin >> a[i];

    h[0] = 1;
    for (int i = 1; i < n; ++i) h[i] = h[i-1]*10;

    sinhHoanVi(0);

    cout << ans << endl;
    for (auto v: p) cout << v << " ";

    return 0;
}
