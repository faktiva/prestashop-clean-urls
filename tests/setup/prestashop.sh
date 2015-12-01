#!/usr/bin/env sh

echo -e "\033[33mInstall and setup Prestashop\033[0m"

#get it
cd /tmp/
wget "https://www.prestashop.com/download/old/prestashop_${PS_VERSION}.zip"
unzip -q prestashop_${PS_VERSION}.zip
rsync -rlp ./prestashop/ ${PS_ROOT%%/}/
cd -

#create DB as old PS did not
mysql -uroot -e 'CREATE database IF NOT EXISTS prestashop_test;'

#install & config
php ${PS_ROOT%%/}/install/index_cli.php \
    --language=en \
    --country=us \
    --domain=${TEST_HOST} \
    --base_uri=${TEST_BASE_DIR} \
    --db_name=prestashop_test \
    --db_create=1 \
    --name='Test Shop' \
    --firstname='Test' \
    --lastname='Administrator' \
    --email='test@example.com' \
    --password=0123456789 \
    --newsletter=0 \
    --send_email=0

#install our module
rsync -rlp --exclude '/.*' --exclude '/composer.*' --exclude '/tests' --exclude '/vendor' ${TRAVIS_BUILD_DIR%%/}/ ${PS_ROOT%%/}/modules/zzcleanurls/

mv ${PS_ROOT%%/}/admin ${PS_ROOT%%/}/_admin
mv ${PS_ROOT%%/}/install ${PS_ROOT%%/}/_install
touch ${PS_ROOT%%/}/.htaccess && chmod 666 ${PS_ROOT%%/}/.htaccess

#XXX
echo -e "\033[33mls -lha ${PS_ROOT}\033[0m"
ls -lha ${PS_ROOT}

