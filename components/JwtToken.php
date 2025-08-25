<?php

namespace app\components;

use app\models\User;
use sizeg\jwt\Jwt;
use Yii;

class JwtToken
{
    private const HOST = 'http://localhost';
    private const APP_ID = 'yii2-request-api-local';
    private const EXPIRES = 86400;
    public static function generate(User $user): ?string
    {
        /* @var Jwt $jwt **/
        $jwt = Yii::$app->jwt;

        if (!$jwt) {
            Yii::error('JWT component not found');
            return null;
        }

        try {
            $signer = $jwt->getSigner('HS256');
            $key = $jwt->getKey();
            $time = time();

            $token = $jwt->getBuilder()
                ->issuedBy(self::HOST)
                ->permittedFor(self::HOST)
                ->identifiedBy(self::APP_ID, true)
                ->issuedAt($time)
                ->expiresAt($time + self::EXPIRES)
                ->withClaim('uid', $user->id)
                ->withClaim('role', $user->role)
                ->getToken($signer, $key);

            return $token;
        } catch (\Exception $e) {
            Yii::error('JWT generation error: ' . $e->getMessage());

            return null;
        }
    }
}