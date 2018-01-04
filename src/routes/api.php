<?php

Route::group(['middleware' => ['auth:api', 'jwt.refresh']], function () {

});