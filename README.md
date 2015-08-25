# Prestashop module "ZiZuu CLean URLs"

[ABOUT](https://github.com/ZiZuu-store/PrestaShop_module-CleanURLs)
===============================================================

It has been reported to work on PS 1.5.6 - 1.6.1.x

We are going to merge other users' contributions and ideas as soon as we note them and find the time to test.

If you fork please make every change the way we can pull, don't reinvent the wheel .. make every custom change on a private branch, so you can merge your own changes to the community mintained full branch every time a new release is out.

INSTALLATION
--------

Install the module from the Backoffice (administration panel), download the release ZIP binary as it already contains the right folder name (cleanurls, not cleanurls-version_x.y.z !)

In the modules tab, click on **add a new module**. Click on Browse to open the dialogue box letting you search your computer, select the file then validate the dialogue box. Finally click on Upload this module.

###Make sure your SEO and URL settings are as follows:
 
This is __MANDATORY__
 * products:         {category:/}{rewrite}              (you **can** add .html at the end)
 * categories:       {parent_categories:/}{rewrite}**/**
 * manufacturers:    manufactures/{rewrite}
 * suppliers:        suppliers/{rewrite}
 * CMS page:         info/{rewrite}                       (you **can** add .html at the end)
 * CMS category:     info/{rewrite}**/**
 * modules:          module/{module}{/:controller}

You can replace words such as "info", "suppliers", etc with whatever you want given that it does not conflicts with a category name

Remember to 
 * **clear the browser cache**
 * **clear PS cache** (under smarty -> cache and smarty -> compile)

UNINSTALLATION
--------

* Go to modules -> Find and uninstall "**zzcleanurl**"

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
