SHELL=/bin/bash

echo "Begin upload dependencies"
curl -s http://getcomposer.org/installer | php
php composer.phar install

echo "Begin setup project"
if [ ! -d "data" ]; then
    mkdir --mode=0777 data
fi

cd data

if [ ! -d "cache" ]; then
    mkdir --mode=0777 cache
fi

if [ ! -d "logs" ]; then
    mkdir --mode=0777 logs
fi

if [ ! -d "docs" ]; then
    mkdir --mode=0777 docs
fi

if [ ! -d "bin" ]; then
    mkdir --mode=0777 bin
fi

cd ../application/configs

if [ ! -f "application.development.ini" ]; then
    cp application.development.ini.dist application.development.ini
fi

cd ../../

if [ ! -f "zf.sh" ]; then
    echo "Install zf tool"
    cp vendor/zend/zf1/bin/zf.sh zf.sh
    cp vendor/zend/zf1/bin/zf.php zf.php
    chmod 755 zf.sh
    chmod 755 zf.php
fi

function zfsetup {
    USER_HOME=$(eval echo ~${SUDO_USER})
    TFILE="${USER_HOME}/.zf.ini"
    echo "php.include_path = \"${PWD}/vendor/zend/zf1/library:${PWD}/vendor/zend/zf1/extras/library\"" > $TFILE
}

function setupmanifest {
    zf enable config.manifest Manifest
}

if [ ! -f "~/.zf.ini" ]; then
    echo "Setup zf tool"
    zfsetup
    echo "Create new config file"
    alias zf=${PWD}/zf.sh
    setupmanifest
    echo "Enable Manifest"
fi

echo "Install finish successfully!"
