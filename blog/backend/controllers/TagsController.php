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
class TagsController extends \yii\web\Controller
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
				'name'=>[
					'asc'=>['name'=>SORT_ASC],
					'desc'=>['name'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'标签名称',
				],
				'slug'=>[
					'asc'=>['slug'=>SORT_ASC],
					'desc'=>['slug'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'标签别名',
				],
				'total'=>[
					'asc'=>['total'=>SORT_ASC],
					'desc'=>['total'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'总数',
				]
				
			]
		]);
		if(isset($name)){
			$query = Viewcategorytags::find()->where("name like '%$name%' or slug like '%$name%'")->andWhere(['catetags'=>'tags'])->orderBy($sort->orders);		
		}else{
			$query = Viewcategorytags::find()->where(['catetags'=>'tags'])->orderBy($sort->orders);
		}
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($pages->offset)
        ->limit($pages->limit)
		->asArray()
        ->all();
//		p($models);exit;
		return $this->render('index',['pagination'=>$pages,'models'=>$models,'sort'=>$sort]);
        
    }

	/**
	 * 新增分类方法
	 */
	public function actionCreate()
    {
		
	
//		$catetags=ArrayHelper::map($catetags,'cate_id','name');
		 $models['cate'] = new category();
		$models['tags'] = new catetags();
		if(isset($_POST['submit'])){
			$models['cate']->name =$_POST['Category']['name'];
			$models['cate']->slug = $_POST['Category']['slug']?strtolower(trim($_POST['Category']['slug'])):trim($_POST['Category']['name']);
			$models['tags']->pid = 0;
			$models['tags']->catetags = 'tags';
			$models['tags']->total = 0;
			$models['tags']->level = 0;
			
			if ($models['cate']->save()) {
				$models['tags']->cate_id = $models['cate']->attributes['cid'];
				if($models['tags']->save())
				ShowMsg("数据添加成功", dirname(Yii::$app->request->absoluteUrl).'/index.php?r=tags/index');
	        } else {
	            return $this->render('create', [
	                'models' => $models
	            ]);
	        }
		}else {
            return $this->render('create', [
                'models' => $models
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
    	$models = $this->findModel($id);
    	
		
//		$listdata=ArrayHelper::map($catetags,'cate_id','name');
        
		if(isset($_POST['submit']) && $models['cate']->validate() && $models['tags']->validate()){
			
			$models['cate']->name =$_POST['Category']['name'];
			$models['cate']->slug = $_POST['Category']['slug']?strtolower(trim($_POST['Category']['slug'])):trim($_POST['Category']['name']);
			
		
			if($models['cate']->save() && $models['tags']->save()){
				
				ShowMsg("数据更新成功", dirname(Yii::$app->request->absoluteUrl));
			}else{
				return $this->render('update', [
                'models' => $models      
           		 ]);
			}		
		}else{
			return $this->render('update', [
                'models' => $models
            ]);
		}
    }
	
	
	public function actionDelete($id)
    {
    	$ids = explode(',', $id);
		$num = Category::deleteAll(['cid'=>$ids]);
		$num2 = Catetags::deleteAll(['id'=>$ids]);
		if($num>0){
			ShowMsg("数据删除成功", dirname(Yii::$app->request->absoluteUrl).'/index');
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
