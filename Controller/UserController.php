<?php

namespace Onfan\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Onfan\UserBundle\Entity\User\User;

use Onfan\UserBundle\Util\Codes as HttpCodes;
use Onfan\UserBundle\Util\CodeGenerator;

class UserController extends Controller
{
    /**
     * Get all users
     * @Route("/users", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $auth_user = $this->getUser();
        
        if (!$auth_user) {
            $response = new Response();
            $response->setStatusCode(HttpCodes::HTTP_FORBIDDEN, 'Authentication required');
            return $response;
        }
        
        $em = $this->getDoctrine()->getManager();

        //$users = $em->getRepository('OnfanUserBundle:User\User')->findAll();
        $users = $em->getRepository('OnfanUserBundle:User\User')->findOneBy(array(
            'username' => $auth_user->getUsername()
        ));
        
        $serializer = $this->container->get('serializer');
        $output = $serializer->serialize($users, 'json');
        
        return new Response($output);
    }
    
    /**
     * Create a new user
     * @Route("/users", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function createAction()
    {
        $serializer = $this->container->get('serializer');
        
        $request = Request::createFromGlobals();        
        
        $user = new User();
	
        // set data from request        
        if ($request->request->has('username')) {
            $username = $request->request->get('username');
            $user->setUsername($username);
        }
        
	if ($request->request->has('password')) {
            $password = $request->request->get('password');
            $user->setPassword($password);
        }
        
        if ($request->request->has('email')) {
            $email = $request->request->get('email');
            $user->setEmail($email);
        }
        
        if ($request->request->has('name')) {
            $name = $request->request->get('name');
            $user->setName($name);
        }
        
        if ($request->request->has('surname')) {
            $surname = $request->request->get('surname');
            $user->setSurname($surname);
        }
        
        if ($request->request->has('facebook_username')) {
            $facebook_username = $request->request->get('facebook_username');
            $user->setFacebookUsername($facebook_username);
        }
        
        if ($request->request->has('facebook_id')) {
            $facebook_id = $request->request->get('facebook_id');
            $user->setFacebookId($facebook_id);
        }
        
        // set new user's defaults
        $user->setIsVerified(false);
        $user->setVerificationCode(CodeGenerator::generateVerificationCode());
        
        // validate user
        $validator = $this->get('validator');
        $errors = $validator->validate($user);
        
        if (count($errors)) {
          $output_errors = $serializer->serialize($errors, 'json');
          $error_response = new Response();
          $error_response->setStatusCode(HttpCodes::HTTP_BAD_REQUEST, "Wrong input data");
          $error_response->setContent($output_errors);
          return $error_response;
        }
        
        // persist user in db
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($user);
        $em->flush();
        
        // send verification email
        $this->sendVerificationEmail($user);
        
        // serialize user object
        $output = $serializer->serialize($user, 'json');
        
        $response = new Response();
        $response->setStatusCode(HttpCodes::HTTP_CREATED, "User created");
        $response->setContent($output);
        return $response;
   
    }
    
    /**
     * Get a specific user
     * @Route("/users/{user_id}", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function showAction($user_id)
    {
        // TODO: Refactor !!!
        $auth_user = $this->getUser();
        
        if ($auth_user->getId() != $user_id) {
            $response = new Response();
            $response->setStatusCode(HttpCodes::HTTP_UNAUTHORIZED, 'Not authorized to view other users');
            return $response;
        }
        
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('OnfanUserBundle:User\User')->find($user_id);

        if (!$user) {
            $response =  new Response();
            $response->setStatusCode(HttpCodes::HTTP_NOT_FOUND, "Unable to find this User");
            return $response;
            //throw $this->createNotFoundException('Unable to find User\User entity.');
        }
        
        $serializer = $this->container->get('serializer');
        $output = $serializer->serialize($user, 'json');
        
        return new Response($output);
    }
    
    /**
     * Update a specific user
     * @Route("/users/{user_id}", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function updateAction($user_id)
    {
        $auth_user = $this->getUser();
        
        if ($auth_user->getId() != $user_id) {
            $response = new Response();
            $response->setStatusCode(HttpCodes::HTTP_UNAUTHORIZED, 'Not authorized to update other users');
            return $response;
        }
        
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->container->get('serializer');

        $user = $em->getRepository('OnfanUserBundle:User\User')->find($user_id);

        if (!$user) {
            $response =  new Response();
            $response->setStatusCode(HttpCodes::HTTP_NOT_FOUND, "Unable to find this User");
            return $response;
            //throw $this->createNotFoundException('Unable to find User\User entity.');
        }
        
        // update fields
        $request = Request::createFromGlobals();
        
	if ($request->request->has('password')) {
            $password = $request->request->get('password');
            $user->setPassword($password);
        }
        
        if ($request->request->has('email')) {
            $email = $request->request->get('email');            
            $user->setEmail($email);
        }
        
        if ($request->request->has('name')) {
            $name = $request->request->get('name');
            $user->setName($name);
        }
        
        if ($request->request->has('surname')) {
            $surname = $request->request->get('surname');
            $user->setSurname($surname);
        }
        
        if ($request->request->has('facebook_username')) {
            $facebook_username = $request->request->get('facebook_username');
            $user->setFacebookUsername($facebook_username);
        }
        
        if ($request->request->has('facebook_id')) {
            $facebook_id = $request->request->get('facebook_id');
            $user->setFacebookId($facebook_id);
        }
        
        // validate updated user
        $validator = $this->get('validator');
        $errors = $validator->validate($user);
        
        if (count($errors)) {
          $output_errors = $serializer->serialize($errors, 'json');
          $error_response = new Response();
          $error_response->setStatusCode(HttpCodes::HTTP_BAD_REQUEST, "Wrong input data");
          $error_response->setContent($output_errors);
          return $error_response;
        }
        
        // update user in db
        $em->flush();
        
        $output = $serializer->serialize($user, 'json');        
        $response =  new Response();
        $response->setStatusCode(HttpCodes::HTTP_RESET_CONTENT, "User updated");
        $response->setContent($output);
        return $response;
    }
    
    /**
     * Delete a specific user
     * @Route("/users/{user_id}", defaults={"_format"="json"})
     * @Method({"DELETE"})
     */
    public function deleteAction($user_id)
    {
        $auth_user = $this->getUser();
        
        if ($auth_user->getId() != $user_id) {
            $response = new Response();
            $response->setStatusCode(HttpCodes::HTTP_UNAUTHORIZED, 'Not authorized to delete other users');
            return $response;
        }
        
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('OnfanUserBundle:User\User')->find($user_id);

        if (!$user) {
            $response =  new Response();
            $response->setStatusCode(HttpCodes::HTTP_NOT_FOUND, "Unable to find this User");
            return $response;
            //throw $this->createNotFoundException('Unable to find User\User entity.');
        }
        
        // remove all user's tokens first from db
        foreach ($user->getAccessTokens() as $token) {
            $em->remove($token);
        }
        $em->flush();
        
        // remove user from db
        $em->remove($user);
        $em->flush();
        
        $response =  new Response();
        $response->setStatusCode(HttpCodes::HTTP_NO_CONTENT, "User deleted");
        return $response;
    }
    
