<?php

$url = "https://offersvc.expedia.com/offers/v2/getOffers?scenario=deal-finder&page=foo&uid=foo&productType=Hotel";
// Get the entered params from the user to be passed into the API thru url
foreach ($_POST as $key => $value) {
    if (!empty($value) && $value != "submit" && $value != "reset") {
         switch ($key) {
              case "minTripStartDate": 
                    $minDate = $value;
                    break;
             case "maxTripStartDate":  
                    $maxDate = $value;
                    break;
         }
        $url = $url . "&" . $key . "=" . $value;
    }
}
// Validate min and max dates if both were entered 
if (isset($maxDate) && isset($minDate) && $minDate > $maxDate) {
   echo '<script type="text/javascript">alert("Min date could not be greater than max date"); window.location = "index.php";</script>';
} else {
   //Include classs lib
   require_once('class_lib.php');
   //Create the search instance
   $searchRes = new searchResult($url);
   //Call the method to draw the html
   $searchRes->drawOffers();
}

?>