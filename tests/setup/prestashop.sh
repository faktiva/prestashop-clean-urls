#!/usr/bin/env bash

echo "Install and setup Prestashop ${PS_VERSION}"

# setup PrestaShop
sudo git clone --single-branch --branch ${PS_VERSION}  https://github.com/PrestaShop/PrestaShop.git /var/www/PS_${PS_VERSION}
php /var/www/PS_${PS_VERSION}/install-dev/index_cli.php --language=en --country=us --domain=localhost --base_uri=/prestashop.test --db_name=prestashop.test --db_create=1 --name=prestashop.test --password=123456789
