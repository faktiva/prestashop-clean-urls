[PrestaShop module "Clean URLs"](https://github.com/faktiva/prestashop-seo-tk) <br /> [![SensioLabsInsight](https://insight.sensiolabs.com/projects/58d1de4f-45fc-4f63-aeb3-7ddc51d4a64e/mini.png)](https://insight.sensiolabs.com/projects/58d1de4f-45fc-4f63-aeb3-7ddc51d4a64e) [![License](https://img.shields.io/packagist/l/faktiva/prestashop-clean-urls.svg?style=flat)](https://creativecommons.org/licenses/by-sa/4.0/)
===

[![GitHub release](https://img.shields.io/github/release/faktiva/prestashop-clean-urls.svg?style=plastic&label=latest)](https://github.com/faktiva/prestashop-clean-urls/releases/latest)
[![Project Status](http://opensource.box.com/badges/active.svg)](http://opensource.box.com/badges)
[![Percentage of issues still open](http://isitmaintained.com/badge/open/faktiva/prestashop-clean-urls.svg)](http://isitmaintained.com/project/faktiva/prestashop-clean-urls "Percentage of issues still open")
[![Average time to resolve an issue](http://isitmaintained.com/badge/resolution/faktiva/prestashop-clean-urls.svg)](http://isitmaintained.com/project/faktiva/prestashop-clean-urls "Average time to resolve an issue")
[![composer.lock](https://poser.pugx.org/faktiva/prestashop-clean-urls/composerlock)](https://packagist.org/packages/faktiva/prestashop-clean-urls)
[![Dependencies Status](https://img.shields.io/librariesio/github/faktiva/prestashop-clean-urls.svg?maxAge=3600)](https://libraries.io/github/faktiva/prestashop-clean-urls)

[![Join the chat at https://gitter.im/faktiva/prestashop-clean-urls](https://img.shields.io/badge/Gitter-CHAT%20NOW-brightgreen.svg?style=plastic)](https://gitter.im/faktiva/prestashop-clean-urls)
[![Twitter](https://img.shields.io/twitter/url/https/github.com/faktiva/prestashop-clean-urls.svg?style=social)](https://twitter.com/intent/tweet?text=Fantastic @PrestaShop module "#Faktiva Clean URLs"&url=https://github.com/faktiva/prestashop-clean-urls)

___

Makes possible to have URLs with no IDs in PrestaShop.

If you fork, please make every change the way we can pull, don't reinvent the wheel .. make every custom change on a private branch, so you can merge your own changes to the community mantained branch every time a new release is out.

* For production use the **latest stable [release](https://github.com/faktiva/prestashop-clean-urls/releases/latest)**
* For developing or Pull Request please use only the "**[dev](https://github.com/faktiva/prestashop-clean-urls/tree/dev)**" branch

It has been reported to work on **PS 1.5.6 - 1.6.1.x** but will install on PS >= 1.5 too.
**If you succesfully use this module on some older version please report**

# INSTALLATION

Install the module from the Backoffice (administration panel):
- download the lastest [release](https://github.com/faktiva/prestashop-clean-urls/releases/latest) ***ZIP*** file (***`faktiva_clean_urls.zip`***) as it already contains the right folder name (`faktiva_clean_urls`, **not** `faktiva-prestashop-clean-urls-version_x.y.z` !)
- in the modules tab, click on **add a new module**
- click on "`Browse`" to open the dialogue box letting you search your computer
- select the ZIP file you downloaded and validate the dialogue box
- click on "`Upload this module`"
- once uploaded you could have to search the module among the others (tip: filter by author "`faktiva`") and click on the `install` button

## Make sure your SEO and URL settings are as follows:

This is __MANDATORY__
 * products:         {category:/}{rewrite}              (you **can** add .html at the end)
 * categories:       {categories:/}{rewrite}**/**
 * manufacturers:    manufactures/{rewrite}
 * suppliers:        suppliers/{rewrite}
 * CMS page:         info/{rewrite}                       (you **can** add .html at the end)
 * CMS category:     info/{rewrite}**/**
 * modules:          modules/{module}{/:controller}

You can replace words such as "info", "suppliers", etc with whatever you want, given that it does not conflicts with a category name

Remember to
 * **clear the browser cache**
 * **clear PS cache** (under smarty -> cache and smarty -> compile)

# UNINSTALLATION

* Go to modules -> Find and uninstall "**faktiva_clean_urls**"

**It should suffice!**


If something goes wrong do the following:
* Open folder /override/classes/
 * Remove "Link.php"
 * Remove "Dispatcher.php"
* Open folder /override/controllers/front/
 * Remove "CategoryController.php"
 * Remove "CmsController.php"
 * Remove "ManufacturerController.php"
 * Remove "ProductController.php"
 * Remove "SupplierController.php"
* Open folder /cache/
 * Remove "class_index.php"
* Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL off -> Save
* Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL on -> Save


If you got any other override modules, you should now go to you back office, uninstall them, and reinstall them again to work correctly.

# License

![Creative Commons BY-SA License](https://i.creativecommons.org/l/by-sa/4.0/88x31.png)


**[PrestaShop Clean URLs](https://github.com/faktiva/prestashop-clean-urls)** by [Faktiva](https://github.com/faktiva) is licensed under a **Creative Commons [Attribution-ShareAlike](http://creativecommons.org/licenses/by-sa/4.0/) 4.0 International License**.

Permissions beyond the scope of this license may be available contacting us at info@faktiva.com.
