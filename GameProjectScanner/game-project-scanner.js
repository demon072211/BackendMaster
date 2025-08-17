// game-project-scanner.js
const fs = require('fs');
const path = require('path');

class GameProjectScanner {
    constructor(rootPath = '/var/app') {
        this.rootPath = rootPath;
        this.results = {
            structure: {},
            services: {},
            configs: {},
            gameModules: {},
            summary: {
                totalFiles: 0,
                totalFolders: 0,
                services: [],
                gameTypes: [],
                configFiles: [],
                errors: []
            }
        };
        
        // Các thư mục và file quan trọng cần scan
        this.importantPaths = {
            backends: [
                'BackendMaster',
                'Backend2Dx', 
                'BackendRoy'
            ],
            gameServices: [
                'banca',
                'txst'
            ],
            webClient: [
                'www'
            ],
            configs: [
                'install'
            ]
        };
        
        this.configFiles = [
            'gameroom.json',
            'cluster.properties',
            'bot.json',
            'config_game.properties',
            'bots.txt',
            'bots_vip.txt',
            'xocdia.properties',
            'Consts.java',
            'docker-compose.yml',
            'nginx.conf'
        ];
        
        this.gameModules = [
            'taixiu', 'xocdia', 'bacay', 'binh', 
            'lieng', 'poker', 'minipoker', 'slot'
        ];
    }

    scanDirectory(dirPath, depth = 0, maxDepth = 15) {
        if (depth > maxDepth) return null;
        
        try {
            if (!fs.existsSync(dirPath)) {
                this.results.summary.errors.push({
                    type: 'missing_directory',
                    path: dirPath,
                    error: 'Directory does not exist'
                });
                return null;
            }

            const items = fs.readdirSync(dirPath);
            const structure = {};
            
            for (const item of items) {
                const fullPath = path.join(dirPath, item);
                
                try {
                    const stats = fs.statSync(fullPath);
                    
                    if (stats.isDirectory()) {
                        this.results.summary.totalFolders++;
                        structure[item] = {
                            type: 'folder',
                            path: fullPath,
                            children: this.scanDirectory(fullPath, depth + 1, maxDepth)
                        };
                    } else {
                        this.results.summary.totalFiles++;
                        const ext = path.extname(item).toLowerCase();
                        
                        structure[item] = {
                            type: 'file',
                            size: stats.size,
                            extension: ext,
                            modified: stats.mtime,
                            path: fullPath
                        };
                        
                        // Kiểm tra file config quan trọng
                        if (this.isImportantConfigFile(item)) {
                            this.results.summary.configFiles.push(fullPath);
                        }
                    }
                } catch (error) {
                    this.results.summary.errors.push({
                        type: 'file_access_error',
                        path: fullPath,
                        error: error.message
                    });
                }
            }
            
            return structure;
        } catch (error) {
            this.results.summary.errors.push({
                type: 'directory_scan_error',
                path: dirPath,
                error: error.message
            });
            return null;
        }
    }

    isImportantConfigFile(filename) {
        return this.configFiles.some(configFile => 
            filename.toLowerCase().includes(configFile.toLowerCase()) ||
            filename.endsWith('.properties') ||
            filename.endsWith('.json') ||
            filename.endsWith('.yml') ||
            filename.endsWith('.yaml') ||
            filename.includes('config') ||
            filename.includes('Config')
        );
    }

    scanServices() {
        console.log('\n🔍 SCANNING SERVICES...');
        
        // Scan Backend Services
        this.importantPaths.backends.forEach(backend => {
            const backendPath = path.join(this.rootPath, backend);
            if (fs.existsSync(backendPath)) {
                this.results.services[backend] = this.analyzeBackendService(backendPath);
                this.results.summary.services.push(backend);
            }
        });
        
        // Scan Game Services
        this.importantPaths.gameServices.forEach(service => {
            const servicePath = path.join(this.rootPath, service);
            if (fs.existsSync(servicePath)) {
                this.results.services[service] = this.analyzeGameService(servicePath);
                this.results.summary.services.push(service);
            }
        });
    }

