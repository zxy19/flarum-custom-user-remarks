<?php

namespace Xypp\CustomUserRemarks;

use Flarum\Database\AbstractModel;
use Flarum\User\User;


class Remark extends AbstractModel
{
    protected $table = 'user_remarks';

    public function user()
    {
        return $this->belongsTo(User::class, "user_id", "id");
    }

    public function owner()
    {
        return $this->belongsTo(User::class, "owner_id", "id");
    }
}
