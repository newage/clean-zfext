SHELL=/bin/bash

echo "Begin upload dependencies\n"
curl -s http://getcomposer.org/installer | php
php composer.phar install

echo "Begin setup project\n"
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

cd ../

if [ ! -f "zf.sh" ]; then
    cp vendor/zend/zf1/bin/zf.sh zf.sh
    cp vendor/zend/zf1/bin/zf.php zf.php
    chmod 755 zf.sh
    chmod 755 zf.php
fi

cd application/configs

if [ ! -f "application.development.ini" ]; then
    cp application.development.ini.dist application.development.ini
fi

echo "Install finish successfully!\n"

cd ../../
alias zf=${PWD}/zf.sh
ZEND_TOOL_INCLUDE_PATH=${PWD}/vendor/zend/zf1/library zf --setup config-file

echo "Install finish successfully!\n"