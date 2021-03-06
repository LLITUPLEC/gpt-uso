<?php

/**
 * @var $this yii\web\View
 * @var $model Comment
 * @var $provider ActiveDataProvider
 *
 */


use app\models\Comment;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

$columns = [

    [
        'label' => 'Кто создал',
        'attribute' => 'name',
        'value' => function (Comment $model) {
            return $model->name;
        }
        // $model->user->username
    ],
    'comment',
    'email',
    'created_at:datetime',
];

if (Yii::$app->user->isGuest) {
    $columns[] = [
        'class' => ActionColumn::class,
        'header' => 'Операции',
        'contentOptions' => ['style' => 'text-align:center; '],
    ];
} else if (Yii::$app->user->can('user')) {
    $columns[] = [
        'class' => ActionColumn::class,
        'header' => 'Операции',
        'template' => '{view}',
        'contentOptions' => ['style' => 'text-align:center; '],
    ];
}

?>

<div class="site-about" style="margin-top: -50px;margin-bottom: 30px;">
    <h1>Список Комментариев</h1>
</div>
<?php Pjax::begin(['id' => 'grid-pjax','timeout' => 1,]) ?>
<?= GridView::widget([
    'dataProvider' => $provider, // $provider->getModels() [....]
    'columns' => $columns,
]) ?>
<?php Pjax::end() ?>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

    <div class="row">
        <div class="col-lg-3">
            <h2>Второе задание</h2>

            <p>SQL-запрос на вывод таблицы с актуальными ценами по дате</p>

            <p>
                <?= Html::a('Перейти', ['second'], ['class' => 'btn btn-primary']) ?>
            </p>
        </div>
    </div>
<?php










//$js = <<<JS
// $('form').on('beforeSubmit', function(){
// var data = $(this).serialize();
// $.ajax({
// url: '/comment/index',
// type: 'POST',
// data: data,
// success: function(res){
// console.log(res);
// },
// error: function(){
// alert('Error!');
// }
// });
// return false;
// });
//JS;
//
//$this->registerJs($js);

