<?php

namespace Service;

use Model\QuizModel;
use Model\QuestionModel;
use Model\AnswerModel;
use Model\UserSummaryModel;


class QuizService 
{
    
    /**
     * Get a list of all quizes
     *
     * @return array
     */
    public function getQuizes(): array
    {
        $model = new QuizModel();
        
        return $model->find();
    }

    /**
     * Get a list of questions and answers identified by their quizId
     *
     * @param integer $quizId
     * @return array
     */
    public function getQuizQuestionsAnswers(int $quizId): array
    {
        $question = new QuestionModel;
        $answer   = new AnswerModel;
        $query    = "SELECT q.id as questionId, q.question, q.quiz_id as quizId, a.id as answerId, a.answer, a.is_correct FROM " . $question->getTableName() . " q LEFT JOIN " . $answer->getTableName() . " a ON q.id = a.question_id WHERE q.quiz_id = $quizId";

        if($result = $question->buildQuery($query)) {
            $rows = [];

            foreach ($result as $row) {
                $rows[$row['quizId']][$row['questionId']]['question'] = $row['question'];
                $rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']] = $row;
                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['quizId']);
                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['questionId']);
                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['question']);
                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['answerId']);
            }

            return $rows;
        }

        return [];
    }

    /**
     * Record user answer to a question
     *
     * @param integer $quizId
     * @param integer $questionId
     * @param integer $answerId
     * @return void
     */
    public function recordUserAnswer(int $quizId, int $questionId, int $answerId)
    {
        $model = new UserSummaryModel;

        $answerModel = new AnswerModel;
        $answer      = $answerModel->findById($answerId);

        $model->insert([
            'quiz_id'     => $quizId,
            'question_id' => $questionId,
            'answer_id'   => $answerId,
            'is_correct'  => $answer['is_correct']
        ]);
    }

    /**
     * Return user summary after taking a test
     *
     * @param integer $userId
     * @param integer $quizId
     * @return array
     */
    public function getUserSummary(int $userId, int $quizId): array
    {
        $model = new UserSummaryModel;

        if($quizSummary = $model->find(['user_id' => $userId, 'quiz_id' => $quizId])) {
            $stat = array_count_values(array_column($quizSummary, 'is_correct'));

            $result = [
                'totalQuestions' => $this->getQuizQuestionCount($quizId), 
                'totalAnswered'  => count($quizSummary),
                'correct'        => isset($stat[1]) ? $stat[1] : 0,
                'wrong'          => isset($stat[0]) ? $stat[0] : 0,
            ];

            return $result;
        }

        return [];
    }

    public function getQuizQuestionCount(int $quizId)
    {
        $model = new QuestionModel;

        $query = "SELECT count(id) as total FROM " . $model->getTableName() . " WHERE quiz_id=$quizId";
        if($result = $question->buildQuery($query)) {
            $result = isset($result[0]) ? $result[0] : [];
            return isset($result['total']) ? $result['total'] : 0;
        }

        return 0;
    }
}
