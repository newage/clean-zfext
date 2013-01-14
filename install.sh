SHELL=/bin/bash

echo "Begin upload dependencies\n"
curl -s http://getcomposer.org/installer | php
php composer.phar install

echo "Begin setup project\n"
cd ../data

if [ ! -d "cache" ]; then
    mkdir --mode=0777 cache
fi

if [ ! -d "logs" ]; then
    mkdir --mode=0777 logs
fi

cd ../application/configs

if [ ! -f "application.development.ini" ]; then
    cp application.development.ini.dist application.development.ini
fi

cd ../../

if [ ! -f "zf.sh" ]; then
    cp ${PWD}/vendor/zend/zf1/bin/zf.sh zf.sh
    cp ${PWD}/vendor/zend/zf1/bin/zf.php zf.php
fi

echo "Install finish successfully!\n"