    /**
     * Verify a specific user
     * @Route("/users/verified/{verification_code}", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function verifyAction($verification_code)
    {
        $em = $this->getDoctrine()->getManager();
        
        // get user by verification code
        $user = $em->getRepository('OnfanUserBundle:User\User')->findOneBy(array(
            'verification_code' => $verification_code
        ));

        if (!$user) {
            $response =  new Response();
            $response->setStatusCode(HttpCodes::HTTP_NOT_FOUND, "Unable to find a User for this Code");
            return $response;
            //throw $this->createNotFoundException('Unable to find User\User entity.');
        }
        
        // verify user
        $user->setIsVerified(true);
        $user->setVerificationCode(null);
        $em->flush();
        
        // send confirmation email
        $this->sendConfirmationEmail($user);
        
        $response =  new Response();
        $response->setStatusCode(HttpCodes::HTTP_RESET_CONTENT, "User verified");
        return $response;
    }
    
    /**
     * Send verification email to user
     * 
     * @param \Onfan\UserBundle\Entity\User\User $user
     */
    public function sendVerificationEmail(User $user)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('Onfan - Email de Verificacion de Cuenta')
                ->setFrom('rhgwebdev@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('OnfanUserBundle:User:verification.email.txt.twig', array(
                        'verification_code' => $user->getVerificationCode(),
                )));
        $this->get('mailer')->send($message);			
    }
    
    /**
     * Send confirmation email to user
     * 
     * @param \Onfan\UserBundle\Entity\User\User $user
     */
    public function sendConfirmationEmail(User $user)
    {
        $message = \Swift_Message::newInstance()
                ->setSubject('Onfan - Email de Confirmacion de Cuenta')
                ->setFrom('rhgwebdev@gmail.com')
                ->setTo($user->getEmail())
                ->setBody($this->renderView('OnfanUserBundle:User:confirmation.email.txt.twig', array()));
        $this->get('mailer')->send($message);
    }
    
}
