<?php

namespace Controller;

use Service\QuizService;

class QuizController extends AbstractController
{

    public function IndexAction()
    {
        $progress = 0;
        $service  = new QuizService;

        // Register the user and start a new quiz
        if(isset($_POST['qid'], $_POST['username'])) {
            $service->resetQuiz();
            $userId = $service->registerUser($_POST['username'], $_POST['qid']);
            $service->startQuiz($_POST['qid'], $userId);
        }
        
        // Record user answers to the questions
        elseif(isset($_POST['question'])) {
            $quizId = $service->getCurrentQuiz();
            $userId = $service->getCurrentUser();

            $service->recordUserAnswer($userId, $quizId, $_POST['question'], $_POST['answer']);
            $progress = $service->getUserProgress($userId);
        }

        // Redirect to summary page if all questions are answered
        if(!$question = $service->getNextQuestion()) {
            $this->redirect('summary', 'index');
        }

        $this->render('index', [
            'question'   => isset($question['question']) ? $question['question'] : null, 
            'questionId' => isset($question['id']) ? $question['id'] : null,
            'answers'    => isset($question['answers']) ? $question['answers'] : [], 
            'progress'   => $progress
        ]);
    }

}
