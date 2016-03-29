SHELL=/bin/bash
all: farthest

farthest: farthest.c
	rand=$$((500+$$RANDOM%500)) && \
	gcc -g -fno-stack-protector -mpreferred-stack-boundary=2 -m32 -DMAX_POINTS=$$rand  -o $@ $< -lm && \
	echo "// MAX_POINTS = $$rand" >> $<
	execstack -s $@

clean:
	rm -f farthest
	sed -i '/\/\/ MAX/d' farthest.c
