<?php

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */ // Объявляем тип dataProvider
/** @var string $searchQuery */ // Добавляем объявление переменной для поискового запроса

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView; // Подключаем ListView
// use yii\grid\GridView; // Если вы используете GridView

$this->title = 'Топики форума';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="topic-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="search-form mb-4">
        <?= Html::beginForm(['topic/index'], 'get', ['class' => 'form-inline']) ?>
            <div class="input-group">
                <?= Html::textInput('q', $searchQuery ?? '', ['class' => 'form-control', 'placeholder' => 'Искать топики...']) ?>
                <button type="submit" class="btn btn-primary">Поиск</button>
            </div>
        <?= Html::endForm() ?>
    </div>

    <?php if (!Yii::$app->user->isGuest): ?>
        <p>
            <?= Html::a('Создать новый топик', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
    <?php else: ?>
        <p class="alert alert-info">
            Пожалуйста, <?= Html::a('войдите', ['/site/login']) ?> или <?= Html::a('зарегистрируйтесь', ['/user/signup']) ?>, чтобы создавать топики.
        </p>
    <?php endif; ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_topic_item', // Имя файла, который будет рендерить каждый топик
        'summary' => 'Показаны {begin}-{end} из {totalCount} топиков', // Пагинация
        'emptyText' => 'Пока нет ни одного топика.', // Текст, если топиков нет
        'options' => [
            'tag' => 'div',
            'class' => 'list-wrapper',
            'id' => 'topic-list',
        ],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'topic-item card mb-3', // Карточка для каждого топика
        ],
    ]); ?>

</div>