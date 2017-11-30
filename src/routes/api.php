<?php

Route::group(['middleware' => ['jwt.auth', 'jwt.refresh']], function () {

});