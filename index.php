<html>
<head>
 <title>Search Hotels</title>
 <?php include 'main.css'; ?>
</head>
<body>
<h1 align="center" style="font-family: cursive;">Hotel Search</h1>
<div id="filtersDiv-id" class="form-style-8">
  <h2>Please fill in your booking options</h2>
  <form method="post" action="submitForm.php"> 
    <input type="text" id="destinationCity" name="destinationCity" placeholder="Destination City"/>
    <input type="text" id="minTripStartDate" name="minTripStartDate" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Min Trip Start Date"/>
    <input type="text" id="maxTripStartDate" name="maxTripStartDate" onfocus="(this.type='date')" onblur="(this.type='text')" placeholder="Max Trip Start Date"/>
    <input type="number" min="1" id="lengthOfStay" name="lengthOfStay" placeholder="Length Of Stay"/>
    <input type="number" min="1" id="minStarRating" name="maxStarRating" placeholder="Star Rating"/>
    <input type="submit" value="submit">
    <input type="reset" value="Clear">
  </form>
</div>
</body>
</html>