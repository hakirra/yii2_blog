<?php

namespace backend\controllers;
use Yii;
use yii\db\ActiveQuery;
use app\models\Article;
use app\models\Category;
use app\models\ArticleCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\Sort;
class ArticleController extends \yii\web\Controller
{
	public $layout = 'branch';
	const PAGESIZE = 3;
	const CACHEKEY = 'branchinfo';
	static $expressionval ='';
	/**
	 *与前端ajax交互， 给前端提供数据
	 */
	public function actionTake($offset)
	{
		$query = Article::find()->select("article_id,name,slug,pid,total");
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($offset)
        ->limit($pages->limit)
        ->all();
		
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return $models;
	}

	public function resetCache()
	{
			
	}
    public function actionIndex($title=null,$istop=null,$post_password=null)
    {
    	$sort = new Sort([
			'attributes'=>[
				'title'=>[
					'asc'=>['title'=>SORT_ASC],
					'desc'=>['title'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'标题',
				],
				'author_name'=>[
					'asc'=>['author_id'=>SORT_ASC],
					'desc'=>['author_id'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'作者',
				],
				'comment'=>[
					'asc'=>['comment'=>SORT_ASC],
					'desc'=>['comment'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'评论',
				],
				'date'=>[
					'asc'=>['date'=>SORT_ASC],
					'desc'=>['date'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'日期',
				],
			]
		]);

		$cache = Yii::$app->cache;			
		
		
		if(isset($title)){
			$query = Article::find()->with('category')->where("title like '%$title%'")->orderBy($sort->orders);		
		}elseif($istop){			
			$query = Article::find()->with('category')->where(['istop'=>$istop])->orderBy($sort->orders);
		}elseif($post_password){
			$query = Article::find()->with('category')->where("post_password != ''")->orderBy($sort->orders);				
		}else{
			$query = Article::find()->with('category')->orderBy($sort->orders);
			
			if(!$cache->get(self::CACHEKEY)){
					$branchinfo['total'] = count(Article::find()->asArray()->all());
					$branchinfo['top'] = count(Article::find()->where(['istop'=>1])->asArray()->all());
					$branchinfo['private'] = count(Article::find()->where("post_password != ''")->asArray()->all());			
					
					$cache->add($a,$branchinfo,0);
										
			}
			
		}
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($pages->offset)
        ->limit($pages->limit)
		->asArray()
        ->all();
//		$cache->delete($a);	
	
		$branchinfo = $cache->get(self::CACHEKEY);
      	return $this->render('index',['models'=>$models,'sort'=>$sort,'pagination'=>$pages,
      				'branchinfo'=>$branchinfo,'total'=>$total]);

        
    }


	
	/**
	 * 添加文章方法
	 */
	public function actionCreate()
    {
    	$models['category'] = new Category();	
		$models['article'] = new Article();
		$models['artcate'] = new ArticleCategory();			
		$models['article']->comment_status = 'open';//设置评论默认值为开启
		$tag_ids = array();//存放所有需要插入到category表中的数据
        if ($models['article']->load(Yii::$app->request->post())) {
        		$post_tags = explode(',',$_POST[Article][tags]);

				//插入标签之前检测数据表中是否已存在该标签
				$db_tags = Category::find()->select('name,category_id')->where(['catetags'=>'tags'])->asArray()->all();
				
				//将数据库查询得到的结果集转换成一维数组,以主键作为一维数组下班，name作为值
				foreach ($db_tags as $value) {
					$db_tag[$value['category_id']]=$value['name'];
				}	
				
				$has_tags = array_intersect($db_tag,$post_tags);//获取数据中已存在的标签
				$new_tags  = array_diff($post_tags, $db_tag); // 获取数据中不存在的标签

														
        		$models['article']->setAttributes([
      				'author_id'=>Yii::$app->user->id,
        			'author_name'=>Yii::$app->user->identity->username,	
        			'created'=>time(),
        			'modified' => time(),
					'post_name'=> urlencode(trim($_POST['Article']['title']))
        		],false);//如果第二个参数不给false,会要求每个字段都必须有默认值
        		
        		
				if($models['article']->save()){
					
					/**
					 * 更新分类表
					 */
					if(count($has_tags)>0){
						foreach($has_tags as $key=>$value){
							$tag_ids[] = $key;
							$obj = Category::findOne($key);
							$obj->total += 1;
							$obj->update();
							
						}
					}
					
					if($n=count($new_tags)>0){
						
						for($i=0;$i<$n;$i++){
							$c = clone $models['category'];			
							$c->name = $new_tags[$i];
							$c->slug = urlencode($new_tags[$i]);
							$c->catetags = 'tags';
							$c->total = 1;			
							$c->insert() ? $tag_ids[] = $c->category_id:'';
							
						}
					}
					
				
					
					/**
					 * 更新article_category文章分类中间表
					 */
						$post_category = $_POST['post_category'];
        				
						if($post_category === null){
								$post_category[] = 1;
								$first = Category::findOne(1);
								$first->total += 1;
								$first->update();		
						}
						
						$tags_merge_cate = array_merge($post_category,$tag_ids);
						
						for($i=0;$i<count($tags_merge_cate);$i++){
							$c = clone $models['artcate'];
							$c->a_id = $models['article']->article_id;
							$c->c_id = $tags_merge_cate[$i];
							$c->save();
						}
					
					
					  return $this->redirect(['index']);			
				}
                
        } else {      	
        	 $catetags = $this->getTree();
            return $this->render('create', [
                'models' => $models,
                'catetags'=>$catetags
            ]);
        }    
    }
	
	
	/**
     * Updates an existing article model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
    	$models = $this->findModel($id);
   
    }
	
	
	public function actionDelete($id)
    {
    	/*$ids = explode(',', $id);
		$num = Article::deleteAll(['cid'=>$ids]);
	
		if($num>0){
			ShowMsg("数据删除成功", dirname(Yii::$app->request->absoluteUrl).'/index');
		}*/
        
    }

    protected function findModel($id)
    {
    
        if (($models= Article::findOne($id)) !== null){
            return $models;
        } else {
            throw new NotFoundHttpException('请求的页面不存在');
        }
    }
	/**
	 * 获取分类节点树
	 */
	public function getTree($id=0)
	{
		$rel = Category::find()->where(['catetags'=>'category','pid'=>$id])->asArray()->all(); 
		$arr = array();
		if($rel){		
			foreach($rel as $val){
				$arr[count($arr)] = $val;
				$sub = $this->getTree($val['category_id']);
				 if(is_array($sub)) $arr = array_merge($arr,$sub);
			}
		}
		return $arr;
	}
	


}
