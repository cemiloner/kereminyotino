<?php
namespace App\Models;

use RedBeanPHP\R as R;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthModel
{
    private static $key = "your_secret_key_here"; // Production'da daha güvenli bir yerde saklayın
    private static $algorithm = 'HS256';
    
    /**
     * Admin kullanıcı giriş kontrolü
     * @param string $username
     * @param string $password
     * @return bool|string JWT token veya false
     */
    public static function login($username, $password)
    {
        // Basit admin hesabı kontrolü - gerçek projede veritabanından çekilmeli
        if ($username === 'admin' && $password === 'adminpass') {
            // RedBean ile veritabanından kontrol edebilirsiniz:
            // $admin = R::findOne('admins', 'username = ? AND password = ?', [$username, md5($password)]);
            
            return self::generateToken([
                'username' => $username,
                'role' => 'admin'
            ]);
        }
        
        return false;
    }
    
    /**
     * JWT token oluştur
     * @param array $userData
     * @return string
     */
    public static function generateToken($userData)
    {
        $issuedAt = time();
        $expire = $issuedAt + 3600; // 1 saat geçerli
        
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expire,
            'data' => $userData
        ];
        
        return JWT::encode($payload, self::$key, self::$algorithm);
    }
    
    /**
     * Token doğrulama
     * @param string $token
     * @return bool|object
     */
    public static function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$key, self::$algorithm));
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Admin yetkisi kontrolü - tüm /admin/ rotaları için middleware
     * @return bool
     */
    public static function checkAdminAuth()
    {
        // Cookie'den JWT token kontrol
        $token = $_COOKIE['admin_token'] ?? null;
        
        // localStorage'dan gelen token (Authorization header)
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        
        if (empty($token) && preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }
        
        if ($token) {
            $decoded = self::validateToken($token);
            if ($decoded && $decoded->data->role === 'admin') {
                return true;
            }
        }
        
        return false;
    }
}