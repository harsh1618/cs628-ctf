all: hackme

hackme: hackme.c
	gcc -g -fno-stack-protector -mpreferred-stack-boundary=2 -m32 -o $@ $<
