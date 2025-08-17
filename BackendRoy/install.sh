#!/bin/bash

# Absolute path to this script, e.g. /home/user/bin/foo.sh
SCRIPT=$(readlink -f "$0")
# Absolute path this script is in, thus /home/user/bin
SCRIPTPATH=$(pwd)

# kill java process
killProcess() {
    echo "Working path: " . $SCRIPTPATH;
    #kill -9 $(ps aux | grep "java -cp" | grep -v 'grep' | awk '{print $2}')
    #rm -rf */*/libs
}

# run vbee
runVbee() {
    currentDir="api/vbee"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
    nohup java -cp "libs/*:api/vbee/libs/*:api/vbee/build/libs/vbee-1.0.jar" com.vinplay.vbee.main.VBeeMain >/dev/null 2>&1 &
}
runBackend() {
    currentDir="api/VinPlayBackend"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
    nohup java -cp "libs/*:api/VinPlayBackend/libs/*:api/VinPlayBackend/build/libs/VinPlayBackend-1.0.jar" com.vinplay.api.backend.server.VinPlayBackendMain >/dev/null 2>&1 &

}
runPortal(){
  currentDir="api/VinPlayPortal"
    cd $currentDir
    ../../gradlew clean
    ../../gradlew build
    cd $SCRIPTPATH;
    nohup java -cp "libs/*:api/VinPlayPortal/libs/*:api/VinPlayPortal/build/libs/VinPlayPortal.jar" com.vinplay.api.server.JettyServer >/dev/null 2>&1 &
}
#runWspay(){
#    currentDir="api/wspay"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:api/wspay/libs/*:api/wspay/build/libs/wspay.jar" com.vinplay.pay.server.JettyServer >/dev/null 2>&1 &
#
#}

##region run game###

#runMiniGame(){
#    currentDir="game/Minigame"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:game/Minigame/libs/*:game/Minigame/build/libs/Minigame.jar" game.MiniGameMain >/dev/null 2>&1 &
#
#}
#
#runSlot(){
#    currentDir="game/slot"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/SlotMachine.jar" game.SlotMain >/dev/null 2>&1 &
#
#
#}
#### run bacay ###
#runBacay(){
#    currentDir="game/bacayServer"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/bacayServer.jar" game.bacay.server.BacayMain >/dev/null 2>&1 &
#
#
#
#}
#### run binh ###
##runBinh(){
##    currentDir="game/binh"
##    cd $currentDir
##    #../../gradlew clean
##    #../../gradlew build
##    cd $SCRIPTPATH;
##    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/binh.jar" game.binh.server.BinhMain >/dev/null 2>&1 &
##}
#### run tlmn ###
#runTienLen(){
#    currentDir="game/tlmn"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/tlmn.jar" game.tienlen.server.TlmnMain >/dev/null 2>&1 &
#
#
#}
## run Poker
#runPoker() {
#    currentDir="game/poker"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/poker.jar" game.poker.server.PokerMain >/dev/null 2>&1 &
#}
#### run Xi Dach ###
##runXiDach(){
##    currentDir="game/xizach"
# #   cd $currentDir
# #   #../../gradlew clean
##    #../../gradlew build
##    cd $SCRIPTPATH;
# #   nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/xizach.jar" game.xizach.server.XiZachMain >/dev/null 2>&1 &
##
##
##}
#
#### run bai cai ###
##runBaiCao(){
##    currentDir="game/baicao"
## #   cd $currentDir
##    #../../gradlew clean
##    #../../gradlew build
##    cd $SCRIPTPATH;
##    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/baicao.jar" game.baicao.server.BaiCaoMain >/dev/null 2>&1 &
#   #java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/baicao.jar" game.baicao.server.BaiCaoMain
#
#
##}
#
#### run xoc dia ###
#runXocDia(){
#  echo "Start building Xoc Dia..."
#    currentDir="game/xocdia"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/xocdia.jar" game.xocdia.server.XocDiaMain >/dev/null 2>&1 &
#   #java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/baicao.jar" game.baicao.server.BaiCaoMain
#   echo "Finish run Xoc Dia..."
#
#
#}

### run Sam ###
#runSam(){
#  echo "Start building Sam..."
#    currentDir="game/sam"
#    cd $currentDir
#    #../../gradlew clean
 #   #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/sam.jar" game.sam.server.SamMain >/dev/null 2>&1 &
   #java -cp "libs/*:${currentDir}/libs/*:${currentDir}/build/libs/sam.jar" game.sam.server.SamMain
#   echo "Finish run Sam..."
#}

#runGameAccess(){
#  currentDir="api/GameAccess"
#    cd $currentDir
#    #../../gradlew clean
#    #../../gradlew build
#    cd $SCRIPTPATH;
#    nohup java -cp "libs/*:api/GameAccess/libs/*:api/GameAccess/build/libs/GameAccess.jar" com.vinplay.server.JettyServer >/dev/null 2>&1 &
#}


runAllApi(){
  runVbee
  runPortal
# runWspay
  runBackend
# runGameAccess
}

main(){
  killProcess
  sleep 5
  runAllApi
  runMiniGame
  runSlot
  runTienLen
  #runXiDach
  runBacay
  runXocDia
  runBaiCao
  runSam
  #runBinh
  runPoker


}
main
