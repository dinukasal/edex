<?php

class TestController extends BaseController{
	public function test(){

		$magazines=array("mag_1" => array("date"=> "2014/01/01", "issue"=> "1" , "title"=> "This is title", "img"=>"/img/1.jpg"),
						 "mag_2" => array("date"=> "2014/01/01", "issue"=> "1" , "title"=> "This is title", "img"=>"/img/2.jpg")
		);
		/*
		$articlesList=array(
			"volume_1" => 
					array( "article_1" => array("img"=> "/img/3.jpg", "title" => "This is title", "author" => "Author name"),
	  						"article_2" => array("img"=> "/img/4.jpg", "title" => "This is title" , "author" => "Author name"))
	    	,
			"volume_2" => 
					array( "article_1" => array("img"=> "/img/3.jpg", "title" => "This is title", "author" => "Author name"),
	  						"article_2" => array("img"=> "/img/4.jpg", "title" => "This is title" , "author" => "Author name"))
		);

	    */

		$articlesList=array(
					array( "article_1" => array("img"=> "/img/3.jpg", "title" => "This is title", "author" => "Author name"),
	  						"article_2" => array("img"=> "/img/4.jpg", "title" => "This is title" , "author" => "Author name"))
	    	,
					array( "article_1" => array("img"=> "/img/3.jpg", "title" => "This is title", "author" => "Author name"),
	  						"article_2" => array("img"=> "/img/4.jpg", "title" => "This is title" , "author" => "Author name"))
		);

	    $articlesData=array(
	    			array(
				    	array(
				    	"issue_no" => "Volume 1",
						"article_no"=> "article_1", 
						"title"=> "This is title",
						"image"=> "Image url", 
						"author" => "Authir name", 
						"content" => "Link of html formatted web page")
					)
	    );

	    return var_dump($articlesList[0]);
	    return var_dump($_POST);

		if($_POST['request']=='magz'){
			return json_encode($magazines);
		}else if($_POST['request']=='articles'){
			return json_encode($articlesList[$_POST['issue']]);
		}else if( $_POST['request']=='article'){
			return json_encode($articlesData[$_POST['issue']][$_POST['article']]);
		}
		
	}
}