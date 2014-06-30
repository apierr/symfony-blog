Authors and administration
--

This first thing to be managed in the administration bundle will be the author entity. 
It should be possible to create update and delete the author entity. This actions are known as CRUD operations.

- To generate this common action I will use the following generator command 
`generate:doctrine:crud`


 - I will move the controller, the test and the template generated into Model Bundle (ModelBundle) to the administration bundle (AdminBundle).

```
mv src/Blog/ModelBundle/Controller/AuthorController.php src/Blog/AdminBundle/Controller/
mv src/Blog/ModelBundle/Tests/Controller/AuthorControllerTest.php src/Blog/AdminBundle/Tests/Controller/
mv src/Blog/ModelBundle/Resources/views/Author src/Blog/AdminBundle/Resources/views/
```

- I will fix the Coding Standards into the file named `AuthorController.php`
