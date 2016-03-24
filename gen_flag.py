#!/usr/bin/python
import sys
from md5 import md5

secret = "XXXXXXXXXXXXXXXXXXXXXX"

if len(sys.argv) != 3:
    print "Usage: %s <random1> <random2>" % sys.argv[0]
    exit(1)

flag = md5(secret + sys.argv[1] + sys.argv[2]).hexdigest()
print "flag{%s}" % flag
