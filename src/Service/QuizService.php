<?php

namespace Service;

use Model\QuizModel;
use Model\QuestionModel;
use Model\AnswerModel;
use Model\UserSummaryModel;
use Model\UserQuizModel;


class QuizService 
{
    protected $session;

    private $questions;

    public function __construct()
    {
        $this->session = new SessionService;
    }
    
    /**
     * Register a user once quiz is started
     *
     * @param string $username
     * @param integer $quizId
     * @return integer
     */
    public function registerUser(string $username, int $quizId)
    {
        $model = new UserQuizModel;
        $data  = [
            'username'   => $username,
            'quiz_id'    => $quizId,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $userId = $model->insert($data);

        $this->session->set('user', $userId);

        return $userId;
    }

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
    public function getQuestionsAnswers(int $quizId): array
    {
        $question = new QuestionModel;
        $answer   = new AnswerModel;
        $query    = "SELECT q.id as questionId, q.question, q.quiz_id as quizId, a.id as answerId, a.answer, a.is_correct FROM " . $question->getTableName() . " q LEFT JOIN " . $answer->getTableName() . " a ON q.id = a.question_id WHERE q.quiz_id = $quizId";

        if($result = $question->buildQuery($query)) {
            $rows = [];

            foreach ($result as $row) {
                $rows[$row['quizId']][$row['questionId']]['id']                        = $row['questionId'];
                $rows[$row['quizId']][$row['questionId']]['question']                  = $row['question'];
                $rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']] = $row;

                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['quizId']);
                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['questionId']);
                unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['question']);
                // unset($rows[$row['quizId']][$row['questionId']]['answers'][$row['answerId']]['answerId']);
            }

            return $rows;
        }

        return [];
    }

    /**
     * Returns questions count of a given quiz
     *
     * @param integer $quizId
     * @return integer
     */
    public function getQuestionsCount(int $quizId)
    {
        $model = new QuestionModel;

        return $model->numRows(['quiz_id' => $quizId]);
    }

    /**
     * Save current quiz
     *
     * @param integer $quizId
     * @param integer $userId
     * @return void
     */
    public function startQuiz(int $quizId, int $userId)
    {
        $this->session->set('quiz', $quizId);
        $this->session->set('user', $userId);
    }

    /**
     * End current quiz and clear all sessions
     *
     * @return void
     */
    public function endQuiz()
    {
        $this->session->clear();
    }

    public function resetQuiz()
    {
        $this->session->clear('questions');
        $this->session->clear('currentQuestion');
    }

    /**
     * Checks if the quiz has been stoped
     *
     * @return boolean
     */
    public function isQuizStoped()
    {
        return !$this->session->has('questions');
    }

    /**
     * Get active quiz
     *
     * @return array|null
     */
    public function getQuiz()
    {
        $model  = new QuizModel;
        $quizId = $this->session->get('quiz');

        if($quiz = $model->find($quizId)) {
            return [
                'data'    => $quiz,
                'summary' => ['questionsCount' => $this->getQuestionsCount($quizId)]
            ];
        }

        return null;
    }

    /**
     * Returns the next question
     *
     * @return array|bool question array if next question is existent otherwise false
     */
    public function getNextQuestion()
    {
        if(!$this->session->has('quiz')) {
            throw new \Exception('No quiz has been started yet.');
        }

        $quizId = $this->getCurrentQuiz();

        if(!$this->session->has('questions')) {
            $this->session->set('questions', $this->getQuestionsAnswers($quizId));
            $this->session->set('currentQuestion', current($this->getQuestions()));
            $this->session->set('answered', 0);
        }
        else {
            $questions       = $this->getQuestions();
            $currentQuestion = $this->getCurrentQuestion();
            
            while (current($questions) !== $currentQuestion) {
                next($questions); 
            } 
            
            $this->session->set('currentQuestion', next($questions));
        }

        return $this->getCurrentQuestion();
    }

    public function getUserProgress()
    {
        $quizId         = $this->getCurrentQuiz();
        $answered       = $this->getAnsweredQuestions();
        $totalQuestions = $this->getQuizQuestionCount($quizId);

        return floor(($answered / $totalQuestions) * 100);
    }

    /**
     * Returns started quiz questions list
     *
     * @return array
     */
    public function getQuestions()
    {
        $questions = $this->session->get('questions');

        if(is_array($questions) && count($questions) > 0) {
            return current($questions);
        }

        return [];
    }

    /**
     * Returns current quiz
     *
     * @return integer
     */
    public function getCurrentQuiz()
    {
        return $this->session->get('quiz');
    }

    /**
     * Returns current userId
     *
     * @return integer
     */
    public function getCurrentUser()
    {
        return $this->session->get('user');
    }
    
    /**
     * Return current question which user is answering to
     *
     * @return array
     */
    public function getCurrentQuestion()
    {
        return $this->session->get('currentQuestion');
    }

    /**
     * Record user answer to a question
     *
     * @param integer $quizId
     * @param integer $questionId
     * @param integer $answerId
     * @return void
     */
    public function recordUserAnswer(int $userId, int $quizId, int $questionId, int $answerId)
    {
        $model = new UserSummaryModel;

        $answerModel = new AnswerModel;
        $answer      = $answerModel->findById($answerId);

        $model->insert([
            'user_id'     => $userId,
            'quiz_id'     => $quizId,
            'question_id' => $questionId,
            'answer_id'   => $answerId,
            'is_correct'  => $answer['is_correct']
        ]);

        $this->session->set('answered', ($this->getAnsweredQuestions() + 1));
    }

    /** 
     * Returns numbert of answered questions
     */
    public function getAnsweredQuestions()
    {
        return $this->session->get('answered');
    }

    /**
     * Return user summary after taking a test
     *
     * @return array
     */
    public function getUserSummary(): array
    {
        $model  = new UserSummaryModel;
        $userId = $this->getCurrentUser(); 
        $quizId = $this->getCurrentQuiz();

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
        if($result = $model->buildQuery($query)) {
            $result = isset($result[0]) ? $result[0] : [];
            return isset($result['total']) ? $result['total'] : 0;
        }

        return 0;
    }
}
