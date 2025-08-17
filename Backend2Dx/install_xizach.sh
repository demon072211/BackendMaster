#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH
    kill -9 $(ps aux | grep "java -cp" | grep 'xizach' | awk '{print $2}')
    #rm -rf */*/libs
}

# run Binh
runBinh() {
	echo "runBinh"
    currentDir="game/binh"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
nohup java -cp "java-libs/*:game/xizach/libs/*:game/xizach/build/libs/xizach-1.0.jar" game.xizach.server.XizachMain cluster1 console  >/dev/null 2>&1 &
   # nohup java -cp "java-libs/*:game/binh/libs/*:game/binh/build/libs/binh-1.0.jar" game.binh.server.BinhMain >/dev/null 2>&1 &
}

main() {
  killProcess
  runBinh
}
main
