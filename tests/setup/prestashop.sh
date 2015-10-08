#!/usr/bin/env sh

echo "Install and setup Prestashop ${PS_VERSION}"

export PS_ROOT="${TEST_DOC_ROOT}${TEST_BASE_DIR}"

# clone the right Prestashop version
sudo git clone --single-branch --branch ${PS_VERSION}  https://github.com/PrestaShop/PrestaShop.git ${PS_ROOT}

# install it
echo "php ${PS_ROOT}install-dev/index_cli.php --language=en --country=us --domain=${TEST_HOST} --base_uri=${TEST_BASE_DIR} --db_name=prestashop.test --db_create=1 --name=prestashop.test --password=123456789"
php ${PS_ROOT}install-dev/index_cli.php --language=en --country=us --domain=${TEST_HOST} --base_uri=${TEST_BASE_DIR} --db_name=prestashop.test --db_create=1 --name=prestashop.test --password=123456789 2>&1 | tee /tmp/ps.log

cat /tmp/ps.log

