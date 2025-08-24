<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    public static function tableName(): string
    {
        return '{{%users}}';
    }

    public function rules(): array
    {
        return [
            [['username', 'password_hash', 'role'], 'required'],
            ['username', 'string', 'max' => 50],
            ['role', 'string', 'max' => 20],
            ['username', 'unique'],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        try {
            $jwt = Yii::$app->jwt;
            $token = $jwt->getParser()->parse((string) $token);
            $data = $jwt->getValidationData();
            $data->setCurrentTime(time());

            if ($token->validate($data) && $token->verify($jwt->getSigner(), $jwt->getKey())) {
                return static::findOne($token->getClaim('uid'));
            }
        } catch (\Exception $e) {
            return null;
        }

        return null;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey): bool
    {
        return false;
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateJwt()
    {
        $jwt = Yii::$app->jwt;
        $signer = $jwt->getSigner('HS256');
        $key = $jwt->getKey();
        $time = time();

        return $jwt->getBuilder()
            ->issuedBy('http://localhost') // Локальный хост
            ->permittedFor('http://localhost') // Локальный хост
            ->identifiedBy('yii2-request-api-local', true) // Уникальный ID для локального проекта
            ->issuedAt($time)
            ->expiresAt($time + 86400) // 24 часа для удобства тестирования
            ->withClaim('uid', $this->id)
            ->withClaim('role', $this->role)
            ->getToken($signer, $key);
    }

    public function getRole()
    {
        return $this->role;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function getRequests(): ActiveQuery
    {
        return $this->hasMany(Request::class, ['user_id' => 'id']);
    }
}
