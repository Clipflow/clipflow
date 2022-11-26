<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMember extends Pivot
{
    public const ROLE_ADMIN = 'admin';
    public const ROLE_MEMBER = 'member';
}
