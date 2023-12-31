<?php

namespace App\Controller;

use App\Entity\Student;
use App\Repository\GradeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GradesAverageByStudentController extends AbstractController
{
    public function __construct(
        private GradeRepository $gradeRepository
    ) {}
    
    public function __invoke(Student $data): ?array
    {
        //call query to calculate average by student
        $avg = $this->gradeRepository->getGradesAverageByStudent($data);
        if($avg)
        {
            $avg = number_format($avg, 2);
        }
        return ["average" => $avg];
    }
}