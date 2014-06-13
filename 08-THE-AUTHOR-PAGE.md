### The author page.
The goal is to generate a posts list by author.

#### Controller for the author.
We need a new controller for the author. For this purpose I will use the controller generator which command is:
```
php app/console generate:controlle

```
To the console will pass the following two parameters `CodeBundle:Author` and `showAction`.

#### Test 
To test the author I need a custom query.
To write a custom query I need a custom repository which will be named AuthorRepository.php. and it will placed into ModelBundle/Repository