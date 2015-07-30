<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property string $id
 * @property string $author_id
 * @property string $title
 * @property string $content
 * @property string $keywords
 * @property string $excerpt
 * @property integer $created
 * @property integer $modified
 * @property string $post_name
 * @property string $post_password
 * @property string $comment_status
 * @property string $guid
 * @property integer $comment_total
 */
class Article extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'title', 'content'], 'required','message'=>'该字段必填'],
//          [['author_id', 'created', 'modified', 'comment_total'], 'integer'],
//          [['content', 'excerpt'], 'string'],
//          [['title', 'keywords', 'guid'], 'string', 'max' => 255],
//          [['post_name'], 'string', 'max' => 200],
//          [['post_password', 'comment_status'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */

	
	public function getCategory()
	{
		return $this->hasMany(Category::className(),['category_id'=>'c_id'])
					->viaTable('article_category',['a_id'=>'article_id']);
	}
	

	
}
