#!/bin/bash
echo "Start time: " . `date +"%Y/%m/%d %H:%M:%S"`
DATE=`date +"%Y%m%d"`
SQLFILE=backup-${DATE}.sql
docker exec game-db /usr/bin/mysqldump -u root --password=Noname@2022 -h 127.0.0.1 --default-character-set=utf8 --single-transaction --routines --events --databases  "cgame" "vinplay" "vinplay_admin" "minigame" "vinplay_gamebai" "vinplay_minigame" "game_email" "gamepay" "adminpro" > $SQLFILE
gzip $SQLFILE
#mv backup-* /var/app/install/backup/
echo "Done: " . `date +"%Y/%m/%d %H:%M:%S"`
