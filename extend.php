<?php

/*
 * This file is part of xypp/flarum-custom-user-remarks.
 *
 * Copyright (c) 2024 小鱼飘飘.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Xypp\CustomUserRemarks;

use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\User\Event\Saving;
use Xypp\CustomUserRemarks\Content\AddRemarkAttribute;
use Xypp\CustomUserRemarks\Listener\SaveUserEvent;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__ . '/js/dist/forum.js')
        ->css(__DIR__ . '/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js'),
    new Extend\Locales(__DIR__ . '/locale'),
    (new Extend\ApiSerializer(ForumSerializer::class))
        ->attribute('can_set_remark', function (ForumSerializer $serializer, $model, $attrs) {
            return $serializer->getActor()->can('set_remark');
        }),
    (new Extend\ApiSerializer(BasicUserSerializer::class))
        ->attributes(AddRemarkAttribute::class),
    (new Extend\Event)
        ->listen(Saving::class,SaveUserEvent::class)
];
