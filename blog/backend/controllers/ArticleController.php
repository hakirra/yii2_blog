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

	
	public function getCatedata($id)
	{
		$data = Article::find()->with('category')->where(['article_id'=>$id])->asArray()->all();
		$category = $data[0]['category'];
		$catedatas = array();
		$tagdatas = array();
		$catetags = array();
		foreach($category as $value){
			if($value['catetags']=='category'){
				$catedatas[$value['category_id']] = $value['name'];
			}else{
				$tagdatas[$value['category_id']] = $value['name'];
			}
		}
		$catetags['cate'] = $catedatas;
		$catetags['tags'] = $tagdatas;
		return $catetags;
//		v($catetags);;exit;
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
					'asc'=>['author_name'=>SORT_ASC],
					'desc'=>['author_name'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'作者',
				],
				'comment'=>[
					'asc'=>['comment'=>SORT_ASC],
					'desc'=>['comment'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'评论',
				],
				'created'=>[
					'asc'=>['created'=>SORT_ASC],
					'desc'=>['created'=>SORT_DESC],
					'default'=>SORT_ASC,
					'label' =>'日期',
				],
			]
		]);

				
		
		$cache = Yii::$app->cache;	
		if(isset($title)){
			$query = Article::find()->with('category')->where("title like '%$title%'")->orderBy($sort->orders);
			
			$class = array('total'=>'active','top'=>'','private'=>'');	
		}elseif($istop){			
			$query = Article::find()->with('category')->where(['istop'=>$istop])->orderBy($sort->orders);
			$class	= array('total'=>'','top'=>'active','private'=>'');	
		}elseif($post_password){
			$query = Article::find()->with('category')->where("post_password != ''")->orderBy($sort->orders);
			$class	= array('total'=>'','top'=>'','private'=>'active');			
		}else{
			$class = array('total'=>'active','top'=>'','private'=>'');
			$query = Article::find()->with('category')->orderBy($sort->orders)->addOrderBy(['created'=>SORT_DESC]);
//			v( $cache->get(self::CACHEKEY));
			if(!$cache->get(self::CACHEKEY)){
					$branchinfo['total'] = count(Article::find()->asArray()->all());
					$branchinfo['top'] = count(Article::find()->where(['istop'=>1])->asArray()->all());
					$branchinfo['private'] = count(Article::find()->where("post_password != ''")->asArray()->all());			
					
					
					$cache->add(self::CACHEKEY,$branchinfo);
										
			}
			
		}
		
		$countQuery = clone $query;//必须，不然分页显示不出来
		$pages = new Pagination(['totalCount' =>$countQuery->count(),'defaultPageSize' => self::PAGESIZE]);
		 $models = $query->offset($pages->offset)
        ->limit($pages->limit)
		->asArray()
        ->all();
