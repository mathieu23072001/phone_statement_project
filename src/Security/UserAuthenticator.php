<?php

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use App\Repository\UserRepository;
use Symfony\Component\Security\Guard\PasswordAuthenticatedInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;







class UserAuthenticator extends AbstractFormLoginAuthenticator implements PasswordAuthenticatedInterface
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator, CsrfTokenManagerInterface $csrfTokenManager,UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;


    }

    public function supports(Request $request)
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $credentials['email']]);
       
       

        if (!$user) {
            throw new UsernameNotFoundException('Email non trouv??.');
    
        }
        $mail = $user->getEmail();
          
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['active'=> 1,'email'=>$mail]);
          
        if (!$user) {
            throw new UsernameNotFoundException('Compte non actif.');
           
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        
        return $this->passwordEncoder->isPasswordValid($user, $credentials['password']);


        // Check the user's password or other credentials and return true or false
        // If there are no credentials to check, you can just return true
       // throw new \Exception('TODO: check the credentials inside '.__FILE__);
    } 
    
      
    /**
    * Used to upgrade (rehash) the user's password automatically over time.
    */
   public function getPassword($credentials): ?string
   {
       return $credentials['password'];
   }


    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        // For example : return new RedirectResponse($this->urlGenerator->generate('some_route'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
        $users= $this->userRepository->findOneBy(['email'=>$request->get('email')]);
        if($users->getRoles()==['ROLE_ADMIN'] ){
        return new RedirectResponse($this->urlGenerator->generate('admin_accueil'));
      }

      if($users->getRoles()==['ROLE_ADS']){
        return new RedirectResponse($this->urlGenerator->generate('ads_accueil'));
      }

      if($users->getRoles()==['ROLE_RDC']){
        return new RedirectResponse($this->urlGenerator->generate('rdc_accueil'));
      }

      if($users->getRoles()==['ROLE_COMM']){
        return new RedirectResponse($this->urlGenerator->generate('comm_accueil'));
      }


     


    }

    protected function getLoginUrl()
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
