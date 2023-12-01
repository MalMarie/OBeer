<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    // class used to redirect the user to the last visited page before connection
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * Method to authenticate an user 
     *
     * @param Request $request
     * @return Passport
     */
    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        // Passport contains all informations about user authenticating information (email / password)
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                // automatically adds CSRF token to check capabilities of this authenticator
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    /**
     * Methode to handle the success of authentication
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Redirect to the url saved in session that forced the user to connect 
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) 
        {
            // redirect to the targeted path (visited page before connection)
            return new RedirectResponse($targetPath);
        }

        // or redirect to a default road (here index.html.twig -> homepage)
        return new RedirectResponse($this->urlGenerator->generate('app_main_index'));
    }

    /**
     * Generate the login route
     * 
     * @param Request $request
     * @return string
     */
    protected function getLoginUrl(Request $request): string
    {
        // LOGIN_ROUTE = app_login
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
