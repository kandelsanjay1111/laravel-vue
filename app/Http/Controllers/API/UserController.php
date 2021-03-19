<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('isAdmin');
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:6'

        ]);
        
        User::create([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=>Hash::make($request['password']),
                'type'=>$request['type'],
                'bio'=>$request['bio'],
                'photo'=>$request['photo']
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public function profile(){
        return Auth::user();
    }

    public function updateProfile(Request $request){

        $user=auth('api')->user();
        $currentphoto=$user->photo;
        if($request->photo != $currentphoto){
            $name=time().'.'. explode('/',explode(':',substr($request->photo,0,strpos($request->photo, ';')))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

             $request['photo']=$name;

             $userPhoto=public_path('img/profile/').$currentphoto;

             if(file_exists($userPhoto)){
                @unlink($userPhoto);
             }
        }

        $user->update($request->all());
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $user=User::find($id);

        $this->validate($request,[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users,email,'.$user->id,
            'password'=>'sometimes|string|min:6'

        ]);

        if($request->password){
            $request['password']=Hash::make($request->password);
        }
        
        $user->update($request->all()) ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user=User::find($id);
        $user->delete();
    }

    public function product(){
        return [
            [
                'name'=>'Apple',
                'price'=>200,
                'description'=>'It is good',
                'stock'=>'twenty piece'
            ],
            
            [
                'name'=>'Mango',
                'price'=>100,
                'description'=>'It is ripen',
                'stock'=>'ten piece'
            ],
        ];
    }
}
