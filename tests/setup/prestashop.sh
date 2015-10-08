#!/usr/bin/env sh

echo "Install and setup Prestashop ${PS_VERSION}"

# clone the right Prestashop version
sudo git clone --single-branch --branch ${PS_VERSION}  https://github.com/PrestaShop/PrestaShop.git ${TEST_DOC_ROOT}${TEST_BASE_DIR}

# install it
echo "php ${TEST_DOC_ROOT}${TEST_BASE_DIR}install-dev/index_cli.php --language=en --country=us --domain=${TEST_HOST} --base_uri=${TEST_BASE_DIR} --db_name=prestashop.test --db_create=1 --name=prestashop.test --password=123456789"
php ${TEST_DOC_ROOT}${TEST_BASE_DIR}install-dev/index_cli.php --language=en --country=us --domain=${TEST_HOST} --base_uri=${TEST_BASE_DIR} --db_name=prestashop.test --db_create=1 --name=prestashop.test --password=123456789
