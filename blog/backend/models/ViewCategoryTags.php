<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%view_category_tags}}".
 *
 * @property string $cid
 * @property string $name
 * @property string $slug
 * @property string $id
 * @property string $cate_id
 * @property string $catetags
 * @property string $pid
 * @property integer $total
 */
class ViewCategoryTags extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%view_category_tags}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'id', 'cate_id', 'pid', 'total'], 'integer'],
            [['id'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['catetags'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'Cid',
            'name' => 'Name',
            'slug' => 'Slug',
            'id' => 'ID',
            'cate_id' => 'Cate ID',
            'catetags' => 'Catetags',
            'pid' => 'Pid',
            'total' => 'Total',
            'level' => 'Level',
        ];
    }
}
