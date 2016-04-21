#!/bin/sh

# Restrict access to dmesg
echo "kernel.dmesg_restrict=1" >> /etc/sysctl.conf
# Turn off ASLR
echo "kernel.randomize_va_space=0" >> /etc/sysctl.conf

# Hide processes. Adding this to /etc/fstab doesn't work in Ubuntu 12.04
# See https://bugs.launchpad.net/ubuntu/+source/mountall/+bug/1039887
mount -o remount,hidepid=2 /proc

chmod 1733 /tmp /var/tmp /dev/shm

cp limits.conf /etc/security/limits.d/ctf.conf
