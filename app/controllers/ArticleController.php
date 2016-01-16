<?php

class ArticleController extends BaseController
{


    /**
     * View the form to add an article
     * @param $issue
     * @return mixed
     */
    public function viewForm($issue)
    {
        $article = ArticlesList::where('issue', '=', $issue)->get();
        foreach ($article as $key => $value) {
            $articleCount = $value['articleNo'];
        }
        if (isset($article[0])) {
            return View::make('uploadArticle')
                ->with('title', 'Add Article')
                ->with('articleNo', $articleCount + 1)
                ->with('issue', $issue);
        } else {
            return View::make('uploadArticle')
                ->with('title', 'Add Article')
                ->with('articleNo', 1)
                ->with('issue', $issue);
        }
    }


    /**
     * Saves an article uploaded
     * @return mixed
     */
    public function saveArticle()
    {
        $article = new ArticlesList;
        $article->issue = Input::get('issue');
        $article->articleno = Input::get('articleNo');
        $article->language=Input::get('language');
        $article->articleHeading = Input::get("heading");
        $article->author = Input::get("author");

        //include the advertisement
        if (Input::hasFile('adImage')) {
            $fileName = Input::get('issue') . '-' . Input::get('articleNo') . '.' . Input::file('adImage')->getClientOriginalExtension();
            Input::file('adImage')->move(public_path() . '/Images/magazines/articles/' . Input::get('issue') . '/ads/', $fileName);
            $adImageLink = '/Images/magazines/articles/' . Input::get('issue') . '/ads/' . $fileName;
            $article->hasAd = true;
            $article->adImage = $adImageLink;
        }
        $status = $article->save();

        if ($status == true) {
            $article = new ArticleData;
            $article->issue = $_POST['issue'];
            $article->articleno = $_POST['articleNo'];

            $link = null;
            if (Input::hasFile('image')) {
                $fileName = Input::get('issue') . '-' . Input::get('articleNo') . '.' . Input::file('image')->getClientOriginalExtension();
                Input::file('image')->move(public_path() . '/Images/magazines/articles/' . Input::get('issue') . '/', $fileName);
                $link = '/Images/magazines/articles/' . Input::get('issue') . '/' . $fileName;
                Log::info($link);
            } else {
                return Redirect::back()->with('error', "Image is required!")->withInput();
            }

            $article->image = $link;
            $article->data = $_POST['data'];
            $status = $article->save();

            if ($status == true) {
                return Redirect::to('addarticle/' . Input::get('issue'))
                    ->with('success', Input::get('articleNo') . ' added successfully!');
            } else {
                return Redirect::back()->with('error', 'Article not saved');
            }
        }
        return Redirect::back()->with('error', 'Article not saved');
    }


    /**
     * Update an article
     * @return mixed
     */
    public function updateArticle()
    {
        $article = ArticlesList::find(
            ArticlesList::where('issue', '=', $_POST['issue'])->where('articleNo', '=', $_POST['articleNo'])->get()[0]['id']);
        $article->articleHeading = $_POST['heading'];
        $article->author = $_POST['author'];
        $status = $article->save();

        if ($status == true) {
            $article = ArticleData::find(
                ArticleData::where('issue', '=', $_POST['issue'])->where('articleNo', '=', $_POST['articleNo'])->first()->id);

            $link = null;
            if (Input::hasFile('image')) {
                $fileName = Input::get('issue') . '-' . Input::get('articleNo') . '.' . Input::file('image')->getClientOriginalExtension();
                Input::file('image')->move(public_path() . '/Images/magazines/articles/' . Input::get('issue') . '/', $fileName);
                $link = '/Images/magazines/articles/' . Input::get('issue') . '/' . $fileName;
                Log::info($link);
            }
            $article->data = $_POST['data'];
            $status = $article->save();

            if ($status == true) {
                return Redirect::away('/listarticles/' . $_POST['issue']);
            } else {
                return Redirect::back()->with('error', 'Article Not Saved!!');
            }

        } else {
            return Redirect::back()->with('error', 'Article Not Saved!!');
        }
    }


    /**
     * Get an individual article in a view
     * @param $issue
     * @param $articleno
     * @return mixed
     */
    public function getArticle($issue, $articleno)
    {
        return View::make('displayArticle')
            ->with('title', 'Issue ' . $issue)
            ->with('issue', $issue)
            ->with('article', ArticleData::where('issue', '=', $issue)->where('articleNo', '=', $articleno)->first())
            ->with('articleData', ArticlesList::where('issue', '=', $issue)->where('articleNo', '=', $articleno)->first());
    }


    /**
     * Shows the form to edit an article
     * @param $issue
     * @param $articleno
     * @return mixed
     */
    public function editArticle($issue, $articleno)
    {
        return View::make('editArticle')
            ->with('title', 'Issue ' . $issue)
            ->with('issue', $issue)
            ->with('article', ArticleData::where('issue', '=', $issue)->where('articleNo', '=', $articleno)->first())
            ->with('articleData', ArticlesList::where('issue', '=', $issue)->where('articleNo', '=', $articleno)->first())
            ->with('articleNo', ArticlesList::where('issue', '=', $issue)->where('articleNo', '=', $articleno)->first()->articleNo);
    }

    public function lastIssue()
    {
        return DB::table('data')->order_by('issue', 'desc')->first();
    }

    public function delete($issue)
    {
        $magazine = new Magazine;
        $status = $magazine->where('issue', '=', $issue)->delete();
        if ($status) {
            return '
			<title>Delete Article</title>
			Issue ' . $issue . ' Deleted';
        } else {
            return 'Article Not Deleted';
        }
    }


    /**
     * Get a list of articles
     * @param $issue
     * @return mixed
     */
    public function listArticles($issue)
    {
        return View::make('articleslist')
            ->with('title', 'Issue ' . $issue)
            ->with('issue', $issue)
            ->with('heading', ArticlesList::where('issue', '=', $issue)->get()[0]['articleHeading'])
            ->with('articles', ArticlesList::where('issue', '=', $issue)
                ->get()
            );
    }

    public function deleteMultiple()
    {
        $deleted = array();
        $count = 0;
        $issue = 1;
        foreach ($_POST as $articleno => $value) {
            $article = new ArticlesList;
            $status = $article->where('issue', '=', $issue)->where('articleNo', '=', $articleno)->delete();
            if ($status) {
                $article = new ArticleData;
                $status = $article->where('issue', '=', $issue)->where('articleNo', '=', $articleno)->delete();
                if ($status) {
                    $deleted[$count++] = $articleno;
                }
            }
        }
        return View::make('deletedArticles')
            ->with('title', 'Deleted Docs')
            ->with('deleted', $deleted);
        /*
        return var_dump($_POST);
        */
    }
}