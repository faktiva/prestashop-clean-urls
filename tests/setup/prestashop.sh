#!/usr/bin/env sh

echo "Install and setup Prestashop"

#get it
git clone --single-branch --branch ${PS_VERSION} https://github.com/PrestaShop/PrestaShop.git ${PS_ROOT}

#install & config
php ${PS_ROOT}install-dev/index_cli.php --language=en --country=us --domain=${TEST_HOST} --base_uri=${TEST_BASE_DIR} --db_name=prestashop.test --db_create=1 --name='Test Shop' --password=123456789

#install our module
rsync -av --exclude '/.*' --exclude '/composer.*' --exclude '/tests' --exclude '/vendor' ${TRAVIS_BUILD_DIR}/ ${PS_ROOT}/modules/zzcleanurls/
