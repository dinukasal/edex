<?php

class MagazineController extends BaseController
{

    /**
     * Save the magazine.
     * @return type
     */
    public function saveMagazine()
    {

        $link = null;
        if (Input::hasFile('image')) {
            $fileName = Input::get('issue') . '.' . Input::file('image')->getClientOriginalExtension();
            Input::file('image')->move(public_path() . '/Images/magazines/', $fileName);
            $link = '/Images/magazines/' . $fileName;
            Log::info($link);
        } else {
            return Redirect::back()->with('error', "Image is required!")->withInput();
        }

        $magazine = new Magazine;
        $magazine->issue = Input::get('issue');
        $magazine->heading = Input::get('heading');
        $magazine->date = Input::get('date');
        $magazine->image = $link;
        $status = $magazine->save();

        if ($status == true) {
            return Redirect::to('addarticle/' . Input::get('issue'));
        } else {
            return Redirect::back()->with('title', 'Data Not Saved!!')
                ->with('issue', Magazine::all()[Magazine::all()->count() - 1]['issue'] + 1);
        }
    }


    /**
     * get all the magazines
     * @return type
     */
    public function getMagazines()
    {
        return View::make('displayMagazines')
            ->with('title', 'All Magazines')
            ->with('magazines', Magazine::paginate(5));
    }


    /**
     * Get the magazine by issue
     * @param type $issue
     * @return type
     */
    public function getMagazineByIssue($issue)
    {
        return View::make('articleslist')
            ->with('title', 'Issue ' . $issue)
            ->with('heading', Magazine::where('issue', '=', $issue)->first()->heading)
            ->with('issue', $issue)
            ->with('articles', ArticlesList::where('issue', '=', $issue)->get()
            );
    }

    public function lastIssue()
    {
        return DB::table('data')->order_by('issue', 'desc')->first();
    }

    public function deleteArticle($issue, $articleno)
    {
        $magazine = new Magazine;
        $status = $magazine->where('issue', '=', $issue)->delete();
        if ($status) {
            return '
			<title>Delete Data</title>
			Issue ' . $issue . ' Deleted';
        } else {
            return 'Data Not Deleted';
        }
    }

    public function deleteMagazine($issue)
    {
        $magazine = new Magazine;
        $articlesList = new ArticlesList;
        $articleData = new ArticleData;
        $count = 0;
        $deleted = array();
        $status = $magazine->where('issue', '=', $issue)->delete();

        if ($status) {
            $status = $articlesList->where('issue', '=', $issue)->delete();
            if ($status) {
                $status = $articleData->where('issue', '=', $issue)->delete();
                if ($status) {
                    $deleted[$count++] = $issue;
                }
            }
        }
        return View::make('deletedMagz')
            ->with('title', 'Deleted Magazines')
            ->with('deleted', $deleted);

        if ($status) {
            return '
			<title>Delete Data</title>
			Issue ' . $issue . ' Deleted';
        } else {
            return 'Data Not Deleted';
        }
    }


    /**
     * List all the magazines
     * @return mixed
     */
    public function listMagazines()
    {
        return View::make('maglist')
            ->with('title', 'Magazines List')
            ->with('magazines', Magazine::all());
    }


    /**
     * Delete multiple magazines
     * @return mixed
     */
    public function deleteMultiple()
    {
        $deleted = array();
        $count = 0;
        foreach ($_POST as $issue => $value) {
            $magazine = new Magazine;
            $articlesList = new ArticlesList;
            $articleData = new ArticleData;

            $status = $magazine->where('issue', '=', $issue)->delete();

            if ($status) {
                $status = $articlesList->where('issue', '=', $issue)->delete();
                if ($status) {
                    $status = $articleData->where('issue', '=', $issue)->delete();
                    if ($status) {
                        $deleted[$count++] = $issue;
                    }
                }
            }
        }
        return View::make('deletedMagz')
            ->with('title', 'Deleted Magazines')
            ->with('deleted', $deleted);
        /*
          return var_dump($_POST);
         */
    }


    /**
     * Get the JSON from of the data requested. Magazine, articles or article
     * @return string
     */
    public function getJsonData()
    {
        $request = Input::get('request');
        $issue = Input::get('issue');
        $articleNo = Input::get('article');


        Log::info(Input::all());
        /**
         * Returning all the magazines if magazines are requested
         */
        if ($request === 'magz') {
            $magazines = Magazine::all();
            $temp = array();
            $counter = 1;
            foreach ($magazines as $item) {
                $temp['mag_' . $counter] = array();

                $temp['mag_' . $counter]['issue'] = $item['issue'];
                $temp['mag_' . $counter]['title'] = $item['heading'];
                $temp['mag_' . $counter]['image'] = '' . asset($item->image);

                $temp['mag_' . $counter++]['date'] = $item['date'];
            }
            return json_encode($temp);
        } else if ($request === 'articles') {
            $articlesList = ArticlesList::where('issue', Input::get('issue'))->get();
            $temp = array();
            $counter = 1;

            /**
             * Send only the articles
             */
            foreach ($articlesList as $item) {
                $temp['article_' . $counter] = array();
                //$temp['article_'.$counter]['isAdd']=0;
                $temp['article_' . $counter]['issue'] = $item['issue'];
                $temp['article_' . $counter]['articleNo'] = $item['articleNo'];
                $temp['article_' . $counter]['title'] = $item['articleHeading'];
                $imageLink = ArticleData::where('issue', $item->issue)->where('articleNo', $item->articleNo)->first()->image;
                $temp['article_' . $counter]['image'] = asset($imageLink);
                $temp['article_' . $counter]['lng'] = $articlesList->language;
                $temp['article_' . $counter++]['author'] = $item['author'];
            }
            return json_encode($temp);
        } else if ($request == 'article') {

            $articlesList = ArticlesList::where('issue', Input::get('issue'))
                ->where('articleNo', $articleNo)->first();

            $articleData = ArticleData::where('issue', $issue)
                ->where('articleNo', $articleNo)
                ->first();

            $data = array();

            $data['issue'] = $articlesList->issue;
            $data['articleNo'] = $articleData->articleNo;
            $data['title'] = $articlesList->articleHeading;
            $data['image'] = '' . asset($articleData->image);
            $data['author'] = $articlesList->author;
            $data['content'] = $articleData->data;
            $data['lng'] = $articlesList->language;
            $data['hasAd'] = $articlesList->hasAd ? 1 : 0;
            $data['adImage'] = $articlesList->hasAd ? $articlesList->adImage : null;
            return json_encode($data);
        } else {
            $file = uploadImage($_POST['issue'], $_FILES);
            return $file;
        }
    }

}

function uploadImage($issue, $files)
{
    File::makeDirectory(url('img/' . $issue));
    /*
      if($status){
      return 'ok';
      }else{
      return url('img/'.$issue);
      }
     */

    $destinationPath = url('img');
    $filename = basename($files["image"]["tmp_name"]);

    if (Input::hasFile($destinationPath . $filename)) {
        return 'ok';
        $file = Input::file($filename);
        $destinationPath = '/img/';
        $filename = $issue . '_' . $file->getClientOriginalName();
        $uploadSuccess = $file->move($destinationPath, $filename);
    } else {
        return 'no';
    }


    $target_dir = url('img');
    $target_file = $target_dir . basename($files["image"]["tmp_name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($files["image"]["tmp_name"]);
        if ($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }
}
