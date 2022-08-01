<!DOCTYPE html>
<html lang="en">
<head>
<style>
    body 
    {
        width: 100%;
        height: 100vh;
        margin: 0;
        background-color: #ffffff;
        color: #1b1b32;
        font-family: Tahoma;
        font-size: 16px;   
    }

    form 
    {
        width: 75vw;
        max-width: 6000px;
        min-width: 300px;
        margin: 0 auto;
    }

    h1
    {
        text-align: center;
        background-color: rgb(85, 238, 150);
    }

    label
    {
        display: block;
        margin: 0.5rem 0;
        text-align: left;
    }

    fieldset
    {

        width:690px;  
        padding: 5px;
        /*-webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
        -moz-border-radius:5px;  
        border-radius: 5px;  
        -webkit-border-radius: 5px;
    }

    .compress
    {
        width: 75%;
    }

    .left 
    {
        float:left;
    }
    
    .right 
    {
        float: right;
    }

    .button
    {
        float: left;
    }
</style>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css" />
<title>Shift Closing</title>

</head>
    <body>
        <center>
            <fieldset>
                <h1>Shift Closing</h1>
                <fieldset >
                    <div class="left">
                        <label>Working Date. <input type="date" required> </label>
                        <label>Shop Name<input type="text" required></label>
                        <label>Till No <input type="number"></label> 
                        <label>Opening Cash <input type="text" required></label>
                        <label>Cash in Hand <input type="text"></label>
                        <label>Closing Cash <input type="text" required></label>
                        <label>Area <input type="text" required></label>
                       
                    </div>
                    
                    <div class="right">
                    <label>Shift Start Date <input type="date" required></label>
                        <label>User Id <input type="text" required></label>
                        <label>Shift <input type="text" required></label>
                        <label>Remarks <input type="text" required></label>
                        <label>Shift Close Date <input type="date" required></label>
                        <label>Difference <input type="text" required></label>   
                    </div> 

                    
                </fieldset>
                    <div class = "right">
                        
                        <input class="button" type="submit" value="EXIT" />
                        <input class="button" type="submit" value="NEW" />
                        <input class="button" type="submit" value="SAVE" />
                    
                    </div>
            </fieldset>
        </center>
    </body>
</html>