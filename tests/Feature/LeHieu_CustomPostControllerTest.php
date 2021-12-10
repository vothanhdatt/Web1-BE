<?php

namespace Tests\Feature;

use Botble\Blog\Http\Controllers\API\CustomPostController;
use Illuminate\Http\Request;
use Tests\TestCase;

class LeHieu_CustomPostControllerTest extends TestCase
{
    /**
     * Test testGetPostByCategory OK
     */
    public function testGetPostByCategorytOk()
    {
        $request = new Request();
        $request->category_id = 1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
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
            $json->error == null;
        }
        $this->assertTrue($check);
    }
    // /**
    //  * Test testGetPostByCategory is not exist
    //  */
    public function testGetPostByCategoryNotExist()
    {
        $request = new Request();
        $request->category_id = -1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory is float
     */
    public function testGetPostByCategoryFloat()
    {
        $request = new Request();
        $request->category_id = 1.23;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory is negative
     */
    public function testGetPostByCategoryNegative()
    {
        $request = new Request();
        $request->category_id = -1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory bool true
     */
    public function testGetPostByCategoryBoolTrue()
    {
        $request = new Request();
        $request->category_id = true;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data != null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory bool false
     */
    public function testGetPostByCategoryBoolFalse()
    {
        $request = new Request();
        $request->category_id = false;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == true ;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory is String
     */
    public function testGetPostByCategoryString()
    {
        $request = new Request();
        $request->category_id = '/\[]%^&*';
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory is null
     */
    public function testGetPostByCategoryNull()
    {
        $request = new Request();
        $request->category_id = null;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "Khong tim thay category";
        }
        $this->assertTrue($check);
    }

    /**
     * Test testGetPostByCategory is empty array
     */
    public function testGetPostByCategoryEmptyArray()
    {
        $request = new Request();
        $request->category_id = [];
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "Khong tim thay category";
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory is array
     */
    public function testGetPostByCategoryArray()
    {
        $request = new Request();
        $request->category_id = [1, 2, 3];
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
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
            $json->error == null;
        }
        $this->assertTrue($check);
    }
    /**
     * Test testGetPostByCategory is object
     */
    public function testGetPostByCategoryObject()
    {
        $request = new Request();
        $request->category_id = new Request();
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostByCategory($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test getAllCategories ok
     */
    public function testGetAllCategoriesOk()
    {
        $postController = new CustomPostController();
        $relatedPost = $postController->getAllCategories()->content();
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
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test getAllCategories ng
     */
    public function testGetAllCategoriesNg()
    {
        $postController = new CustomPostController();
        $relatedPost = $postController->getAllCategories()->content();
        $json = json_decode($relatedPost);

        $check = false;
        if ($json) {
            $check =
            !isset($json->isSuccess) ||
            $json->isSuccess == false ||
            !isset($json->data) ||
            !is_array($json->data) ||
            !isset($json->data[0]) ||
            !isset($json->data[0]->id) ||
            !is_numeric($json->data[0]->id) ||
            !isset($json->error) ||
            $json->error != false;
        }
        $expected = false;
        $this->assertEquals($check, $expected);
    }

    /**
     * Test detail post OK
     */
    public function testDetailPostOk()
    {
        $request = new Request();
        $request->postID = 1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data != null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test detail post Ng
     */
    public function testDetailPostNg()
    {
        $request = new Request();
        $request->postID = -1;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }

     /**
     * Test detail post Float
     */
    public function testDetailPostFloat()
    {
        $request = new Request();
        $request->postID = 1.123;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }
     /**
     * Test detail post String
     */
    public function testDetailPostString()
    {
        $request = new Request();
        $request->postID = "%qưe*";
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }
     /**
     * Test detail post negative
     */
    public function testDetailPostNegative()
    {
        $request = new Request();
        $request->postID = -33;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }
     /**
     * Test detail post is null
     */
    public function testDetailPostNull()
    {
        $request = new Request();
        $request->postID = null;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }
     /**
     * Test detail post is array
     */
    public function testDetailPostArray()
    {
        $request = new Request();
        $request->postID = [1,2,3,4];
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data != null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test detail post is null array
     */
    public function testDetailPostNullArray()
    {
        $request = new Request();
        $request->postID = [];
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }

    /**
     * Test detail post false
     */
    public function testDetailPostFalse()
    {
        $request = new Request();
        $request->postID = false;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }
    /**
     * Test detail post true
     */
    public function testDetailPostTrue()
    {
        $request = new Request();
        $request->postID = true;
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == true &&
            $json->data != null &&
            isset($json->error) &&
            $json->error == false;
        }
        $this->assertTrue($check);
    }
    /**
     * Test detail post object
     */
    public function testDetailPostObject()
    {
        $request = new Request();
        $request->postID = new Request();
        $postController = new CustomPostController();
        $relatedPost = $postController->getPostById($request)->content();
        $json = json_decode($relatedPost);
        $check = false;
        if ($json) {
            $check =
            isset($json->isSuccess) &&
            $json->isSuccess == false &&
            $json->data == null &&
            isset($json->error) &&
            $json->error == "There are no posts !";
        }
        $this->assertTrue($check);
    }
}
