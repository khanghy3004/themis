import sys
sys.stdin = open('CHANLE.INP', 'r')
sys.stdout = open('CHANLE.OUT', 'w')
n = int(input())
print('CHAN' if n%2==0)
