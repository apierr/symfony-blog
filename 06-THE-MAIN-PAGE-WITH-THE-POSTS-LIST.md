### Tha main page with post list

#### Create a Controller

* You can create the controller by using a generator.
```
php app/console generate:controller

Controller name: -> CoreBundle:Post
New action name -> indexAction
Action Route -> /
```

* We can delete the default controller

* to make the controller working we need to return something:
```
    public function indexAction()
    {
    	retun array();
    }
```
