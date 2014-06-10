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

* to test the application you can run
```
phpunit -c app
```

#### Design

* Delete the Default View of CoreBundle
* Create a new layout.html.twig file into views of CoreBundle
```
{% extends "::base.html.twig" %}

{% block stylesheets %}
	<link rel="stylesheet" type="text/css" href="{{ asset('bundles/core/css/main.css') }}">
{% endblock %}

{% block body %}
	<header>
		<p>Symfony 2 Blog</p>
		<nav>
			<ul>
				<li><a href="#">{{ 'home' | trans }}</a></li>
			</ul>
		</nav>

	</header>

	{% block sidebar %}{% endblock %}

	<section>
		{% block section %}{% endblock %}
	</section>

	<footer>
		<p>&copy; {{ 'now' | data('Y') }} Symfony 2 Blog</p>
	</footer>

{% endblock %}
```

* Create a resource for the translation into Resources/translations/ directory.
You can just create two files, one for the English (messages.en.yml) and the other one for the Italian (messages.it.yml). 
```
home: Home
```

* Create the CoreBundle CSS file.
You can create a file into CoreBundle/Resources/public/css/main.css
```
html {
	position: relative;
	min-height: 100%;
}

body {
	margin: 0 0 80px;
}
``

* Installs bundles web assets under a public web directory.
As you can see the directory "bundles/core/css/main.css" does not exist, but you can create a symbolic link just by running 
```
php app/console assets:install --symlink
```

* Modify the view of the Post Action
To modify the view of Post Action you need to edit "CoreBundle/Resources/views/Post/index.html.twig"
which was auto-generated.
First we need to inherit the template created into CoreBundle/Resource and then override the block title.
```
{% extends "CoreBundle::layout.html.twig" %}

{% block title %}{{ 'post.plural' | trans }}{% endblock %}

{% block section %}
<h1>Welcome to the Post:index page</h1>
{% endblock %}

```

* enable the translator in your configuration
framework:
    #esi:             ~
    translator:      { fallback: "%locale%" }


