<?php

namespace ApiDemo\Transformers;

use ApiDemo\Models\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['user', 'comments'];

    public function transform(Post $post)
    {
        return $post->attributesToArray();
    }
    //请求方式
    //http://jwt.cc/api/posts?include=user
    //返回结果,就是把user信息添加到结果里了
//    {
//    "data": [
//    {
//    "id": 1,
//    "user_id": 1,
//    "title": "测试个标题",
//    "content": "简单内容测试",
//    "created_at": "2016-10-20 08:57:09",
//    "user": {
//    "data": {
//    "id": 1,
//    "email": "xwiwi@tom.com",
//    "name": "elick",
//    "avatar": null,
//    "created_at": "2016-10-20 08:48:10",
//    "updated_at": "2016-10-20 08:48:10",
//    "deleted_at": null
//    }
//    }
//    }, ......
    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer());
    }

    // 带参数这个还不不对,如何用url传参还没弄明白
    public function includeComments(Post $post, ParamBag $params = null)
    {
        $limit = 10;
        if ($params) {
            $limit = (array) $params->get('limit');
            $limit = (int) current($limit);
        }

        $comments = $post->comments()->limit($limit)->get();
        $total = $post->comments()->count();

        return $this->collection($comments, new PostCommentTransformer())->setMeta(['total' => $total]);
    }
}
