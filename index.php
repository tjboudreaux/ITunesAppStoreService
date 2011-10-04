<?php

    //The app ID for your app
    $appId = "284910350";   
    //require the library to connect to iTunes
    require_once "ITunesAppStoreService.php";
    //create a new instance of ITunesAppStoreService
    $app = new ITunesAppStoreService($appId);
    //manually call retrieve when you are ready to make the remote call to the iTunes Web Service
    try{
        $app->retrieve();
    } catch (Exception $e) {
        //the class will throw an error if you do not set the app ID in the 
        //constructor, or if the iTunes Web Service returns some invalid data.
        echo $e->getMessage();
    }    
    /***
     * Here are a list of all of the variables that you can use from your
     * app 
     *
     * $app->averageRating      //The average of all of the ratings for your app
     * $app->description        //The description you set in iTunes Connect for your app
     * $app->developerUrl       //The developer url you listed for the app in iTunes Connect
     * $app->iTunesWebUrl       //The web based version of iTunes preview URL
     * $app->largeThumbnail     //The large thumbnail you upload for your app in iTunes Connect. 512x512
     * $app->name               //The name of your app in iTunes Connect.
     * $app->numberOfRatings    //The total number of ratings for all versions of your app
     * $app->numberOfRatingsForCurrentVersion   //The total number of ratings for the current version of your app
     * $app->price              //The current price of your app
     * $app->isFree             //A boolean value to check if your app is free or paid.
     * $app->iPhoneScreenshots  //An array of urls to your iPhone screenshots.
     * $app->iPadScreenshots    //An array of urls to your iPad screenshots.
     * $app->smallThumbnail     //The small thumbnail your upload for your app in iTunes Connect.
     * $app->version            //The current version number published in the store of your app.
     ***/
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            body { padding:0; margin:0; color:#333; font-family:Georgia; background:#e5ebcb; color:#374c4c; }
            #wrapper { width:990px; height:100%; margin:0 auto; padding:10px;  }
            h1{ font-size:4.0em; color:#cc3432;}
            h2{ font-size:1.5em;}
            span {font-weight:bold; color:#262522; }
        </style>
    </head>
    <body>
        <div id="wrapper">
            <h1><img src="<?=$app->smallThumbnail?>"  /> <?=$app->name ?></h1>        
            
            <p><span>Version: </span> <?=$app->version?></p>
            <p><span>Price: </span> <? if ($app->isFree):?>Free <? else : ?> $<?=$app->price?><?endif;?></p>
            <p><span>Ratings: </span><?=$app->numberOfRatings?> rating(s) with an average of <?=$app->averageRating?> out of 5 stars</p>                    
            <h2>Description</h2>
            <div id="description"><?=$app->description ?>
        
            <h2>Screenshots</h2>
            <?foreach($app->iPhoneScreenshots as $screenshot):?>
                <img src="<?=$screenshot?>" width="180px"/>
            <?endforeach;?>
        
                
        </div>
    </body>
</html>

