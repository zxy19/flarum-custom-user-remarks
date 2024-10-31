<?php

use Illuminate\Database\Schema\Blueprint;

use Flarum\Database\Migration;

return Migration::createTable(
    'user_remarks',
    function (Blueprint $table) {
        $table->increments('id');
        $table->integer('user_id')->unsigned();
        $table->integer('owner_id')->unsigned();
        $table->string('remark');

        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');

        $table->index(['user_id', 'owner_id']);
    }
);