<?php

/*==========================================================================
 * Copyright (c) 2020
 * =========================================================================
 * 
 *
 * Project: Upload & Share
 * Author: Berkine 
 * Version: 1.0.0
 * 
 * 
 * =========================================================================
 */

# Core Initialization File
require_once __DIR__ . '/../core/init.core.php';

# Load the Google API PHP Client Library.
require_once __DIR__ . '/../vendor/google/autoload.php';

class GA {
	

	/**
	*
	* Creates and returns the Analytics Reporting service object
	* @return analytics object
	*
	*/
	private function initializeAnalytics() {
	  // Use the developers console and download your service account
	  // credentials in JSON format. Place them in this directory or
	  // change the key file location if necessary.
	  $KEY_FILE_LOCATION = __DIR__ . '/../core/service-account-credentials.json';

	  // Create and configure a new client object.
	  $client = new Google_Client();
	  $client->setApplicationName("Project");
	  $client->setAuthConfig($KEY_FILE_LOCATION);
	  $client->setScopes(['https://www.googleapis.com/auth/analytics.readonly']);
	  $analytics = new Google_Service_Analytics($client);

	  return $analytics;

	}


	/**
	*
	* Get the user's first view (profile) ID
	* @return profile id
	*
	*/
	private function getFirstProfileId($analytics) {
	  // Get the list of accounts for the authorized user.
	  $accounts = $analytics->management_accounts->listManagementAccounts();

	  if (count($accounts->getItems()) > 0) {
		$items = $accounts->getItems();
		$firstAccountId = $items[0]->getId();

		// Get the list of properties for the authorized user.
		$properties = $analytics->management_webproperties
			->listManagementWebproperties($firstAccountId);

		if (count($properties->getItems()) > 0) {
		  $items = $properties->getItems();
		  $firstPropertyId = $items[0]->getId();

		  // Get the list of views (profiles) for the authorized user.
		  $profiles = $analytics->management_profiles
			  ->listManagementProfiles($firstAccountId, $firstPropertyId);

		  if (count($profiles->getItems()) > 0) {
			$items = $profiles->getItems();

			// Return the first view (profile) ID.
			return $items[0]->getId();

		  } else {
			throw new Exception('No views (profiles) found for this user.');
		  }
		} else {
		  throw new Exception('No properties found for this user.');
		}
	  } else {
		throw new Exception('No accounts found for this user.');
	  }
	}
	
	
	/**
	*
	* Get the number of users and sessions for the last 2 weeks
	* @param analytics object, profile id, start date, end date
	* @return users and sessions
	*
	*/
	private function SessionsAndUsers($analytics, $profileId, $start_date, $end_date) {
		

		$optParams = array( 
			'metrics'=>'ga:users, ga:sessions',
			'dimensions'=> 'ga:date'
		);
		
		return $analytics->data_ga->get(
		   'ga:' . $profileId,
		   $start_date,
		   $end_date,
		   'ga:sessions',
		   $optParams
		);		   
	}
	

	/**
	*
	* Get the number of top browsers used for the last 2 weeks
	* @param analytics object, profile id, start date, end date
	* @return browser names and sessions for each
	*
	*/
	private function TopBrowsers($analytics, $profileId, $start_date, $end_date) {
		
		$optParams = array( 
			'dimensions' => 'ga:browser',
			'metrics' => 'ga:sessions',
			'sort' => '-ga:sessions',
			'max-results' => 5
		);
		
		return $analytics->data_ga->get(
		   'ga:' . $profileId,
		   $start_date,
		   $end_date,
		   'ga:sessions',
		   $optParams
		);
	}
	

	/**
	*
	* Get the number of top devices used for the last 2 weeks
	* @param analytics object, profile id, start date, end date
	* @return top devices and sessions for each
	*
	*/
	private function TopDevices($analytics, $profileId, $start_date, $end_date) {
		
		$optParams = array( 
			'dimensions' => 'ga:deviceCategory',
			'metrics' => 'ga:sessions',
			'sort' => '-ga:sessions',
			'max-results' => 3
		);
		
		return $analytics->data_ga->get(
		   'ga:' . $profileId,
		   $start_date,
		   $end_date,
		   'ga:sessions',
		   $optParams
		);
	}
	

