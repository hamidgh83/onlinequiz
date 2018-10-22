<?php

namespace Model;

class AnswerModel extends AbstractModel implements ModelInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'answer';
    }
}