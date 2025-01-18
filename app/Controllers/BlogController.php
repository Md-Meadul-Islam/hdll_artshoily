<?php
namespace App\Controllers;

use App\Models\Blog;
use App\Models\User;
class BlogController
{
    public function index()
    {
        return view('blogs');
    }
    public function blog($b)
    {
        if (!$b) {
            echo json_encode(['success' => false, 'message' => 'Something Wrong !']);
            return 0;
        }
        $blog = new Blog();
        $res = $blog->blog($b);
        return view('blog', ['blog' => $res]);
    }
    public function loadCreateBlogModal()
    {
        $user = new User();
        $bloggers = $user->bloggers();
        $mode = 'create';
        return view('admin.blog-modal', ['bloggers' => $bloggers, 'mode' => $mode]);
    }
    public function loadEditBlogModal()
    {
        $blogId = $_GET['blog_id'];
        $user = new User();
        $bloggers = $user->bloggers();
        $blogs = new Blog();
        $blog = $blogs->blog($blogId);
        $mode = 'edit';
        return view('admin.blog-modal', ['bloggers' => $bloggers, 'blog' => $blog, 'mode' => $mode]);
    }
    public function loadBlogPaginate()
    {
        header('Content-type: application/json');
        $page = $_GET['page'];
        $limit = $_GET['limit'];
        $blog = new Blog();
        $blog = $blog->paginateBlog($page, $limit);
        echo json_encode(['success' => true, 'data' => $blog]);
    }
    public function storeBlog()
    {
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/blogs/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!empty($_FILES['image']['name'])) {
            $image = [
                'name' => $_FILES['image']['name'],
                'type' => $_FILES['image']['type'],
                'tmp_name' => $_FILES['image']['tmp_name'],
                'error' => $_FILES['image']['error'],
                'size' => $_FILES['image']['size']
            ];
            $filename = uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
            if (!$filename) {
                $_SESSION['error'][] = "Failed to upload image!";
                return 0;
            }
            $data['blog_id'] = generateUId();
            $data['image'] = $filename;
            $blog = new Blog();
            $res = $blog->store($data);
            if ($res['data']) {
                echo json_encode(['success' => true, 'message' => 'Blog Inserted Successfully !', 'data' => $res['data']]);
            }
        }
    }
    public function updateBlog()
    {
        header("Content-Type: application/json");
        $data = array_map('sanitizeInput', $_POST);
        $image_upload_dir = 'storage/blogs/';
        $image_max_size = 5 * 1024 * 1024; // 5 MB
        $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

        $previousImage = $data['previousImage'] ?? "";
        $blogImgName = '';

        if (empty($data['blog_id'])) {
            echo json_encode(['success' => false, 'message' => 'Blog ID is required!']);
            return;
        }
        if (!$previousImage && empty($_FILES['image']['name'])) {
            echo json_encode(['success' => false, 'message' => 'Blog image is required!']);
            return;
        }
        if (!empty($_FILES['image']['name'])) {
            $image = [
                'name' => $_FILES['image']['name'],
                'type' => $_FILES['image']['type'],
                'tmp_name' => $_FILES['image']['tmp_name'],
                'error' => $_FILES['image']['error'],
                'size' => $_FILES['image']['size']
            ];
            $blogImgName = uploadFile($image, $image_upload_dir, $allowed_image_types, $image_max_size);
        } else {
            $blogImgName = 'storage/blogs/' . explode('/storage/blogs/', $previousImage)[1];
        }
        $data['image'] = $blogImgName;
        try {
            $blog = new Blog();
            $res = $blog->update($data);
            if ($res['data']) {
                echo json_encode(['success' => true, 'message' => 'Blog updated successfully!', 'data' => $res['data']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Blog update failed!']);
            }
        } catch (\Throwable $th) {
            echo json_encode(['success' => false, 'message' => 'Error updating Blog: ' . $th->getMessage()]);
        }

    }
    public function deleteBlog()
    {
        header('Content-type: application/json');
        if (empty($_POST['id'])) {
            echo json_encode(['success' => false, 'message' => 'Something Wrong !']);
            return 0;
        }
        $id = sanitizeInput($_POST['id']);
        $arts = new Blog();
        $res = $arts->delete($id);
        if ($res['success']) {
            echo json_encode(['success' => true, 'message' => 'Art Deleted Successfully !']);
            return 0;
        } else {
            echo json_encode(['success' => false, 'message' => $res['message']]);
        }
    }
}