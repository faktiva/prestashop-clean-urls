#!/usr/bin/env sh

echo -e "\033[33mSetup apache + php-fpm\033[0m"

# enable php-fpm
sudo cp ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf.default ~/.phpenv/versions/$(phpenv version-name)/etc/php-fpm.conf
sudo a2enmod rewrite actions fastcgi alias

echo "cgi.fix_pathinfo = 1" >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo 'date.timezone = "Europe/Rome"' >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo 'sendmail_path = /bin/true' >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini
echo 'register_argc_argv = on' >> ~/.phpenv/versions/$(phpenv version-name)/etc/php.ini

phpenv config-rm xdebug.ini || true

~/.phpenv/versions/$(phpenv version-name)/sbin/php-fpm

# configure apache virtual hosts
sudo cp -f ${TRAVIS_BUILD_DIR%%/}/test/setup/apache-vhost.conf /etc/apache2/sites-available/default
sudo sed -e "s#%DOCUMENT_ROOT%#${TEST_DOC_ROOT%%/}/#g" --in-place /etc/apache2/sites-available/default
sudo sed -e "s#%SERVER_NAME%#${TEST_HOST}#g" --in-place /etc/apache2/sites-available/default

sudo mkdir -p ${TEST_DOC_ROOT}
sudo chown ${USER}:$(grep APACHE_RUN_GROUP /etc/apache2/envvars | cut -d= -f2) ${TEST_DOC_ROOT}
sudo chmod -R 777 ${TEST_DOC_ROOT}

sudo service apache2 restart
