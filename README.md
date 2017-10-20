[![SensioLabsInsight](https://insight.sensiolabs.com/projects/58d1de4f-45fc-4f63-aeb3-7ddc51d4a64e/small.png)](https://insight.sensiolabs.com/projects/58d1de4f-45fc-4f63-aeb3-7ddc51d4a64e)
[PrestaShop module "Faktiva Clean URLs"](https://github.com/faktiva/prestashop-clean-urls)
===

[![GitHub release](https://img.shields.io/github/release/faktiva/prestashop-clean-urls.svg?style=flat&label=latest)](https://github.com/faktiva/prestashop-clean-urls/releases/latest)
[![Project Status](http://opensource.box.com/badges/active.svg?style=flat)](http://opensource.box.com/badges)
[![Percentage of issues still open](http://isitmaintained.com/badge/open/faktiva/prestashop-clean-urls.svg?style=flat)](http://isitmaintained.com/project/faktiva/prestashop-clean-urls "Percentage of issues still open")
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/faktiva/prestashop-clean-urls.svg?style=flat)](http://isitmaintained.com/project/faktiva/prestashop-clean-urls "Average time to resolve an issue")
[![composer.lock](https://poser.pugx.org/faktiva/prestashop-clean-urls/composerlock?style=flat)](https://packagist.org/packages/faktiva/prestashop-clean-urls)
[![Dependencies Status](https://img.shields.io/librariesio/github/faktiva/prestashop-clean-urls.svg?maxAge=3600&style=flat)](https://libraries.io/github/faktiva/prestashop-clean-urls)
[![License](https://img.shields.io/packagist/l/faktiva/prestashop-clean-urls.svg?style=flat)](https://tldrlegal.com/license/mit-license)

[![Join the chat at https://gitter.im/faktiva/prestashop-clean-urls](https://img.shields.io/badge/Gitter-CHAT%20NOW-brightgreen.svg?style=flat)](https://gitter.im/faktiva/prestashop-clean-urls)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/faktiva/prestashop-clean-urls.svg?style=social)](https://twitter.com/intent/tweet?text=Fantastic+@PrestaShop+module+"%23Faktiva+Clean+URLs"&url=https://github.com/faktiva/prestashop-clean-urls)
[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_SM.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=YF3R37RLY85CU&lc=IT&item_name=faktiva&item_number=GitHub%2dprestashop%2dclean%2durls&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted)
____

**Makes possible to have URLs with no IDs in PrestaShop.**

>    This module is **NOT intended to work on PS 1.7.x** (it may, but it is not supported at all)

>
>    For production use the **latest stable [release](https://github.com/faktiva/prestashop-clean-urls/releases/latest)**
>
>    It has been reported to work on **PS 1.5.6 - 1.6.1.x** but will install on PS >= 1.5 too.
>    **If you succesfully use this module on some older version please report**
>

# INSTALLATION

## from _PS administration panel_

Go in the back office of your shop and follow these steps:
  - download the [lastest release](https://github.com/faktiva/prestashop-clean-urls/releases/latest) **_ZIP_ file** (**_`faktiva_clean_urls.zip`_**) as it already contains the right folder name (`faktiva_clean_urls`, **not** `faktiva-prestashop-clean-urls-version_x.y.z` !)
  - in the modules tab, click on **`add a new module`**
  - click on **"`Browse`"** to open the dialogue box letting you search your computer
  - select the ZIP file you downloaded and validate the dialogue box
  - click on "**`Upload this module`**"
  - once uploaded, you could have to search the module among the others (_tip: filter by author "**`faktiva`**"_) and click on the **`install`** button

# Configuration & Checks

**Make sure your _`SEO and URL`_ settings are as follows:**

This is **MANDATORY**
  - products:         {category:/}{rewrite}              (you **can** add .html at the end)
  - categories:       {categories:/}{rewrite}**/**
  - manufacturers:    manufactures/{rewrite}
  - suppliers:        suppliers/{rewrite}
  - CMS page:         info/{rewrite}                       (you **can** add .html at the end)
  - CMS category:     info/{rewrite}**/**
  - modules:          modules/{module}{/:controller}

_You can replace words such as "info", "suppliers", etc with whatever you want, given that it does not conflicts with a category name_

**Remember to**
  - clear the **browser cache**
  - clear **PS cache** (under smarty -> cache and smarty -> compile)

# UNINSTALLATION

* Go to modules -> Find and uninstall "**faktiva_clean_urls**"

**It should suffice!**


If something goes wrong do the following:
  - Open folder **`/override/classes/`**
    - Remove **`Link.php`**
    - Remove **`Dispatcher.php`**
  - Open folder **`/override/controllers/front/`**
    - Remove **`CategoryController.php`**
    - Remove **`CmsController.php`**
    - Remove **`ManufacturerController.php`**
    - Remove **`ProductController.php`**
    - Remove **`SupplierController.php`**
  - Open folder **`/cache/`**
    - Remove **`class_index.php`**
  - Go to **`back office`** -> **`Preferences`** -> **`SEO and URLs`** -> Set **`userfriendly URL`** off -> **`Save`**
  - Go to **`back office`** -> **`Preferences`** -> **`SEO and URLs`** -> Set **`userfriendly URL`** on -> **`Save`**


If you got any other override modules, you should now go to you back office, uninstall them, and reinstall them again to work correctly.

