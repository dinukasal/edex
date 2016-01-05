<?php

class MagazineController extends BaseController{

	public function saveMagazine(){
		//return var_dump($_FILES);
		$magazine=new Magazine;
		$magazine->issue=$_POST['issue'];
		$magazine->heading=$_POST['heading'];
		$magazine->date=$_POST['date'];
		$magazine->image=file_get_contents($_FILES['image']['tmp_name']);
		$status=$magazine->save();
		if($status==true){
			return Redirect::away('/addarticle/'.$_POST['issue']);
			//return View::make('upload')->with('title','Data Saved')
			//->with('issue',Magazine::all()[Magazine::all()->count()-1]['issue']+1);
		}else{

			return View::make('upload')->with('title','Data Not Saved!!')
			->with('issue',Magazine::all()[Magazine::all()->count()-1]['issue']+1);
		}
	}

	public function getMagazines(){
		return View::make('displayMagazines')
		->with('title','All Magazines')
		->with('magazines',Magazine::all());
	}
	public function getMagazineByIssue($issue){
		return View::make('articleslist')
		->with('title','Issue '.$issue)
		->with('heading',Magazine::where('issue','=',$issue)->get()[0]['heading'])
		->with('issue',$issue)
		->with('articles',ArticlesList::where('issue','=',$issue)->get()
		);
	}
	public function lastIssue(){
		return DB::table('data')->order_by('issue', 'desc')->first();
	}
	public function deleteArticle($issue,$articleno){
		$magazine=new Magazine;
		$status=$magazine->where('issue','=',$issue)->delete();
		if($status){
			return '
			<title>Delete Data</title>
			Issue '.$issue.' Deleted';
		}else{
			return 'Data Not Deleted';
		}
	}

	public function deleteMagazine($issue){
		$magazine=new Magazine;
		$status=$magazine->where('issue','=',$issue)->delete();
		if($status){
			return '
			<title>Delete Data</title>
			Issue '.$issue.' Deleted';
		}else{
			return 'Data Not Deleted';
		}
	}

	public function listMagazines(){
		return View::make('maglist')
		->with('title','Magazines List')
		->with('magazines',Magazine::all());
	}
	public function deleteMultiple(){
		$deleted=array();
		$count=0;
		foreach ($_POST as $issue=>$value) {
			$magazine=new Magazine;
			$status=$magazine->where('issue','=',$issue)->delete();
			if($status){
				$deleted[$count++]=$issue;
			}
		}
		return View::make('deletedMagz')
		->with('title','Deleted Magazines')
		->with('deleted',$deleted);
		/*
		return var_dump($_POST);
		*/
	}
	public function getJsonData(){
		$request=$_POST['request'];
		if(isset($_POST['issue'])){
			$issue=$_POST['issue'];
		}

		if(isset($_POST['articleNo'])){
			$articleno=$_POST['articleNo'];
		}
		//return Magazine::where('issue','=',$issue)->get()->toJson();
		if($_POST['request']=='magz'){
			$magazines=Magazine::all();
			$temp=array();
			$counter=0;
			foreach ($magazines as $item) {
				$temp[$counter++]=array($item['issue'],$item['heading'],$item['date']);
			}
				return json_encode($temp);
		}else if($_POST['request']=='articles'){
			$articlesList=ArticlesList::all();
			$temp=array();
			$counter=0;
			foreach ($articlesList as $item) {
				$temp[$counter++]=array($item['issue'],$item['articleNo'],$item['articleHeading'],$item['author']);
			}
			return json_encode($temp);
		}else if( $_POST['request']=='article'){
			$articleData=ArticleData::all();
			$temp=array();
			$counter=0;
			foreach ($articlesList as $item) {
				$temp[$counter++]=array($item['issue'],$item['articleNo'],$item['data']);
			}
			return json_encode($temp);
		}
	}
}