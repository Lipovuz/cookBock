<?php
/**
 * Created by PhpStorm.
 * User: vadim
 * Date: 21.10.18
 * Time: 23:31
 */
namespace app\widgets;

use yii\base\Widget;
use app\modules\admin\models\Category;
use Yii;

class MenuWidget extends Widget
{
    public $tpl;
    public $data;
    public $model;
    public $tree;
    public $menuHtml;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        if ($this->tpl===null){
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';

    }

    public  function run()
    {
        if($this->tpl == 'menu.php'){
            $menu = Yii::$app->cache->get('menu');
            if($menu) return $menu;
        }
            $this->data = Category::find()->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
        if($this->tpl == 'menu.php') {
            Yii::$app->cache->set('menu', $this->menuHtml, 60);
        }
        return $this->menuHtml;
    }

    protected function getTree()
    {
        $tree = [];
        foreach ($this->data as $id=>&$node) {
            if (!$node['parent_id']){
                $tree[$id] = &$node;
            }else{
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
            }
        }
        return $tree;
    }

    protected function getMenuHtml($tree,$tab='')
    {
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category, $tab);
        }
        return $str;
    }

    protected function catToTemplate($category, $tab)
    {
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }
}