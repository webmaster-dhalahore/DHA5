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
        width: 950px;  
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
<title>Advance</title>

</head>
    <body>
        <center>
            <fieldset>
                <h1>Advance</h1>
                <fieldset >
                    <div class="left">
                        <label>Doc No. <input type="number" required> </label>
                        <label>Branch <input type="text" required></label>
                        <label>Member ID <input type="text"></label>
                        <label>Guest Name <input type="text" required></label>
                        <label>Guest Address <input type="text"></label>
                        <label>From Date <input type="date"> To Date <input type="date"></label>
                        <label>No. of rooms <input type="number"> No. of days <input type="number"></label>
                        <label>No. of guests <input type="number"></label>   
                    </div>
                    
                    <div class="right">
                        <label>Doc Date <input type="date" > </label>
                        <label>Doc Type <select><option value="">(select one)</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Other</option></select>
                        Status <select><option value="">(select one)</option>
                            <option value="1">Option 1</option>
                            <option value="2">Option 2</option>
                            <option value="3">Option 3</option>
                            <option value="4">Other</option></select></label>
                        <label>Refby <input type="text" ></label>
                        <label>Mobile Number <input type="number" ></label>
                        <label>Phone Number <input type="number" ></label>
                        <label>CNIC <input type="number" ></label>
                        <label>Email <input type="text" ></label>
                        <label>PA Number <input type="number" ></label>
                        <label>PA Unit <input type="text" ></label>
                        <label>Advance <input type="number" ></label>
                    </div>

                    <div class = "left">
                    <label>Remarks <textarea rows=10 cols= 130> </textarea></label>  
                    </div>

                    
                </fieldset>
                    <div class = "left">
                        <input class="button" type="submit" value="Room Booking Details" />
                        <input class="button" type="submit" value="Advance Booking Register" />
                        <input class="button" type="submit" value="Data Wise Booking" />
                        <input class="button" type="submit" value="Checked IN" />
                    </div>

                    <div class = "right">
                        <input class="button" type="submit" value="Report" />
                        <input class="button" type="submit" value="EXIT" />
                        <input class="button" type="submit" value="NEW" />
                        <input class="button" type="submit" value="SAVE" />
                        <input class="button" type="submit" value="Booking " />
                    </div>
            </fieldset>
        </center>
    </body>
</html>