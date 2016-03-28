#include<stdio.h>
#include<string.h>

int main()
{
    char *ptr;
    FILE *fp;
    size_t written = 0;
    char message[256], file_flag[40], user_flag[40];

    fp = fopen("flag.txt", "r");
    fscanf(fp, "%39s", file_flag);

    printf("Enter the flag\n");
    scanf("%39s", user_flag);

    ptr = message;
    snprintf(ptr, 10, "You said ");
    written += 9;
    size_t len = snprintf(ptr + written, sizeof(message) - written, user_flag);
    if (len > sizeof(message)-written) len = sizeof(message)-written-1;
    written += len;

    if (strcmp(user_flag, file_flag) == 0) {
        snprintf(ptr + written, sizeof(message) - written, " which is correct!!\n");
    }
    else {
        snprintf(ptr + written, sizeof(message) - written, " which is incorrect!!\n");
    }

    printf("%s\n", message);
    return 0;
}
