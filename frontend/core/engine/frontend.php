<?php

/*
 * This file is part of Fork CMS.
 *
 * For the full copyright and license information, please view the license
 * file that was distributed with this source code.
 */

/**
 * This class defines the frontend, it is the core. Everything starts here.
 * We create all needed instances.
 *
 * @author Tijs Verkoyen <tijs@sumocoders.be>
 */
class Frontend
{
	public function __construct()
	{
		$this->initializeFacebook();

		new FrontendURL();
		new FrontendTemplate();
		new FrontendPage();
	}

	/**
	 * Initialize Facebook
	 */
	private function initializeFacebook()
	{
		// get settings
		$facebookApplicationId = FrontendModel::getModuleSetting('core', 'facebook_app_id');
		$facebookApplicationSecret = FrontendModel::getModuleSetting('core', 'facebook_app_secret');

		// needed data available?
		if($facebookApplicationId != '' && $facebookApplicationSecret != '')
		{
			$config = array(
				'appId' => $facebookApplicationId,
				'secret' => $facebookApplicationSecret,
			);

			// create instance
			$facebook = new Facebook($config);

			// grab the signed request, if a user is logged in the access token will be set
			$facebook->getSignedRequest();

			// store in reference
			Spoon::set('facebook', $facebook);

			// trigger event
			FrontendModel::triggerEvent('core', 'after_facebook_initialization');
		}
	}
}
