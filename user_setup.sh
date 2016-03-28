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
useradd --uid $((10000+$id)) -g $group -k /home/cs628/skel -m $username
# disable password based login, probably not required if passwordless SSH login is disabled
passwd -l $username

home=/home/$username
# prevent other users from reading contents of home directory
# may need 770 if a challenge requires writing by the victim binary
set_perms $username:$group 750 $home

#generate keys for SSH
mkdir -p $home/.ssh
ssh-keygen -f $home/.ssh/id_rsa
set_perms $username:$group 700  $home/.ssh 
cp $home/.ssh/id_rsa.pub $home/.ssh/authorized_keys
set_perms $username:$group 640 $home/.ssh/authorized_keys
set_perms $username:$group 600 $home/.ssh/id_rsa
set_perms $username:$group 640 $home/.ssh/id_rsa.pub

set_bin_flag_perms () {
# Usage
# set_bin_flag_perms <relative_path_to_binary> <relative_path_to_flag> <uid_offset_for_problem_user>
# flag file doesn't exist yet
    binary="$1"
    flag="$2"
    uid_offset="$3"
    binid=$(($uid_offset+$id))

    ./gen_flag.py "$flag" "$username" > "$home/$flag"
    # setuid
    set_perms $binid:$group 4750 $home/$binary
    set_perms $binid:$binid  400 $home/$flag
    # make the flag and the binary immutable
    chattr +i $home/$binary
    chattr +i $home/$flag
}

# eternal history file
set_perms root:$group 660 $home/.eternal_history
# make append only
chattr +a $home/.eternal_history

set_bin_flag_perms 1/dew 1/flag 30000
