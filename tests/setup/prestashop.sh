#!/usr/bin/env sh

echo "Install and setup Prestashop"

git clone --single-branch --branch ${PS_VERSION}  https://github.com/PrestaShop/PrestaShop.git ${PS_ROOT}

php ${PS_ROOT}install-dev/index_cli.php --language=en --country=us --domain=${TEST_HOST} --base_uri=${TEST_BASE_DIR} --db_name=prestashop.test --db_create=1 --name='Test Shop' --password=123456789

rsync -a ${TRAVIS_BUILD_DIR}/ ${TEST_DOC_ROOT}/modules/zzcleanurls/