//		$cache->delete(self::CACHEKEY);	
		$branchinfo = $cache->get(self::CACHEKEY);
      	return $this->render('index',['models'=>$models,'sort'=>$sort,'pagination'=>$pages,
      				'branchinfo'=>$branchinfo,'class'=>$class]);

        
    }


	
	/**
	 * 添加文章方法
	 */
	public function actionCreate()
    {
    	
    	$cache = Yii::$app->cache;
    	$models['category'] = new Category();	
		$models['article'] = new Article();
		$models['artcate'] = new ArticleCategory();			
		$models['article']->comment_status = 'open';//设置评论默认值为开启
		$tag_ids = array();//存放所有需要插入到category表中的标签数据
        if ($models['article']->load(Yii::$app->request->post())) {
        		$post_category = $_POST['post_category'];
				
        		$post_tags = explode(',',$_POST['Article']['tags']);

				//插入标签之前检测数据表中是否已存在该标签
				$db_tags = Category::find()->select('name,category_id')->where(['catetags'=>'tags'])->asArray()->all();
				
				//将数据库查询得到的结果集转换成一维数组,以主键作为一维数组下班，name作为值
				foreach ($db_tags as $value) {
					$db_tag[$value['category_id']]=$value['name'];
				}	
				
				$has_tags = array_intersect($db_tag,$post_tags);//获取数据中已存在的标签
				$new_tags  = array_diff($post_tags, $db_tag); // 数据库中没有的标签

														
        		$models['article']->setAttributes([
      				'author_id'=>Yii::$app->user->id,
        			'author_name'=>Yii::$app->user->identity->username,	
        			'created'=>time(),
        			'modified' => time(),
					'post_name'=> urlencode(trim($_POST['Article']['title']))
        		],false);//如果第二个参数不给false,会要求每个字段都必须有默认值
        		
        		
				if($models['article']->save()){
					
					$cache_data = $cache->get(self::CACHEKEY);
					$cache_data['total'] += 1;
					$cache->set(self::CACHEKEY,$cache_data);
					/**
					 * 更新分类表中total字段的值
					 */
					 if(!$post_category){//若没选择分类将放到未分类目录下
								$post_category[] = 1;
								$first = Category::findOne(1);
								$first->total += 1;
								$first->update();		
					}else{
						 foreach($post_category as $value){
					 		$newobj = Category::findOne($value);
						 	$newobj->total += 1;
							$newobj->update();
					 	}
					}
					 
					
					 
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
					 * 向article_category文章分类中间表中添加数据
					 */
									
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
        	 $arr = $this->getTree();
			
			/**
			 * 转换$arr数组,配合Html::checkboxList方法
			 */
		/*	foreach($arr as $key=>$value){
				$catetags[$key][$value['category_id'].'-'.$value['level']] = $value['name'];
				
			}*/
            return $this->render('create', [
                'models' => $models,
                'catetags'=>$arr
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
    	$categorys = $this->getCatedata($id);
		$cates = $categorys['cate'];
		$tags = $categorys['tags'];
    	$cateinfo = array();//文章对应的分类目录信息,索引数组
		$taginfo = array();//文章对应的标签信息,索引数组
		$tagids = array();//存放这篇文章对应的标签的所有category_id
		
			
        	//获取并分派文章对应的分类目录数据
			 foreach($cates as $key=>$val){
			 	$cateinfo[]	= $key;
			 }
//		v($cateinfo);exit;

        	//获取并分派文章对应标签数据
			if($tags){
				foreach($tags as $key=>$val){
					$taginfo[] = $val;
					$tagids[] = $key;
				}
			}
			

		$cache = Yii::$app->cache;
  		$models['article'] = $this->findModel($id);
		$models['category'] = new Category();	
		$models['artcate'] = new ArticleCategory();			
		

			$tag_ids = array();//存放所有需要插入到category表中的标签数据
   		   if (isset($_POST['submit'])) {
   		   		
   		   		$post_category = $_POST['post_category'];
        		$post_tags = explode(',',$_POST['Article']['tags']);
				//插入标签之前检测数据表中是否已存在该标签
				$db_tags = Category::find()->select('name,category_id')->where(['catetags'=>'tags'])->asArray()->all();
//				v($post_category);v($cates);v($post_tags);v($tags);exit;
				//将数据库查询得到的结果集转换成一维数组,以主键作为一维数组下班，name作为值
				foreach ($db_tags as $value) {
					$db_tag[$value['category_id']]=$value['name'];
				}	
				
				$has_tags = array_intersect($db_tag,$post_tags);//获取数据库中已存在的标签
				$new_tags  = array_diff($post_tags, $db_tag); // 数据库中没有的标签
				$new_cates = array_diff($post_category,$cateinfo);//获取这篇文章新的分类
				$has_tags_ids = array();//存放这篇文章对应的标签id集
				
				
				foreach($has_tags as $key=>$value){
					$has_tags_ids[] = $key;
				}
													
        		$models['article']->setAttributes([
      				'author_id'=>Yii::$app->user->id,
        			'author_name'=>Yii::$app->user->identity->username,	
        			'modified' => date('Y-m-d H:i:s',time()),
					'post_name'=> urlencode(trim($_POST['Article']['title'])),
					'title'=>$_POST['Article']['title'],
					'keywords'=>$_POST['Article']['keywords'],
					'excerpt'=>$_POST['Article']['excerpt'],
					'content'=>$_POST['Article']['content'],
					'comment_status'=>$_POST['Article']['comment_status']
        		],false);//如果第二个参数不给false,会要求每个字段都必须有默认值
        		
        		
				if($models['article']->save()){
					
					
					/**
					 * 更新分类表
					 */
					
					 if(!$post_category){//若没选择分类将放到未分类目录下
								$post_category[] = 1;
								$first = Category::findOne(1);
								$first->total += 1;
								$first->update();		
					}elseif($new_cates){
						 foreach($new_cates as $value){
					 		$newobj = Category::findOne($value);
						 	$newobj->total += 1;
							$newobj->update();
					 	}
					}
				
					if($new_tags){
					
						foreach($new_tags as $value){
							$c = clone $models['category'];		
							$c->setAttributes([
								'name'=>$value,
								'slug'=>urlencode($value),
								'catetags'=>'tags',
								'total'=>1
							]);	
							$c->insert() ? $tag_ids[] = $c->category_id:'';
						}
												
					}
					//更新分类表中total字段的值
					$diff = array_diff(array_flip($has_tags), $tagids);
					if($diff){
						foreach($diff as $value){
							$newobj = Category::findOne($value);
						 	$newobj->total += 1;
							$newobj->update();
						}
					}
					
					
					$diff2 =  array_diff($tags,$post_tags);
					if($diff2){
						foreach($diff2 as $key=>$value){
							$newobj = Category::findOne($key);
						 	$newobj->total -= 1;
							$newobj->update();
						}
					}
					
					
					$diff3 =  array_diff(array_flip($cates),$post_category);
					if($diff3){
						foreach($diff3 as $value){
							$newobj = Category::findOne($value);
						 	$newobj->total -= 1;
							$newobj->update();
						}
					}
					
					/**
					 * 更新article_category文章分类中间表
					 */
					 
					$tags_merge_cate = array_merge($post_category,$has_tags_ids,$tag_ids);
					ArticleCategory::deleteAll(['a_id'=>$id]);
			
					for($i=0;$i<count($tags_merge_cate);$i++){
							
							$c = clone $models['artcate'];
							$c->a_id = $id;
							$c->c_id = $tags_merge_cate[$i];
							$c->save();
								
						}
					
					
					  return $this->redirect(['index']);			
				}else {
            		throw new NotFoundHttpException('文章添加失败');
       		 }
                
        } else {
	
			$catetags = $this->getTree();
		
            return $this->render('update', [
                'models' => $models,
                'catetags'=>$catetags,
                'cateinfo'=> $cateinfo,
                'taginfo'=>$taginfo
            ]);
        } 
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
		$rel = Category::find()->select('category_id,name,level')->where(['catetags'=>'category','pid'=>$id])->asArray()->all(); 
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
