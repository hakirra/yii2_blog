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
				'cid'=>[
					'asc'=>['cid'=>SORT_ASC],
					'desc'=>['cid'=>SORT_DESC],
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
					'label' =>'总数',
				],
				'pid'=>[
					'asc'=>['pid'=>SORT_ASC],
					'desc'=>['pid'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'父分类',
				]
			]
		]);
		if(isset($name)){
			$query = Viewcategorytags::find()->where("name like '%$name%' or slug like '%$name%'")->andWhere(['catetags'=>'category'])->orderBy($sort->orders);		
		}else{
			$query = Viewcategorytags::find()->where(['catetags'=>'category'])->orderBy($sort->orders);
		}
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($pages->offset)
        ->limit($pages->limit)
		->asArray()
        ->all();
		 $models2 =Viewcategorytags::find()->where(['catetags'=>'category'])->asArray()
        ->all();
//		p($models);exit;
		return $this->render('index',['pagination'=>$pages,'models'=>$models,'models2'=>$models2,'sort'=>$sort]);
        
    }

	/**
	 * 新增分类方法
	 */
	public function actionCreate()
    {
		
		$catetags = $this->getTree(0);
//		$catetags=ArrayHelper::map($catetags,'cate_id','name');
		 $models['cate'] = new category();
		$models['tags'] = new catetags();
		if(isset($_POST['submit'])){
			$models['cate']->name =$_POST['Category']['name'];
			$models['cate']->slug = $_POST['Category']['slug']?strtolower(trim($_POST['Category']['slug'])):trim($_POST['Category']['name']);
			$models['tags']->pid = $_POST['CateTags']['cate_id']?$_POST['CateTags']['cate_id']:0;
			$models['tags']->catetags = 'category';
			$models['tags']->total = 0;
			if($models['tags']->pid==0){//等于0表示未选择父节点，新添加的为一级分类
				$models['tags']->level = 0;
			}else{
				$one = Viewcategorytags::find()->where(['cid'=>$models['tags']->pid])->asArray()->all();
				$models['tags']->level = $one[0]['level']+1;
			}
			
			
			if ($models['cate']->save()) {
				$models['tags']->cate_id = $models['cate']->attributes['cid'];
				if($models['tags']->save())
				ShowMsg("数据添加成功", dirname(Yii::$app->request->absoluteUrl).'/index.php?r=category/index');
	        } else {
	            return $this->render('create', [
	                'models' => $models,
	                'catetags' =>$catetags,
	            ]);
	        }
		}else {
            return $this->render('create', [
                'models' => $models,
                'catetags'=>$catetags,
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
    	$catetags = $this->getTree(0,$models['tags']['level']); 
		
//		$listdata=ArrayHelper::map($catetags,'cate_id','name');
        
		if(isset($_POST['submit']) && $models['cate']->validate() && $models['tags']->validate()){
			
			$models['cate']->name =$_POST['Category']['name'];
			$models['cate']->slug = $_POST['Category']['slug']?strtolower(trim($_POST['Category']['slug'])):trim($_POST['Category']['name']);
			$models['tags']->pid = $_POST['CateTags']['cate_id']?$_POST['CateTags']['cate_id']:0;
			$models['tags']->catetags = 'category';
			$models['tags']->total = 0;
			if($models['tags']->pid==0){//等于0表示未选择父节点，新添加的为一级分类
				$models['tags']->level = 0;
			}else{
				$one = Viewcategorytags::find()->where(['cid'=>$models['tags']->pid])->asArray()->all();
				$models['tags']->level = $one[0]['level']+1;
			}
			if($models['cate']->save() && $models['tags']->save()){
				
				ShowMsg("数据更新成功", dirname(Yii::$app->request->absoluteUrl));
			}else{
				return $this->render('update', [
                'models' => $models,
                'catetags'=>$catetags
           		 ]);
			}		
		}else{
			return $this->render('update', [
                'models' => $models,
                'catetags'=>$catetags
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
	/**
	 * 获取分类节点树
	 */
	public function getTree($id=0,$level=0)
	{
		$rel = Viewcategorytags::find()->where(['catetags'=>'category','pid'=>$id])->asArray()->all(); 
		$arr = array();
		if($rel){		
			foreach($rel as $val){
//				$val['level']=$level;
				$arr[count($arr)] = $val;
				$sub = $this->getTree($val['cid']);
				 if(is_array($sub)) $arr = array_merge($arr,$sub);
			}
		}
		return $arr;
	}

}
