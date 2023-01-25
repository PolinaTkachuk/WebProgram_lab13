<?php

namespace App\Http\Controllers;

use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Models\Quiz;
use Illuminate\Http\Request;

class UIController extends Controller
{
    public function startQuiz()
    {
        $quiz = new Quiz();
        $quiz->save();

        return view('quiz', ['quizId' => $quiz->getKey()]);
    }

    public function home()
    {
        return view('home');
    }

    public function getQuizResult()
    {
        $quiz = Quiz::findOrFail(Quiz::max('id'));
        $questions = $quiz->questions()->with('quizAttempts')->get();
        $totalQuestions = $questions->count();
        $correctAnswers = 0;
        $finalUserExpressions = [];
        foreach($questions as $question) {
            // we use first() here, because we know that in this program one question WILL NEVER have more than one attempt.
            $quizAttempt = $question->quizAttempts->first();
            $finalUserExpressions[] = $question->question . ' ' . $quizAttempt?->answer;
            if ($quizAttempt?->answer == $question->answer) {
                $correctAnswers++;
            }
        }

        return view('result', ['totalQuestions' => $totalQuestions, 'correctAnswers' => $correctAnswers, 'finalUserExpressions' => $finalUserExpressions]);
    }
}
git remote add origin git@github.com:PolinaTkachuk/WebProgram_lab13.git
