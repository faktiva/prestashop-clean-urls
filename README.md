README
======


ABOUT
--------

This PrestaShop 1.5 module is based on [PrestaShop-modules-CleanURLs](https://github.com/Ha99y/PrestaShop-modules-CleanURLs)

Thanks to original version you can delete IDs from all friendly links.
This version gives additional possibility to use templates of links to achieve links like below:
* domain.com/product
* domain.com/parent_categories/category
* domain.com/category
* domain.com/manufacturer
* domain.com/supplier
* domain.com/cms

Just use {rewrite} for: products, manufacturer, supplier, cms. For category you can use the same or {parent_categories:/}{rewrite}.

**Important:** categories of CMS are currently not supported. You can use only main category.

INSTALLATION
--------

Install the module from the Backoffice (administration panel)

In the modules tab, click on add a new module. Click on Browse to open the dialogue box letting you search your computer, select the file then validate the dialogue box. Finally click on Upload this module.

UNINSTALLATION
--------

Go to modules -> Find and uninstall "CleanURL".

Open folder /cache/
-> Remove "class_index.php"

Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL off -> Save
Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL on -> Save

If you got any other override modules, you should now go to you back office, uninstall them, and reinstall them again to work correctly.
