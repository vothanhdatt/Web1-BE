<?php

namespace Botble\Member\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Botble\Base\Http\Responses\CustomResult;
use Botble\Member\Models\Member;

class CustomMemberController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $result = new CustomResult();
        try {
            $validator = Validator::make($request->input(), [
                'email'       => 'required|max:60|min:6|email',
                'password'       => 'required|max:60|min:6',
            ]);
            if ($validator->fails()) {
                $result->setError('Some field is not true !!');
            }else{
                $validated = ['email'=>$request->email,'password'=>$request->password];
                if (auth('member')->attempt($validated)) {
                    $memberLocation = "member_" . auth('member')->user()->id;
                // Create Token
                $token = auth('member')->user()->createToken($memberLocation)->accessToken;

                    $result->setData($token);
                }else{
                    $result->setError('Wrong at email or password');
                }
            }
        } catch (Exception $ex) {
            $result->setError($ex->getMessage());
        }
        return response($result->toResponse());
    }
}
