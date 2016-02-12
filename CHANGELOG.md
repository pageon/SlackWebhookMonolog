0.4.0 (xxxx-xx-xx)
--
Improvements:

* Use attachments instead of the plain text messages.
* Move SerializeToString to the General namespace.
* Add a general Url so we don't need to keep duplicating the validation.
* Added a class for slack string formatting.

Bugfixes:

0.3.1 (2016-02-09)
--
Improvements:

Bugfixes:

* Make sure that the var parameters in the Error class is an array

0.3.0 (2016-02-09)
--
Improvements:

* Refactor the code to set the channel name
* Added an error class containing extra information about what happened
* Implement all the customization options
* Code style

Bugfixes:

* Fully remove all traces of the socket implementation


0.2.1 (2016-02-07)
--
Improvements:

Bugfixes:

* Updated the tests to reflect the changes from version 0.2.0


0.2.0 (2016-02-07)
--
Improvements:

* Add interface to include extra error information.

Bugfixes:

* Moved away from sockets to curl because of connectivity errors (not all notifications arrived in slack).


0.1.2 (2016-02-03)
--
Improvements:

* Lower the required version of monolog so we can use this class with Fork CMS

Bugfixes:


0.1.1 (2016-01-31)
--
Improvements:

* Added travis
* Added badges to the README file
* Removed some code duplications

Bugfixes:
* Fix wrong return type in Monolog ConfigInterface for the Level

0.1.0 (2016-01-31)
--
Improvements:

* Initial implementation

Bugfixes:
