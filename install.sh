SHELL=/bin/bash

echo "Begin upload dependencies\n"
curl -s http://getcomposer.org/installer | php
php composer.phar install
cd public
bower install

cd ../data
echo "Begin setup project\n"

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

echo "Install finish successfully!\n"