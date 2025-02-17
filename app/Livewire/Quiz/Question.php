<?php

namespace App\Livewire\Quiz;

use Livewire\Component;

class Question extends Component
{
    public $question;
    public $options;
    public $answer;
    public $questions;
    public $keyCurrentQuestion;
    public $result;

    public function mount()
    {
        $this->questions = [
            0 => [
                'question' => 'Какой твой любимый язык программирования?',
                'right_answer' => 'PHP',
                'options' => [
                    0 => 'PHP',
                    1 => 'JavaScript',
                    2 => 'Python',
                    3 => 'C++'
                ]
            ],
            1 => [
                'question' => 'Какой фреймворк ты предпочитаешь для веб-разработки?',
                'right_answer' => 'Laravel',
                'options' => [
                    0 => 'Laravel',
                    1 => 'React',
                    2 => 'Vue.js',
                    3 => 'Django'
                ]
            ],
            2 => [
                'question' => 'Что ты считаешь самым важным в разработке?',
                'right_answer' => 'Оптимизация',
                'options' => [
                    0 => 'Оптимизация',
                    1 => 'Безопасность',
                    2 => 'Производительность',
                    3 => 'Код-стайл'
                ]
            ],
            3 => [
                'question' => 'Как часто ты пишешь тесты для своего кода?',
                'right_answer' => 'Часто',
                'options' => [
                    0 => 'Часто',
                    1 => 'Иногда',
                    2 => 'Редко',
                    3 => 'Никогда'
                ]
            ],
            4 => [
                'question' => 'Какую роль в команде ты предпочитаешь?',
                'right_answer' => 'Лидер',
                'options' => [
                    0 => 'Лидер',
                    1 => 'Разработчик',
                    2 => 'Тестировщик',
                    3 => 'Менеджер'
                ]
            ],
            5 => [
                'question' => 'Что для тебя важнее: скорость разработки или качество кода?',
                'right_answer' => 'Качество кода',
                'options' => [
                    0 => 'Качество кода',
                    1 => 'Скорость разработки',
                    2 => 'Баланс',
                    3 => 'Это не важно'
                ]
            ],
            6 => [
                'question' => 'Как ты подходишь к решению сложных задач?',
                'right_answer' => 'Анализирую и разлагаю на части',
                'options' => [
                    0 => 'Анализирую и разлагаю на части',
                    1 => 'Делаю сразу, как есть',
                    2 => 'Спрашиваю коллег',
                    3 => 'Использую готовые решения'
                ]
            ]
        ];
        $this->toggleQuestion();
    }

    public function next()
    {
        $this->questions[$this->keyCurrentQuestion] = array_merge(
            $this->questions[$this->keyCurrentQuestion], ['passed' => true, 'answer_got' => $this->answer]
        );
        $this->toggleQuestion();
        $this->reset('answer');
    }

    public function toggleQuestion()
    {
        $currentQuestion = null;
        foreach ($this->questions as $key => $question) {
            if (!isset($question['passed'])) { // проверка, был ли вопрос пройден
                $currentQuestion = $question;
                $this->keyCurrentQuestion = $key;
                $this->question = $currentQuestion['question'];
                $this->options = $currentQuestion['options'];
                break;
            }
        }
        if (is_null($currentQuestion)) {
            $this->result = $this->calculateRightAnswers($this->questions);
        }
    }

    public function calculateRightAnswers($questions)
    {
        return array_reduce($questions, function($carry, $question){
            if (isset($question['answer_got']) && $question['answer_got'] === $question['right_answer']) {
                $carry = $carry + 1;
            }
            return $carry;
        }, 0);
    }


    public function render()
    {
        return view('livewire.quiz.question')->extends('layouts.base');
    }
}
