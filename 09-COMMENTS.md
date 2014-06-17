### Comments

* Let's generate the comment entity inside ModelBundle:Comment.
```
php app/console generate
```
* We set a notBlank validation to authorName and tot he body.

* We create a relationship between comment and post.
```
    /**
     * @var Post
     *
     * @ORM\ManytoOne(targetEntity="Post", inversedBy="comments")
     * @ORM\JoinColumn(name="postId", referencedColumnName="id", nullable=false)
     * @Assert\NotBlank
     */
    private $post;
```

* Generates entity classes and method for the comment entity:
```
php app/console doctrine:generate:entities ModelBundle:Comment
```

* Add relationship with the comment in the post entity which file name is Post.php
```
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post", cascade={"remove"})
     */
    private $comments;
```

* I will generate entities for Post 
```
php app/console doctrine:generate:entities ModelBundle:Post
```

* I will transfer this change made on entities to the database.
```
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate
```

* Fixture for the comments.
For the comments I will create a fixture stored in a file named 20-Comments.php
```
<?php

namespace Blog\ModelBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Fixtures for the Comment Entity
 */
class Comments extends AbstractFixtures implements OrderedFixturesInterface
{
	/**
	 * {@inheritDoc}
	 */
	public function getOrder()
	{
		return 20;
	}

	/**
	 * {@inheritDoc}
	 */
	public function load(ObjectManager $manager)
	{
		$posts = $manager->getRepository('ModelBundle:Post')->findAll();

		$comments = array(
			0 => '',
			1 => '',
			2 => ''
		);

		$i = 0;

		foreach($posts as $post) {
			$comment = new Comment();
			$comment->setAuthorName('someone');
			$comment->setBody($comments[$i++]);
			$comment->setPost($post);

			$manager->persist($comment);
		}

		$manager->flush();
	}
}
```
* I will load this fixture running the following command:
```
php app/console doctrine:fixture:load
```

* I will write a test to show the comments editing the file named PostControllerTest.php
```
$this->assertGreaterThanOrEqual(1, $crawler->filter('article.comment')->count(), 'There should be at least 1 comment.');

```

* I will edit Post/show.html.twig to display the comments using a partial which file name will be `_comment.html.twig`:

```

	<a id="comments"></a>
	<h2>{{ 'comment.plural' | trans }}</h2>

	{% for comment in post.comments %}
		{{ include('CoreBundle:Post:_comment.html.twig', { comment: comment }) }}
	{% endfor %}
```

The file `_comment.html.twig` will look like this:
```
<article class="comment">
	<header>
		<p>
			{{ 'on' | trans | capitalize }} <time datetime="{{ comment.createdAt | date('c') }}">{{ comment.createdAt | date }}</time>
			{{ 'by' | trans }} {{ comment.authorName }}
		</p>
	</header>

	<p>{{ comment.body | nl2br }}</p>
</article>
```

#### Display the number of comments in the posts list.
To display the number of comments in the posts list I will edit `Post/_post.html.twig`.
```
- <a href="{{ path('blog_core_post_show', {slug: post.slug}) }}#comments">
	{% set count = post.comments | length %}
	{{ 'post.comments' | transchoice(count) }}
</a>
```

#### Test the creation of a new comment

* First we will write the code to test the creation of a new comment.
I will edit `PostControllerTest.php`.
```
    /**
     * tests create a comment
     */
    public function testCreateComment()
    {
        $client = static::createClient();

        /* @var Post $post */ 
        $post = $client->getContainer()
            ->get('doctrine')
            ->getManager()
            ->getRepository('ModelBundle:Post')
            ->findFirst();

        $crawler = $client->request('GET', '/'.$post->getSlug());

        $buttonCrawlerNode = $crawler->selectButton('Send');

        $form = buttonCrawlerNode->form(array(
            'blog_modelbundle_comment[authorName]' => 'A humble commenter',
            'blog_modelbundle_comment[body]' => 'Hi, I am commenting about the following post'
        ));

        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/'.$post->getSlug()),
            'There was not redirection after submitting the form'
        );

        $crawler = $client->followRedirect();

        $this->assertCount(
            1,
            $crawler->filter('html:contains("your comment was submitted successfully")').
            'There was not any confirmation message'
        );
    }
```

#### Form type
I will create a new form type class based on a Doctrine entity passing the parameter `ModelBundle:Comment` to `php app/console doctrine:generate:form` command.

