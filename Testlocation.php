<!DOCTYPE html>
<header>
  <title> Test Center Avaiablive</title>
  <link href="websitecss.css" rel="stylesheet">
</header>
<html>
<h2> Find A Test Centre </h2> <?php
include 'templates/nav.php';

?> <div id="nhsWindow" style="position: relative; max-width: 80vw; height: 600px"><iframe
    src="https://api-bridge.azurewebsites.net/conditions/?p=coronavirus-covid-19&aspect=name,overview_short,symptoms_short,symptoms_long,treatments_overview_short,other_treatments_long,self_care_long,prevention_short,causes_short&tab=3&uid=h"
    title="NHS website - health a-z"
    style="position: absolute; height: 100%; width: 100%; border: 2px solid #015eb8;"></iframe></div>

</html>