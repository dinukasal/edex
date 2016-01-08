<?php

class MagazineController extends BaseController {

    /**
     * Save the magazine.
     * @return type
     */
    public function saveMagazine() {

        Log::info(public_path());
        $link = null;
        if (Input::hasFile('image')) {
            $fileName = Input::get('issue') . '.' . Input::file('image')->getClientOriginalExtension();
            Input::file('image')->move(public_path().'/Images/magazines/', $fileName);
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
    public function getMagazines() {
        return View::make('displayMagazines')
                        ->with('title', 'All Magazines')
                        ->with('magazines', Magazine::paginate(5));
    }

    
    /**
     * Get the magazine by issue
     * @param type $issue
     * @return type
     */
    public function getMagazineByIssue($issue) {
        return View::make('articleslist')
                        ->with('title', 'Issue ' . $issue)
                        ->with('heading', Magazine::where('issue', '=', $issue)->first()->heading)
                        ->with('issue', $issue)
                        ->with('articles', ArticlesList::where('issue', '=', $issue)->get()
        );
    }

    public function lastIssue() {
        return DB::table('data')->order_by('issue', 'desc')->first();
    }

    public function deleteArticle($issue, $articleno) {
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

    public function deleteMagazine($issue) {
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

    public function listMagazines() {
        return View::make('maglist')
                        ->with('title', 'Magazines List')
                        ->with('magazines', Magazine::all());
    }

    public function deleteMultiple() {
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

    public function getJsonData() {
        $request = $_POST['request'];
        if (isset($_POST['issue'])) {
            $issue = $_POST['issue'];
        }

        if (isset($_POST['articleNo'])) {
            $articleno = $_POST['articleNo'];
        }

        //return Magazine::where('issue','=',$issue)->get()->toJson();
        if ($_POST['request'] == 'magz') {
            $magazines = Magazine::all();
            $temp = array();
            $counter = 1;
            foreach ($magazines as $item) {
                $temp['mag_' . $counter] = array();

                $temp['mag_' . $counter]['issue'] = $item['issue'];
                $temp['mag_' . $counter]['title'] = $item['heading'];
                $temp['mag_' . $counter]['image'] = 'http://dulaj.comuv.com/image1.jpg';
                //$temp['mag_'.$counter]['img2']='data:image/jpeg;base64'.base64_encode($item['image']);

                $temp['mag_' . $counter++]['date'] = $item['date'];
            }
            return json_encode($temp);
        } else if ($_POST['request'] == 'articles') {
            $articlesList = ArticlesList::all();
            $temp = array();
            $counter = 1;
            foreach ($articlesList as $item) {
                if ($item['articleHeading'] != '') {
                    $temp['article_' . $counter] = array();
                    //$temp['article_'.$counter]['isAdd']=0;
                    $temp['article_' . $counter]['issue'] = $item['issue'];
                    $temp['article_' . $counter]['articleNo'] = $item['articleNo'];
                    $temp['article_' . $counter]['title'] = $item['articleHeading'];
                    $temp['article_' . $counter]['image'] = 'http://dulaj.comuv.com/image1.jpg';
                    $temp['article_' . $counter]['lng'] = 'e';
                    $temp['article_' . $counter++]['author'] = $item['author'];
                } else {
                    $temp = array(
                        'isAdd' => 1,
                        'addImage' => 'http://dulaj.comuv.com/image1.jpg'
                    );
                }
            }
            return json_encode($temp);
        } else if ($_POST['request'] == 'article') {
            $articlesList = new ArticlesList;
            $articlesList = $articlesList->where('issue', '=', $_POST['issue'])->get();
            $articleData = new ArticleData;
            $articleData = $articleData->where('issue', '=', $_POST['issue'])
                    ->where('articleNo', '=', $_POST['article'])
                    ->get();
            $counter = 0;
            //return $articlesList[$_POST['issue']]['issue'];
            $data = array();

            $data['issue'] = $articlesList[$_POST['issue'] - 1]['issue'];
            $data['articleNo'] = $articleData[0]['articleNo'];
            $data['title'] = $articlesList[$_POST['issue'] - 1]['articleHeading'];
            $data['image'] = 'http://dulaj.comuv.com/image1.jpg';
            $data['author'] = $articlesList[$_POST['issue'] - 1]['author'];
            $data['content'] = $articleData[0]['data'];
            $temp['article_' . $counter++]['lng'] = 'e';

            return json_encode($data);
        } else {

            $file = uploadImage($_POST['issue'], $_FILES);
            return $file;
        }
    }

}

function uploadImage($issue, $files) {
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
