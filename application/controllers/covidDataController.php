<?php
/*makes calls to uk government covid data API
using php CURL and manipulates returned json data to be displayed as graphs/charts in the view*/

Class covidDataController extends CI_controller
{
   
    
    public function index()
    {
        header("Content-Type: application/JSON; charset=UTF-8");
        //test url extract the number of new cases, cumulative cases, and new deaths and cumulative deaths for England in JSON format
        $url ='https://api.coronavirus.data.gov.uk/v1/data?filters=areaType=nation;areaName=england&structure={"date":"date","newCasesByPublishDate":"newCasesByPublishDate"}';

        //https://www.php.net/manual/en/book.curl.php
        //initiate CURL resource
        $ch = curl_init();

        //set CURL return type
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        
        //execute CURL request
        $response = curl_exec($ch);
        
        //if there is an error
        if($e = curl_error($ch))
        {
            echo $e;
        }
        else
        {
           // print_r(($response));
        }


        //close CURL resource
        curl_close($ch);

      
        $this->load->view('dashboard');
    }


}

?>