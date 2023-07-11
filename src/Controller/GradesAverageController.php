<?php

namespace App\Controller;
use App\Repository\GradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GradesAverageController extends AbstractController
{
    public function __construct(
        private GradeRepository $gradeRepository
    ) {}
    
    public function __invoke(): ?array
    {
        $avg = $this->gradeRepository->getGradesAverage();
        if($avg)
        {
            $avg = number_format($avg, 2);
        }
        return ["average" => $avg];
    }
}