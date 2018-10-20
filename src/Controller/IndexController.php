<?php

namespace Controller;

class IndexController extends AbstractController
{

    public function IndexAction()
    {
        $this->render('home');
    }

}