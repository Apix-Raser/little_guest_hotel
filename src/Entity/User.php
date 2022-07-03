<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\AddFavoriteController;
use App\Controller\RemoveFavoriteController;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
  
    itemOperations: [
        "get", "put", "patch", "delete",
        'add_favorite' => [
            'method' => 'PATCH',
            'path' => '/users/{id}/addfavorite',
            'controller' => AddFavoriteController::class,
            'denormalization_context' => ['groups' => 'favorite'],
            'openapi_context'=>[
                'summary' => 'allow user to add a favorite hotel',
            ],
            'formats' => ['json'],
        ],
        'remove_favorite' => [
            'method' => 'PATCH',
            'path' => '/users/{id}/removefavorite',
            'controller' => RemoveFavoriteController::class,
            'denormalization_context' => ['groups' => 'favorite'],
            'openapi_context'=>[
                'summary' => 'allow user to remove a favorite hotel',
            ],
            'formats' => ['json'],
        ],
    ],
    collectionOperations:[
        "post"=>[
            'denormalization_context' => ['groups' => 'postUser'],
        ],"get"
    ],
    subresourceOperations:[
        'getsubresouce' => [
            'method' => 'GET',
            'openapi_context'=>[
                'summary' => 'get all favorites hotels for a user',
            ],
        ],
    ]
)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['favorite'])]
    private $id;

    #[Groups(['postUser'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $firstName;
    #[Groups(['postUser'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $lastName;
    #[Groups(['postUser'])]
    #[ORM\Column(type: 'string', length: 300)]
    private $email;

    #[ORM\ManyToMany(targetEntity: Hotel::class)]
    #[ApiSubresource]
    private $favorites_hotels;

    #[Groups(['favorite'])]
    public $hotel_id_temp;

    public function __construct()
    {
        $this->favorites_hotels = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Hotel>
     */
    public function getFavoritesHotels(): Collection
    {
        return $this->favorites_hotels;
    }

    public function addFavoritesHotel(Hotel $favoritesHotel): self
    {
        if (!$this->favorites_hotels->contains($favoritesHotel)) {
            $this->favorites_hotels[] = $favoritesHotel;
        }

        return $this;
    }

    public function removeFavoritesHotel(Hotel $favoritesHotel): self
    {
        $this->favorites_hotels->removeElement($favoritesHotel);

        return $this;
    }
 
}
