<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title> Quiz - Backend3</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
            integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
            crossorigin="anonymous"></script>
</head>

<body onload="displayNewQuestion()">
<header>
    <div class="header">Backend3</div>
    <a href="/home" class="Home">Home</a>
    <a href="/Mockups" class="Home">Mockups</a>
</header>

<div class="content">
    <h2>Mockups</h2>
    <div class="menu">
        <div>Quiz</div>
        <div id="question"> </div>
        <div><input size="40" id="answer"></div>
        <div class="button">
            <button href="Mockups/Quiz" onclick="updateQuestion()">Next</button>
            <button class="Finish" onclick="finishQuiz()">Finish</button>
        </div>

    </div>

</div>
<footer>© 2022 - Backend3</footer>
</body>
</html>

<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        margin-left: 7%;
    }
    header{
        padding-top: 3%;
        padding-bottom: 3%;
        background-color: black;
        color:gray;
        font-size: 20px;
        font-weight: bold;
        margin:-10px -10px -10px -8%;
        text-align: left;

    }
    .header{
        font-size: 30px;
        padding-left:7%;
        display: inline-block;

    }
    .Home{
        padding-left:45px;
        color:gray;
        text-decoration:none;
    }
    h2{
        font-size: 48px;
    }
    input{
        width: 350px;
        height: 40px;
        border:2px solid gray;
        border-radius: 5px;
    }
    .button{
        margin-top: 20px;
    }
    .button button{
        height: 40px;
        width: 75px;
        font-size: 16px;
        border:2px solid gray;
        border-radius: 5px;
    }
    .Finish{
        color:white;
        background-color: #3473b6;
    }
    footer {
        border-top: solid 1px gainsboro;
        padding-top: 35px;
        margin-top: 30px;
        font-size: 16px;
    }

</style>

<script>
    // on page load retrieve new question


    function updateQuestion() {
        saveAnswer();
        displayNewQuestion();
    }

    function finishQuiz() {
        saveAnswer();
        window.location.replace('http://localhost:8000/Mockups/Quiz/Result');
    }

    function saveAnswer() {
        let answer = document.getElementById('answer').value;
        $.ajax({
            method: 'POST',
            url: 'http://localhost:8000/api/quiz-attempt',
            data: { "answer": answer, "questionId": localStorage.getItem('questionId'), 'quizId': {{$quizId}} },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                clearAnswer();
            },
            error: function (data) {
                console.log(data);
                alert('ERROR WHILE SAVING ANSWER');
            }
        });
    }

    function displayNewQuestion() {
        $.ajax({
            method: 'POST',
            url: 'http://localhost:8000/api/question',
            data: { 'quizId': {{$quizId}} },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                localStorage.setItem('questionId', data.questionId);
                clearOldQuestion();
                fillNewQuestion(data.expression);
            },
            error: function (data) {
                console.log(data);
                alert('ERROR WHILE FETCHING NEW QUESTION');
            }
        });
    }

    function clearAnswer() {
        document.getElementById('answer').value = '';
    }

    function clearOldQuestion() {
        document.getElementById('question').innerText = '';
    }

    function fillNewQuestion(expression) {
        document.getElementById('question').innerText = expression;
    }
</script>
