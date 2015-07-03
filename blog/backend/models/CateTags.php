<?php

namespace app\models;

use Yii;
//use \yii\db\ActiveQuery;
/**
 * This is the model class for table "{{%cate_tags}}".
 *
 * @property string $id
 * @property string $cate_id
 * @property string $cate_tags
 * @property string $pid
 * @property integer $count
 */
class CateTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%cate_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//          [['id'], 'required'],
            [['id', 'cate_id', 'pid', 'total'], 'integer'],
            [['catetags'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '父节点',
            'cate_id' => 'Cate ID',
            'catetags' => 'Cate Tags',
            'pid' => 'pid',
            'total' => 'Total',
        ];
    }
	

}
