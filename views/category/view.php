<?php

use yii\widgets\ListView;
use app\widgets\MenuWidget;

/**
 * @var \app\models\Recipe[] $recipe
 */

$this->title = 'Головна';
?>
<div class="site-index container">
    <div class="row">
        <div class="">
            <h2>Категорії</h2>
            <div>
                <ul id="menu-dashboard" class="col-md-2 menu catalog nav nav-pills nav-stacked">
                    <li><?=MenuWidget::widget(['tpl'=>'menu']) ?></li>
                </ul>
            </div>
            <div>
                <?php echo ListView::widget([
                    'dataProvider' => $dataProvider,
                    'itemView' => 'view_primal.php',
                ]);?>
            </div>
        </div>

    </div>

</div>

