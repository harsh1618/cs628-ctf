#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>

#define MAX_POINTS 1000

struct point {
  double x;
  double y;
};

double dist(struct point a, struct point b)
{
    return sqrt(pow(a.x - b.x, 2) + pow(a.y - b.y, 2));
}

double farthest(char *in, int count)
{
    int i, j;
    double max = -1, dis;
    struct point buf[MAX_POINTS];

    if (count < MAX_POINTS) {
        memcpy(buf, in, count * sizeof(struct point));
        for (i = 0; i < count; i++) {
            for (j = i+1; j < count; j++) {
                dis = dist(buf[i], buf[j]);
                if (dis > max)
                    max = dis;
            }
        }
        return max;
    }
    else
        printf("Too many points\n");
    return -1;
}

int main(int argc, char *argv[])
{
    int num_points;
    char *in;

    if (argc != 2)
    {
        fprintf(stderr, "One argument required\n");
        exit(1);
    }

    /*
     * format of argv[1]
     * <num_points>,<array of 'num_points' struct points>
     * count should be human readable.
     * Rest of the data should be binary.
     */

    num_points = (int)strtoul(argv[1], &in, 10);
    if (*in != ',') {
        fprintf(stderr, "Wrong format\n");
        exit(1);
    }
    in++; /* skip the comma */
    farthest(in, num_points);

    return 0;
}
