<?php

namespace vladkukushkin\math\models;

use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "math".
 * @property int $id
 * @property double $a
 * @property double $b
 * @property string $task
 * @property double $result
 * @property integer $user_id
 * @property double $user_result
 * @property boolean $is_correct
 * @property boolean $is_finished
 */
class Math extends \yii\db\ActiveRecord
{
    /**
     * @var double
     */
    public $a;
    /**
     * @var double
     */
    public $b;
    /**
     * @var string
     */
    public $operation;

    const ACTION_ADD = '+';
    const ACTION_SUB = '-';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'math';
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(
            parent::scenarios(),
            [
                'operation' => ['a', 'b'],
                'result' => ['task', 'result'],
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task', 'result', 'user_result', 'user_id'], 'required'],
            ['user_result', 'trim'],
            [['task', 'operation'], 'string'],
            ['user_id', 'integer'],
            [['a', 'b', 'result', 'user_result'], 'double'],
            [['is_correct', 'is_finished'], 'boolean'],
        ];
    }

    /**
     * Making adding operation
     * @param double $a
     * @param double $b
     * @return int|null
     * @throws \yii\base\ErrorException
     */
    public function add($a = null, $b = null)
    {
        if (!is_null($a)) {
            $this->a = $a;
        }
        if (!is_null($b)) {
            $this->b = $b;
        }
        $this->setScenario('operation');
        if (!$this->validate()) {
            throw new \yii\base\ErrorException(var_export($this->getErrors(), true));
        }
        $this->operation = self::ACTION_ADD;
        $this->result = $this->a+$this->b;
        if ($this->save()) {
            return $this->result;
        }
        return null;
    }
    
    /**
     * Making subtraction operation
     * @param double $a
     * @param double $b
     * @return int|null
     * @throws \yii\base\ErrorException
     */
    public function sub($a = null, $b = null)
    {
        if (!is_null($a)) {
            $this->a = $a;
        }
        if (!is_null($b)) {
            $this->b = $b;
        }
        $this->setScenario('operation');
        if (!$this->validate()) {
            throw new \yii\base\ErrorException(var_export($this->getErrors(), true));
        }
        $this->operation = self::ACTION_SUB;
        $this->result = $this->a-$this->b;
        if ($this->save()) {
            return $this->result;
        }
        return null;
    }
    
    /**
     * Making preparations before save to db
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->setScenario('result');
            $this->task = $this->a.$this->operation.$this->b;
            $this->user_id = \Yii::$app->user->id;
            return true;
        }
        return false;
    }
}
