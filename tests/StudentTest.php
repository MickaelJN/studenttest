<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Student;

class StudentTest extends ApiTestCase
{
    public function testGetCollectionStudent(): void
    {
        $response = static::createClient()->request('GET', '/api/students');
        $this->assertResponseIsSuccessful();
        
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        
         $this->assertJsonContains([
            '@context' => '/api/contexts/Student',
            '@id' => '/api/students',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 1
        ]);
        
        $this->assertCount(1, $response->toArray()['hydra:member']);
        
        $this->assertMatchesResourceCollectionJsonSchema(Student::class);
    }
}
