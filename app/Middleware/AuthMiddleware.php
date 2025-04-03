<?php
namespace App\Middleware;

use App\Models\AuthModel;

class AuthMiddleware
{
    /**
     * Admin rotalarını korumak için middleware
     * @param string $route İstek yapılan rota
     * @return bool Yetki var mı?
     */
    public static function protectAdminRoutes($route)
    {
        // Admin rotasını kontrol et (/admin/ ile başlıyor mu?)
        if (strpos($route, 'admin') === 0 && $route !== 'admin/login') {
            // Login sayfası hariç tüm admin rotaları korunur
            if (!AuthModel::checkAdminAuth()) {
                // Yetkisiz erişim - login sayfasına yönlendir
                header('Location: /admin/login');
                exit;
            }
        }
        
        return true;
    }
}