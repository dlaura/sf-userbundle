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
     * Create a new user
     * @Route("/accesstoken", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function getAccessTokenAction()
    {
        $serializer = $this->container->get('serializer');
        $em = $this->getDoctrine()->getManager();
        
        $request = Request::createFromGlobals();
        $response = new Response();
        
        if ($request->request->has('type')) {
            $type = $request->request->get('type');
            switch ($type) {
                case 'userpass':
                    if ($request->request->has('username') && $request->request->has('password')) {
                        $username = $request->request->get('username');            
                        $password = $request->request->get('password');
                        
                        // check user's credentials
                        $user = $em->getRepository('OnfanUserBundle:User\User')->findOneBy(array(
                            'username' => $username,
                            'password' => $password
                        ));
                        
                        if ($user) {
                            // create new token
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
                    } else {
                        $response->setStatusCode(HttpCodes::HTTP_BAD_REQUEST, "You must pass username and password");
                        return $response;
                    }

                    break;
                case 'facebook':
                    if ($request->request->has('fb_access_token')) {
                        $fb_access_token = $request->request->get('fb_access_token');                        
                        
                        // validate facebook access token
                        // with PHP FB API
                        
                        if (true) {
                            // if there is already a user with this FBUser.email
                            if (true) {
                                // update existing user with FB.id
                                // load user into $user
                            } else {
                                // create a new user
                                // set FB.id, and other data from FB
                                // load user into $user
                            }
                            
                            // create new token
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
                            $response->setStatusCode(HttpCodes::HTTP_FORBIDDEN, "Invalid Facebook access token");
                            return $response;
                        }
                    } else {
                        $response->setStatusCode(HttpCodes::HTTP_BAD_REQUEST, "You must pass a valid Facebook access token");
                        return $response;
                    }


                    break;

                default:
                    // undefined authentication type
                    $response->setStatusCode(HttpCodes::HTTP_NOT_ACCEPTABLE, "Authentication method not acceptable");
                    return $response;
                    break;
            }
        } else {
            // authentication type required
            $response->setStatusCode(HttpCodes::HTTP_NOT_FOUND, "Authentication method not found");
            return $response;
            break;
        }
   
    }
    

    
}
