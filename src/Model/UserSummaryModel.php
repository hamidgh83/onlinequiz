<?php

namespace Model;

class UserSummaryModel extends AbstractModel implements ModelInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTableName()
    {
        return 'user_summary';
    }
}