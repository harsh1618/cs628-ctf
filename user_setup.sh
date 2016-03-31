#!/bin/bash

#exit on failure
set -e

if [ $(id -u) -ne 0 ]
then
    echo "Must be running as root"
    exit 1
fi

if [ $# -ne 2 ]
then
    echo "Usage: $0 ID Username"
    exit 1
fi

set_perms() {
    local ownergroup="$1"
    local perms="$2"
    local pn="$3"
    chown $ownergroup $pn
    chmod $perms $pn
}

id=$1
username=$2
group=$2
groupadd --gid $((10000+$id)) $group
# create user, copy files from /home/cs628/skel
useradd --uid $((10000+$id)) -g $group -k /home/cs628/cs628-ctf/home -m $username
# disable password based login, probably not required if passwordless SSH login is disabled
passwd -l $username

home=/home/$username
# prevent other users from reading contents of home directory
# may need 770 if a challenge requires writing by the victim binary
set_perms $username:$group 750 $home

#generate keys for SSH
mkdir -p $home/.ssh
ssh-keygen -N '' -f $home/.ssh/id_rsa
set_perms $username:$group 700  $home/.ssh 
cp $home/.ssh/id_rsa.pub $home/.ssh/authorized_keys
set_perms $username:$group 640 $home/.ssh/authorized_keys
set_perms $username:$group 600 $home/.ssh/id_rsa
set_perms $username:$group 640 $home/.ssh/id_rsa.pub

set_bin_flag_perms () {
# Usage
# set_bin_flag_perms <relative_path_to_binary>  <relative_path_to_flag> <uid_offset_for_problem_user> <flag_id>
# flag file doesn't exist yet
    binary="$1"
    flag_path="$2"
    uid_offset="$3"
    flag_id=$4
    binid=$(($uid_offset+$id))

    /home/cs628/cs628-ctf/gen_flag.py "$flag_id" "$username" > "$home/$flag_path"
    # setuid
    set_perms $binid:$group 4750 $home/$binary
    set_perms $binid:$binid  400 $home/$flag_path
    # make the flag and the binary immutable
    chattr +i $home/$binary
    chattr +i $home/$flag_path
}

# eternal history file
set_perms root:$group 660 $home/.eternal_history
# make append only
chattr +a $home/.eternal_history
cd $home/1
make
rm dew.c Makefile
cd $home/3
make
cd $home/4
make
cd $home/5
make
cd /home/cs628/cs628-ctf
set_bin_flag_perms 1/dew 1/flag.txt 30000 1
set_bin_flag_perms 3/auth 3/flag.txt 35000 3
set_bin_flag_perms 4/hackme 4/flag.txt 40000 4
set_bin_flag_perms 5/farthest 5/flag.txt 45000 5
