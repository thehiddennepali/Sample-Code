<?php
/* @var $this View */
/* @var $content string */

use fbwidget\assets\AppAsset;
use fbwidget\models\LoginForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody();
        
        $cookies = Yii::$app->request->cookies;
        
        $languageCookie = $cookies['language'];
        
        if(isset($languageCookie->value) && !empty($languageCookie->value)){
            Yii::$app->language = $languageCookie->value;
        }
        ?>


        <!--[if lte IE 8]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
        <![endif]-->

        <div id="preloader">
            <div class="sk-spinner sk-spinner-wave" id="status">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div><!-- End Preload -->

    <div class="container margin_60_35">
   
    <?php echo $content;?>
    </div>
        

        <?php $this->endBody() ;
        
        $this->registerJs("
            var socket = io.connect('https://aondego.com:8080/');
                    socket.on('connect', function () {
                        console.log('Connected!');
                        var order = {user: 'order', text: 'name'};
                        console.log(order);


                    });
                    socket.on('order-".Yii::$app->user->id."', function (order) {
                        console.log('i am hjere');
                        console.log(order);
                        if (order.data_id)
                            $('.calendar-' + order.staff_id).fullCalendar('removeEvents', order.data_id);
                        if (order.type != 5)
                            $('.calendar-' + order.staff_id).fullCalendar('renderEvent', order, true);
                        $('.notif-new-order-total-counter').html(parseInt($('.notif-new-order-total-counter').html()) + 1);

                        if (($('#group-order-grid').length > 0) && (order.type == 4 || order.type == 3 || order.type == 7)) {
                            $('#group-order-grid').yiiGridView('update');
                        }

                        switch (order.type) {
                            case 1:
                                $('#notif-new-order-created').html(parseInt($('#notif-new-order-created').html()) + 1);
                                break;
                            case 2:
                                $('#notif-new-order-changed').html(parseInt($('#notif-new-order-changed').html()) + 1);
                                break;
                            case 3:
                                $('#notif-new-order-created').html(parseInt($('#notif-new-order-created').html()) + 1);
                                break;
                            case 4:
                                $('#notif-new-order-canceled').html(parseInt($('#notif-new-order-canceled').html()) + 1);
                                break;
                            case 5:
                                $('#notif-new-order-canceled').html(parseInt($('#notif-new-order-canceled').html()) + 1);
                                break;
                            case 7:
                                $('#notif-new-order-changed').html(parseInt($('#notif-new-order-changed').html()) + 1);
                                break;
                        }
                        //$('.calendar-' + order.staff_id).fullCalendar('render');
                    });
                    ");
        ?>
    </body>
</html>
<?php $this->endPage() 
        
        
        ?>
