<?php
namespace App\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Reactions;
use App\Models\Search;

class HomeController
{
    public function index()
    {
        view('index');
    }
    public function allCategory()
    {
        header('Content-type: application/json');
        $category = new Category();
        $categories = $category->activeCategory();
        echo json_encode(['success' => true, 'data' => $categories]);
    }
    public function activeCategory()
    {
        header('Content-type: application/json');
        $category = new Category();
        $categories = $category->activeCategoryId();
        echo json_encode(['success' => true, 'data' => $categories]);
    }
    public function leftContent()
    {
        $article = new Article();
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $slug = isset($_GET['cart']) ? $_GET['cart'] : '';
        $currentArticleId = '';
        if (!empty($slug)) {
            $currentArticleId = $article->findIdBySlug($slug);
        }
        $date = date('Y-m-d', strtotime('-10 days'));
        $leftContent = $article->leftContent($page, $date, $currentArticleId);
        if (!empty($leftContent)) {
            view('leftcontent', ['leftContent' => $leftContent]);
        } else {
            echo 'N';
        }
    }
    public function recentArticleCount()
    {
        $article = new Article();
        $recent = $article->recentCount();
        header('Content-type: application/json');
        echo json_encode(['success' => true, 'recent' => $recent]);
    }
    public function storeView()
    {
        $aSlug = $_POST['data'];

        $uId = isset($_SESSION['temp']) ? $_SESSION['temp'] : '';
        $article = new Article();
        $aId = $article->findIdBySlug($aSlug);
        $article->storeView($aId, $uId);

    }
    public function loadTopViews()
    {
        $article = new Article();
        $top = $article->topViews();
        header('Content-type: application/json');
        echo json_encode(['success' => true, 'd' => $top]);
    }
    public function addArticleReaction()
    {
        $userId = user()->email ? $_SESSION['temp'] : null;
        $articleId = sanitizeInput($_POST['aid']);
        $type = sanitizeInput($_POST['rt']);
        $previousReaction = isset($_POST['pr']) ? sanitizeInput($_POST['pr']) : null;
        try {
            $reaction = new Reactions();
            $totalReactions = $reaction->storeArticleReaction($articleId, $userId, $type, $previousReaction);
            echo json_encode(['success' => true, 'total' => $totalReactions]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function addCommentReaction()
    {
        $userId = user()->email ? $_SESSION['temp'] : null;
        $commentId = sanitizeInput($_POST['cid']);
        $articleId = sanitizeInput($_POST['aid']);
        $type = sanitizeInput($_POST['type']);
        $previousReaction = isset($_POST['pr']) ? sanitizeInput($_POST['pr']) : null;
        // dd($userId, $commentId, $articleId, $type, $previousReaction);
        try {
            $reaction = new Reactions();
            $reaction->storeCommentReaction($commentId, $articleId, $userId, $type, $previousReaction);
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function loadCommentReaction($id)
    {
        $reaction = new Reactions();
        $reactions = $reaction->getCommentReactions($id);
        echo json_encode($reactions);
    }
    public function searchKey()
    {
        $search = new Search();
        $keys = $search->keys();
        echo json_encode(['success' => true, 'searchkey' => $keys]);
    }
    public function search($key)
    {
        $key = sanitizeInput($key);
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = new Search();
        $article = $search->search($key, $page);
        if (!empty($article)) {
            view('searchedarticle', ['article' => $article]);
        } else {
            echo 'N';
        }
    }
    public function storeKey()
    {
        $key = sanitizeInput($_POST['key']);
        $is_find = sanitizeInput($_POST['status']);
        $search = new Search();
        $search->storeKey($key, $is_find);
    }
    public function searchCategory($key)
    {
        $key = sanitizeInput($key);
        $is_find = 0;
        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = new Search();
        $article = $search->searchCategory($key, $page);
        if (!empty($article)) {
            view('searchedarticle', ['article' => $article]);
            $is_find = 1;
        } else {
            echo 'N';
        }
        $search->storeKey($key, $is_find);
    }
}