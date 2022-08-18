<!DOCTYPE html>
<header>
<title> Test Center Avaiablive</title>
<link href="websitecss.css" rel="stylesheet">
</header>
<html>
<h2> Find A Test Centre </h2>

<?PHP

$Date = date ("Y-m-d");
echo "<h4> Today's date is  {$Date}";

?>
<div>
<h3> Test Center</h3> 
<h4 id="Testlocation"> <a href="index.php">DailyUpdates</a> </id>
<h4 id="NHSInformation"> <a href="NHSInformation.php">NHS Information</a> </id>
<h4 id="Protect"> <a href="Shopformask.php">Protect Yourself</a> </id>
<h4 id="Death"> <a href="Death.php">Deaths Data</a> </id>
<h4 id="COVIDInformation"> <a href="COVIDInformation.php">COVID-19 Information</a> </id>
</div>


<div id="nhsWindow" style="position: relative; max-width: 80vw; height: 600px"><iframe src="https://api-bridge.azurewebsites.net/conditions/?p=coronavirus-covid-19&aspect=name,overview_short,symptoms_short,symptoms_long,treatments_overview_short,other_treatments_long,self_care_long,prevention_short,causes_short&tab=3&uid=h" title="NHS website - health a-z" style="position: absolute; height: 100%; width: 100%; border: 2px solid #015eb8;"></iframe></div>


</html>
