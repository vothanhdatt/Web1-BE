<?php

namespace Botble\Blog\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Botble\Base\Http\Responses\CustomResult;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Member\Models\Member;
use Google\Service\BigtableAdmin\Split;
use Google\Service\ManufacturerCenter\Count;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;

class CustomPostController extends Controller
{
    private $result;
    // Construct
    function __construct()
    {
        $this->result = CustomResult::getInstance();
    }

    /**
     * Detail post
     */
    function getPostById(Request $request)
    {
        try {
            $post = Post::select('posts.*', 'members.first_name as authorFirstName', 'members.last_name as authorLastName', 'members.avatar as authorAvatar')
                ->join('members', 'members.id', '=', 'posts.author_id')
                ->where('posts.id', $request->postID)->first();
            if ($post == null) {
                return response($this->result->setError("There are no posts !"));
            }
            if ($post->status != "published") {
                return response($this->result->setError("This post has not been approved !"));
            }
            return response($this->result->setData($post));
        } catch (Exception $ex) {
            return response($this->result->setError($ex->getMessage()));
        }
    }

    /**
     * Create post
     */
    function createPost(Request $request)
    {
        try {
            $member = $request->user();
            $validator = Validator::make($request->all(), [
                'name'          => 'required|min:2|max:60',
                'description'   => 'nullable|min:4|max:60',
                'content'       => 'required',
                'image'         => 'required|image|mimes:jpg,jpeg,png',
            ]);

            if ($validator->fails()) {
                return response($this->result->setError('Some field is not true !!'));
            }

            // Processing list category id
            $listCategoryId = $request->categoriesId;
            if (!$listCategoryId) {
                return response($this->result->setError('Category not found !!'));
            }

            $listCategoryId = explode(',', $listCategoryId);
            $newListCategoryId = [];
            // Filter Category Id
            foreach ($listCategoryId as $categoryId) {
                if (is_numeric($categoryId) && $this->checkCategoryIdExist($categoryId)) {
                    array_push($newListCategoryId, $categoryId);
                }
            }
            if (count($newListCategoryId) == 0) {
                return response($this->result->setError('Not sending in the correct format !!'));
            }

            // Insert Data
            $post = Post::create([
                'name' => $request->name,
                'description' => $request->description,
                'content' => $request->content,
                'status' => 'pending',
                'author_id' => $member->id,
                'author_type'   => "Botble\Member\Models\Member",
                'format_type'   => 'default'
            ]);
            $get_image = $request->file('image');
            $avatar_name = $post->id . '.' . $get_image->getClientOriginalExtension();
            $post->image = 'news/' . $avatar_name;
            $post->save();

            // Save image 600 x 600
            $image_resize = Image::make($get_image->getRealPath());
            $image_resize->resize(600, 600);
            $image_resize->save(public_path('storage/news/' . $avatar_name));

            // Create image by size
            $this->createImageBySize($post, $get_image, $image_resize);

            // Insert data into 'post_categories' table
            foreach ($newListCategoryId as $categoryId) {
                DB::table('post_categories')->insert([
                    'post_id' => $post->id,
                    'category_id' => $categoryId
                ]);
            }

            return response($this->result->setData($post));
        } catch (Exception $ex) {
            return response($this->result->setError($ex->getMessage()));
        }
    }

    function createImageBySize($post, $get_image, $image_resize)
    {
        $arrSize = array("150x150", "540x360", "565x375");

        for ($i = 0; $i < count($arrSize); $i++) {
            $avatar_name = $post->id . "-" . $arrSize[$i] . "." . $get_image->getClientOriginalExtension();
            $arrNumberSize = explode("x", $arrSize[$i]);
            $image_resize->resize($arrNumberSize[0], $arrNumberSize[1]);
            $image_resize->save(public_path('storage/news/' . $avatar_name));
        }
    }

    function checkCategoryIdExist($categoryID)
    {
        $arrCategories = Category::all();

        foreach ($arrCategories as $category) {
            if ($category->id == $categoryID) {
                return true;
            }
        }
        return false;
    }

    /**
     * Update post
     */
    function updatePost(Request $request)
    {
        try {



            return response($this->result->setData("Update successful!"));
        } catch (Exception $ex) {
            return response($this->result->setError($ex->getMessage()));
        }
    }




    /**
     * Delete post
     */

    function deletePost(Request $request)
    {
        try {
            $member = $request->user();
            $post = Post::where('id', $request->postID)->first();
            if ($post == null) {
                return response($this->result->setError("Post not found !"));
            }
            if ($post->author_id != $member->id) {
                return response($this->result->setError("The post is not owned by the owner, cannot be deleted !"));
            }
            $postID = $post->id;
            DB::table('post_categories')->where('post_id', $postID)->delete();

            // Delete Image
            $imageLink = $post->image;
            $temp = explode(".", $imageLink);
            $endOfImage = $temp[count($temp) - 1];
            $image1 = $postID . "." . $endOfImage;
            $image2 = $postID . "-150x150." . $endOfImage;
            $image3 = $postID . "-540x360." . $endOfImage;
            $image4 = $postID . "-565x375." . $endOfImage;

            $arrImage = array($image1, $image2, $image3, $image4);

            for ($i = 0; $i < count($arrImage); $i++) {
                $destinationPath = 'storage/news/' . $arrImage[$i];
                // Delete Image
                if (file_exists($destinationPath)) {
                    unlink($destinationPath);
                }
            }

            // Delete post
            $post->delete();
            return response($this->result->setData("Delete successfull!"));
        } catch (Exception $ex) {
            return response($this->result->setError($ex->getMessage()));
        }
    }

    // Get datetime Viet Nam Now
    private function getDatetimeVietNamNow()
    {
        // Get date
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        return date('Y/m/d H:i:s', time());
    }
    //Get URL Sever
    function get_url_sever()
    {
        $server_name = $_SERVER['SERVER_NAME'];

        if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
            $port = ":$_SERVER[SERVER_PORT]";
        } else {
            $port = '';
        }

        if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
            $scheme = 'https';
        } else {
            $scheme = 'http';
        }
        return $scheme . '://' . $server_name . $port;
    }
}
