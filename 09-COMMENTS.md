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
php app/console doctrine:generate:entities
```