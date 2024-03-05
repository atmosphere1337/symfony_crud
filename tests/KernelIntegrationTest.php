<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Service\CityService;
use App\Entity\City;

class KernelIntegrationTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();
        $container = static::getContainer();
        $cityService = $container->get(CityService::class);
        $this->assertEquals(count($cityService->read()), 0);

        $city = new City();
        $city->setAll("moscow", "russia", 1337); 
        $cityService->create($city);
        $result = $cityService->read();
        $result = $result[0];
        $this->assertEquals($result->getCity(), $city->getCity());
        $this->assertEquals($result->getCountry(), $city->getCountry());
        $this->assertEquals($result->getPopulation(), $city->getPopulation());
        $city->setCountry("ukraine");
        $cityService->update($city);
        $result = $cityService->read()[0];
        $this->assertEquals($result->getCountry(), $city->getCountry());
        $cityService->drop($result);
        $this->assertEquals(count($cityService->read()), 0);

        $this->assertSame('test', $kernel->getEnvironment());
    }
}
