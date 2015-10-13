#!/usr/bin/env sh

echo "Install and setup Prestashop"

#get it
cd /tmp/
wget "https://www.prestashop.com/download/old/prestashop_${PS_VERSION}.zip"
unzip -q prestashop_${PS_VERSION}.zip
rsync -aO ./prestashop/ ${PS_ROOT%%/}/
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
    --firstname='Test'
    --lastname='Administrator'
    --email='test@example.com' \
    --password=0123456789 \
    --newsletter=0 \
    --send_email=0

#install our module
rsync -aO --exclude '/.*' --exclude '/composer.*' --exclude '/tests' --exclude '/vendor' ${TRAVIS_BUILD_DIR%%/}/ ${PS_ROOT%%/}/modules/zzcleanurls/

mv ${PS_ROOT%%/}/admin ${PS_ROOT%%/}/_admin
mv ${PS_ROOT%%/}/install ${PS_ROOT%%/}/_install

#XXX
echo ls -lha ${PS_ROOT}
ls -lha ${PS_ROOT}

