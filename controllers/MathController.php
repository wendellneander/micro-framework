<?php

namespace Controllers;

use Core\Controller;

class MathController extends Controller
{
    public function calculateScore($score1, $score2, $score3, $score4)
    {
        $score = ($score1 + $score2 + $score3 + $score4) / 4;

        $message = 'Aluno Reprovado';

        if($score >= 7){
            $message = 'Aluno Aprovado';
        }

        $this->view('math/score', ['score' => $score, 'message' => $message]);
    }

    public function  calculateTemperature($celsius)
    {
        $fahrenheit  = ($celsius * 9/5) + 32;

        $this->view('math/temperature', ['celsius' => $celsius, 'fahrenheit' => $fahrenheit]);
    }

}
