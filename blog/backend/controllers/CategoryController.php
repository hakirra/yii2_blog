<?php

namespace backend\controllers;
use Yii;
use yii\db\ActiveQuery;
use app\models\category;
use app\models\catetags;
use app\models\viewcategorytags;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\Sort;
use  yii\helpers\ArrayHelper;
class CategoryController extends \yii\web\Controller
{
	public $layout = 'branch';
	const PAGESIZE = 3;
	
	/**
	 *与前端ajax交互， 给前端提供数据
	 */
	public function actionTake($offset)
	{
		$query = Viewcategorytags::find()->select("id,cate_id,name,slug,pid,total");
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($offset)
        ->limit($pages->limit)
        ->all();
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $models;
	}
	
    public function actionIndex($name=null)
    {
    	$sort = new Sort([
			'attributes'=>[
				'id'=>[
					'asc'=>['id'=>SORT_ASC],
					'desc'=>['id'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'ID',
				],
				'name'=>[
					'asc'=>['name'=>SORT_ASC],
					'desc'=>['name'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'分类名称',
				],
				'slug'=>[
					'asc'=>['slug'=>SORT_ASC],
					'desc'=>['slug'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'分类别名',
				],
				'total'=>[
					'asc'=>['total'=>SORT_ASC],
					'desc'=>['total'=>SORT_DESC],
					'default'=>SORT_ASC,
					'total' =>'总数',
				]
			]
		]);
		if(isset($name)){
			$query = Viewcategorytags::find()->where("name like '%$name%' or slug like '%$name%'")->orderBy($sort->orders);		
		}else{
			$query = Viewcategorytags::find()->orderBy($sort->orders);
		}
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
		return $this->render('index',['pagination'=>$pages,'models'=>$models,'sort'=>$sort]);
        
    }

	/**
	 * 新增分类方法
	 */
	public function actionCreate()
    {
    	$catenodes =Viewcategorytags::find()->where(['catetags'=>'category'])->all(); 
		
		$listdata=ArrayHelper::map($catenodes,'cate_id','name');
	
      /*  $model = new category();
		$catetags = new catetags();*/
		 $models['cate'] = new category();
		$models['tags'] = new catetags();
		if(isset($_POST['submit'])){
			$models['cate']->name =$_POST['Category']['name'];
			$models['cate']->slug = $_POST['Category']['slug']?strtolower(trim($_POST['Category']['slug'])):trim($_POST['Category']['name']);
			$models['tags']->pid = $_POST['Category']['id']?$_POST['Category']['id']:0;
			$models['tags']->catetags = 'category';
			$models['tags']->total = 0;
			
			if ($models['cate']->save()) {
				$models['tags']->cate_id = $models['cate']->attributes['cid'];
				if($models['tags']->save())
				ShowMsg("数据添加成功", dirname(Yii::$app->request->absoluteUrl).'/index.php?r=Category/index');
	        } else {
	            return $this->render('create', [
	                'model' => $models,
	                'catetags' =>$catetags,
	                'listdata'=>$listdata
	            ]);
	        }
		}else {
            return $this->render('create', [
                'model' => $models,
                'catetags'=>$catetags,
                'listdata'=>$listdata
            ]);
        }
        
    }
	
	
	/**
     * Updates an existing category model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$catenodes =Viewcategorytags::find()->where(['catetags'=>'category'])->all(); 
		
		$listdata=ArrayHelper::map($catenodes,'cate_id','name');
        $model = $this->findModel($id);
		if(isset($_POST['submit']) && $model['cate']->validate() && $model['tags']->validate()){
			$models['cate']->name =$_POST['Category']['name'];
			$models['cate']->slug = $_POST['Category']['slug']?strtolower(trim($_POST['Category']['slug'])):trim($_POST['Category']['name']);
			$models['tags']->pid = $_POST['Category']['id']?$_POST['Category']['id']:0;
			$models['tags']->catetags = 'category';
			$models['tags']->total = 0;
			if($model->save()){
				ShowMsg("数据更新成功", dirname(Yii::$app->request->absoluteUrl).'/index.php?r=category/index');
//				 return $this->redirect(['index']);
			}else{
				return $this->render('update', [
                'model' => $model,
                'listdata'=>$listdata
           		 ]);
			}		
		}else{
			return $this->render('update', [
                'model' => $model,
                'listdata'=>$listdata
            ]);
		}
    }
	
	  /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$models =[];
        if (($models['cate'] = Category::findOne($id)) !== null && ($models['tags'] =Catetags::findOne($id)) !== null){
            return $models;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
