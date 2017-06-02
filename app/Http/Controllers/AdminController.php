<?php 
 namespace App\Http\Controllers;
use Mail;
use Session;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Input;
use Response;
use App\Admin;
use App\EventCategory;
use App\Event;
use App\Blog;
use App\User;
use DB;
class AdminController extends Controller{
	public function index(){
		$validate =0;
		$dataArray = Input::all();
		if (Session::has('Admin') ==  true){
			return redirect('/admin/dashboard');
		}
		$dataArray = Input::all();
		$retJson = array();
		if(!empty($dataArray) ){
			if(!isset($dataArray['email']) || empty($dataArray['email']) ){
				$validate++;
				Session::flash('validate', 'Please Enter Email');
			}else if(!isset($dataArray['password']) || empty($dataArray['password']) ){
				$validate++;
				Session::flash('validate', 'Please Enter Password');
			}
			if($validate==0){
				$Admin = Admin::where('status', '=', 1)->where('password', '=', md5($dataArray['password']))->where('email', '=', $dataArray['email'])->first();
				if (isset($Admin)) {
					Session::set('Admin',$Admin);
					Session::flash('validate', 'Login Successfully');
					return redirect('/admin/dashboard');
				}else{
					Session::flush();
					Session::flash('validate', 'Invalid Login Credentials');
					$validate++;
				}
			}
		}
		if($validate == 0){
				Session::flash('msgtype', 'success');
			}else{
				Session::flash('msgtype', 'danger');
			}
		return view('backend.admin.login');
	}
	public function dashboard(){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		return view('backend.admin.dashboard');
	}
	public function changepassword(){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
  		$dataArray =Input::all();
  		if(!empty($dataArray)){
   			$validate = 0;
			if(empty(Input::get('current')) ){
				Session::flash('validate', 'Current password must not blank');
				$validate++;
			}else if(empty(Input::get('password')) ){
				Session::flash('validate', 'New password must not blank');
				$validate++;
			}else if(empty(Input::get('confirm')) ){
				Session::flash('validate', 'Confirm password must not blank');
				$validate++;
			}else if(Input::get('password') != Input::get('confirm')){
				Session::flash('validate', 'Confirm password not match.');
				$validate++;
			}else{
				$user =Session::get('Admin');
				$OldPassCheck = Admin::where('id', '=', $user->id)->where('password','=',md5($dataArray['current']))->get();
				
				if( @$OldPassCheck[0] ) {
					$user = Admin::find($user->id);
					$user->password = md5($dataArray['password']);
					if($user->save()){
						Session::flash('validate', 'Password Changed successfully.');
					}else{
						$validate++;
						Session::flash('validate', 'Password cannot be changed this time. Please try later.');
					}
				}else{
					$validate++;
					Session::flash('validate', 'Incorrect Old Password.');
					
				}
			}
			if($validate == 0){
				Session::flash('msgtype', 'success');
			}else{
				Session::flash('msgtype', 'danger');
			}
		}
		return view('backend.admin.changepassword');
	}

	
	public function addEvent(){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$eventCategories = EventCategory::where('status', '!=', 4)->lists('event_category_name','id');
		$response =array();
		$inputData = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'event_category_id' => @$inputData['event_category_id'],
			  'event_name'  => @$inputData['event_name'],
			  'event_description'  => @$inputData['event_description'],
			  'event_address'  => @$inputData['event_address'],
			  'event_performance_time'  => @$inputData['event_performance_time'],
			  'event_date_time_description'  => @$inputData['event_date_time_description'],
			  'event_ticket_price' => @$inputData['event_ticket_price'],
			  'event_banner_image'  => @$inputData['event_banner_image'],
			  'event_video'  => @$inputData['event_video'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'event_category_id' => 'required',
				'event_name' => 'required',
				'event_description' => 'required',
				'event_address' => 'required',
				'event_performance_time' => 'required',
				'event_date_time_description' => 'required',
				'event_banner_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
				'event_video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
				'status' => 'required',
				'event_ticket_price'=> 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			 //save to DB user details
			$destinationPath = '';
			$filename        = '';

			if (Input::hasFile('event_banner_image') ) {
				$file            = Input::file('event_banner_image');
				$destinationPath = public_path().'/images/eventsbanner';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['event_banner_image'] = $filename;
			}
			if (Input::hasFile('event_video')) {
				$file            = Input::file('event_video');
				$destinationPath = public_path().'/images/eventVideo';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['event_video'] = $filename;
			}
			
			  if(Event::create($userData)){ 
				$response =array(
					  'Status' => 'success',
				  'message' => 'Event has been added successfully.'
					);
			  }
			}
		}
		return view('backend.admin.addEvent')->with('response',$response)->with('inputData',$inputData)->with('eventCategories',$eventCategories);
	}
	public function editEvent($id){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$eventCategories = EventCategory::where('status', '!=', 4)->lists('event_category_name','id');
		$response =array();
		$inputData = array();
		$inputData = Event::find($id);
		$old_file['event_banner_image'] = $inputData['event_banner_image'];
		$old_file['event_video'] = $inputData['event_video'];
		if(!empty(Input::all())){
			$inputData =Input::all();
			$userData = array(
			  'event_category_id' => @$inputData['event_category_id'],
			  'event_name'  => @$inputData['event_name'],
			  'event_description'  => @$inputData['event_description'],
			  'event_address'  => @$inputData['event_address'],
			  'event_performance_time'  => @$inputData['event_performance_time'],
			  'event_date_time_description'  => @$inputData['event_date_time_description'],
			  'event_ticket_price' => @$inputData['event_ticket_price'],
			  'event_banner_image'  => @$inputData['event_banner_image'],
			  'event_video'  => @$inputData['event_video'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'event_category_id' => 'required',
				'event_name' => 'required',
				'event_description' => 'required',
				'event_address' => 'required',
				'event_performance_time' => 'required',
				'event_date_time_description' => 'required',
				'event_banner_image' => 'mimes:jpeg,jpg,png,gif|required|max:10000',
				'event_video' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
				'status' => 'required',
				'event_ticket_price'=> 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			 //save to DB user details
			$destinationPath = '';
			$filename        = '';
			
			$Event = Event::find($id);
			//print_r($Event);
			//exit;
			if (Input::hasFile('event_banner_image') ) {
				$file            = Input::file('event_banner_image');
				$destinationPath = public_path().'/images/eventsbanner';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['event_banner_image'] = $filename;
				//unlink(public_path().'\images\eventsbanner'.$Event->event_banner_image);
			}
			
			if (Input::hasFile('event_video')) {
				$file            = Input::file('event_video');
				$destinationPath = public_path().'/images/eventVideo';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['event_video'] = $filename;
				//unlink($destinationPath.'/'.$Event->event_video);
			}
			$Event->event_category_id = @$inputData['event_category_id'];
			$Event->event_name = @$inputData['event_name'];
			$Event->event_description = @$inputData['event_description'];
			$Event->event_address = @$inputData['event_address'];
			$Event->event_performance_time = @$inputData['event_performance_time'];
			$Event->event_date_time_description = @$inputData['event_date_time_description'];
			$Event->event_banner_image = !empty(@$userData['event_banner_image'])?@$userData['event_banner_image']:$old_file['event_banner_image'];
			$Event->event_video = !empty(@$userData['event_video'])?@$userData['event_video']:$old_file['event_video'];
			$Event->status = @$inputData['status'];
			//save to DB user details
			if($Event->save()){ 
				$response =array(
					  'Status' => 'success',
				  'message' => 'Event has been updated successfully !!'
					);
			  }
			}
		}
		return view('backend.admin.editEvent')->with('response',$response)->with('inputData',$inputData)->with('eventCategories',$eventCategories);
	}	
	public function viewEvent(){
			if (Session::has('Admin') ==  false){
				return redirect('/admin/');
			}
			$model = Event::where('events.status', '!=', 4)->leftjoin('event_category', 'events.event_category_id', '=', 'event_category.id')->select('events.*','event_category.event_category_name')->get();
			
			return view('backend.admin.viewEvent')->with('events', $model);
		}	
	public function statusEvent($status,$id){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$Event = Event::where('id','=',$id)->firstorfail();
		
		$Event->status = $status;
		$Event->save();
		Session::set('msgtype', 'success');
		if($Event->status==1){
			Session::set('validate', 'Event Category activated Successfully !!');
		}else if($Event->status==0){
			Session::set('validate', 'Event Category inactivated Successfully !!');
		}
		else{
			Session::set('validate', 'Event Category deleted Successfully !!');
		}
		return redirect('admin/viewEvent');
	}
	public function addEventCategory(){
		if (Session::has('Admin') ==  false){
		return redirect('/admin/');
		}
		$response =array();
		$inputData = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'event_category_name' => @$inputData['event_category_name'],
			  'event_category_description'  => @$inputData['event_category_description'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'event_category_name'   => 'required',
				'event_category_description' => 'required',
				'status' => 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			 //save to DB user details
			  if(EventCategory::create($userData)){ 
				$response =array(
					  'Status' => 'success',
				  'message' => 'Event Category has been added successfully.'
					);
			  }
			}
		}
		return view('backend.admin.addEventCategory')->with('response',$response)->with('inputData',$inputData);
	}
	public function editEventCategory($id){
		if (Session::has('Admin') ==  false){
		return redirect('/admin/');
		}
		$response =array();
		$inputData = array();
		
		$inputData = EventCategory::find($id);
		
		if(!empty(Input::all())){
			$inputData =Input::all(); 
			$userData = array('event_category_name' => @$inputData['event_category_name'],'event_category_description' => @$inputData['event_category_description'],'status'=> @$inputData['status']);
			$rules = array('event_category_name' => 'required','event_category_description' => 'required','status' => 'required');
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response = array('Status' => 'danger','message' => $erMsg);
			}	
			else {
				$EventCategory = EventCategory::find($id);
				//$EventCategory = new EventCategory;
				//$EventCategory->status = ($EventCategory->status==1) ? 2 : 1;
				$EventCategory->event_category_name = @$inputData['event_category_name'];
				$EventCategory->event_category_description = @$inputData['event_category_description'];
				$EventCategory->status = @$inputData['status'];
				//$EventCategory->id = $id;
				//save to DB user details
				if($EventCategory->save()){ 
					$response = array('Status' => 'success','message' => 'Event Category has been updated successfully.');
				}
			}
		}
		return view('backend.admin.editEventCategory')->with('response',$response)->with('inputData',$inputData);
	}
	public function viewEventCategory(){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$model = EventCategory::where('status', '!=', 4)->get();
		return view('backend.admin.viewEventCategory')->with('categories', $model);
	}
	public function statusEventCategory($status,$id){
			if (Session::has('Admin') ==  false){
				return redirect('/admin/');
			}
			$EventCategory = EventCategory::where('id','=',$id)->firstorfail();
			
			$EventCategory->status = $status;
			$EventCategory->save();
			Session::set('msgtype', 'success');
			if($EventCategory->status==1){
				Session::set('validate', 'Event Category activated Successfully !!');
			}else if($EventCategory->status==0){
				Session::set('validate', 'Event Category inactivated Successfully !!');
			}
			else{
				Session::set('validate', 'Event Category deleted Successfully !!');
			}
			return redirect('admin/viewEventCategory');
		}
	public function addblog(){
		//Blog
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$response =array();
		$inputData = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'blog_title' => @$inputData['blog_title'],
			  'blog_description'  => @$inputData['blog_description'],
			  'blog_video'  => @$inputData['blog_video'],
			  'blog_image'  => @$inputData['blog_image'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'blog_title' => 'required',
				'blog_description' => 'required',
				'blog_image' => 'mimes:jpeg,jpg,png,gif|max:10000',
				'blog_video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
				'status' => 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			 //save to DB user details
			$destinationPath = '';
			$filename        = '';

			if (Input::hasFile('blog_image') ) {
				$file            = Input::file('blog_image');
				$destinationPath = public_path().'/images/blogImages';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['blog_image'] = $filename;
			}
			if (Input::hasFile('blog_video')) {
				$file            = Input::file('blog_video');
				$destinationPath = public_path().'/images/blogVideo';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['blog_video'] = $filename;
			}
			
			  if(Blog::create($userData)){ 
				$response =array(
					  'Status' => 'success',
				  'message' => 'Blog has been added successfully.'
					);
			  }
			}
		}
		return view('backend.admin.blog.addBlog')->with('response',$response)->with('inputData',$inputData);
	}
	
	public function viewblog(){
			if (Session::has('Admin') ==  false){
				return redirect('/admin/');
			}
			$model = Blog::where('blogs.status', '!=', 4)->get();
			
			return view('backend.admin.blog.viewblog')->with('blogs', $model);
	}

	public function editblog($id){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$response =array();
		$inputData = array();
		$inputData = Blog::find($id);
		$old_file = array();
		$old_file['blog_video'] = @$inputData['blog_video'];
		$old_file['blog_image'] = @$inputData['blog_image'];
		if(!empty(Input::all())){
			$inputData =Input::all();
			$userData = array(
			  'blog_title' => @$inputData['blog_title'],
			  'blog_description'  => @$inputData['blog_description'],
			  'blog_video'  => @$inputData['blog_video'],
			  'blog_image'  => @$inputData['blog_image'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'blog_title' => 'required',
				'blog_description' => 'required',
				'blog_image' => 'mimes:jpeg,jpg,png,gif|max:10000',
				'blog_video' => 'mimes:mp4,ogx,oga,ogv,ogg,webm',
				'status' => 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			 //save to DB user details
			$destinationPath = '';
			$filename        = '';
			
			$Blog = Blog::find($id);
			if (Input::hasFile('blog_image') ) {
				$file            = Input::file('blog_image');
				$destinationPath = public_path().'/images/blogImages';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['blog_image'] = $filename;
			}
			if (Input::hasFile('blog_video')) {
				$file            = Input::file('blog_video');
				$destinationPath = public_path().'/images/blogVideo';
				$filename        = time() . '_' . $file->getClientOriginalName();
				$filename = str_replace(' ','_',$filename);
				$uploadSuccess   = $file->move($destinationPath, $filename);
				$userData['blog_video'] = $filename;
			}
			$Blog->blog_title = @$inputData['blog_title'];
			$Blog->blog_description = @$inputData['blog_description'];
			$Blog->blog_image = !empty(@$userData['blog_image'])?@$userData['blog_image']:$old_file['blog_image'];
			$Blog->blog_video = !empty(@$userData['blog_video'])?@$userData['blog_video']:$old_file['blog_video'];
			$Blog->status = @$inputData['status'];
			//save to DB user details
			if($Blog->save()){ 
				$response =array(
					  'Status' => 'success',
				  'message' => 'Blog has been updated successfully !!'
					);
			  }
			}
		}
		return view('backend.admin.blog.editblog')->with('response',$response)->with('inputData',$inputData)->with('old_file',$old_file);
	}
	public function statusblog($status,$id){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$Blog = Blog::where('id','=',$id)->firstorfail();
		
		$Blog->status = $status;
		$Blog->save();
		Session::set('msgtype', 'success');
		if($Blog->status==1){
			Session::set('validate', 'Blog activated Successfully !!');
		}else if($Blog->status==0){
			Session::set('validate', 'Blog inactivated Successfully !!');
		}
		else{
			Session::set('validate', 'Blog deleted Successfully !!');
		}
		return redirect('admin/viewblog');
	}
    public function addUser(){
		//Blog
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$response =array();
		$inputData = array();
		$inputData =Input::all(); 
		if(!empty($inputData)){
			$userData = array(
			  'firstname' => @$inputData['firstname'],
			  'lastname'  => @$inputData['lastname'],
			  'email'  => @$inputData['email'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'firstname'=> 'required',
				'lastname' => 'required',
				'email'    => 'required|email|unique:users,email,NULL,id,status,!4',
				'status'   => 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			    $userData['tmp_link'] =  url('/resetPass').'/'.md5(uniqid(rand(), true));
				$userData['registered_by'] = 2;
				
			  if(User::create($userData)){ 
			    // Mail Send : Starts Here 
				Mail::send('email.adminSend', array('tmp_link' => $userData['tmp_link']), function($message)
				{
					$message->to(Input::get('email'), 'SATORIS Support')->subject('SATORIS Support - Your email is registered.');
				});
			    // Mail Send : Ends Here 
				$response =array(
					'Status' => 'success',
				    'message' => 'Users has been added successfully.'
			    );
			  }
			}
		}
		return view('backend.admin.users.addUser')->with('response',$response)->with('inputData',$inputData);
	}

	public function viewUser(){
			if (Session::has('Admin') ==  false){
				return redirect('/admin/');
			}
			$model = User::where('users.status', '!=', 4)->get();
			
			return view('backend.admin.users.viewUser')->with('users', $model->toArray());
	}
	public function statusUser($status,$id){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$User = User::where('id','=',$id)->firstorfail();
		
		$User->status = $status;
		$User->save();
		Session::set('msgtype', 'success');
		if($User->status==1){
			Session::set('validate', 'User activated Successfully !!');
		}else if($User->status==0){
			Session::set('validate', 'User inactivated Successfully !!');
		}
		else{
			Session::set('validate', 'User deleted Successfully !!');
		}
		return redirect('admin/viewUser');
	}
	public function editUser($id){
		if (Session::has('Admin') ==  false){
			return redirect('/admin/');
		}
		$response =array();
		$inputData = array();
		$inputData = User::find($id);
		if(!empty(Input::all())){
			$inputData =Input::all();
			$userData = array(
			  'firstname' => @$inputData['firstname'],
			  'lastname'  => @$inputData['lastname'],
			  'email'  => @$inputData['email'],
			  'status'     => @$inputData['status'],
			);
			$rules = array(
				'firstname'=> 'required',
				'lastname' => 'required',
				'email'    => 'required|email|unique:users,email,'.$id.',id,status,!4',
				'status'   => 'required',
			);
			$validator = Validator::make($userData,$rules);
			if($validator->fails()){
				$errors = $validator->getMessageBag()->toArray();
				foreach($errors as $error){
					$erMsg = $error[0];
					break;
				}
				$response =array(
						  'Status' => 'danger',
						  'message' => $erMsg
						);
			}	
			else {
			$User = User::find($id);
			$User->firstname = @$inputData['firstname'];
			$User->lastname = @$inputData['lastname'];
			$User->email = @$userData['email'];
			$User->status = $userData['status'];
			//save to DB user details
			if($User->save()){ 
				$response =array(
					  'Status' => 'success',
				  'message' => 'User has been updated successfully !!'
					);
			  }
			}
		}
		return view('backend.admin.users.editUser')->with('response',$response)->with('inputData',$inputData);
	}
}