    analyzeBackendService(servicePath) {
        const analysis = {
            path: servicePath,
            type: 'backend_service',
            configs: [],
            gameModules: [],
            apis: [],
            scripts: []
        };
        
        try {
            // Tìm file install.sh
            const installScript = path.join(servicePath, 'install.sh');
            if (fs.existsSync(installScript)) {
                analysis.scripts.push('install.sh');
            }
            
            // Tìm gradlew
            const gradlew = path.join(servicePath, 'gradlew');
            if (fs.existsSync(gradlew)) {
                analysis.scripts.push('gradlew');
            }
            
            // Scan game modules
            this.gameModules.forEach(module => {
                const modulePath = path.join(servicePath, 'game', module);
                if (fs.existsSync(modulePath)) {
                    analysis.gameModules.push(module);
                    this.results.summary.gameTypes.push(module);
                }
            });
            
            // Scan API modules
            const apiPath = path.join(servicePath, 'api');
            if (fs.existsSync(apiPath)) {
                analysis.apis.push('VinPlayPortal');
            }
            
        } catch (error) {
            analysis.error = error.message;
        }
        
        return analysis;
    }

    analyzeGameService(servicePath) {
        const analysis = {
            path: servicePath,
            type: 'game_service',
            configs: [],
            executables: []
        };
        
        try {
            // Scan cho .jar files
            const targetPath = path.join(servicePath, 'target');
            if (fs.existsSync(targetPath)) {
                const files = fs.readdirSync(targetPath);
                files.forEach(file => {
                    if (file.endsWith('.jar')) {
                        analysis.executables.push(file);
                    }
                });
            }
            
            // Scan cho .dll files (cho BanCa)
            const publishPath = path.join(servicePath, 'BanCaLiteNet', 'publish');
            if (fs.existsSync(publishPath)) {
                analysis.executables.push('BanCaLiteNet.dll');
            }
            
        } catch (error) {
            analysis.error = error.message;
        }
        
        return analysis;
    }

    scanGameConfigs() {
        console.log('\n⚙️ SCANNING GAME CONFIGURATIONS...');
        
        this.gameModules.forEach(gameModule => {
            this.results.gameModules[gameModule] = this.analyzeGameModule(gameModule);
        });
    }

    analyzeGameModule(gameModule) {
        const analysis = {
            name: gameModule,
            configs: {},
            bots: false,
            algorithms: {},
            fees: {}
        };
        
        // Tìm config cho game module trong các backend
        this.importantPaths.backends.forEach(backend => {
            const gameConfigPath = path.join(this.rootPath, backend, 'game', gameModule);
            if (fs.existsSync(gameConfigPath)) {
                analysis.configs[backend] = this.scanGameModuleConfigs(gameConfigPath);
            }
        });
        
        return analysis;
    }

    scanGameModuleConfigs(configPath) {
        const configs = {};
        
        try {
            const confPath = path.join(configPath, 'conf');
            if (fs.existsSync(confPath)) {
                const files = fs.readdirSync(confPath);
                files.forEach(file => {
                    const filePath = path.join(confPath, file);
                    if (fs.statSync(filePath).isFile()) {
                        configs[file] = {
                            path: filePath,
                            size: fs.statSync(filePath).size
                        };
                    }
                });
            }
        } catch (error) {
            configs.error = error.message;
        }
        
        return configs;
    }

    readConfigFile(filePath, maxSize = 20000) {
        try {
            if (!fs.existsSync(filePath)) {
                return `File not found: ${filePath}`;
            }
            
            const stats = fs.statSync(filePath);
            if (stats.size > maxSize) {
                return `File too large (${this.formatFileSize(stats.size)}). Showing first ${maxSize} characters:\n\n` + 
                       fs.readFileSync(filePath, 'utf8').substring(0, maxSize) + '\n\n[TRUNCATED]';
            }
            return fs.readFileSync(filePath, 'utf8');
        } catch (error) {
            return `Error reading file: ${error.message}`;
        }
    }

    formatFileSize(bytes) {
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        if (bytes === 0) return '0 Bytes';
        const i = Math.floor(Math.log(bytes) / Math.log(1024));
        return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
    }

