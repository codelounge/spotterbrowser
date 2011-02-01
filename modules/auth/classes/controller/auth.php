<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller_Website{

	function action_register()
	{	
		#If user already signed-in
		if(Auth::instance()->logged_in()!= 0){
			#redirect to the user account
                        Request::instance()->redirect('admin/');
		}
 
		if (!Kohana::config('auth.allow_registration')) {
			$content = $this->template->content = View::factory('auth/noregister');		
			return;
		}
		
		
		#Load the view
		$content = $this->template->content = View::factory('auth/register');		
 
		#If there is a post and $_POST is not empty
		if ($_POST)
		{
			#Instantiate a new user
			$user = ORM::factory('user');	
 
			#Load the validation rules, filters etc...
			$post = $user->validate_create($_POST);			
 
			#If the post data validates using the rules setup in the user model
			if ($post->check())
			{
				#Affects the sanitized vars to the user object
				$user->values($post);
 
				#create the account
				$user->save();
 
				#Add the login role to the user
				$login_role = new Model_Role(array('name' =>'login'));
				$user->add('roles',$login_role);
 
				#sign the user in
				Auth::instance()->login($post['username'], $post['password']);
 
				#redirect to the user account
				Request::instance()->redirect('account/index');
			}
			else
			{
                                #Get errors for display in view
				$content->errors = $post->errors('register');
			}			
		}		
	}
 
 
 
 
	public function action_login()
	{

		#If user already signed-in
		if (Auth::instance()->logged_in()!= 0) {
			#redirect to the user account
			Request::instance()->redirect('browser/');		
		}
 		
		$data = array();
		$data['statistics'] = array();
		
		$this->template->statistics = SB_Statistics::getStatistics();
		$content = $this->template->content = View::factory('auth/login', $data);	
 
		#If there is a post and $_POST is not empty
		if ($_POST) {
			
			#Instantiate a new user
			$user = ORM::factory('user');

			#Check Auth
			$status = $user->login($_POST);
	
			#If the post data validates using the rules setup in the user model
			if ($status) {		
				#redirect to the user account
				Request::instance()->redirect('admin');
			} else {
                #Get errors for display in view
				$content->errors = $_POST->errors('signin');
			}
		}
	}
 
 
 
 
	public function action_logout()
	{
		#Sign out the user
		Auth::instance()->logout();
 
		#redirect to the user account and then the signin page if logout worked as expected
		Request::instance()->redirect('/');		
	}
	
	public function action_invitation() {
		
		 if ($_POST) {
            if ($_POST['token'] == Security::token()) {
            	$purifier = new Purifier();
            	$invitationcode = $purifier->clean($_POST['invitationcode']);
            	
            	
            	
            }
		 }
		 Request::instance()->redirect('register');
		
	}
	
	
} // End Welcome
