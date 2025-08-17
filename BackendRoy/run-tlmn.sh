#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH;
    kill -9 $(ps aux | grep "TlmnMain" | grep -v 'grep' | awk '{print $2}')
    rm -rf ../game/tlmn/libs/*
   
}

runTlmn() {
    currentDir="../game/tlmn"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd ..
    nohup java -cp "java-libs/*:/var/app/server/libs/*:game/tlmn/build/libs/tlmn.jar" game.tienlen.server.TlmnMain >/dev/null 2>&1 &
}
run(){
    killProcess
    runTlmn
}
run