    generateDetailedReport() {
        console.log('='.repeat(80));
        console.log('🎮 GAME PROJECT ANALYSIS REPORT');
        console.log('='.repeat(80));
        
        // Summary
        console.log('\n📊 PROJECT SUMMARY:');
        console.log(`📁 Total Folders: ${this.results.summary.totalFolders}`);
        console.log(`📄 Total Files: ${this.results.summary.totalFiles}`);
        console.log(`🔧 Services Found: ${this.results.summary.services.length}`);
        console.log(`🎯 Game Types: ${[...new Set(this.results.summary.gameTypes)].length}`);
        console.log(`⚙️ Config Files: ${this.results.summary.configFiles.length}`);
        
        // Services
        console.log('\n🔧 SERVICES ANALYSIS:');
        Object.entries(this.results.services).forEach(([name, service]) => {
            console.log(`\n├── ${name} (${service.type})`);
            console.log(`│   ├── Path: ${service.path}`);
            if (service.scripts && service.scripts.length > 0) {
                console.log(`│   ├── Scripts: ${service.scripts.join(', ')}`);
            }
            if (service.gameModules && service.gameModules.length > 0) {
                console.log(`│   ├── Game Modules: ${service.gameModules.join(', ')}`);
            }
            if (service.executables && service.executables.length > 0) {
                console.log(`│   └── Executables: ${service.executables.join(', ')}`);
            }
        });
        
        // Game Modules
        console.log('\n🎯 GAME MODULES ANALYSIS:');
        Object.entries(this.results.gameModules).forEach(([name, module]) => {
            console.log(`\n├── ${name.toUpperCase()}`);
            Object.entries(module.configs).forEach(([backend, configs]) => {
                console.log(`│   ├── ${backend}:`);
                Object.entries(configs).forEach(([file, info]) => {
                    if (info.path) {
                        console.log(`│   │   └── ${file} (${this.formatFileSize(info.size)})`);
                    }
                });
            });
        });
        
        // Errors
        if (this.results.summary.errors.length > 0) {
            console.log('\n❌ ERRORS & WARNINGS:');
            this.results.summary.errors.forEach(error => {
                console.log(`├── ${error.type}: ${error.path}`);
                console.log(`│   └── ${error.error}`);
            });
        }
    }

    scanImportantConfigs() {
        console.log('\n📋 IMPORTANT CONFIGURATION FILES:');
        console.log('-'.repeat(60));
        
        // Scan important config files
       const importantConfigs = [
    './install/docker-compose.yml',
    './BackendMaster/VbeeCommon/src/main/java/com/vinplay/vbee/common/statics/Consts.java',
    './BackendMaster/game/tlmn/conf/gameroom.json',
    './BackendMaster/game/xocdia/config/xocdia.properties',
    './BackendMaster/game/Minigame/src/main/java/game/modules/minigame/entities/MinigameConstant.java'
];

        
        importantConfigs.forEach(configPath => {
            if (fs.existsSync(configPath)) {
                console.log(`\n📄 ${path.basename(configPath)}:`);
                console.log('-'.repeat(20));
                console.log(this.readConfigFile(configPath, 3000));
            } else {
                console.log(`\n❌ Missing: ${configPath}`);
            }
        });
    }

    generateStartupScript() {
        console.log('\n🚀 STARTUP SCRIPT GENERATION:');
        console.log('-'.repeat(40));
        
        const startupScript = `#!/bin/bash
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
`;
        
        fs.writeFileSync('./game-startup.sh', startupScript);

        console.log('Startup script saved to: /tmp/game-startup.sh');
        console.log('Make executable with: chmod +x /tmp/game-startup.sh');
    }

    run() {
        console.log(`🔍 Scanning Game Project at: ${path.resolve(this.rootPath)}`);
        
        // Scan full structure
        this.results.structure = this.scanDirectory(this.rootPath);
        
        // Analyze services
        this.scanServices();
        
        // Analyze game modules
        this.scanGameConfigs();
        
        // Generate reports
        this.generateDetailedReport();
        this.scanImportantConfigs();
        this.generateStartupScript();
        
        // Save full analysis
        const reportPath = 'game-project-analysis.json';
        fs.writeFileSync(reportPath, JSON.stringify(this.results, null, 2));
        console.log(`\n💾 Complete analysis saved to: ${reportPath}`);
        
        console.log('\n✅ Game Project Scan Complete!');
    }
}

// Usage
const scanner = new GameProjectScanner('../'); // Lùi 1 cấp để scan thư mục app

scanner.run();
