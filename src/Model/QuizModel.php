<?php

namespace Model;

class QuizModel extends AbstractModel implements ModelInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'quiz';
    }
}