# -*- coding: utf-8 -*-
"""
Created on Sat Mar 16 05:19:19 2019

@author: YangTaeLIn

def solution(v):
    answer = []
    
    if v[0][0] == v[1][0] or v[0][1] == v[1][1]:
        if v[0][0] == v[2][0] or v[0][1] == v[2][1]:
            answer = [v[1][0]+v[2][0]-v[0][0],v[1][1]+v[2][1]-v[0][1]]
        else:
            answer = [v[0][0]+v[2][0]-v[1][0],v[0][1]+v[2][1]-v[1][1]]
        
    else:
        answer = [v[0][0]+v[1][0]-v[2][0],v[0][1]+v[1][1]-v[2][1]]
        

    return answer

a, b = map(int, input().strip().split(' '))
#print(a + b)
for fir in range(b):
    for fir in range(a):
        print("*",end='')
    print("\n")        


def solution(s):
    answer = ''
    if(len(s)%2 == 1):
        answer = s[(len(s)//2)]
    else:
        answer = s[(len(s)//2)-1,(len(s)//2)]
    return answer


a, b = map(int, input().strip().split(' '))
#print(a + b)
for fir in range(b):
    for fir in range(a):
        print("*",end='')   
    print("\n",end='')

N = int(input())
an = []
#print(a + b)
for i in range(1, N+1):
    if N % i == 0:
        an.append(i) 
if len(an)%2 != 0:
    print(0)
else:
    print(an[len(an)//2]-an[len(an)//2-1])
       
giho = input()
won = []
soo = []
for i in giho:
    if i.isupper():
        won.append(i)
    elif i.islower():
        won[len(won)-1] += i
    elif i.isdigit():
        soo.append(i)
if len(won) != len(soo):
    print("error")
else:
    for i in range(len(won)):
        print(won[i],end="")
        if soo[i]!="1":
            print(soo[i],end="")
#print(a + b) 

num = int(input())
build=[]
max = 0
for i in range(num):
    build.append(int(input()))
for i in range(num):
    for j in range(i+1,num):
        if build[j] >= build[i]:
            if max < j - i:
                max = j -i
                break
"""     


