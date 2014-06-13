### The Post Page

The goal of this section is to develop the post show displaying a specific post with a specific query.

#### 

* We need a new method to get a specific post. To do that we edit the PostRepository.php adding a new method named findFirst.
```
	/**
	 * Find the first post
	 *
	 * @return Post
	 */
	public function findFirst()
	{
		$em = $this->getQueryBuilder()
			->orderBy('p.id', 'asc')
			->setMaxResults(1);

		return $qb->getQuery()->getSingleResult();
	}
```

* Let's write the test editing PostControllerTest.php`
```
    /**
     * tests show post
     */
    public function testShow()
    {
        $client = static::createClient();

        /* @var Post $post */ 
        $post = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('ModelBundle:Post')
            ->findFirst();

        $crawler = $client->request('GET', '/'.$post->getSlug());

        $this->assertTrue($client->getResponse()->isSuccessful(), 'The response was not successful');

        $this->assertEquals($post->getTitle(), $crawler->filter('h1')->test(), 'Invalid post title');
    }
```
This test corresponds to what we want to develop.

* We will edit the PostController.php adding a new action.
```
    /**
     * Show a post
     *
     * @param string $slug
     *
     * @throws NotFoundHttpException
     * @return array 
     *
     * @Route("/{slug}")
     * @Template()
     */
    public function showAction()
    {
        $posts = $this->getDoctrine()
            ->getRepository('ModelBundle:Post')
            ->findOneBy(
                array(
                    'slug' => $slug
                )
        );

        if (null = $post) {
            throw $this->createNotFoundException('Post was not found');
        }

        return array(
            'post'       => $post
        );
    }
```

* We will create the template named `show.html.twig` into Resources/views/Post directory name.
```
{% extends "CoreBundle::layout.html.twig" %}

{% block title %}{{ post.title }}{% endblock %}

{% block sidebar %}
	<aside>
		<h3>{{ 'author' |trans }}</h3>
		<p>
			<a href="#" title="{{ 'post.by.author' | trans({ '%name%': post.author.name }) }}">
				{{ post.author.name }}
			</a>
		</p>
	</aside>
{% endblock %}

{% block section %}
	<article class="post">
		<header>
			<h1>{{ post.title }}</h1>
			<p>
				{{ 'post.on' | trans }} <time datetime="{{ post.createdAt | date('c') }}">{{ post.createdAt | date }}</time>
			</p>
		</header>
		<p>{{ post.body | nl2br }}}</p>
	</article>
{% endblock %}

```

#### Update the link to access the post.
Let's update the link  editing the `_post.html.twig` and `index.html.twig` `file view.
To discover which route should I call, you can just run the command `php app/console route:debug`
```
<a href="{{ path('blog_core_post_show', {slug: post.slug}) }}">
```


