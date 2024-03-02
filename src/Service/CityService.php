<?php
namespace App\Service;
use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;

class CityService {
    public function __construct(public EntityManagerInterface $entityManager,
                                
    ) {

    }
    public function read() {
        $result = $this->entityManager->getRepository(City::class)->findAll();
        return $result;
    }
    public function create($formInput) {
        $this->entityManager->persist($formInput);
        $this->entityManager->flush();
    }
    public function update($formInput) {
        $existingCity = $this->entityManager->getRepository(City::class)->find($formInput->getId());
        $existingCity->clown($formInput);
        $this->entityManager->flush();
        //dd($existingCity);
    }
    public function drop($formInput) {
        $existingCity = $this->entityManager->getRepository(City::class)->find($formInput->getId());
        $this->entityManager->remove($existingCity);
        $this->entityManager->flush();
        //dd($formInput);
    }
    
}