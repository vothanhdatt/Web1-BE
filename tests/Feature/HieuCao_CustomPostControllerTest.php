<?php

namespace Tests\Feature;

use Botble\Base\Http\Responses\CustomResult;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Botble\Blog\Http\Controllers\API\CustomPostController;
use Illuminate\Http\Request;
use Tests\TestCase;

class HieuCao_CustomPostControllerTest extends TestCase
{
    /**
     * Test testGetRelatedPost OK
     */
    public function testGetRelatedPostOk()
    {
        $request = new Request();
        $request->post_id = 1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == true &&
                isset($json->data) &&
                is_array($json->data) &&
                isset($json->data[0]) &&
                isset($json->data[0]->id) &&
                is_numeric($json->data[0]->id) &&
                isset($json->error) &&
                $json->error == NULL;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetRelatedPost with id is not exist
     */
    public function testGetRelatedPostWithIdNotExist()
    {
        $request = new Request();
        $request->post_id = -1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Post not found !!';
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetRelatedPost with id is float
     */
    public function testGetRelatedPostWithIdFloat()
    {
        $request = new Request();
        $request->post_id = 1.23;
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
     /**
     * Test testGetRelatedPost with id is String
     */
    public function testGetRelatedPostWithIdString()
    {
        $request = new Request();
        $request->post_id = '/\[]%^&*';
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetRelatedPost with id is null
     */
    public function testGetRelatedPostWithIdNull()
    {
        $request = new Request();
        $request->post_id = NULL;
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetRelatedPost with id is object
     */
    public function testGetRelatedPostWithIdObject()
    {
        $request = new Request();
        $request->post_id = new CustomResult();
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
     /**
     * Test testGetRelatedPost with id is BOOL TYPE, value is true
     */
    public function testGetRelatedPostWithIdTrue()
    {
        $request = new Request();
        $request->post_id = true;
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
     /**
     * Test testGetRelatedPost with id is BOOL TYPE, value is false
     */
    public function testGetRelatedPostWithIdFalse()
    {
        $request = new Request();
        $request->post_id = false;
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetRelatedPost with id is empty array
     */
    public function testGetRelatedPostWithIdEmptyArray()
    {
        $request = new Request();
        $request->post_id = [];
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetRelatedPost with id is array
     */
    public function testGetRelatedPostWithIdArray()
    {
        $request = new Request();
        $request->post_id = [1,2,3];
        $postController = new CustomPostController();
        $relatedPost = $postController->getRelatedPost($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
                isset($json->isSuccess) &&
                $json->isSuccess == false &&
                $json->data == NULL &&
                isset($json->error) &&
                $json->error == 'Wrong at Post Id';
        }
        $this->assertTrue($check);
    }
}
