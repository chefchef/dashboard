# Run all tests. Add 'path' parameter to only test one file or a concrete folder
run-all-tests:
	mocha src/js/Tests/
	./vendor/phpunit/phpunit/phpunit --bootstrap=vendor/autoload.php -c phpunit.xml.dist

run-js-tests:
	mocha src/js/Tests/

run-php-tests:
	./vendor/phpunit/phpunit/phpunit --bootstrap=vendor/autoload.php -c phpunit.xml.dist

build:
	npm install
	bower install
	php composer.phar install

build-deploy:
	git pull origin master
	mkdir -p /home/chefchef/www/chefuri.net/dashboard_deploy/
	cp * -R /home/chefchef/www/chefuri.net/dashboard_deploy/
	chown chefchef:chefchef /home/chefchef/www/chefuri.net/dashboard_deploy/ -R
	sudo mkdir -p /home/chefchef/www/chefuri.net/dashboard_deploy/app/cache
	sudo mkdir -p /home/chefchef/www/chefuri.net/dashboard_deploy/app/logs
	sudo chmod 777 /home/chefchef/www/chefuri.net/dashboard_deploy/app/cache -R
	sudo chmod 777 /home/chefchef/www/chefuri.net/dashboard_deploy/app/logs -R
	cd /home/chefchef/www/chefuri.net/dashboard_deploy/
	curl -sS https://getcomposer.org/installer | php
	chmod +x composer.phar
	cp app/config/parameters_prod.yml.dist app/config/parameters.yml.dist
	rm -rf /home/chefchef/www/chefuri.net/dashboard/
	mv /home/chefchef/www/chefuri.net/dashboard_deploy/ /home/chefchef/www/chefuri.net/dashboard/

build-prod:
	npm install
	export SYMFONY_ENV=prod
	bower install
	php composer.phar install --optimize-autoloader --no-dev
	php app/console assetic:dump --env=prod --no-debug

build-cache:
	sudo chmod 777 app/cache -R
	sudo chmod 777 app/logs -R