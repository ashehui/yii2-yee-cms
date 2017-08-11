<?php

namespace mapi\controllers;

use yeesoft\post\models\Category;
use yeesoft\post\models\Post;
use yeesoft\post\models\Tag;
use Yii;
use yii\data\ActiveDataProvider;
use mapi\actions\PostAction;

use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class ArticleController extends \yii\web\Controller
{
    public function actionIndex($slug='')
    {
        // display home page
        if (empty($slug) || $slug == 'index') {
            return $this->getArticles();
        }

        //try to display action from controller
        try {
            return $this->runAction($slug);
        } catch (\yii\base\InvalidRouteException $ex) {

        }

        //if nothing suitable was found then throw 404 error
        throw new NotFoundHttpException('Page not found.');
    }


    public function actionCategory($slug = '')
    {
        $data = [];
        if (empty($slug)) return $data;

        $category = Category::find()->where(['slug'=>$slug])->one();
        if (!empty($category)) {
            $data = $this->getArticles($category->getPosts());
        }

        return $data;
    }

    public function actionTag($slug = '')
    {
        $data = [];
        if (empty($slug)) return $data;

        $tag = Tag::find()->where(['slug'=>$slug])->one();
        if (!empty($tag)) {
            $data = $this->getArticles($tag->getPosts());
        }

        return $data;
    }

    protected function getArticles($query = '')
    {
        if (empty($query)) {
            $query = Post::find()->where(['status'=>Post::STATUS_PUBLISHED]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'updated_at' => SORT_DESC
                ]
            ]
        ]);

        $data = [];
        foreach($dataProvider->models as $model) {
            $data[$model->id] = $this->getApiData($model);
        }

        return [
            'totalCount' => $dataProvider->totalCount,
            'pageCount' => $dataProvider->pagination->pageCount,
            'pageSize' => $dataProvider->pagination->pageSize,
            'pageNum' => $dataProvider->pagination->page,
            'articles' => array_values($data),
        ];
    }

    protected function getApiData($model, $isDetail = false)
    {
        $data = [];
        $data['title'] = $model->title;
        $data['view_count'] = $model->view_count;
        $data['thumbnail'] = empty($model->thumbnail) ? '' : Yii::$app->urlManager->hostInfo.$model->thumbnail;
        $data['updated_at'] = $model->updated_at;
        $data['category'] = $model->category->title ?? '';
        $data['category_url'] = empty($model->category->slug) ? '' :  Yii::$app->urlManager->createAbsoluteUrl(['/article/category', 'slug'=>$model->category->slug]);

        $data['tags'] = [];
        foreach($model->tags as $tag) {
            $data['tags'][] = [
                'title' => $tag->title,
                'tag_url' => Yii::$app->urlManager->createAbsoluteUrl(['/article/tag', 'slug'=>$tag->slug])
            ];
        }

        $data['detail_url'] = Yii::$app->urlManager->createAbsoluteUrl(['/article/index', 'year'=>date('Y', $model->published_at), 'month'=>date('m', $model->published_at), 'slug'=>$model->slug]);

        if ($isDetail) {
            $data['content'] = $model->content;
        }

        return $data;
    }

}