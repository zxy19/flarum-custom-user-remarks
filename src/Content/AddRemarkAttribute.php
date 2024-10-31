<?php

namespace Xypp\CustomUserRemarks\Content;

use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Http\RequestUtil;
use Flarum\User\User;
use Xypp\CustomUserRemarks\Remark;

class AddRemarkAttribute
{
    public function __invoke(BasicUserSerializer $serializer, User $user, $attributes)
    {
        if ($serializer->getActor()->can('set_remark')) {
            $remark = Remark::where('user_id', $user->id)->where('owner_id', $serializer->getActor()->id)->first();
            if ($remark) {
                $attributes['realDisplayName'] = $attributes['displayName'];
                $attributes['displayName'] = $remark->remark;
                $attributes['remark'] = $remark->remark;
            }
        }
        return $attributes;
    }
}