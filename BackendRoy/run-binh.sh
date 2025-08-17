#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH;
    kill -9 $(ps aux | grep "BinhMain" | grep -v 'grep' | awk '{print $2}')
    rm -rf ../game/binh/libs/*
   
}

runBinh() {
    currentDir="../game/binh"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd ../..
    nohup java -cp "java-libs/*:game/binh/libs/*:game/binh/build/libs/binh.jar" game.binh.server.BinhMain >/dev/null 2>&1 &

    #java -cp "java-libs/*:game/Minigame/libs/*:game/Minigame/build/libs/Minigame-1.0.jar" game.MinigameMain

}
run(){
    killProcess
    runBinh
}
run
