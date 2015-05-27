<?php include("ser_calculator.php"); ?>

<html>
    <head>
        <script type="text/javascript" src="ddjs_v7-8.js"></script>
        <script type="text/javascript" src="requiredapi.js"></script>
        <TITLE>Body Fat Calculator</TITLE>
        <script>
            var style = 1;
            
        </script>
    </head>
    <body>
        <form id="calc" onSubmit="su();return false;"> 
            <table>
                <tr>
                    <td>
                        Height: <input id="height" type=text name=height> 
                    </td>
                    <td>
                        <div class="heightLabel">CM</div>  
                    </td>
                </tr>
                <tr>
                    <td>
                        Weight: <input id="weight" type=text name=weight>
                    </td>
                    <td>
                        <div class="weightLabel">KG</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Waist: <input id="waist" type=text name=waist> 
                    </td>
                    <td>
                        <div class="heightLabel">CM</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Hip: <input id="hip" type=text name=hip>
                    </td>
                    <td>
                        <div class="heightLabel">CM</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Neck: <input id="neck" type=text name=neck>
                    </td>
                    <td>
                        <div class="heightLabel">CM</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Age: <input id="age" type=text name=age>
                    </td>
                    <td>
                        Years.
                    </td>
                </tr>
                <tr>
                    <td>
                        Sex: <input type=radio id="sex" name=sex value="1" onclick="getGenderValue(this.value)"> Male <input type=radio id="sex" name=sex value="2" onclick="getGenderValue(this.value)"> Female <br>
                    </td>
                </tr>
                <tr>
                    <td>
                        Measurement: <input type=radio name=measure value="1" onclick="getMeasureValue(this)" > US <input type=radio name=measure value="2" onclick="getMeasureValue(this)" checked="checked"> Metric <br>
                    </td>
                </tr>
            </table>
                Activity: 
                <select id="activity" name ="activity" onchange="getActivityValue()">
                    <option value="1">Sedentary (Little or no exercise)</option>
                    <option value="2">Lightly active (Sports 1-3 days a week)</option>
                    <option value="3">Moderately active (Sports 3-5 days a week)</option>
                    <option value="4">Very active (Sports 6-7 days a week)</option>
                    <option value="5">Extra active (Sports & physical job or twice amount of training)</option>
                </select>

            <input type="submit"/>

        </form> 

        <script type="text/javascript">
            var gender = 1;
            var activityValue = 1;
        
            function getGenderValue(value){
                gender = value;
            }
        
            function getActivityValue() {
                var input = document.getElementById("activity");
                activityValue = input.options[input.selectedIndex].value;
            }
            
            function getMeasureValue(myRadio) {
                style = myRadio.value;
            
                if (style == 1){
                    var listofUS = document.getElementsByClassName("heightLabel");
           
                    for (i=0; i < listofUS.length; i++){
                        var label = listofUS[i];
                        label.innerHTML = "inch";
                    }
                    var listofUS = document.getElementsByClassName("weightLabel");
                    for (i=0; i < listofUS.length; i++){
                        var label = listofUS[i];
                        label.innerHTML = "pounds";
                    }
               
                }else if (style == 2){
                    var listofUS = document.getElementsByClassName("heightLabel");
           
                    for (i=0; i < listofUS.length; i++){
                        var label = listofUS[i];
                        label.innerHTML = "CM";
                    }
                    var listofUS = document.getElementsByClassName("weightLabel");
                    for (i=0; i < listofUS.length; i++){
                        var label = listofUS[i];
                        label.innerHTML = "KG";
                    }
                }
            }
            
            function su(){
                    getActivityValue();
                    ajaxj('ser_calculator.php?request=chooseMeasurement',{sex:gender,measure:style, height:objv('height'),weight:objv('weight'),waist:objv('waist'),hip:objv('hip'),neck:objv('neck'), activity:activityValue},function(msg) {

                    alert(JSON.stringify(msg));
                    for(i = 0; i < msg.length; i++){
                        var table=document.createElement('table');
                        var tr=document.createElement('tr');
                        var td=document.createElement('td');
                        tr.appendChild(td);
                        table.appendChild(tr);
                        td.innerHTML=msg[i];
                        document.body.appendChild(table);
                    }
                });
                
                
            }
        </script>
    </body>
</html>
