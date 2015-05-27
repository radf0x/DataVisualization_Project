<html>
    <head>
    <script type="text/javascript" src="ddjs_v7-8.js"></script>
    <script type="text/javascript" src="requiredapi.js"></script>
    <TITLE>Body Fat Calculator</TITLE>
</head>
<body>
    <form id="calc" onSubmit="su();return false;"> 
        Height: <input id="height" type=text name=height> CM <br>
        Weight: <input id="weight" type=text name=weight> KG <br> 
        Waist: <input id="waist" type=text name=waist> CM <br> 
        Hip: <input id="hip" type=text name=hip> CM <br>
        Neck: <input id="neck" type=text name=neck> CM <br>
        Gender: <input type=radio name=gender value="male">Male <input type=radio name=gender value="female">Female <br>
        <input type="submit" />
    </form> 
    
    <script type="text/javascript">
        function su(){
        ajaxt('ser_calculator.php?request=calMaleMetric',{height:objv('height'),weight:objv('weight'),waist:objv('waist'),hip:objv('hip'),neck:objv('neck')},function(msg){
        alert(msg);
        });
        }
            
    </script>
</body>
</html>
