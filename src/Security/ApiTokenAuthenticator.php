<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiTokenAuthenticator extends AbstractAuthenticator
{
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    public function supports(Request $request): ?bool
    {
        //check if it's a request for the api
        return str_starts_with($request->getPathInfo(),'/api/');
    }

    public function authenticate(Request $request): Passport
    {
        //getting the token
        $apiToken= $request->headers->get('x-api-token');

        if (null=== $apiToken) {
            throw new CustomUserMessageAuthenticationException('No api token provided');
        }
        //get the user via the token and anthenticate him
        return new SelfValidatingPassport(
            new UserBadge($apiToken, function($apiToken){
                $user=$this->userRepository->findByApiToken($apiToken);
                
                if (!$user) {
                throw new UserNotFoundException();
                }

                return $user;
            })
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
         return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        //error message
       $data=[
        'message'=> strtr($exception->getMessageKey(), $exception->getMessageData())
       ];
       return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

//    public function start(Request $request, AuthenticationException $authException = null): Response
//    {
//        /*
//         * If you would like this class to control what happens when an anonymous user accesses a
//         * protected page (e.g. redirect to /login), uncomment this method and make this class
//         * implement Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface.
//         *
//         * For more details, see https://symfony.com/doc/current/security/experimental_authenticators.html#configuring-the-authentication-entry-point
//         */
//    }
}
