#include <bits/stdc++.h>

using namespace std;

int main(){
    freopen ("BCFACTOR.inp", "r", stdin);
    freopen ("BCFACTOR.out", "w", stdout);
    long long n;
    cin >> n;
    long long dem;

    for(long long i = 2; i <= n; i++){
        dem = 0;
        while(n % i == 0){
            ++dem;
            n /= i;
        }
        if(dem){
            cout << i;
            if(dem > 0) cout << " " << dem;
            if(n > i){
                cout << "\n";
            }
        }
    }
}
