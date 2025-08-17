#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH;
    kill -9 $(ps aux | grep "BaiCaoMain" | grep -v 'grep' | awk '{print $2}')
    rm -rf ../game/baicao/libs/*
   
}

runBaicao() {
    currentDir="../game/baicao"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd ../..
    nohup java -cp "java-libs/*:game/baicao/libs/*:game/baicao/build/libs/baicao.jar" game.baicao.server.BaiCaoMain >/dev/null 2>&1 &


}
run(){
    killProcess
    runBaicao
}
run
