<?php

namespace Controllers;

use Core\Controller;
use Core\Request;
use Core\Session;
use Core\Validator;

class MathController extends Controller
{
    const DAYS_IN_A_YEAR = 365;
    const DAYS_IN_A_MONTH = 30;

    public function calculateScore($score1, $score2, $score3, $score4)
    {
        try {
            Validator::getInstance()->validate([
                'score1' => $score1,
                'score2' => $score2,
                'score3' => $score3,
                'score4' => $score4,
            ], [
                'score1' => 'integer',
                'score2' => 'integer',
                'score3' => 'integer',
                'score4' => 'integer',
            ]);

            $score = ($score1 + $score2 + $score3 + $score4) / 4;

            $message = 'Aluno Reprovado';

            if ($score >= 7) {
                $message = 'Aluno Aprovado';
            }

            $this->view('math/score', ['score' => $score, 'message' => $message]);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());

            Request::redirect('/');
        }
    }

    public function calculateTemperature($celsius)
    {
        try {
            Validator::getInstance()->validate([
                'celsius' => $celsius
            ], [
                'celsius' => 'integer'
            ]);

            $fahrenheit = ($celsius * 9 / 5) + 32;

            $this->view('math/temperature', ['celsius' => $celsius, 'fahrenheit' => $fahrenheit]);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());

            Request::redirect('/');
        }

    }

    public function calculateAge($years, $months, $days)
    {
        try {
            Validator::getInstance()->validate([
                'years' => $years,
                'months' => $months,
                'days' => $days,
            ], [
                'years' => 'integer',
                'months' => 'integer',
                'days' => 'integer',
            ]);


            $ageInDays = $years * self::DAYS_IN_A_YEAR;

            $ageInDays += $months * self::DAYS_IN_A_MONTH;

            $ageInDays += $days;

            $this->view('math/age', ['age' => $ageInDays]);
        } catch (\Exception $exception) {
            Session::flash('message', $exception->getMessage());

            Request::redirect('/');
        }

    }

}
