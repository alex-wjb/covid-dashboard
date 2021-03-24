<html>
    <!-- Should display user interactive graphs/charts displaying UK covid data-->
<head>
    <?php header("Content-Type: text/html; charset=UTF-8");?>

    <!--chartJS library link-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"> </script>

    <title>Covid-19 Information Dashboard</title>
    <h1>
        Dashboard
    </h1>

    <!-- chart html elements - need new one for each chart-->
    <canvas id="engNewCasesLineChart"></canvas>
    <canvas id="engVirusTestsLineChart"></canvas>

</head>
<body>
    <script>
        //fetches JSON data from API url, parses it into an array of javascript objects and returns it.
        //asynchronous function - so runs in background 
        async function getData(api_url){
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

        //creates chart - NEED TO MAKE A NEW FUNCTION FOR EACH NEW CHART
        function makeEngNewCasesLineChart(data){
            const chart = document.getElementById('engNewCasesLineChart');

            //RETRIEVING VALUES TO POPULATE THE GRAPH WITH FROM THE ARRAY OF JAVASCRIPT OBJECTS PASSED IN
            
            //places the value of date attribute for every obj in data array into new array
            const date = data.map(obj => obj.date).reverse();
            //places the value of newCasesByPublishDate attribute for every obj in data array into new array
            const newCases = data.map(obj => obj.newCasesByPublishDate).reverse();
            //array reverse used to make dates start from earliest in dataset

            let LineChart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: date, //x axis data
                    datasets: [{
                        label: 'New Coronavirus Cases In England', //graph title
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJointStyle: 'miter',
                        data: newCases //y axis data
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
                                labelString: 'Number of New Cases' //y axis label
                            }
                        }],
                        xAxes: [{ 
                            scaleLabel: {
                                display: true,
                                labelString: 'Date' //x axis label
                            }
                        }]
                    }
                }
            })
        }

        function makeEngDailyVirusTestsChart(data){
            const chart = document.getElementById('engVirusTestsLineChart');

            //RETRIEVING VALUES TO POPULATE THE GRAPH WITH FROM THE ARRAY OF JAVASCRIPT OBJECTS PASSED IN
            
            //places the value of date attribute for every obj in data array into new array
            const date = data.map(obj => obj.date).reverse();
            //places the value of newCasesByPublishDate attribute for every obj in data array into new array
            const newVirusTests = data.map(obj => obj.newVirusTests).reverse();
            //array reverse used to make dates start from earliest in dataset

            let LineChart = new Chart(chart, {
                type: 'line',
                data: {
                    labels: date, //x axis data
                    datasets: [{
                        label: 'New virus tests In England', //graph title
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJointStyle: 'miter',
                        data: newVirusTests //y axis data
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
                                labelString: 'Number of New tests' //y axis label
                            }
                        }],
                        xAxes: [{ 
                            scaleLabel: {
                                display: true,
                                labelString: 'Date' //x axis label
                            }
                        }]
                    }
                }
            })
        }

    //CALLING FUNCTIONS TO GET DATA MAKE GRAPHS

    //waits for the javascript object array to be retrieved from the api url and passes it into the function for making a chart.
    getData('https://api.coronavirus.data.gov.uk/v1/data?filters=areaType=nation;areaName=england&structure={"date":"date","newCasesByPublishDate":"newCasesByPublishDate"}').then(data => makeEngNewCasesLineChart(data));
    
    getData('https://api.coronavirus.data.gov.uk/v1/data?filters=areaType=nation;areaName=england&structure={"date":"date","newVirusTests":"newVirusTests"}').then(data => makeEngDailyVirusTestsChart(data));;
    </script>
</body>
</html>