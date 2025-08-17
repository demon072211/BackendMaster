#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH;
    kill -9 $(ps aux | grep "XiZachMain" | grep -v 'grep' | awk '{print $2}')
    rm -rf ../game/xizach/libs/*
   
}

runXiDach() {
   currentDir="../game/xizach"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
   cd ../..
    nohup java -cp "java-libs/*:game/xizach/libs/*:game/xizach/build/libs/binh-1.0.jar" game.xizach.server.XiZachMain >/dev/null 2>&1 &
}
run(){
    killProcess
    runXiDach
}
run
