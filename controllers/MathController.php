<?php

namespace Controllers;

use Core\Controller;

class MathController extends Controller
{
    const DAYS_IN_A_YEAR = 365;
    const DAYS_IN_A_MONTH = 30;

    public function calculateScore($score1, $score2, $score3, $score4)
    {
        $score = ($score1 + $score2 + $score3 + $score4) / 4;

        $message = 'Aluno Reprovado';

        if ($score >= 7) {
            $message = 'Aluno Aprovado';
        }

        $this->view('math/score', ['score' => $score, 'message' => $message]);
    }

    public function calculateTemperature($celsius)
    {
        $fahrenheit = ($celsius * 9 / 5) + 32;

        $this->view('math/temperature', ['celsius' => $celsius, 'fahrenheit' => $fahrenheit]);
    }

    public function calculateAge($years, $months, $days)
    {
        $ageInDays = $years * self::DAYS_IN_A_YEAR;

        $ageInDays += $months * self::DAYS_IN_A_MONTH;

        $ageInDays += $days;

        $this->view('math/age', ['age' => $ageInDays]);
    }

}
