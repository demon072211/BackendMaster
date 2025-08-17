#!/bin/bash
# Auto-generated Game Project Startup Script
echo "Starting Game Project Services..."

# Start Docker Services
cd /var/app/install
docker-compose start

# Wait for database
sleep 30

# Configure MySQL
docker exec -it -u root game-db bash -c "mysql -u root -pAki86dh123 -e 'set global max_connections = 2000000; FLUSH PRIVILEGES;'"

# Start Backend Services
cd /var/app/BackendMaster
./install.sh &

cd /var/app/Backend2Dx  
./install.sh &

cd /var/app/BackendRoy
./install.sh &

# Start Game Services
cd /var/app/txst/target
nohup java -jar TXST-0.0.1-SNAPSHOT.jar >> txcb.out 2>&1&

cd /var/app/banca/BanCaLiteNet/publish
nohup dotnet BanCaLiteNet.dll >/dev/null 2>&1 &

echo "All services started! Check status with: sudo netstat -tulpn"
