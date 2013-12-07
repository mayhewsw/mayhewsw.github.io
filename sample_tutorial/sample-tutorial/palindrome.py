#!/usr/bin/python

def isPalindrome(n):
    ''' Decides if n is a palindrome '''
    nospace = "".join((str(n).split()))
    nospace_reverse = list(nospace)
    nospace_reverse.reverse()
    return "".join(nospace_reverse) == nospace

if __name__ == "__main__":
    print isPalindrome("a man a plan a canal panama")
    print isPalindrome("fourscore and seven years ago...")
    print isPalindrome(4554)
