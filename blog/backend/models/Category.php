<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $category_id
 * @property string $name
 * @property string $slug
 * @property string $catetags
 * @property string $pid
 * @property string $level
 * @property string $total
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pid', 'level', 'total'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 200],
            [['catetags'], 'string', 'max' => 20],
            ['name','required','message'=>'名称不能为空']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'name' => '名称',
            'slug' => '别名',
            'catetags' => 'Catetags',
            'pid' => 'Pid',
            'level' => 'Level',
            'total' => 'Total',
        ];
    }
	
	/*public function getArticle()
	{
		return $this->hasMany(Category::className(),['category_id'=>'c_id'])
					->viaTable('article_category',['a_id'=>'article_id']);
	}*/
}
