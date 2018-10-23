<?php

namespace Controller;

use Service\QuizService;

class SummaryController extends AbstractController
{
    private $service;

    public function __construct()
    {
        $this->service = new QuizService;
    }

    public function IndexAction()
    {
        if($this->service->isQuizStoped()) {
            $this->redirect('index', 'index');
        }

        $summary = $this->service->getUserSummary();

        $this->service->endQuiz();

        $this->render('index', $summary);
    }

}