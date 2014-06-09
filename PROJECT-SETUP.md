### Project Setup

#### Initial symfony project setup

```
composer create-project symfony/framework-standard-edition symfony-blog 2.4.*
```

#### Initial database setup

```
create database symfony-blog
```

####

* Let’s enter in the project directory to see if "php app/console" runs correctly.
In this way you can see are all the symfony2 commands.

* We can use the PHP built-in web server to run Symfony
```
php app/console server:run
```

#### Remove the AcmeDemoBundle

* Unregister the bundle in the AppKernel. 

To disconnect the bundle from the framework, you need to remove the bundle from the AppKernel::registerBundles() method in "app/AppKernel.php" file.

*  Remove bundle routing
The routing for the AcmeDemoBundle can be found in app/config/routing_dev.yml. 

* Remove the bundle from the Filesystem
