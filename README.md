debugbar-doctrine
=================

Doctrine PDO Collector for Debugbar

#### Installation

You will need `laravel-debugbar` package. This package **will not install dependencies**.

Insert this line into your `composer.json` file:

    "vittee/debugbar-doctrine" : "dev-master",
    
Then run an `composer update`

Once installed, add the service provider to the `providers` array in `app/config/app.php` file:

    'Vittee\DebugbarDoctrine\DebugbarDoctrineServiceProvider',
    
Now if you enable db collector in Debugbar, database queries should be logged in the DebugBar Database section.
