<?php

class ProfileController extends BaseController {

	protected $user,
			  $follower;

	public function __construct(User $user,
								Follower $follower) 
	{
		$this->user = $user;
		$this->follower = $follower;
	}

	public function index() {
		
	}

	public function show($nickname) {
		// if($user = User::where('nickname', '=', $nickname)->first()) {
		// 	$user->tweets = $user->tweets()->orderBy('id', 'DESC')->get();
		// 	return View::make('profile.index', ['user' => $user]);
		// }
		// 	return Redirect::to('/');

		//Querying and orderBy is seperate
		// if ($user = User::findByNickname($nickname)) {
		// 	$user->tweets = Tweet::getByUser($user);
		// 	return View::make('profile.index', ['user' => $user]); 
		// }


		if ($user = $this->user->findByNickname($nickname, 'withTweetsOrderBy')) {

			if ($this->follower->checkByIfAlreadyFollowed($nickname, $userInfo = $user->id)) {
				$following = true;
			} else {
				$following = false;
			}

			$tweetCount = $user->tweets()->count();
		  	$followingCount = $user->following()->count(); 
		  	$followersCount = $user->followers()->count();

		  	if($imgPathProfile = $user->img_path){
			} else {
				$imgPathProfile = "default/avatar1.png";
			}
  	
			return View::make('profile.index', [
				'user' => $user, 
				'following' => $following,
				'tweetCount' => $tweetCount,
				'followingCount' => $followingCount,
				'followersCount' => $followersCount,
				'imgPathProfile' => $imgPathProfile
			]); 
		}

		// if($user = User::where('nickname', '=', $nickname)->with(array('tweets' => function($query)
		// {
		// 	$query->orderBy('id', 'DESC');
		// }))->first()) {
		// 	//return $user->tweets;
		// 	return View::make('profile.index', ['user' => $user]);
		// }
		// 	return Redirect::to('/');

	}

	public function followingIndex($nickname) {
		if ($user = $this->user->findByNickname($nickname, 'withFollowingOrderBy')) {
			
			if ($this->follower->checkByIfAlreadyFollowed($nickname, $userInfo = $user->id)) {
				$following = true;
			} else {
				$following = false;
			}

			if ($this->follower->listOftheFollowersId()) {
				$followersIdCollection = $this->follower->followersIdCollection;
			}

			if ($this->follower->listOftheFollowingId()) {
				$followingIdCollection = $this->follower->followingIdCollection;
			}

			$tweetCount = $user->tweets()->count();
		  	$followingCount = $user->following()->count(); 
		  	$followersCount = $user->followers()->count();

		  	if($imgPathProfile = $user->img_path){
			} else {
				$imgPathProfile = "default/avatar1.png";
			}

			return View::make('profile.following', [
				'user' => $user,

				'followersIdCollection' => $followersIdCollection,
				'followingIdCollection' => $followingIdCollection,
				
				'following' => $following,
				'tweetCount' => $tweetCount,
				'followingCount' => $followingCount,
				'followersCount' => $followersCount,
				'imgPathProfile' => $imgPathProfile
			]); 

		}

	}

	public function followersIndex($nickname) {
		if ($user = $this->user->findByNickname($nickname, 'withFollowersOrderBy')) {

			if ($this->follower->checkByIfAlreadyFollowed($nickname, $userInfo = $user->id)) {
				$following = true;
			} else {
				$following = false;
			}

			if ($this->follower->listOftheFollowersId()) {
				$followersIdCollection = $this->follower->followersIdCollection;
			}

			if ($this->follower->listOftheFollowingId()) {
				$followingIdCollection = $this->follower->followingIdCollection;
			}

			$tweetCount = $user->tweets()->count();
		  	$followingCount = $user->following()->count(); 
		  	$followersCount = $user->followers()->count();

		  	if($imgPathProfile = $user->img_path){
			} else {
				$imgPathProfile = "default/avatar1.png";
			}

			return View::make('profile.followers', [
				'user' => $user,
				
				'followersIdCollection' => $followersIdCollection,
				'followingIdCollection' => $followingIdCollection,

				'following' => $following,
				'tweetCount' => $tweetCount,
				'followingCount' => $followingCount,
				'followersCount' => $followersCount,
				'imgPathProfile' => $imgPathProfile
			]); 

		}
	}

}

?>