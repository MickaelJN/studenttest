<?php

namespace App\Entity;

use App\Controller\GradesAverageController;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\GradeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
#[ApiResource(
    operations: [
        new Post(denormalizationContext: ["groups" => ["grade:write"]]),
    ],
)]
#[ApiResource(
    operations: [
        new getCollection(
            name: "average",
            uriTemplate: "/grades/average",
            controller: GradesAverageController::class,
            paginationEnabled: false,
            openapiContext: [
                'summary' => 'Retrieves the average of all grades',
                'parameters' => [], 
                'responses' => [
                    '200' => [
                        'description' => "Success return average",
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'array',
                                    'example' => ["average" => 10.5]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ),
    ],
)]
class Grade {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 2)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Assert\Range(
        min: 0,
        max: 20,
        notInRangeMessage: 'Score must be between {{ min }} and {{ max }}'
    )]
    #[Groups(['grade:item', 'grade:write', 'student:item'])]
    private ?string $score = null;

    #[ORM\Column(length: 64)]
    #[Assert\NotNull()]
    #[Assert\NotBlank()]
    #[Groups(['grade:item', 'grade:write', 'student:item'])]
    private ?string $subject = null;

    #[ORM\ManyToOne(inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['grade:item', 'grade:write'])]
    private ?Student $student = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getScore(): ?string {
        return $this->score;
    }

    public function setScore(string $score): static {
        $this->score = $score;

        return $this;
    }

    public function getSubject(): ?string {
        return $this->subject;
    }

    public function setSubject(string $subject): static {
        $this->subject = $subject;

        return $this;
    }

    public function getStudent(): ?Student {
        return $this->student;
    }

    public function setStudent(?Student $student): static {
        $this->student = $student;

        return $this;
    }

}
