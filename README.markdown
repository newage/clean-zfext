##System Requirements

* PHP >= 5.3

* [Composer](http://getcomposer.org)

* Curl

* php-gd


##Versioning

Releases will be numbered with the following format:
```
<major>.<minor>.<patch>
```

##In the commit message

### Types

* feature - is used when adding a new application-level functionality
* fix - if any serious bug fixed
* docs - all that relates to the documentation
* style - fix typos, correct formatting
* refactor - refactoring your code
* test - everything associated with testing

```
[issue number] type (module); action**ed** + wherefore + details [optional]
```

### Example commit message:
```
[#32] Fix (users, administrator); Added new migrations. For correct work need rebuild database.
```

## Install

Clone this project

```
git clone git@github.com:newage/clean-zfext.git
```

## Automatically setup on ubuntu

Run bash script: create need folders, copy config.ini and zf.sh, config zf tool

```
cd project-home
source install.sh
```

## Manual setup

* Install composer and dependencies

```
cd project-home
curl -s http://getcomposer.org/installer | php
php composer.phar install
```

* Create folders /data/logs and /data/cache

* Change chmod 777 to folder data and all subfolders

* Copy /application/configs/application.ini to /application/configs/application.development.ini. Change development file.

* Set alias to ./zf [optional]

* Setup manifest

```
zf show config
zf create config
zf enable config.manifest Manifest
```
## Setup database

Config you application.development.ini for use module and db connection

* Enter database parameters:

```
resources.db.adapter = pdo_mysql
resources.db.params.host = localhost
resources.db.params.username = root
resources.db.params.password = 123456
resources.db.params.dbname = clean-zfext
resources.db.params.charset = utf8
resources.db.isDefaultTableAdapter = true
```

* Create schema on your database

```
zf apply schema
zf load fixture
```

After load fixture created default users
```
Admin
email: admin@example.com
password: 123qwe
```
```
User
email: user@example.com
password: 123qwe
```

##Setup upload

Change parameters in config file:
```
resources.frontcontroller.params.upload.path = BASE_PATH "/data/upload"
resources.frontcontroller.params.upload.alias = public
```
path - upload path
alias - alias to upload folder in apache virtualhost


## Create apache virtualhost

```
<VirtualHost *:80>
	ServerName zend
	DocumentRoot /var/www/clean-zfext/public
	DirectoryIndex index.php
	<Directory /var/www/clean-zfext/public>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	Alias /vendor /var/www/clean-zfext/vendor
	<Directory /var/www/clean-zfext/vendor>
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	Alias /components /var/www/clean-zfext/components
	<Directory /var/www/clean-zfext/components>
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>

	Alias /public /var/www/clean-zfext/data/upload
	<Directory /var/www/clean-zfext/data/upload>
		AllowOverride All
		Order allow,deny
		allow from all
	</Directory>
        SetEnv APPLICATION_ENV development
</VirtualHost>
```
## Create API documentation
```
apigen --source application --destination data/docs
```
## Examples
