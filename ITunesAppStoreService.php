<?php

/**
 * Exception that is thrown by ITunesAppStoreService.
 *
 * @package default
 * @author Travis Boudreaux <tjboudreaux@gmail.com>
 */
class ITunesAppStoreService_Exception extends Exception {}

/**
 * This object will take an appId parameter, connect to the iTunes App Store
 * and retrieve data for the app like rating, number of ratings, description,
 * price, screenshots and more.
 *
 * The best use for this class is for supplimenting a one page marketing site
 * for an app with dynamic data.  When you update your app's pricing in the 
 * app store, you will no longer need to update the price on your website.
 *
 * Pull in screenshots for a slideshow, or show off your awesome user rating
 * in real time when you app hits it big.
 *
 * @author Travis Boudreaux <tjboudreaux@gmail.com>
 */
class ITunesAppStoreService 
{
    /**
     * Endpoint URL to lookup one single entity by it's id.
     *
     * @author Travis Boudreaux <tjboudreaux@gmail.com>
     */
    const ITUNES_LOOKUP_URL  = "http://ax.itunes.apple.com/WebObjects/MZStoreServices.woa/wa/wsLookup?entity=software&id=";
    
    /**
     * The appId 
     *
     * @var string
     * @author Travis Boudreaux <tjboudreaux@gmail.com>
     */
    protected $appId;
    
    public $averageRating;
    
    public $description;
    
    public $developerUrl;
    
    public $isFree; 
    
    public $iTunesWebUrl;
    
    public $largeThumbnail;
    
    public $numberOfRatings;
    
    public $numberOfRatingsForCurrentVersion;
    
    public $price;
    
    public $screenShots;
    
    public $smallThumbnail;
    
    public $version;
    
    
    /**
     * THe default constructor takes an app ID
     *
     * @param string $appId 
     * @author Travis Boudreaux <tjboudreaux@gmail.com>
     */
    public function __construct($appId)
    {
        $this->appId = $appId;
    }
    
    /**
     * Call this function to make a GET request to the iTunes App Store
     * and load the 
     *
     * @return void
     * @author Travis Boudreaux <tjboudreaux@gmail.com>
     */
    public function retrieve()
    {
        if (empty($this->appId))
        {
            throw new ITunesAppStoreService_Exception("Attempting to retrieve app data without an app ID.");
        }
        
        $requestUrl = self::ITUNES_LOOKUP_URL . $this->appId;
        
        $curl = curl_init($requestUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        curl_close($curl);

        $parsedResponse = json_decode($response, true);
        if ($parsedResponse['resultCount'] == 1)
        {
            $parsedResponse = $parsedResponse['results'][0];
    
            $this->averageRating = $parsedResponse['averageUserRating'];

            $this->description =  nl2br($parsedResponse['description']);

            $this->developerUrl = $parsedResponse['artistViewUrl'];
            
            $this->iTunesWebUrl = $parsedResponse['trackViewUrl'];
            
            $this->largeThumbnail = $parsedResponse['artworkUrl100'];

            $this->name = $parsedResponse['trackName'];

            $this->numberOfRatings = $parsedResponse['userRatingCount'];

            $this->numberOfRatingsForCurrentVersion = $parsedResponse['userRatingCountForCurrentVersion'];

            $this->price = $parsedResponse['price'];
            
            $this->isFree = $this->price == 0;

            $this->iPhoneScreenshots = $parsedResponse['screenshotUrls'];

            $this->iPadScreenshots = $parsedResponse['ipadScreenshotUrls'];

            $this->smallThumbnail = $parsedResponse['artworkUrl60'];

            $this->version = $parsedResponse['version'];            
        } else {
            throw new ITunesAppStoreService_Exception("Invalid data returned from the iTunes Web Service. Check your app ID, and verify that the iTunes is currently up.");
        }
    }
    
}