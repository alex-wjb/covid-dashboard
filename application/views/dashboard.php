<html>
    <!-- Should display user interactive graphs/charts displaying UK covid data-->
<head>
    <?php header("Content-Type: text/html; charset=UTF-8");?>
    <?php header("Accepts: application/json; application/xml; text/csv; application/vnd.PHE-COVID19.v1+json; application/vnd.PHE-COVID19.v1+xml");?>

    <!--chartJS library link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"> </script>

    <title>Covid-19 Information Dashboard</title>
    <h1>
        Dashboard
    </h1>

    <!-- chart html elements-->
    <canvas id="dailyNewCasesEng"></canvas>

</head>
<body>
    <script>
        /*Decided not to use the FETCH API or javascript Promises for http request
        *to allow internet explorer 11 support - for improved accessibility
        */
        function populateDailyNewCasesEngChart(resource){
            const request = new XMLHttpRequest();
            //listens for XMLHttpRequest ready state changes
            request.addEventListener('readystatechange', function() {
                //readystate 4 = XMLHttpRequest complete
                if(request.readyState === 4 && request.status === 200){
                    //parses the retrieved JSON file into an array of json objects
                    const objData = JSON.parse(request.responseText);
                    //logs the resulting js object data structure in web browser console
                    console.log(objData);

                    //access the array of objects that are contained within the 'data' array
                    covidData = objData.data;
                    //create empty associative array
                    const values ={};
                    //places the value of date attribute for every obj in covidData array into new array
                    values.date = covidData.map(function(obj){return obj.date;}).reverse();
                    //places the value of newCasesByPublishDate attribute for every obj in covidData array into new array
                    values.newCases = covidData.map(function(obj){return obj.newCasesByPublishDate;}).reverse();
                    //array reverse used to make dates start from earliest in dataset

                    makeChart(values);
                    //response code not 200 so not successful
                } else if(request.readyState === 4){
                    console.log("Unable to retrieve data");
                }
            });

            //opens an asynchronous http request(runs in background while script continues on)
            request.open('GET', resource, true);
            request.send();
        };

        function makeChart(values){
            const chart = document.getElementById('dailyNewCasesEng');
            //arrays containing axes values
            date = values.date;
            newCases = values.newCases;
            
            let LineChart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: date,
                    datasets: [{
                        label: 'New Coronavirus Cases In England',
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJointStyle: 'miter',
                        data: newCases
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                suggestedMin: 0,
                                suggestedMax: 10000
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Number of New Cases'
                            }
                        }],
                        xAxes: [{ 
                            scaleLabel: {
                                display: true,
                                labelString: 'Date'
                            }
                        }]
                    }
                }
            })
        }

    
        //calling methods to populate and display charts
        populateDailyNewCasesEngChart('https://api.coronavirus.data.gov.uk/v1/data?filters=areaType=nation;areaName=england&structure={"date":"date","newCasesByPublishDate":"newCasesByPublishDate"}');
    </script>
</body>
</html>