# multi-string-widget

MultiStringWidget - виджет для отображения и редактирования (добавление и удаление элементов  + редактирование значений полей) списка строковых полей.

## Установка

1. Загрузить через git: https://github.com/novokshonovev/multi-string-widget.git
или 
2. Установка через composer 
2.1 Добавить в composer.json проекта:
* репозиторий 
```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/novokshonovev/multi-string-widget"
        }
    ],
```
* и зависимость
```json
    "require": {
        "dowlatow/multi-string-widget": "dev-master"
    },
```
2.2 Выполнить установку: ``composer install``


## Параметры
*TODO*
## Пример использования
```php
<?php $multiQuestions = Mul::begin([
        'model'          => $model,
        'attribute'      => 'questions',
        'externalData'   => ['formId' => $form->getId()],
        'addLinkOptions' => function ($item, MultiStringWidget $widget) {
            return Html::a(Yii::t('poll', 'Add question'), '#', [
                'class'            => 'btn add-question ' . $widget->addLinkClass(),
                'data-sample-item' => $item
            ]);
        },
        'listOptions'    => ['class' => 'question-list'],
        // проброс контента, что бы MultiString не рисовал лишнего к кастомному "инпуту"
        'itemOptions'    => function ($input) {
            return $input;
        },
        'inputOptions'   => function ($key, $model, MultiStringWidget $widget) {
            return $this->render('_question_item', ['model' => $model, 'key' => $key, 'widget' => $widget]);
        },
        'clientOptions'  => [
            'afterInsert'       => new JsExpression('$(\'#' . $form->getId() . '\').editPollForm(\'getQuestionAfterInsert\')'),
            'afterDelete'       => new JsExpression('$(\'#' . $form->getId() . '\').editPollForm(\'getQuestionAfterDelete\')'),
            'protectSingleItem' => true
        ]
]); ?>
```