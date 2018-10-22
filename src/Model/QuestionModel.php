<?php

namespace Model;

class QuestionModel extends AbstractModel implements ModelInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'question';
    }
}