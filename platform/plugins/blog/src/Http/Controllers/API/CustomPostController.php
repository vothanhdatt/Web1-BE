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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;


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
    function getPostById(Request $request){
        try {
            $post = Post::select('posts.*', 'members.first_name as authorFirstName','members.last_name as authorLastName','members.avatar as authorAvatar')
            ->join('members','members.id','=', 'posts.author_id')
            ->where('posts.id', $request->postID)->first();
            if ($post == null) {
                return response($this->result->setError("There are no posts !"));
            }
            if ($post->status!="published") {
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
    function createPost(Request $request){

        try {
            $member = $request->user();
            $validator = Validator::make($request->input(), [
                'name'          => 'required|min:2|max:60',
                'description'   => 'nullable|min:4|max:60',
                'content'       => 'required',
                // 'image'            => 'required|email|min:6',
            ]);

            if ($validator->fails()) {
                return response($this->result->setError('Some field is not true !!'));
            }

            // Insert Data
            $post = Post::create([
                'name' => $request->name,
                'description' => $request->description,
                'content' => $request->content,
                'status' => 'pending',
                'author_id' => $member->id,
            ]);

            return response($this->result->setData($post));

        } catch (Exception $ex) {
            return response($this->result->setError($ex->getMessage()));
        }
    }

    /**
     * Delete post
     */

    function deletePost(Request $request){
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
