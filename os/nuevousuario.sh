cd /home
useradd $1
echo $1:$2 > $1.tmp
chpasswd < $1.tmp
mkdir $1
chown $1 $1
rm $1.tmp
