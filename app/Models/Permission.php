<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public static function defaultPermissions()
    {
        return [
            'create-user',
            'edit-user',
            'update-user',
            'delete-user',
            'show-user',
            'create-questions',
            'edit-questions',
            'delete-questions',
            'show-questions ',
        ];
    }
}
