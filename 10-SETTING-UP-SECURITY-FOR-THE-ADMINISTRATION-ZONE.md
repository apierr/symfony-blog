### Setting up security for the administration zone

#### Creation of AdminBundel
*  I will generate a new bundle named AdminBundle
```
php app/console generate:bundle
```
* Login Controller.
In order to handle the authentication I will implement a specific controller named SecurityController.php.
```
<?php

namespace Blog\AdminBundle\Controller;

use Symfony/Bundle/FrameworkBundle/Controller/Controller;
use Symfony/Component/Security/Core/SecurityContext;
use Symfony/Component/HttpFoundation/Response;

/** 
 * Class SecurityController
 */ 
class SecurityController extends Controller
{

	/** 
	 * Login
	 *
	 * @return Response
	 *
	 * @Route('/login')
	 */ 
	public function loginAction()
	{
		$request = $this->getRequest();
		$session = $request->getSession();

		// get the login error if there is one
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		return $this->render(
			'AdminBundle:Security:login.html.twig',
			array(
				// last username entered by the user
				'last_username' => $session->get(SecurityContext::LAST_USERNAME),
				$error 			=> $error
			);
		);
	}

	/**
	 * Login check
	 *
	 * @Route('/login_check')
	 */
	public function loginCheckAction()
	{
	}
}
```
* Layout for the bundle named AdminBundle and the css rule for the same bundle
```
{% extends "::base.html.twig" %}

{% block stylesheet %}
	<link rel="stylesheet" type="text/css" href="{{ asset('bundle/admin/css/main.css') }}">
{% endblock %}

{% block body %}
	<header>
		<p>Symfony 2 - Admin</p>
		<nav>
			<ul>
				<li><a href="#">Posts</a></li>
				<li><a href="#">Authors</a></li>
			</ul>
		</nav>
	</header>

	<section>
		{% for type, message in app.sessionflashbag.all() %}
			<p class="session-message">{{ message }}</p>
		{% endfor %}

		{% block section %}{% endblock %}
	</section>
{% endblock %}
```
* Set up the application security
I will edit the file placed into `app/config/security.yml`
```
security:
    encoders:
        Symfony\Component\Security\Core\User\User: plaintext

    role_hierarchy:
        ROLE_ADMIN:       ROLE_USER
        ROLE_SUPER_ADMIN: [ROLE_USER, ROLE_ADMIN, ROLE_ALLOWED_TO_SWITCH]

    providers:
        in_memory:
            memory:
                users:
                    admin: { password: admin, roles: [ 'ROLE_ADMIN' ] }

    firewalls:
        dev:
            pattern:  ^/(_(profiler|wdt)|css|images|js)/
            security: false

        admin_area:
            pattern: ^/admin/
            anonymous: ~
            http_basic:
            form_login:
                login_path: blog_admin_security_login
                check_path: blog_admin_security_logincheck

    access_control:
        - { path: ^/admin/login, roles: IS_AUTHENTICATED_ANONYMOUSLY}
        - { path: ^/admin/, roles: ROLE_ADMIN }

```
