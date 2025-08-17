#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH;
    kill -9 $(ps aux | grep "GameAccess" | grep -v 'grep' | awk '{print $2}')
    rm -rf ../api/GameAccess/libs/*
   
}

runGameAccess(){
  currentDir="../api/GameAccess"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd ../..
    nohup java -cp "libs/*:api/GameAccess/libs/*:api/GameAccess/build/libs/GameAccess.jar" com.vinplay.server.JettyServer >/dev/null 2>&1 &
}


run(){
    killProcess
    runGameAccess
}
run
