<?php
/**
 * Created by PhpStorm.
 * User: ViviPro
 * Date: 7/29/2016
 * Time: 10:09 PM
 */

namespace Webapp\Frontend\Controllers;


use Webapp\Frontend\Models\Article;
use Webapp\Frontend\Models\ArticleView;
use Webapp\Frontend\Models\AtCat;
use Webapp\Frontend\Models\Category;
use Webapp\Frontend\Utility\Helper;

class CategoryController extends ControllerBase
{
    public function indexAction(){
        $id = $this->dispatcher->getParam("id","int");
        $categoryObject = Category::findFirst($id);
        $htmlx = "";
        // Load Slideshow
        $slideshow = ArticleView::find(array('conditions' => "poskey='slideshow' and catid = {$categoryObject->id}","order" => "sorts ASC"));
        $this->view->slideshow = $slideshow;

        if($categoryObject->type=="product"){
            $category = $categoryObject->toArray();
            $listchild = Category::find(array("conditions"=>"parentid=:parentid:","bind"=>array("parentid"=>$id)))->toArray();
            foreach($listchild as $key=>$child){
                $listchild[$key]['listArticles'] = Article::query()
                    ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                    ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $child['id']))
                    ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                    ->limit(3,0)
                    ->execute()->toArray();
            }
            $category['listchild'] = $listchild;
        }
        if($categoryObject->type=="about"){
            $category = $categoryObject;
        }
        else if($categoryObject->type=="copyright"){
            $categoryObject->audio = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"audio"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(4,0)
                ->execute();
            $categoryObject->video = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"video"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(4,0)
                ->execute();
            $categoryObject->copyright1 = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"copyright"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(2,0)
                ->execute();
            $categoryObject->copyright2 = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"copyright"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(2,2)
                ->execute();
            $category = $categoryObject;

        }
        else if($categoryObject->type=="learning"){
            $categoryObject->uuthe = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"uuthe"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(2,0)
                ->execute();
            $categoryObject->tuyensinh = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"tuyensinh"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(4,0)
                ->execute();
            $categoryObject->nganhdaotao = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"nganhdaotao"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(2,0)
                ->execute();
            $categoryObject->kynang = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"kynang"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(3,0)
                ->execute();
            $categoryObject->giangvien = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"giangvien"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(16,0)
                ->execute();
            $category = $categoryObject;

        }
        else if($categoryObject->type=="creator"){
            $categoryObject->listarticle = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $id))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit(27,0)
                ->execute();
            $category = $categoryObject;
        }
        else if($categoryObject->type=="news"){
            $link = rtrim($this->view->configapp->application->baseUrl,"/").$categoryObject->getlinkDetail();
            $this->response->redirect($link);
            return;
        }
        $htmlx = $this->render_template("category/template",$categoryObject->type,$category);
        $this->view->htmlx = $htmlx;
        /** Header */
        $this->view->header = array(
            "title"=>$categoryObject->name,
            "desc"=>$categoryObject->descriptions,
            "keyword"=>$categoryObject->descriptions,
            "canonial"=>str_replace('http:/','http://',str_replace("//","/",$this->config->application->baseUrl.$categoryObject->getlink())),
            "image"=>$this->view->coverphoto
        );
    }
    public function detailAction($id){
        if(empty($id)) $id = $this->dispatcher->getParam("id");
        $category = Category::findFirst($id);
        // Load Slideshow
        $slideshow = ArticleView::find(array('conditions' => "poskey='slideshow' and catid = {$category->id}","order" => "sorts ASC"));
        $this->view->slideshow = $slideshow;

        $categoryObject = $category;
        $category = $category->toArray();

        $htmlx = "";
        if($category['type']=="product"){
            $limit = 9;
            $p = $this->request->get("p","int");
            if ($p <= 1) $p = 1;
            $cp = ($p - 1) * $limit;

            $article = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1', array('catid' => $id))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit($limit,$cp)
                ->execute();
            $count =  AtCat::count(array("conditions"=>"catid=:catid:","bind"=>array("catid"=>$id)));
            $category['articles']= $article;
            $htmlx = $this->render_template("category/detail","product",$category);
            $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        }
        else if($category['type']=="copyright"){
            $limit = 8;
            $p = $this->request->get("p","int");
            if ($p <= 1) $p = 1;
            $cp = ($p - 1) * $limit;

            $type = $this->request->get("type","string");
            $category['articles'] = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 and Webapp\Frontend\Models\Article.types= :types:', array('catid' => $id,'types'=>"$type"))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit($limit,$cp)
                ->execute();
            $count =  AtCat::count(array("conditions"=>"catid=:catid:","bind"=>array("catid"=>$id)));
            $category['selectType'] = $type;
            $htmlx = $this->render_template("category/detail","copyright",$category);
            $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        }
        else{
            $limit = 20;
            $p = $this->request->get("p","int");
            if ($p <= 1) $p = 1;
            $cp = ($p - 1) * $limit;

            $category['articles'] = Article::query()
                ->leftJoin('Webapp\Frontend\Models\AtCat', 'Webapp\Frontend\Models\AtCat.atid = Webapp\Frontend\Models\Article.id')
                ->where('Webapp\Frontend\Models\AtCat.catid = :catid: and  Webapp\Frontend\Models\Article.status = 1 ', array('catid' => $id))
                ->orderBy('Webapp\Frontend\Models\Article.datecreate DESC')
                ->limit($limit,$cp)
                ->execute();
            $count =  AtCat::count(array("conditions"=>"catid=:catid:","bind"=>array("catid"=>$id)));
            $htmlx = $this->render_template("category/detail","news",$category);
            $this->view->painginfo = Helper::paginginfo($count, $limit, $p);
        }
        $this->view->htmlx = $htmlx;
        /** Header */
        $this->view->header = array(
            "title"=>$category['name'],
            "desc"=>$category['descriptions'],
            "keyword"=>$category['descriptions'],
            "canonial"=>str_replace('http:/','http://',str_replace("//","/",$this->config->application->baseUrl.$categoryObject->getlink())),
            "image"=>$this->view->coverphoto
        );

    }
}