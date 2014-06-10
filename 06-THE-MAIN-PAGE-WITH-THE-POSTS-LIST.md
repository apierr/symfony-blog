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

#### Test

* delete the test into ModelBundle
* delete the default Controller Bundle into CoreBundle
* code PHP standard for PostControllerTest adding comments
* add an assert into PostControllerTest class
```
$this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');
```
