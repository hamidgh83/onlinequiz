<?php

namespace Controller;

use Service\QuizService;
use Service\SessionService;

class IndexController extends AbstractController
{

    public function IndexAction()
    {
        $service = new QuizService;
        $quizes  = $service->getQuizes();

        $this->render('home', ['quizes' => $quizes]);
    }

}