<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%article_category}}".
 *
 * @property string $aid
 * @property string $cid
 */
class ArticleCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article_category}}';
    }

    /**
     * @inheritdoc
     */
 /*   public function rules()
    {
        return [
            [['a_id', 'c_id'], 'required'],
            [['a_id', 'c_id'], 'integer']
        ];
    }*/

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'a_id' => 'Aid',
            'c_id' => 'Cid',
        ];
    }
}
