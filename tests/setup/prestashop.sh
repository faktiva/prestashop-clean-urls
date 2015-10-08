#!/usr/bin/env sh

echo "Install and setup Prestashop ${PS_VERSION}"

# clone the right Prestashop version
sudo git clone --single-branch --branch ${PS_VERSION}  https://github.com/PrestaShop/PrestaShop.git ${TEST_DOC_ROOT}

# install it
php ${TEST_DOC_ROOT}/install-dev/index_cli.php --language=en --country=us --domain=localhost --base_uri=${TEST_BASE_URI} --db_name=prestashop.test --db_create=1 --name=prestashop.test --password=123456789
