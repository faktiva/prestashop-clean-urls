[ABOUT](https://github.com/Ha99y/PrestaShop-modules-CleanURLs)
===============================================================
it works on my 1.6.0.9
don't ask me how and why, hack away,
btw I added support for smartblog url rewrite, so now both module play nicely along, or at least for my needs...

INSTALLATION
--------

Install the module from the Backoffice (administration panel)

In the modules tab, click on add a new module. Click on Browse to open the dialogue box letting you search your computer, select the file then validate the dialogue box. Finally click on Upload this module.

###Make sure your seo and url settings are as follows:
 
This is __MANDATORY__
* products:          {categories:/}{rewrite} (no .html at the end **OBLIGATORY**)
* categories:       {parent_categories:/}{rewrite}/
* manufacturers: {rewrite}
* CMS:                "WHAT YOU WANT"/{rewrite} ex info/{rewrite}
 
Keep in mind to clear browser cache / PS cache under smarty/cache and smarty/compile

UNINSTALLATION
--------

Go to modules -> Find and uninstall "CleanURL".

Open folder /override/classes/
-> Remove "Link.php"
-> Remove "Dispatcher.php"

Open folder /override/controllers/front/
-> Remove "CategoryController.php"
-> Remove "CmsController.php"
-> Remove "ManufacturerController.php"
-> Remove "ProductController.php"
-> Remove "SupplierController.php"

Open folder /cache/
-> Remove "class_index.php"

Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL off -> Save
Go to back office -> Preferences -> SEO and URLs -> Set userfriendly URL on -> Save

If you got any other override modules, you should now go to you back office, uninstall them, and reinstall them again to work correctly.
