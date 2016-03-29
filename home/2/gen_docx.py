#!/usr/bin/python
from docx import Document
import sys
from subprocess import check_output

if len(sys.argv) != 2:
    print "Usage: %s username" % sys.argv[0]
    exit(1)

flag = check_output(["../../gen_flag.py", "3", sys.argv[1]])
document = Document()

p = document.add_paragraph(flag)
document.save('secret.docx')
