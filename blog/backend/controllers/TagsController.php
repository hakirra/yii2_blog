<?php

namespace backend\controllers;

use Yii;
use yii\db\ActiveQuery;
use app\models\category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\Sort;

class TagsController extends \yii\web\Controller {

    public $layout = 'branch';

    const PAGESIZE = 3;

    /**
     * 与前端ajax交互， 给前端提供数据
     */
    public function actionTake($offset) {
        $query = Category::find()->select("category_id");
        $countQuery = clone $query; //必须，不然分页显示不出来
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => self::PAGESIZE]);
        $models = $query->offset($offset)
                ->where(['catetags' => 'tags'])
                ->limit($pages->limit)
                ->all();

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $models;
    }

    public function actionIndex($name = null) {
        $sort = new Sort([
            'attributes' => [
                'name' => [
                    'asc' => ['name' => SORT_ASC],
                    'desc' => ['name' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => '标签名称',
                ],
                'slug' => [
                    'asc' => ['slug' => SORT_ASC],
                    'desc' => ['slug' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => '标签别名',
                ],
                'total' => [
                    'asc' => ['total' => SORT_ASC],
                    'desc' => ['total' => SORT_DESC],
                    'default' => SORT_ASC,
                    'label' => '总数',
                ]
            ]
        ]);
        if (isset($name)) {
            $query = Category::find()->where("name like '%$name%' or slug like '%$name%'")->andWhere(['catetags' => 'tags'])->orderBy($sort->orders);
        } else {
            $query = Category::find()->where(['catetags' => 'tags'])->orderBy($sort->orders);
        }
        $countQuery = clone $query; //必须，不然分页显示不出来
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'defaultPageSize' => self::PAGESIZE]);
        $models = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();

        return $this->render('index', ['pagination' => $pages, 'models' => $models, 'sort' => $sort]);
    }

    /**
     * 新增标签方法
     */
    public function actionCreate() {

        $models = new category();
        if (isset($_POST['submit'])) {
            $models->name = $_POST['Category']['name'];
            $models->slug = $_POST['Category']['slug'] ? strtolower(trim($_POST['Category']['slug'])) : trim($_POST['Category']['name']);

            $models->catetags = 'tags';

            if ($models->save()) {
                ShowMsg("数据添加成功", \yii\helpers\Url::to(['Tags/index']));
            } else {
                $category = $this->getTree();
                return $this->render('create', [
                            'models' => $models,
                            'category' => $category,
                ]);
            }
        } else {
            $catetags = $this->getTree();
            return $this->render('create', [
                        'models' => $models,
                        'catetags' => $catetags,
            ]);
        }
    }

    /**
     * Updates an existing category model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $models = $this->findModel($id);
        $catetags = $this->getTree();

//		$listdata=ArrayHelper::map($Category,'category_id','name');

        if (isset($_POST['submit']) && $models->validate()) {

            $models->name = $_POST['Category']['name'];
            $models->slug = $_POST['Category']['slug'] ? strtolower(trim($_POST['Category']['slug'])) : trim($_POST['Category']['name']);
            $models->catetags = 'tags';

            if ($models->save()) {
                ShowMsg("数据更新成功", \yii\helpers\Url::to(['tags/index']));
            } else {
                return $this->render('update', [
                            'models' => $models,
                            'catetags' => $catetags
                ]);
            }
        } else {
            return $this->render('update', [
                        'models' => $models,
                        'catetags' => $catetags
            ]);
        }
    }

    public function actionDelete($id) {
        $ids = explode(',', $id);
        $num = Category::deleteAll(['category_id' => $ids]);
        if ($num > 0) {
            ShowMsg("数据删除成功", \yii\helpers\Url::to(['tags/index']));
        }
    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {

        if (($models = Category::findOne($id)) !== null) {
            return $models;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 获取分类节点树
     */
    public function getTree($id = 0) {
        $rel = Category::find()->where(['catetags' => 'category', 'pid' => $id])->asArray()->all();
        $arr = array();
        if ($rel) {
            foreach ($rel as $val) {
                $arr[count($arr)] = $val;
                $sub = $this->getTree($val['category_id']);
                if (is_array($sub))
                    $arr = array_merge($arr, $sub);
            }
        }
        return $arr;
    }

}
