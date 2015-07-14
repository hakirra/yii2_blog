<?php

namespace backend\controllers;

use Yii;
use common\models\user;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\Sort;
/**
 * UserController implements the CRUD actions for user model.
 */
class UserController extends Controller
{
	public $layout = 'branch';
	const PAGESIZE = 3;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post','get'],
                ],
            ],
        ];
    }
	

	/**
	 *与前端ajax交互， 给前端提供数据
	 */
	public function actionTake($offset)
	{
		$query = User::find()->select("id,username,email,status,login_time,ip_addr")->where(['role'=>0]);
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($offset)
        ->limit($pages->limit)
        ->all();
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $models;
	}
    /**
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex($username=null)
    {		    
		$sort = new Sort([
			'attributes'=>[
				'id'=>[
					'asc'=>['id'=>SORT_ASC],
					'desc'=>['id'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'ID',
				],
				'username'=>[
					'asc'=>['username'=>SORT_ASC],
					'desc'=>['username'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'用户名',
				],
				'email'=>[
					'asc'=>['email'=>SORT_ASC],
					'desc'=>['email'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'邮箱',
				],
				'status'=>[
					'asc'=>['email'=>SORT_ASC],
					'desc'=>['email'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'状态',
				],
				'login_time'=>[
					'asc'=>['login_time'=>SORT_ASC],
					'desc'=>['login_time'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'最后登录时间',
				],
				'ip_addr'=>[
					'asc'=>['ip_addr'=>SORT_ASC],
					'desc'=>['ip_addr'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'最后登录地址',
				]
			]
		]);
		if(isset($username)){
			$query = User::find()->where("role=0 AND username LIKE '%$username%' ")->orderBy($sort->orders);		
		}else{
			$query = User::find()->where(['role'=>0])->orderBy($sort->orders);
		}
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($pages->offset)
        ->limit($pages->limit)
        ->all();
		return $this->render('index',['pagination'=>$pages,'models'=>$models,'sort'=>$sort]);
	
    }

	


    /**
     * Displays a single user model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new user();
		$model->status=1;
		if(isset($_POST['submit'])){	
			$model->role = 0;
			$model->email =$_POST['User']['email'];
			$model->username = $_POST['User']['username'];
			$model->status = $_POST['User']['status'];
			$model->generateAuthKey();
			$model->setPassword($_POST['User']['password_hash']);
			if ($model->save()) {
//          return $this->redirect(['index']);
				ShowMsg("数据添加成功", dirname(Yii::$app->request->absoluteUrl).'/index.php?r=user/index');
	        } else {
	            return $this->render('create', [
	                'model' => $model,
	            ]);
	        }
		}else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
        
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		if(isset($_POST['submit']) && $model->validate()){
			$post = Yii::$app->request->post();
			$model->username =$post['User']['username'];
			$model->email = $post['User']['email'];
			$model->status = $post['User']['status'];
			if($model->save()){
//				echo dirname(Yii::$app->request->absoluteUrl);exit;
				ShowMsg("数据更新成功", dirname(Yii::$app->request->absoluteUrl));
//				 return $this->redirect(['index']);
			}else{
				return $this->render('update', [
                'model' => $model,
           		 ]);
			}		
		}else{
			return $this->render('update', [
                'model' => $model,
            ]);
		}
    }

    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$ids = explode(',', $id);
		$num = User::deleteAll(['id'=>$ids]);
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
        if (($model = user::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
