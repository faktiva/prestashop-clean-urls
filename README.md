[Prestashop module "ZiZuu Clean URLs"](https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs)
==

[![Sensio Labs Insight][insight]](https://insight.sensiolabs.com/projects/0f609ac9-667f-4840-82d4-464e0f7c31ba)
[![Travis CI build status][travis]](https://travis-ci.org/ZiZuu-store/zzCleanURLs)

[![Join our Gitter chat][gitter]](https://gitter.im/ZiZuu-store/zzCleanURLs)

[insight]: https://insight.sensiolabs.com/projects/0f609ac9-667f-4840-82d4-464e0f7c31ba/mini.png
[travis]: https://travis-ci.org/ZiZuu-store/zzCleanURLs.svg?branch=integrate-travis-ci
[gitter]: https://badges.gitter.im/Join%20Chat.svg

* For production use the **latest stable [release](https://github.com/ZiZuu-store/zzCleanURLs/releases/)**
* For developing or Pull Request please use only the "**[dev](https://github.com/ZiZuu-store/zzCleanURLs/tree/dev)**" branch

We are going to merge other users' contributions and ideas as soon as we note them and find the time to test.

If you fork, please make every change the way we can pull, don't reinvent the wheel .. make every custom change on a private branch, so you can merge your own changes to the community mintained branch every time a new release is out.

It has been reported to work on **PS 1.5.6 - 1.6.1.x** but will install on PS >= 1.5 too.
**If you succesfully use this module on some older version please report**

## INSTALLATION

Install the module from the Backoffice (administration panel), download the release ZIP file (***zzcleanurls.zip***) as it already contains the right folder name (`zzcleanurls`, **not** `zzcleanurls-version_x.y.z` !)

In the modules tab, click on **add a new module**. Click on Browse to open the dialogue box letting you search your computer, select the ZIP file then validate the dialogue box. Finally click on Upload this module.

### Make sure your SEO and URL settings are as follows:
 
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

## UNINSTALLATION

* Go to modules -> Find and uninstall "**zzcleanurls**"

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
