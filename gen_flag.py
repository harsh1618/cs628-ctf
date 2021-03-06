#!/usr/bin/python
import sys
from md5 import md5

with open("flag_key", "r") as f:
    secret = f.read().strip()

if len(sys.argv) != 3:
    print "Usage: %s <flag_id> <username>" % sys.argv[0]
    exit(1)

flag = md5(secret + sys.argv[1] + sys.argv[2]).hexdigest()
print "flag{%s}" % flag
