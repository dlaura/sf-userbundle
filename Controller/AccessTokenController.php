<?php

namespace Onfan\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Onfan\UserBundle\Entity\User\User;
use Onfan\UserBundle\Entity\User\AccessToken;

use Onfan\UserBundle\Util\Codes as HttpCodes;
use Onfan\UserBundle\Util\CodeGenerator;

class AccessTokenController extends Controller
{

    /**
     * Create a new access token for an authenticated user
     * @Route("/accesstoken", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function getAccessTokenAction()
    {
        $serializer = $this->container->get('serializer');
        $em = $this->getDoctrine()->getManager();
        
        $request = Request::createFromGlobals();
        $response = new Response();
        
        
        $user = $this->getUser();
        if ($user) {
            // create new access token
            $token = new AccessToken();
            $token->setUser($user);

            // persist token
            $em->persist($token);
            $em->flush();

            // serialize token
            $output = $serializer->serialize($token, 'json');

            $response->setContent($output);
            return $response;                            
        } else {
            $response->setStatusCode(HttpCodes::HTTP_FORBIDDEN, "Invalid user/password credentials");
            return $response;
        }
    }
}
