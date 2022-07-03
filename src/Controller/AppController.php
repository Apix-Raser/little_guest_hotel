<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;

class AppController extends AbstractController
{

    
    #[Route('/', name: 'app_app')]
    public function index(Request $request): Response
    {
       
        $user_id = $request->get('user_id');

        $data = null;
       
        if($user_id!=null){
            $client = HttpClient::create();
       
            $path = 'http://localhost:8000/api/users/'.$user_id.'/favorites_hotels';
            $response = $client->request('GET', $path);
            $data = get_object_vars(json_decode($response->getContent()))["hydra:member"];
        }

 
        // dd($data);
       
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'data'=> $data,
            'user_id'=> $user_id
        ]);
    }

   
}
