#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(dirname "$SCRIPT")

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH
   # kill -9 $(ps aux | grep "java -cp" | grep -v 'grep' | awk '{print $2}')
    #rm -rf */*/libs
}
runVbee() {
    currentDir="api/vbee"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
    nohup java -cp "java-libs/*:api/vbee/libs/*:api/vbee/build/libs/vbee-1.0.jar" com.vinplay.vbee.main.VBeeMain >/dev/null 2>&1 &
}
runVinPlayPortal() {
    currentDir="api/VinPlayPortal"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
    nohup java -cp "java-libs/*:api/VinPlayPortal/libs/*:api/VinPlayPortal/build/libs/VinPlayPortal-1.0.jar" com.vinplay.api.server.VinPlayPortal >/dev/null 2>&1 &
}
# runVinPlayBackend() {
#     currentDir="api/VinPlayBackend"
#     cd $currentDir
#      ../../gradlew clean
#     ../../gradlew build
#     cd $SCRIPTPATH;
#     nohup java -cp "java-libs/*:api/VinPlayBackend/libs/*:api/VinPlayBackend/build/libs/VinPlayBackend-1.0.jar" com.vinplay.api.backend.server.VinPlayBackendMain >/dev/null 2>&1 &
# }
runMinigame() {
    echo "Start building MiniGame..."
    currentDir="game/Minigame"
    cd $currentDir
     ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
    nohup java -cp "java-libs/*:game/Minigame/libs/*:game/Minigame/build/libs/Minigame-1.0.jar" game.MinigameMain >/dev/null 2>&1 &
    echo "Finish run Minigame..."
}
runBaicao() {
   currentDir="game/baicao"
   cd $currentDir
    ../../gradlew clean
   ../../gradlew build
   cd $SCRIPTPATH;
   nohup java -cp "java-libs/*:game/baicao/libs/*:game/baicao/build/libs/baicao-1.0.jar" game.baicao.server.BaicaoMain >/dev/null 2>&1 &
   }
runBinh() {
   currentDir="game/binh"
   cd $currentDir
    ../../gradlew clean
   ../../gradlew build
   cd $SCRIPTPATH;
   nohup java -cp "java-libs/*:game/binh/libs/*:game/binh/build/libs/binh-1.0.jar" game.binh.server.BinhMain >/dev/null 2>&1 &
   }
runLieng() {
   currentDir="game/lieng"
   cd $currentDir
    ../../gradlew clean
   ../../gradlew build
   cd $SCRIPTPATH;
   nohup java -cp "java-libs/*:game/lieng/libs/*:game/lieng/build/libs/lieng-1.0.jar" game.lieng.server.LiengMain >/dev/null 2>&1 &
   }
runPoker() {
   currentDir="game/poker"
   cd $currentDir
    ../../gradlew clean
   ../../gradlew build
   cd $SCRIPTPATH;
   nohup java -cp "java-libs/*:game/poker/libs/*:game/poker/build/libs/poker-1.0.jar" game.poker.server.PokerMain >/dev/null 2>&1 &
   }
runSam() {
   currentDir="game/sam"
   cd $currentDir
    ../../gradlew clean
   ../../gradlew build
   cd $SCRIPTPATH;
   nohup java -cp "java-libs/*:game/sam/libs/*:game/sam/build/libs/sam-1.0.jar" game.sam.server.SamMain >/dev/null 2>&1 &
   }
main() {
  killProcess
  runVbee
  runVinPlayPortal
  runVinPlayBackend
  runWspay
  runMinigame
  runBaicao
  runBinh
  runLieng
  runPoker
  runSam
}
main
