<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior; // Подключаем TimestampBehavior

/**
 * This is the model class for table "topic".
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $image_url
 * @property int $created_at
 * @property int $updated_at
* @property Comment[] $comments
 * @property User $user
 */
class Topic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'topic';
    }

    /**
     * Подключаем поведение TimestampBehavior для автоматического заполнения created_at и updated_at
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'title'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['description'], 'string'],
            [['title', 'image_url'], 'string', 'max' => 255],
            [['image_url'], 'url'], // Проверка, что image_url - это валидный URL
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Автор',
            'title' => 'Заголовок',
            'description' => 'Описание',
            'image_url' => 'URL фото',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * Gets query for [[User]].
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    // ... (после метода getUser())

/**
 * Gets query for [[Comments]].
 * @return \yii\db\ActiveQuery
 */
public function getComments()
{
    return $this->hasMany(Comment::class, ['topic_id' => 'id']);
}
}