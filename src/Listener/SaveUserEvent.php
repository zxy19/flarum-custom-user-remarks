<?php

namespace Xypp\CustomUserRemarks\Listener;

use Flarum\User\Event\Saving;
use Illuminate\Support\Arr;
use Xypp\CustomUserRemarks\Remark;

class SaveUserEvent
{
    public function __invoke(Saving $event)
    {
        $user = $event->user;
        $actor = $event->actor;
        $data = $event->data;
        if (($remark = Arr::get($data, 'attributes.remark', false)) !== false) {
            $actor->assertCan('set_remark');
            if ($remark === null) {
                Remark::where('user_id', $user->id)->where('owner_id', $actor->id)->delete();
            } else {
                $remarkObj = Remark::where('user_id', $user->id)->where('owner_id', $actor->id)->firstOrNew();
                $remarkObj->user()->associate($user);
                $remarkObj->owner()->associate($actor);
                $remarkObj->remark = $remark;
                $remarkObj->save();
            }
        }
    }
}