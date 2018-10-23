<?php

namespace Model;

class UserQuizModel extends AbstractModel implements ModelInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'user_quiz';
    }
}