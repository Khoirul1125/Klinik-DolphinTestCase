<?php
namespace App\Services;

use App\Models\MenuManajemen;
use Illuminate\Support\Facades\Auth;

class MenuService
{
    public static function getUserMenu()
    {
        $user = Auth::user();

        // Jika user memiliki "all-permission", ambil semua menu tanpa filter
        if ($user->hasPermissionTo('all-permission')) {
            return MenuManajemen::whereNull('parent_id')
                ->where('is_visible', true)
                ->with(['children' => function ($query) {
                    $query->where('is_visible', true)
                          ->with(['children' => function ($query) {
                              $query->where('is_visible', true);
                          }]);
                }])
                ->orderBy('order')
                ->get();
        }

        // Ambil semua permission dari role yang dimiliki user
        $userRolePermissions = $user->roles->flatMap(function ($role) {
            return $role->permissions->pluck('name');
        })->unique()->toArray();

        // Ambil semua permission yang diberikan langsung ke user
        $userDirectPermissions = $user->getPermissionNames()->toArray();

        // Gabungkan semua permission dari role dan langsung
        $userPermissions = array_unique(array_merge($userRolePermissions, $userDirectPermissions));

        // Ambil menu utama berdasarkan permission user
        return MenuManajemen::whereNull('parent_id')
            ->where('is_visible', true)
            ->where(function ($query) use ($userPermissions) {
                $query->whereIn('permission', $userPermissions);
            })
            ->with(['children' => function ($query) use ($userPermissions) {
                $query->whereIn('permission', $userPermissions)
                      ->where('is_visible', true)
                      ->with(['children' => function ($query) use ($userPermissions) {
                          $query->whereIn('permission', $userPermissions)
                                ->where('is_visible', true);
                      }]);
            }])
            ->orderBy('order')
            ->get();
    }
}
