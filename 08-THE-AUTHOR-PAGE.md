### The author page.
The goal is to generate a posts list by author.

#### Controller for the author.
We need a new controller for the author. For this purpose I will use the controller generator which command is:
```
php app/console generate:controlle

```
To the console will pass the following two parameters `CodeBundle:Author` and `showAction`.

#### Test 

* To test the author I need a custom query.
To write a custom query I need a custom repository which will be named AuthorRepository.php. and it will placed into ModelBundle/Repository.
```
<?php

namespace Blog\ModelBundle\Repository;

use Doctrine\ORM\EntityRepository;

/** 
 * Class AuthorRepository
 */
class AuthorRepository extends EntityRepository {

	/** 
	 * Find the first author
	 *
	 * @return Author
	 */
	public function findFirst()
	{
		$qb = $this->getQueryBuilder()
			->orderBy('a.id', 'asc')
			->setMaxResults(1);

		return $qb->getQuery()->getSingleResult();
	}

	private function getQueryBuilder()
	{

		$em = $this->getEntityRepository();

		$qb = $em->getRepository('ModelBundle:Author')
			->createQueryBuilder('a');

		return $qb;
	}
}
```

* To make Doctrine knows about repositoryAuthor I will edit `Blog\ModelBundle\Entity`:
```
/**
 * Author
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Blog\ModelBundle\Repository\AuthorRepository")
 */
```

* To add a sluggable behavior I will edit `Blog\ModelBundle\Entity`:
```
    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"name"}, unique=false)
     * @ORM\Column(length=255)
     */
    private $slug;
```

* Add a setter and getter for the slug field running the following command:
```
php app/console doctrine:generate:entities ModelBundle:Author
```

* We create a migration:
```
php app/console doctrine:migrations:diff
php app/console doctrine:migrations:migrate
``` 

 


