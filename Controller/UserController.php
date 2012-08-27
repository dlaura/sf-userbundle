<?php

namespace Onfan\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Onfan\UserBundle\Entity\User\User;

class UserController extends Controller
{
    /**
     * Get all users
     * @Route("/users", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('OnfanUserBundle:User\User')->findAll();
        
        $response = array();
        
        foreach ($users as $user) {
            $response[] = array(
                "id" => $user->getId(),
                "username" => $user->getUsername(),
            );
        }
        
        return new Response(json_encode($response));
    }
    
    /**
     * Create a new user
     * @Route("/users", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function createAction()
    {
        return array();
    }
    
    /**
     * Get a specific user
     * @Route("/users/{user_id}", defaults={"_format"="json"})
     * @Method({"GET"})
     */
    public function showAction($user_id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('OnfanUserBundle:User\User')->find($user_id);

        if (!$user) {
            throw $this->createNotFoundException('Unable to find User\User entity.');
        }
        
        $response = array(
            "id" => $user->getId(),
            "username" => $user->getUsername(),
        );
        
        return new Response(json_encode($response));
    }
    
    /**
     * Update a specific user
     * @Route("/users/{user_id}", defaults={"_format"="json"})
     * @Method({"PUT"})
     */
    public function updateAction($user_id)
    {
        return array();
    }
    
    /**
     * Delete a specific user
     * @Route("/users/{user_id}", defaults={"_format"="json"})
     * @Method({"DELETE"})
     */
    public function deleteAction($user_id)
    {
        return array();
    }
}
