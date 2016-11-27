<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$app->get('/', function () use ($app) {
    return $app->version();
});



$api = app('Dingo\Api\Routing\Router');

// v1 version API
// choose version add this in header    Accept:application/vnd.lumen.v1+json
$api->version('v1', [
        'namespace' => 'App\Http\Controllers\Api\V1',
        'middleware' => ['cors']
    ], function ($api) {

    // Auth
    // login
    $api->post('authorization', [
        'as' => 'auth.login',
        'uses' => 'AuthController@login',
    ]);
    // register
    $api->post('users', [
        'as' => 'users.store',
        'uses' => 'AuthController@register',
    ]);

    //cat
    $api->get('categories/{cid?}',[
        'as' => 'category.list',
        'uses'=> 'CategoryController@index'
    ]);

    //goods
    $api->get('goods/{cid?}/{pageSize?}',[
        'as' => 'goods.list',
        'uses'=> 'CategoryController@goods'
    ]);

    //good
    $api->get('good/{id}',[
        'as' => 'good.index',
        'uses'=> 'CategoryController@getGood'
    ]);
    // User
    // user list
    $api->get('users', [
        'as' => 'users.index',
        'uses' => 'UserController@index',
    ]);
    // user detail
    $api->get('users/{id}', [
        'as' => 'users.show',
        'uses' => 'UserController@show',
    ]);

    // POST
    // post list
    $api->get('posts', [
        'as' => 'posts.index',
        'uses' => 'PostController@index',
    ]);
    // post detail
    $api->get('posts/{id}', [
        'as' => 'posts.show',
        'uses' => 'PostController@show',
    ]);

    // POST COMMENT
    // post comment list
    $api->get('posts/{postId}/comments', [
        'as' => 'posts.comments.index',
        'uses' => 'PostCommentController@index',
    ]);

    // AUTH
    // refresh jwt token
    $api->post('auth/token/new', [
        'as' => 'auth.token.new',
        'uses' => 'AuthController@refreshToken',
    ]);

    // need authentication
    // 这里用的中间件 并不是app.php里注册的那个 'auth' => App\Http\Middleware\Authenticate::class,
    // 而是dinggo的api里的middleware就是Auth. 如果用app.php那个会无法验证过期的.
    // 这个注册和jwt一样 都是在 LumenServiceProvider 里完成的 所以不注意会找不到
    $api->group(['middleware' => 'api.auth'], function ($api) {
        // USER
        // my detail
        $api->get('user', [
            'as' => 'user.show',
            'uses' => 'UserController@userShow',
        ]);

        // update part of me
        $api->patch('user', [
            'as' => 'user.update',
            'uses' => 'UserController@patch',
        ]);
        // update my password
        $api->put('user/password', [
            'as' => 'user.password.update',
            'uses' => 'UserController@editPassword',
        ]);

        $api->post('user/wallet/{id}',[
            'as' => 'user.wallet',
            'uses' => 'UserController@getWallet',
        ]);

        // POST
        // user's posts index
        $api->get('user/posts', [
            'as' => 'user.posts.index',
            'uses' => 'PostController@userIndex',
        ]);
        // create a post
        $api->post('posts', [
            'as' => 'posts.store',
            'uses' => 'PostController@store',
        ]);
        // update a post
        $api->put('posts/{id}', [
            'as' => 'posts.update',
            'uses' => 'PostController@update',
        ]);
        // update part of a post
        $api->patch('posts/{id}', [
            'as' => 'posts.update',
            'uses' => 'PostController@update',
        ]);
        // delete a post
        $api->delete('posts/{id}', [
            'as' => 'posts.destroy',
            'uses' => 'PostController@destroy',
        ]);

        // POST COMMENT
        // create a comment
        $api->post('posts/{postId}/comments', [
            'as' => 'posts.comments.store',
            'uses' => 'PostCommentController@store',
        ]);
        $api->put('posts/{postId}/comments/{id}', [
            'as' => 'posts.comments.update',
            'uses' => 'PostCommentController@update',
        ]);
        // delete a comment
        $api->delete('posts/{postId}/comments/{id}', [
            'as' => 'posts.comments.destroy',
            'uses' => 'PostCommentController@destroy',
        ]);
    });
});

// v2 version API
// add in header    Accept:application/vnd.lumen.v2+json
$api->version('v2', function ($api) {
    $api->get('foos', 'App\Http\Controllers\Api\V2\FooController@index');
});
