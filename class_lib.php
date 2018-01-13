<?php
class searchResult
{
    //API URL
    private $url;
    private $userID;
    //ARRAY TO HOLD THE RESULT
    private $offers = array();
    
    
    function __construct($url)
    {
        $curl = curl_init();
        //to get the result using exec
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($curl, CURLOPT_URL, $url);
        // Execute
        $response = curl_exec($curl);
        // Closing
        curl_close($curl);
        $jsonobj = json_decode($response, true);
        foreach ($jsonobj as $key => $val) {
            if (is_array($val)) {
                switch ($key) {
                    case "userInfo":
                        $this->userID = $val['userId'];
                        break;
                    case "offers":
                        foreach ($val['Hotel'] as $key => $val) {
                            $offer_vars                    = array();
                            //Store the result in the array 
                            $offer_vars['startDate']       = $val['offerDateRange']['travelStartDate'][0] . "-" . $val['offerDateRange']['travelStartDate'][1] . "-" . $val['offerDateRange']['travelStartDate'][2];
                            $offer_vars['endDate']         = $val['offerDateRange']['travelEndDate'][0] . "-" . $val['offerDateRange']['travelEndDate'][1] . "-" . $val['offerDateRange']['travelEndDate'][2];
                            $offer_vars['hotelName']       = $val['hotelInfo']['hotelName'];
                            $offer_vars['contry']          = $val['destination']['country'];
                            $offer_vars['city']            = $val['hotelInfo']['hotelCity'];
                            $offer_vars['lengthOfStay']    = $val['offerDateRange']['lengthOfStay'];
                            $offer_vars['hotelStarRating'] = $val['hotelInfo']['hotelStarRating'];
                            $offer_vars['numOfBokkings']   = $val['hotelUrgencyInfo']['numberOfPeopleBooked'];
                            $offer_vars['numOfLeftRooms']  = $val['hotelUrgencyInfo']['numberOfRoomsLeft'];
                            $offer_vars['pricePerNight']   = $val['hotelPricingInfo']['originalPricePerNight'];
                            $offer_vars['savingMoney']     = $val['hotelPricingInfo']['percentSavings'];
                            $offer_vars['currency']        = $val['hotelPricingInfo']['currency'];
                            $offer_vars['hotelImgURL']     = $val['hotelInfo']['hotelImageUrl'];
                            $offer_vars['hotelSiteURL']    = urldecode($val['hotelUrls']['hotelInfositeUrl']);
                            $offer_vars['searchURL']       = urldecode($val['hotelUrls']['hotelSearchResultUrl']);
                            //Creat object to hold hotle offer info
                            $currentOffer                  = new hotelOffer($offer_vars);
                            // Push the offer into the array
                            array_push($this->offers, $currentOffer);
                        }
                        break;
                }
            }
        }
    }
    //Method to draw the offer html
    function drawOffers()
    {
        if (is_array($this->offers)) {
            echo '<body bgcolor="#E6E6FA"><div><a href="index.php" >Back To Search</a></div>';
            foreach ($this->offers as $offer) {
                echo '<div align="center" style="font-family: cursive; margin-right: 25%; margin-left: 25%; width: 600px">               
                          <h2>' . $offer->get_hotelName() . ' Hotel </h2>
                          <img src="'.$offer->get_hotelImgURL().'" style="float: right" alt="Hotel Image"/>
                          <ul align="left">
                          <li>Price Per Night: ' . $offer->get_pricePerNight() . ' ' . $offer->get_currency() . '  Saving : <strong>' . $offer->get_savingMoney() . '%</strong></li>
                          <li>Location: ' . $offer->get_contry() . ' - ' . $offer->get_city() . '</li>
                          <li>Avilable from: ' . $offer->get_startDate() . '  To: ' . $offer->get_endDate() . '</li> 
                          <li>Length Of Stay: ' . $offer->get_lengthOfStay() . '</li>
                          <li>Star Rating: ' . $offer->get_hotelStarRating() . ' Stars</li>
                          <li>Current Bokkings: ' . $offer->get_numOfBokkings() . '  Avilable rooms: ' . $offer->get_numOfLeftRooms() . '</li>
                          <li><a href="' . $offer->get_hotelSiteURL() . '" target="_blank">Hotel Site Link</a></li>
                          <li><a href="' . $offer->get_searchURL() . '" target="_blank">More Info</a></li>
                          </ul>
                       </div>
                       <hr>';
            }
            if (!empty($this->offers)) {
                 echo '<div><a href="index.php" >Back To Search</a></div></body>';
            } else {
                 // No restul 
                 echo '<h2>Sorry there is no result matchs your selections right now!. Hit the link above to get back to the search page.</h2></body>';
            }
        }
    }
    function set_url($url)
    {
        $this->url = $url;
    }
    
    function get_url()
    {
        return $this->url;
    }
}
// Class to store the offer details
class hotelOffer
{
    private $startDate;
    private $endDate;
    private $hotelName;
    private $contry;
    private $city;
    private $lengthOfStay;
    private $hotelStarRating;
    private $numOfBokkings;
    private $numOfLeftRooms;
    private $pricePerNight;
    private $savingMoney;
    private $currency;
    private $hotelImgURL;
    private $hotelSiteURL;
    private $searchURL;
    
    
    
    function __construct(array $args)
    {
        $this->startDate       = $args[startDate];
        $this->endDate         = $args[endDate];
        $this->hotelName       = $args[hotelName];
        $this->contry          = $args[contry];
        $this->city            = $args[city];
        $this->lengthOfStay    = $args[lengthOfStay];
        $this->hotelStarRating = $args[hotelStarRating];
        $this->numOfBokkings   = $args[numOfBokkings];
        $this->numOfLeftRooms  = $args[numOfLeftRooms];
        $this->pricePerNight   = $args[pricePerNight];
        $this->savingMoney     = $args[savingMoney];
        $this->currency        = $args[currency];
        $this->hotelImgURL     = $args[hotelImgURL];
        $this->hotelSiteURL    = $args[hotelSiteURL];
        $this->searchURL       = $args[searchURL];
    }
    
    function set_hotelName($hotelName)
    {
        $this->hotelName = $hotelName;
    }
    //todo: Creat setter for each variable
    function get_searchURL()
    {
        return $this->searchURL;
    }
    function get_hotelSiteURL()
    {
        return $this->hotelSiteURL;
    }
    function get_hotelImgURL()
    {
        return $this->hotelImgURL;
    }
    function get_currency()
    {
        return $this->currency;
    }
    function get_savingMoney()
    {
        return $this->savingMoney;
    }
    function get_pricePerNight()
    {
        return $this->pricePerNight;
    }
    function get_numOfLeftRooms()
    {
        return $this->numOfLeftRooms;
    }
    function get_numOfBokkings()
    {
        return $this->numOfBokkings;
    }
    function get_hotelStarRating()
    {
        return $this->hotelStarRating;
    }
    function get_lengthOfStay()
    {
        return $this->lengthOfStay;
    }
    function get_hotelName()
    {
        return $this->hotelName;
    }
    
    function get_startDate()
    {
        return $this->startDate;
    }
    function get_endDate()
    {
        return $this->endDate;
    }
    function get_contry()
    {
        return $this->contry;
    }
    function get_city()
    {
        return $this->city;
    }
    
    
    
}
?>