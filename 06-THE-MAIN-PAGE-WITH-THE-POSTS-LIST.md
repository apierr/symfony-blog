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

#### Display the posts
Since in the fixtures there are three posts in the test I will expect three post.
* SO I will change the PostControllerTest.php.
```
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        $this->assertCount(3, $crawler->filter('h2'), 'There should be 3 displayed posts');
    }
```

When I run `phpunit -c app`, it fails.
This is one of the principle of Test Driven Development; I write the test, it fails and then I develop it.
* Now I will write the PostController.php and the view to display the three posts.

In order to fetch posts from the database, the `PostController.php` will be:
```
    public function indexAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('ModelBundle:Post')
            ->findAll();

    	return array(
            'posts' => $posts
        );
    }
```

I will change the Post view in this way by using a partial which file name is _post.html.twig
```
{% block section %}
	{% for post in posts %}
		{{ include('CoreBundle:Post:_post.html.twig', {post: post}) }}
	{% endfor %}
{% endblock %}
```
The partial `_post.html.twig` will look like:
```
<article>
	<header>
		<h2><a href="#">{{ post.title }}</a></h2>
		<p>
			{{ 'post.on' | trans }} <time datetime="{{ post.createdAt | date('c') }}">{{ post.createdAt | date }}</time>
			{{ 'by' | trans }} <a href="#">{{ post.author.name }}</a>
		</p>
	</header>
	<p>
		{{ post.body | truncate(400) }} &#8212; <a href="#">{{ 'read.more' | trans }} &raquo;</a>
	</p>
</article>

```
* In order to fix this error message `The filter "truncate" does not exist` you need to enable the filter truncate editing the general file configuration named `config.yml`:
```
services:
    text.twig.extension:
         class: Twig_Extensions_Extension_Text
         tags: [{ name: twig.extension }]
```
* you will change the CSS file into CoreBundle to improve the display and then to take to change sometimes you need to run again the following command:
```
php app/console assets:install --symlink
```
* What would happen if we have a lots of posts? 
In the model, we need a custom query which get just the latest posts.

* I will set a repository for the Post Entity:
The file name will be named `PostRepository.php and it will look like this:
```
<?php

namespace Blog\ModelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class PostRepository
 */
class PostRepository extends EntityRepository
{
	/**
	 * Find latest
	 *
	 * @param int $num How many posts to get
	 *
	 * @return array
	 */
	public function findLatest($num)
	{
		$qb = $this->getQueryBuilder()
			->orderBy('p.createdAt', 'desc')
			->setMaxResults($num);

		return $qb->getQuery()->getResult();
	}

	/**
	 * Find latest
	 *
	 * @param int $num How many posts to get
	 */
	private function getQueryBuilder()
	{
		$em = $this->getEntityManager();

		$qb = $em->getRepository('ModelBundle:Post')
			->createQueryBuilder('p');

		return $qb;
	}
}
```
* I edit the `PostController.php` to get the latest posts.
```
        $latestPosts = $this->getDoctrine()
            ->getRepository('ModelBundle:Post')
            ->findLatest(5);

    	return array(
            'posts'       => $posts,
            'latestPosts' => $latestPosts
        );
```

* I edit the post view `index.html.twig` adding the block sidebar which is already in our layout.
This block will display the list of the posts title in the sidebar.
```
{% block sidebar %}
	<aside>
		<h3>{{ 'post.latests' | trans }}</h3>

		{% for post in posts %}
			<p><a href="#">{{ post.title }}</a></p>
		{% endfor %}
	</aside>
{% endblock %}
```

* Add style to the sidebar listing the posts
```
aside {
	background-color: #c3c3c3;
	border: 1px solid #b5b5b5;
	float: right;
	margin: 5px;
	padding: 5pxp 15px;
	width: 30%;
}

aside h3 {
	font-weight: bold;
}

```

#### DoctrineExtensions's features
* Add stof/doctrine-extensions-bundle to composer.json
```
"stof/doctrine-extensions-bundle": "dev-master",
```
and to your application kernel:
```
new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
```
* I will enable the sluggable behavior into `app/config/config.yml`
```

```
* Add slug to the Post entity
```

```
and then I will generate the getter and setter by the command:
```
php app/console generate:doctrine:entities ModelBundle:Post
```

* Perform a database migration:
```
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate
```

* To fill the database since there is a new field named slug we can run:
```
php app/console doctrine:fixtures:load
```

#### Opening the posts
* Exploiting the timestampable behavior of doctrine-extensions-bundle.
To exploit the timespampable behavior we add the key `timespampable: true` to config.yml
and we delete the constructor from the Timestampable class editing  Timestampable.php in this way:
```
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"}, unique=false)
     * @ORM\Column(length=255)
     */
    private $slug;
```
To check that it works as before we can run:
```
php app/console doctrine:fixtures:load
```

