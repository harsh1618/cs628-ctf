#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <unistd.h>

void read_flag()
{
    system("/bin/cat flag.txt");
}

void safe_strcpy(char *out, int outl, char *in)
{
  int i, len;

  len = strlen(in);
  if (len > outl)
    len = outl;

  for (i = 0; i <= len; i++)
    out[i] = in[i];
}

void bar(char *arg)
{
  char buf[200];
  safe_strcpy(buf, sizeof buf, arg);
}

void foo(char *argv[])
{
  int *p;
  int a = 0;
  p = &a;
  bar(argv[1]);
  *p = a;
  _exit(0);
  /* foo does not return */
}

int main(int argc, char *argv[])
{
    if (argc != 2)
    {
        fprintf(stderr, "One argument required\n");
        exit(1);
    }
    getchar();
    foo(argv);
    return 0;
}
