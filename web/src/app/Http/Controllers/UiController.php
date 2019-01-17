<?php

namespace App\Http\Controllers;
use Validator;
use Input;
use Redirect;
use Auth;
use Cookie;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Log;

class UiController extends Controller {

    public function showLogin()
    {
        return view('login');
    }
    
    public function doLogin()
    {
        // define rules for the inputs
        $rules = array(
            'email'    => 'required|email',
            'password' => 'required|alphaNum|min:3'
        );
        
        // validate inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('/')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // create our user data for the authentication
            $userdata = array(
                'email'     => Input::get('email'),
                'password'  => Input::get('password')
            );
        
            // attempt to do the login
            $response = $this->requestLoginApi($userdata);

            if ($response->status == true) {
                // validation successful, save cookie!
                return Redirect::to('showsearch')
                ->withCookie(Cookie::make('accessToken', $response->data->accessToken, 60))
                ->with('message', 'Auth OK! (Token created)');
        
            } else {
                // validation fail, send back to login form
                return Redirect::to('/')
                ->withErrors("Invalid credentials")
                ->withInput(Input::except('password'));
            }
        }
    }

    public function requestLoginApi($userdata)
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->get('http://localhost:80/api/login', [
            'headers' => ['Accept' => 'application/json'],
            'query' => [
                'email' => $userdata['email'],
                'password' => $userdata['password']
             ]
        ]);

        return json_decode($response->getBody()->getContents());
    }

    public function requestApi($requestUrl)
    {
        $accessToken = Cookie::get('accessToken');
        if(!$accessToken) {
            Log::info("requestApi error: no accessToken");
            return false;
        }
       
        $client = new \GuzzleHttp\Client();
        $response = $client->get($requestUrl, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$accessToken,
            ],
        ]);
        $result = $response->getBody()->getContents();
        return $result;
    }

    public function showSearch()
    {
        return view('search');
    }

    public function doSearch(Request $request)
    {
        $request->flash();

        $requestUrl = "http://localhost:80/api/" . Input::get('api_version') . 
        "/products?q=" . Input::get('filter_title') .
        "&filter=brand:" . Input::get('filter_brand') .
        ",pricemin:" . Input::get('filter_pricemin') . 
        ",pricemax:" . Input::get('filter_pricemax') . 
        ",stock:" . Input::get('filter_stock') . 
        "&sort=" . Input::get('sort_title') . 
        "," . Input::get('sort_brand') . 
        "," . Input::get('sort_price') . 
        "," . Input::get('sort_stock') .
        "&page=" . Input::get('page');

        $response = $this->requestApi($requestUrl);
        if(!$response) {
            return redirect()->route('login')->withErrors("Login expired!");
        }

        return view('search', ['response' => $response, 'requestUrl' => $requestUrl]);
    }
}