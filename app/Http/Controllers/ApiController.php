<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function saveAnswer(Request $request)
    {
        $quizAttempt = new QuizAttempt(['answer' => $request->input('answer')]);
        $question = Question::findOrFail($request->input('questionId'));
        $question->quizAttempts()->save($quizAttempt);

        return response()->json(['quiz_attempt_id' => $quizAttempt->getKey()]);
    }

    public function newQuestion(Request $request)
    {
        $question = $this->formulateQuestion();
        $question = new Question([
            'question'  => $question['expression'],
            'answer'    => $question['answer'],
            'quiz_id'    => $request->input('quizId')
        ]);
        $quiz = Quiz::findOrFail($request->input('quizId'));

        $quiz->questions()->save($question);

        return response()->json(['questionId' => $question->getKey(), 'expression' => $question->question]);
    }

    protected function formulateQuestion(): array
    {

        $input = array('+', '-', '/', '*');
        $sign = $input[mt_rand(0, 3)];
        $firstNumber = mt_rand(0, 10);
        $secondNumber = mt_rand(1, 10);
        $questionString = $firstNumber . $sign . $secondNumber.'=';
        switch ($sign) {
            case '+':
                $answer=$firstNumber+$secondNumber;
                break;
            case '-':
                $answer=$firstNumber-$secondNumber;
                break;
            case '*':
                $answer=$firstNumber*$secondNumber;
                break;
            case '/':
                $answer=$firstNumber/$secondNumber;
                break;
        }

        return ['expression' => "$firstNumber $sign $secondNumber =", 'answer' => $answer];
    }
}