	/**
	*
	* Get the number of top traffic sources for the last 2 weeks
	* @param analytics object, profile id, start date, end date
	* @return source names and sessions for each
	*
	*/
	private function TrafficSources($analytics, $profileId, $start_date, $end_date) { 
		
		$optParams = array( 
			'dimensions' => 'ga:source',
			'metrics' => 'ga:sessions',
			'sort' => '-ga:sessions',
			'max-results' => 10
		);
		
		return $analytics->data_ga->get(
		   'ga:' . $profileId,
		   $start_date,
		   $end_date,
		   'ga:sessions',
		   $optParams
		);
	}


	/**
	*
	* Get the number of top countries for the last 2 weeks
	* @param analytics object, profile id, start date, end date
	* @return country names and sessions for each
	*
	*/
	private function TopCountries($analytics, $profileId, $start_date, $end_date) {
	  	
		$optParams = array( 
			'dimensions'=>'ga:country',
			'metrics'=>'ga:sessions',
			'sort' => '-ga:sessions',
			'max-results' => 100
		);
		
		return $analytics->data_ga->get(
		   'ga:' . $profileId,
		   $start_date,
		   $end_date,
		   'ga:sessions',
		   $optParams
		);
	}
	

	/**
	*
	* Ajax handler to get the number of top browsers used for the last 2 weeks
	* @param start date, end date
	* @return busers and sessions
	*
	*/
	public function getSessionsAndUsers($start_date, $end_date) {

		$analytics = $this->initializeAnalytics();
		$profile = $this->getFirstProfileId($analytics);
		$sessions = array();

		$sessions = $this->SessionsAndUsers($analytics, $profile, $start_date, $end_date);

		return $sessions;
	}


	/**
	*
	* Ajax handler to handler to get the number of top browsers used for the last 2 weeks
	* @param start date, end date
	* @return browser names and sessions for each
	*
	*/
	public function getTopBrowsers($start_date, $end_date) {
		
		$analytics = $this->initializeAnalytics();
		$profile = $this->getFirstProfileId($analytics);
		$sessions = array();

		$sessions = $this->TopBrowsers($analytics, $profile, $start_date, $end_date);

		return $sessions;
	}
	

	/**
	*
	* Ajax handler to handler to get the number of top devices used for the last 2 weeks
	* @param start date, end date
	* @return top devices and sessions for each
	*
	*/
	public function getTopDevices($start_date, $end_date) {
		
		$analytics = $this->initializeAnalytics();
		$profile = $this->getFirstProfileId($analytics);
		$sessions = array();

		$sessions = $this->TopDevices($analytics, $profile, $start_date, $end_date);

		return $sessions;
	}
	

	/**
	*
	* Ajax handler to handler to get the number of top traffic sources for the last 2 weeks
	* @param start date, end date
	* @return source names and sessions for each
	*
	*/
	public function getTrafficSources($start_date, $end_date) {
		
		$analytics = $this->initializeAnalytics();
		$profile = $this->getFirstProfileId($analytics);
		$sessions = array();

		$sessions = $this->TrafficSources($analytics, $profile, $start_date, $end_date);

		return $sessions;
	}
	

	/**
	*
	* Ajax handler to handler get the number of top countries for the last 2 weeks
	* @param start date, end date
	* @return country names and sessions for each
	*
	*/
	public function getTopCountries($start_date, $end_date) {
		
		$analytics = $this->initializeAnalytics();
		$profile = $this->getFirstProfileId($analytics);
		$sessions = array();

		$sessions = $this->TopCountries($analytics, $profile, $start_date, $end_date);

		$db = DB::getInstance();

		$data = $db->get('configs_google', array('id', '=', 1))->first();

		return array(
					'sessions' => $sessions,
					'key' => $data->maps_key
					);
	}

}
