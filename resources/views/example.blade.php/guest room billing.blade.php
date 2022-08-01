<!DOCTYPE html>
<html lang="en">
<head>
<style>

    body 
    {
        width: 50%;
        height: 100vh;
        margin: 0;
        background-color: #ffffff;
        color: #1b1b32;
        font-family: Tahoma;
        font-size: 16px;
        margin-left: 10%
    
   
    }

    h1
    {
        text-align: center;
        background-color: rgb(255, 255, 0);
    }

    label
    {
        display: block;
        margin: 0.5rem 0;
        text-align: left;
    }

    fieldset
    {
        display: block;
        width:00px; 
        -webkit-margin-start: 2px;
        -webkit-margin-end: 2px;
        -webkit-padding-before: 0.55em;
        -webkit-padding-start: 0.75em;
        -webkit-padding-end: 0.75em;
        -webkit-padding-after: 0.625em;
        -moz-border-radius:5px;  
        border-radius: 5px;  
        -webkit-border-radius: 5px;
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

    .flexContainer
    {
    display: flex;
    flex-direction: row;
    }
    input[type=number] 
    {
        -moz-appearance: textfield;
    } 
    

</style>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="styles.css" />
<title>Guest Room Billing</title>

</head>
    <body>
        <centre>
            <fieldset>
                <h1>Guest Room Billing</h1>
                    <div class="flexContainer" >
                        <fieldset>
                            <div class="left">
                                <label>Bill No. <input type="number" required> </label>
                                <label>Club <input type="text" required></label>
                                <label>Advance Ref <input type="text"></label>
                                <label>Member ID <input type="number" required></label>
                                <label>Guest Name <input type="text"></label>
                                <label>Guest Address <input type="text"></label>
                                <label>Check In Date <input type="date"> Time <input type="time"></label>
                                <label>Check Out Date <input type="date"> Time <input type="time"></label>
                                <label>Number of Rooms <input type="number"></label>
                            </div>
                    
                            <div class="right">
                                <label>Doc Date <input type="date" > </label>
                                <label>Ref Billing <input type="text" ></label>
                                <label>Short Name <input type="text"></label>
                                <label>Ref By <input type="text"></label>
                                <label>Mobile Number <input type="number" ></label>
                                <label>Phone Number <input type="number" ></label>
                                <label>CNIC <input type="number" ></label>
                                <label>Email <input type="text" ></label>
                                <label>Number of Guests <input type="number" ></label>
                                <label>Passport Number <input type="text" ></label>
                                <label>Country <input type="text" ></label>
                            </div>

                            <div class = "left">
                            <label>Remarks <textarea rows=1 cols= 130> </textarea></label>  
                            </div>
                        </fieldset>

                        <fieldset>
                            <div>
                                <label>Pay Mode <select><option value="">(select one)</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Other</option></select></label>
                                <label>Card Number <input type="text" ></label>
                                <label>Bill Value <input type="text"></label>
                                <label>Advance Rcvd <input type="text"></label>
                                <label>Discount <input type="number" ></label>
                                <label>Type <select><option value="">(select one)</option>
                                    <option value="1">Option 1</option>
                                    <option value="2">Option 2</option>
                                    <option value="3">Option 3</option>
                                    <option value="4">Other</option></select></label>
                                <label>Rem <input type="number" ></label>
                                <label>Cash Rcvd <input type="integer" ></label>
                                <label>Balance <input type="number" ></label>
                                <label>Bill <input type="number" ></label>
                            </div>
                        </fieldset >
                    </div>
            </fieldset>
        </centre>
    </body>
</html>