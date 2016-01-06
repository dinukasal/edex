<?php

class ArticleController extends BaseController{


	public function viewForm($issue){
		$article= ArticlesList::where('issue','=',$issue)->get();
		foreach ($article as $key => $value) {
			$articleCount=$value['articleNo'];
		}
		if(isset($article[0])){
			return View::make('uploadArticle')
			->with('title','Add Article')
			->with('articleNo',$articleCount+1)
			->with('issue',$issue)
			;
		}else{
			return View::make('uploadArticle')
			->with('title','Add Article')
			->with('articleNo',1)
			->with('issue',$issue)
			;
		}
	}

	public function saveArticle(){
		$article=new ArticlesList;
		$article->issue=$_POST['issue'];
		$article->articleno=$_POST['articleNo'];
		$article->articleHeading=$_POST['heading'];
		$article->author=$_POST['author'];
		$status=$article->save();

		if($status==true){
			$article=new ArticleData;
			$article->issue=$_POST['issue'];
			$article->articleno=$_POST['articleNo'];
			if($_FILES['image']['tmp_name']!=''){
				$article->image=file_get_contents($_FILES['image']['tmp_name']);
			}
			$article->data=$_POST['data'];

			$status=$article->save();

			if($status==true){
				return Redirect::away('/addarticle/'.$_POST['issue']);
			}else{
				return View::make('uploadArticle')->with('title','Article Not Saved!!')
				->with('issue',Magazine::all()[Magazine::all()->count()-1]['issue']+1);
			}

		}
	}

	public function updateArticle(){
		$article=ArticlesList::find(
			ArticlesList::where('issue','=',$_POST['issue'])->where('articleNo','=',$_POST['articleNo'])->get()[0]['id']);
		$article->articleHeading=$_POST['heading'];
		$article->author=$_POST['author'];
		$status=$article->save();

		if($status==true){
			$article=ArticleData::find(
			ArticleData::where('issue','=',$_POST['issue'])->where('articleNo','=',$_POST['articleNo'])->get()[0]['id']);
			if($_FILES['image']['tmp_name']!=''){
				$article->image=file_get_contents($_FILES['image']['tmp_name']);
			}
			$article->data=$_POST['data'];
			$status=$article->save();

			if($status==true){
				return Redirect::away('/listarticles/'.$_POST['issue']);
			}else{
				return View::make('editArticle')->with('title','Article Not Saved!!')
				->with('issue',Magazine::all()[Magazine::all()->count()-1]['issue']+1);
			}

		}else{
			return "update failed!";
		}
	}

	public function getArticle($issue,$articleno){
		return View::make('displayArticle')
		->with('title','Issue '.$issue)
		->with('issue',$issue)
		->with('article',ArticleData::where('issue','=',$issue)->where('articleNo','=',$articleno)->get())
		->with('articleData',ArticlesList::where('issue','=',$issue)->where('articleNo','=',$articleno)->get());
	}

	public function editArticle($issue,$articleno){
		return View::make('editArticle')
		->with('title','Issue '.$issue)
		->with('issue',$issue)
		->with('article',ArticleData::where('issue','=',$issue)->where('articleNo','=',$articleno)->get())
		->with('articleData',ArticlesList::where('issue','=',$issue)->where('articleNo','=',$articleno)->get())
		->with('articleNo',ArticlesList::where('issue','=',$issue)->where('articleNo','=',$articleno)->get()[0]['articleNo'])
		;
	}

	public function lastIssue(){
		return DB::table('data')->order_by('issue', 'desc')->first();
	}
	public function delete($issue){
		$magazine=new Magazine;
		$status=$magazine->where('issue','=',$issue)->delete();
		if($status){
			return '
			<title>Delete Article</title>
			Issue '.$issue.' Deleted';
		}else{
			return 'Article Not Deleted';
		}
	}
	public function listArticles($issue){
		return View::make('articleslist')
		->with('title','Issue '.$issue)
		->with('issue',$issue)
		->with('heading',ArticlesList::where('issue','=',$issue)->get()[0]['articleHeading'])
		->with('articles',ArticlesList::where('issue','=',$issue)
			->get()
		);
	}
	public function deleteMultiple(){
		$deleted=array();
		$count=0;
		$issue=1;
		foreach ($_POST as $articleno=>$value) {
			$article=new ArticlesList;
			$status=$article->where('issue','=',$issue)->where('articleNo','=',$articleno)->delete();
			if($status){
				$article=new ArticleData;
				$status=$article->where('issue','=',$issue)->where('articleNo','=',$articleno)->delete();
				if($status){
					$deleted[$count++]=$articleno;
				}
			}
		}
		return View::make('deletedArticles')
		->with('title','Deleted Docs')
		->with('deleted',$deleted);
		/*
		return var_dump($_POST);
		*/
	}
}