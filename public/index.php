<?php
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__).'/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV')?getenv('APPLICATION_ENV'):'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

/** Zend_Application */
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH.'/configs/application.ini'
);
$application
	->bootstrap()
	->run();

/*
 - core dev
	- resolve the issue with User "default fields" being in Mapper and "operations on fields" (e.g. encrypt password) being in Model
	   - seems that the Mapper should be the one hashing the password if a new one's set...
    - see if the form validation stuff from AuthController::registerAction can go in the form itself somehow
	+ ensure login and logout works, with different links at the top
       - admin users having access to modify settings
	   - customer being able to see library
	   - and search it
	- use ACLs (probably) to do the user types thing with different pages to admin/authed/non-authed visitors
	- where can "auth state loader" go so that state doesn't have to be loaded in every single Action of every Controller?
	  needed because atm if you go to a Controller/Action without it, you get the un-authed nav appearing
	   + can get it per-controller by placing in the Controller::init() method... can we get it application-wide?
	      - now look to move out the code in to the Plugin_Authenticate thing
 - a test case for the Mapper::save() with referenced objects would be
	- make sure save() knows about ORM_Placeholder
    - pull a Book from the db but don't do getReferenced('Authors')
    - pull an Author from the db
    - set the Book's Author to the new one and save() it and see if it works
	- also try it after getReferenced('Authors') had been called
 - post-core nice to haves
    - find out how the fuck Bootstrap class operates such that moving _initDoctype below _initViewHelpers fucks it all up :/
	+ would be nice to have ReferencedPlaceholder & DependentPlaceholder as actual objects, but where do they go in the filesystem?
	   + but first need Abstract shit moving into an orm heirarchy
    + see if Mapper_Abstract's new getDbTable method can tidy any of the getReferenced/getDependent shit
    + consider scrapping Model_Abstract's __call shortcut as getReferenced() is a bit more sensibly named
    - consider making a Model for "list of books" so we can pull a join instead of multiple pulls for authors/category/etc
	- do something about the default usertype_id being hardcoded in User's Mapper
*/