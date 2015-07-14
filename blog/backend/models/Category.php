<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category}}".
 *
 * @property string $cid
 * @property string $name
 * @property string $slug
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
            [['name', 'slug'], 'string', 'max' => 255],
            [['name'],'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cid' => 'ID',
            'name' => '分类名称',
            'slug' => '别名',
        ];
    }
}
