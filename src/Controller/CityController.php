<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\City;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CityType;
use Symfony\Component\Form\FormFactoryInterface;
use App\Service\CityService;


class CityController extends AbstractController {
	#[Route('/city/page', methods: ['GET', 'POST'])]
	public function cityPageAction(
			Request $request,
			FormFactoryInterface $formFactory,
			CityService $cityService
	) {
		$city = new City();
		$createForm = $formFactory->createNamed('createForm', CityType::class, $city, ['type' => 'create']);
		$updateForm = $formFactory->createNamed('updateForm', CityType::class, $city, ['type' => 'update']);
		$dropForm = $formFactory->createNamed('dropForm', CityType::class, $city, ['type' => 'drop']);

		$context = "Hello world";
		
		$createForm->handleRequest($request);
		$updateForm->handleRequest($request);
		$dropForm->handleRequest($request);
		
		if ($createForm->isSubmitted() && $createForm->isValid()) {	
			$formData = $createForm->getData();
			$cityService->create($formData);
			//$context = "1";
		}
		else if ($updateForm->isSubmitted() && $updateForm->isValid()) {	
			$formData = $createForm->getData();
			$cityService->update($formData);
			//$context = "2";
		}
		else if ($dropForm->isSubmitted() && $dropForm->isValid()) {	
			$formData = $createForm->getData();
			$cityService->drop($formData);
			//$context = "3";
		}
		$cities = $cityService->read();;
		return $this->render('citypage.html.twig', [ 'context' => $context,
													 'createForm' => $createForm,
													 'updateForm' => $updateForm,
													 'dropForm' => $dropForm,
													 'cities' => $cities,
													]);
	}
	
	#[Route('/')]
	public function indexAction(){
		return $this->redirect('/city/page');

	}

}
