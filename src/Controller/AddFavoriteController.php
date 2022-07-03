<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use App\Repository\HotelRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class AddFavoriteController extends AbstractController
{
    private $userRepository;
    private $hotelRepository;

    public function __construct(HotelRepository $hotelRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->hotelRepository = $hotelRepository;
    }

    public function __invoke(User $data): User
    {
        $hotel = $this->hotelRepository->findOneBy(["id"=>$data->hotel_id_temp]);
        $user = $this->userRepository->findOneBy(["id"=>$data->getId()]);
        $user->addFavoritesHotel($hotel);
        return $data ;
    }
}
