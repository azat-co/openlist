#
Welcome to openList


##
openList is free PHP web application for ad classified websites which you can customize into any Craigslist like website.
Project website is at [openList.co]("http://openList.co")


###
Features

- Custom fields for ad categories like real estate, for sale etc.
- Email verification and ad manager for deletion/editing
- Ad flagging ie spam, like, violation, etc
- Minimalistic design and use of templates ease customization
- HTML filter, Captcha and WYSIWYG editor
- clean URLs
- photo upload
- nested categories


###
Installation

1. Download application/package
1. Modify _class/systemconsts.class.php_ with your database parameters
1. Run _install.php_
1. Point localhost to your folder or change _class/config.php_ with a new host name
1. View application at localhost or your custom host name (*it will be pre-populated with data*)


###
Customization

- _class/config.php_ - global constants
- _class/systemconsts.class.php_ - database parameters
- _install.php_ - initial data eg cities, categories, custom fields, etc.

To change cities, categories and other data just modify SQL statements in _install.php_ or edit your database with phpMyAdmin.


###
Libraries

- Slightly modified PHP template engine [Savant3]: http://phpsavant.com/
- JavaScript and HTML WYSIWYG client-side editor [TinyMCE]: http://www.tinymce.com/
- PHP HTML filter [HTML Purifier]: http://htmlpurifier.org/
- PHP Captcha script [Securimage]: http://www.phpcaptcha.org/


###
Future Possible Development

- Admin panel
- More user-friendly customization of initial data (ie install.php)