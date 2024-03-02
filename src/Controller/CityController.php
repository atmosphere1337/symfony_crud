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
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CityController extends AbstractController {
	#[Route('/city/page', methods: ['GET', 'POST'], name: 'pageroot')]
	public function cityPageAction(
			Request $request,
			FormFactoryInterface $formFactory,
			CityService $cityService,
			ValidatorInterface $validator,
	) {
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED');
		$city = new City();
		$createForm = $formFactory->createNamed('createForm', CityType::class, $city, ['type' => 'create', 'validation_groups' => ['create']]);
		$updateForm = $formFactory->createNamed('updateForm', CityType::class, $city, ['type' => 'update','validation_groups' => ['update']]);
		$dropForm = $formFactory->createNamed('dropForm', CityType::class, $city, ['type' => 'drop','validation_groups' => ['drop']]);

		$context = "Hello world";
		
		$createForm->handleRequest($request);
		$updateForm->handleRequest($request);
		$dropForm->handleRequest($request);
		
		if ($createForm->isSubmitted() && $createForm->isValid()) {	
			$formData = $createForm->getData();
			//$validator->validate($formData, null, );
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
