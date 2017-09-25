#coding=utf8
class Stack:
     def __init__(self):
         self.items = []
     def isEmpty(self):
         return self.items == []
     def push(self, item):
         self.items.append(item)
     def pop(self):
         return self.items.pop()
s = Stack()
#
def check(cc):
    left = {"(":")","[":"]","{":"}"}
    for i in cc:
        # print "i=",i
        if i in "([{":
            s.push(i)
        else:
            if s.isEmpty():
                return False
            top = s.pop()
            if left[top] != i:
                return False
    if s.isEmpty():
        return True
    else:
        return False
if __name__ == "__main__":
    print check("{{([][])}()}")
    print check("[{()]")
    print check("[{(})]")
