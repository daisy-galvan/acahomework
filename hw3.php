<html>

    <head>
        <title>Countries on Earth</title>
    </head>

    <body>

        <h3>Countries on Earth</h3>

        <form action="<?php echo($_SERVER['PHP_SELF']); ?>" method="post">
            Enter Country Name: <input type="text" name="country_name" size="30"/>
            <input type="submit" value="Get Details"/>
        </form>

        <hr/>

        <?php

        // Check for an incoming POST request
        if ($_POST) {

            $countryName = $_POST['country_name'];
            echo 'The user entered: ' . $countryName;

            $api= "http://restcountries.eu/rest/v1/name/".$countryName;
            //$json_string= file_get_contents($api);
            $api_data= json_decode(file_get_contents($api));
            $country= $api_data[0];
            echo "<br>Country: ".$country->name;
            echo "<br>Capital: ".$country->capital;
            echo "<br>Region: ".$country->region;
            echo "<br>Population size: ".number_format($country->population);
            $lang_count= count($country->languages);
            echo "<br>Languages: ";
            for ($i=0; $i < $lang_count; $i++) { 
                echo $country->languages[$i].", ";
            } 
            echo " and that's it.";
        }
        ?>
    </body>

</html>