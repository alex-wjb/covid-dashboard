<!DOCTYPE html>

<head>
<title> Death</title>
<link href="websitecss.css" rel="stylesheet">
 <!--chartJS library link-->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"> </script>
 <meta name="viewport" content="width=device-width, initial-scale=1.0,  user-scalable=no">
</head>
<html>

<div id="siteContainer">
<h2> Total Death </h2>




<?PHP

$Date = date ("Y-m-d");
echo "<h4> Today's date is  {$Date}";

?>
<div>
<h3>Deaths Data</h3> 
<h4 id="Testlocation"> <a href="Testlocation.php">Test Center</a> </id>
<h4 id="NHSInformation"> <a href="NHSInformation.php">NHS Information</a> </id>
<h4 id="Protect"> <a href="Shopformask.php">Protect Yourself </a> </id>
<h4 id="Death"> <a href="index.php">Daily Update</a> </id>
<h4 id="COVIDInformation"> <a href="COVIDInformation.php">COVID-19 Information</a> </id>
</div>



<body>
<div class="twoGraphsContainer">

    <div class="deathGraphAndFilterContainer">
        <div class="deathFilter" >
                <!-- deaths area filter-->
                <label for="areaTypeDeaths" class="filterLabel"><b>Filter Deaths By Area</b></label>
                <form id="areaTypeDeaths" class="filterForm" autocomplete="off">
                    <div align="center">
                        <select class="areaTypeList"  id="areaTypeDeathsList" autocomplete="off" ></select>
                    </div>
                </form>
                <form id="areaNameDeaths" class="filterForm" autocomplete="off">
                    <div align="center">
                        <select  class= "areaNameList" id="areaNameDeathsList" autocomplete="off" ></select>
                    </div>
                    <div align="center">
                    <button type="button" class="resetButtonDeath" id="resetUKDeaths" >Reset To UK</button>
                    </div>
                </form> 
                <div class="latestDate" id="newDeaths28DaysByDeathDate">Last Updated: </div>
        </div>
        <div class="deathGraph" >
            <canvas class="graph" id="deathsDeathDateChart" style="width:100%"></canvas>
        </div>
    </div>

   






   

</body>

</div>


