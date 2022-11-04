<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use App\Users;
use App\Images;
use App\ImageTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */

     public function home(){
         $id=Auth::user()->id;
        $images=Images::where('deleted_at','=',null)->where('user_id','=',$id)->get();
        // dd($images);
        return view('home',compact('images'));
     }
    public function register(Request $request)
    {
        
        $rules = [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6'],
            'confirm_password' => 'required|same:password',
        ];
        $this->validate($request, $rules);

        $input=$request->all(); 
        $user = Users::create([
            'email'         => $input['email'],
            'password'      => Hash::make($input['password']),
        ]);
       
        return  redirect('/login');
    }

    public function login(Request $request){
        $rules = [
            'email' => 'required',
            'password' => 'required'
        ];
        // dd($request);

        $this->validate($request, $rules);

        if (Auth::attempt(array('email' => $request['email'], 'password' => $request['password']))) {           
                return redirect('/home');
        }
        else{
            return redirect('/login')->with('error','Invalid Details');
               
        }
    }
    public function upload(Request $request)
    {
        
        $rules = [
            'image' => ['mimes:png,jpeg,jpeg,gif', 'max:2048'],
            'type' => ['required']
        ];
        $this->validate($request, $rules);

        $input=$request->all(); 

        $id=Auth::user()->id;
        

       $type1_img=ImageTypes::where('user_id','=',$id)->where('type', 1)->get();
       $type2_img=ImageTypes::where('user_id','=',$id)->where('type', 2)->get();
       $last_upload=ImageTypes::where('user_id','=',$id)->orderBy('id','desc')->first();

        if($last_upload !=null){
            if ($input['type']== 1) {
                if($last_upload['type']==2){
                    $qr="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=".$input['image'];
                }
                else{
                    if(count($type1_img)%2 !=0){
                        $qr="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=".$input['image'];
                    }
                    else{
                        return  redirect('/home')->with('error','Please upload landscape image');
                    }
                }
                
            } else {
                if($last_upload['type']==1){
    
                    if(count($type1_img)%2 ==0){
                        $qr="https://chart.googleapis.com/chart?cht=qr&chs=500x200&chl=".$input['image'];
                    }
                    else{
                        return  redirect('/home')->with('error','Please upload Potrait image');
                    }
                }
                else{
                    return  redirect('/home')->with('error','Please upload Potrait image');
                }
                
            }
        }
        else{
            if ($input['type']== 1) {
                $qr="https://chart.googleapis.com/chart?cht=qr&chs=200x200&chl=".$input['image'];
            }
            else{
                $qr="https://chart.googleapis.com/chart?cht=qr&chs=500x200&chl=".$input['image'];
            }
        }
        if ($request->file('image')) {
            $filenameWithExt = $request->file('image')->getClientOriginalName(); //filename with ext
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME); //get just filename
            $extension = $request->file('image')->getClientOriginalExtension(); //get just ext
            $cmfilename = $filename . '_' . time() . '.' . $extension; //filename to store
            $path = $request->file('image')->storeAS('public/uploads', $cmfilename); //upload image
        }
       
        $image = Images::create([
            'image_url'         => $path,
            'type'      => $input["type"],
            'qr_code' => $qr,
            'user_id' => $id
        ]);

        $image = ImageTypes::create([
            'user_id'         => $id,
            'type'      => $input["type"],   
        ]);
        

        return  redirect('/home');
    }
}