<script>
 //filters
 const areaType = [
            'Overview',
            'Nation'
        ];
        const overview = "UK";
        const nations = [
            'England',
            'Northern Ireland',
            'Scotland',
            'Wales'
        ];

        function getLastDateUpdated(data, graphMetric)
        {
           
            const date = data.map(obj => obj.date).reverse();
            console.log(date);
            latestDate = date[0];
            console.log(latestDate);

            //appends to above chart
            let latestDiv = document.getElementById(graphMetric);
            latestDiv.innerHTML="Last Updated: ";
            latestDiv.innerHTML+="<b>"+latestDate+"</b>";


        }

        //add ID in as varaible to resuse to create other forms
        function populateAreaTypeList(areaTypeListClass){
            var list = document.getElementsByClassName(areaTypeListClass); 
            for (var i = 0; i < list.length; i++) {
                    for(var j = 0; j < areaType.length; j++) {
                    var opt = areaType[j];
                    var el = document.createElement("option");
                    el.textContent = opt;
                    el.value = opt;
                    list[i].appendChild(el);
                }
            }
        }

         //add ID in as varaible to resuse to create other forms
         function populateAreaNameList(areaTypeListId, areaNameListID){
            var type = document.getElementById(areaTypeListId); 
            let aTypes = [];
            if(type.options[type.selectedIndex].value=="Nation"){
                aTypes = nations;
            }
            if(type.options[type.selectedIndex].value=="Overview"){
                aTypes = overview;
            }
            document.getElementById(areaNameListID).options.length = 0;//clears options
            var select = document.getElementById(areaNameListID); 
            if(aTypes == overview){
                var opt = aTypes;
                var el = document.createElement("option");
                el.textContent = opt;
                el.value = opt;
                select.appendChild(el);
            }
            else{
                for(var i = 0; i < aTypes.length; i++) {
                    var opt = aTypes[i];
                    var el = document.createElement("option");
                    el.textContent = opt;
                    el.value = opt;
                    select.appendChild(el);
                }
            }
        }

        //creates area type filter lists
        populateAreaTypeList("areaTypeList");

        //Deaths chart
        populateAreaNameList("areaTypeDeathsList", "areaNameDeathsList");
        filterListener("areaTypeDeathsList","areaNameDeathsList", "areaTypeDeaths","newDeaths28DaysByDeathDate", makeDeathsDeathDateChart, "resetUKDeaths" );

        function filterListener(areaTypeListId, areaNameListId, areaTypeFormID, graphMetric, graphMakerFunction, resetButtonID){
            //EVENT LISTENERS

            //listen for change in nationList selection
            document.addEventListener('DOMContentLoaded',()=>{popGraph(areaTypeListId,areaNameListId,graphMetric, graphMakerFunction);});
            document.addEventListener('DOMContentLoaded',()=>{populateAreaNameList(areaTypeListId, areaNameListId);});
    
            //reset button
            document.getElementById(resetButtonID).addEventListener("click", ()=>{resetSelection(areaTypeFormID);});
            document.getElementById(resetButtonID).addEventListener("click", ()=>{populateAreaNameList(areaTypeListId, areaNameListId);});
            document.getElementById(resetButtonID).addEventListener("click", ()=>{popGraph(areaTypeListId,areaNameListId,graphMetric,  graphMakerFunction);});

            //area type selections
            document.getElementById(areaTypeListId).addEventListener("change", ()=>{populateAreaNameList(areaTypeListId, areaNameListId);});
            document.getElementById(areaTypeListId).addEventListener("change", ()=>{popGraph(areaTypeListId,areaNameListId,graphMetric, graphMakerFunction);});
    
            //area name selections
            document.getElementById(areaNameListId).addEventListener("change", ()=>{popGraph(areaTypeListId,areaNameListId,graphMetric, graphMakerFunction);});

        }
    
       function popGraph(areaTypeListId, areaNameListID, graphMetric, graphMakerFunction)
        {
            
            
            var areaType ="";
            var areaName ="";

            var e = document.getElementById(areaTypeListId);
            var value = e.options[e.selectedIndex].value;
            var areaType = value;

            if(graphMetric == "newVirusTests" && areaType == "Nation")
            {
                if(window.virusTestsChart instanceof Chart){
                window.virusTestsChart.destroy();
            }

            var canvas = document.getElementById("virusTestsChart");
            var ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.font = "15px Arial";
            
            ctx.fillText("Data only available for the UK", 0, 20);
                
               

                return;
            }

            var e = document.getElementById(areaNameListID);
            var value = e.options[e.selectedIndex].value;
            var areaName = value;

           
            getDataNew(areaType,areaName,graphMetric).then(data => graphMakerFunction(data));
            getDataNew(areaType,areaName,graphMetric, true).then(data => getLastDateUpdated(data,graphMetric));
        
        }

        function resetSelection(areaTypeFormID){
            //reset form
           
            document.getElementById(areaTypeFormID).reset();
        }

        //fetches JSON data from API url, parses it into an array of javascript objects and returns it.
        //asynchronous function - so runs in background 
        async function getDataNew(areaType,areaName,metric, latest){
            let filters = "filters=areaType="+areaType;
            area = areaName.split(' ').join('+');
            let areaNames = ";areaName="+area;
            
            if(areaName=="UK"){
                areaNames = "";
            }

            let metrics = '&structure={"date":"date","'+metric+'":"'+metric+'"}';
            
            let api_url="";
            
            if(latest==true)
            {
                api_url = 'https://api.coronavirus.data.gov.uk/v1/data?'+filters+areaNames+metrics+"latestBy="+metric;
            }
            else
            {
                api_url = 'https://api.coronavirus.data.gov.uk/v1/data?'+filters+areaNames+metrics;
            }
            
            
            console.log(api_url);
            //fetch returns a promise object with one of 3 states - fullfiled(success - response object returned) - pending(initial state) = rejected(failed - returns error)
            //store response object returned by fetch once the promise has resolved
            const response = await fetch(api_url);
           //parses the json in the response object and returns an array of json objects upon completion
            const json = await response.json();
            const data = json.data;
           //logs the returned javascript object array in browser console so you can view it.
            console.log(data);
            return data;
        }   

        //calculates a 7 day rolling average for each datapoint using data from the prev 3 days and data from the next 3 days.
        function movingAvg(array, daysBefore, daysAfter){
            const result = [];
            for (let i = 0; i < array.length; i++){
                if(array.slice(0,i).length<=daysBefore || array.slice(0,i).length>=(array.length-daysAfter)){
                //if data from 3 days before or after current datapoint not available
                    var avg = undefined;
                    //add empty data point to average array
                    result.push(avg);
                }
                else{//calculate average
                    avgSet = array.slice(i-daysBefore,i+daysAfter+1);
                    var sum = 0;
                    for (let j = 0; j < avgSet.length; j++){
                        sum = sum + avgSet[j];
                    }
                    var avg = Math.round(sum/avgSet.length);
                    //console.log(avg);
                    result.push(avg);
                }
            }
                return result;
        }

        //extending the the chartjs line chart class to draw a vertical line cursor
        Chart.controllers.lineWithVerticalCursor = Chart.controllers.line.extend({
            draw: function() {
                Chart.controllers.line.prototype.draw.call(this);
                
                if (this.chart.tooltip._active && this.chart.tooltip._active.length) {
                    var activePoint = this.chart.tooltip._active[0];
                    ctx = this.chart.ctx;
                    x = activePoint.tooltipPosition().x;
                    topY = this.chart.scales['y-axis-0'].top;
                    bottomY = this.chart.scales['y-axis-0'].bottom;

                    // draw line
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(x, topY);
                    ctx.lineTo(x, bottomY);
                    ctx.setLineDash([5,3]);
                
                    ctx.lineWidth = 2;
                    ctx.strokeStyle = '#07C';
                    ctx.stroke();
                    ctx.restore();
                }
            }
        });
       
        //GLOBAL CHART SETTINGS
        //label settings
        Chart.defaults.global.title.display = true;
        Chart.defaults.global.title.fontSize = 20;

        Chart.defaults.global.legend.labels.fontSize = 15;
        Chart.defaults.global.legend.labels.fontSize = 15;
        Chart.defaults.scale.ticks.fontStyle="bold";
        Chart.defaults.scale.ticks.fontSize=13;
        Chart.defaults.scale.scaleLabel.display=true;
        Chart.defaults.scale.scaleLabel.fontStyle="bold";
        Chart.defaults.scale.scaleLabel.fontSize=18;

        //grid settings
        Chart.defaults.scale.gridLines.lineWidth=2;

        //tooltip settings
        Chart.defaults.global.tooltips.enabled= true;
        Chart.defaults.global.tooltips.intersect= false;
        Chart.defaults.global.tooltips.axis= 'x';
        Chart.defaults.global.tooltips.bodyFontSize= 13;
        Chart.defaults.global.tooltips.titleFontSize=18;
        
        //moving average line settings
        Chart.defaults.global.elements.line.fill = false;
        Chart.defaults.global.elements.line.borderWidth = 5;
        Chart.defaults.global.elements.point.radius = 0;
        Chart.defaults.global.elements.line.borderColor = "rgba(0,150,250,1)";
        Chart.defaults.global.elements.point.backgroundColor = "rgba(0,150,250,1)";

        //bar chart settings
        Chart.defaults.global.datasets.bar.backgroundColor = "rgba(5,200,200,1)";
        Chart.defaults.global.datasets.bar.hoverBackgroundColor ="rgba(0,150,250,1)";
        
        function makeDeathsDeathDateChart(data){
        if(window.deathsChart instanceof Chart){
                window.deathsChart.destroy();
            }
          const chart = document.getElementById('deathsDeathDateChart');

          //RETRIEVING VALUES TO POPULATE THE GRAPH WITH FROM THE ARRAY OF JAVASCRIPT OBJECTS PASSED IN
          
          //places the value of date attribute for every obj in data array into new array
          const date = data.map(obj => obj.date).reverse();
          //places the value of newCasesByPublishDate attribute for every obj in data array into new array
          const newDeaths = data.map(obj => obj.newDeaths28DaysByDeathDate).reverse();
          const sevDayAvg = movingAvg(newDeaths, 3,3);
          //array reverse used to make dates start from earliest in dataset

          window.deathsChart = new Chart(chart, {
              type: 'bar',
              data: {
                  labels: date, //x axis data
                  datasets: [{
                        type: 'lineWithVerticalCursor',
                        label: '7 Day Average',
                        data: sevDayAvg,
                        },{
                      label: 'Number of Deaths', //graph title
                      data: newDeaths //y axis data
                  }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                title:{
                        text: 'Daily Deaths Within 28 Days of Positive Test By Date of Death'
                    },
                  scales: {
                      yAxes: [{
                          scaleLabel: {
                              labelString: 'Number of Deaths' //y axis label
                          }
                      }],
                      xAxes: [{ 
                          scaleLabel: {
                              labelString: 'Date' //x axis label
                          },
                          type: 'time',
                          time:{
                              displayFormats: {
                              'day': 'DD-MMM-YY'
                              },
                              tooltipFormat: 'DD/MM/YY',
                              unit: 'day',
                              stepSize: 31
                          }
                      }]
                  }
              }
          })
      }



</script>






</html>
