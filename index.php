<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <style>
            /*Body*/
            body{
                background-color: #2E8B57;
            }

            /*Heading*/
            #dayDate {
                /*Dimension*/
                width: 50%;
                height: 100px;

                /*Postion*/
                position:absolute;
                left: 0px;
                top: 0px;

                /*Color*/
                background-color: #A9A9A9;

                /*Text*/
                text-align: center;
                font-size: 70px;
            }

            #userName {
                /*Dimension*/
                width: 50%;
                height: 100px;

                /*Position*/
                position: absolute;
                right: 0px;
                top: 0px;

                /*Color*/
                background-color: #A9A9A9;

                /*Text*/
                text-align: center;
                font-size: 70px;
            }

            /*Main Body*/
            #programName {
                /*Dimension*/
                width: 100%;
                height: 100px;

                /*Position*/
                position: absolute;
                top: 100px;
                left: 0%;

                /*Color*/
                background-color: #C0C0C0;

                /*Text*/
                text-align: center;
                font-size: 70px;
            }

            #xfitButton {
                /*Dimension*/
                width: 80%;
                height: 150px;

                /*Position*/
                position: absolute;
                left: 10%;
                top: 20%;

                /*Text*/
                text-align: center;
                font-size: 70px;

            }

            #strengthButton {
                /*Dimension*/
                width: 80%;
                height: 150px;

                /*Postiion*/
                position: absolute;
                left: 10%;
                top: 45%;

                /*Text*/
                text-align: center;
                font-size: 70px;

            }

            #weightLossButton {
                /*Dimension*/
                width: 80%;
                height: 150px;

                /*Postion*/
                position: absolute;
                left: 10%;
                top: 70%;

                /*Text*/
                text-align: center;
                font-size: 70px;

            }

            #backToMainBtn {
                /*Dimension*/
                width: 40%;
                height: 150px;

                /*Position*/
                position: absolute;
                right: 0%;
                bottom: 0px;

                /*Text*/
                text-align: center;
                font-size: 70px;

                /*Color*/
                background-color: #B0C4DE;
            }

            /*Workout View*/
            #workout {
                /*Dimensions*/
                width: 90%;
                height: 75%;
                overflow-y: scroll;

                /*Position*/
                position: absolute;
                top: 200px;
                left: 5%;
                z-index: 1;

                /*Coloring*/
                background-color: #F8F8FF;

                /*Text*/
                text-align: left;
                font-size: 70px;

                /*Display*/
                display: none;
            }

            button {
                background-color: #B0C4DE;
            }

            td {
                border-right-style: solid;
                font-size: 50px;
            }

            th {
                border-bottom-style: solid;
            }

        </style>

        <script type="text/javascript">
            //Giving var data a global scope
            var data;
            
            function xfitBtnPress() {
                console.log("Start xfitBtnPress");
                document.getElementById("workout").style.display = "block";
                event.stopPropagation();
                document.getElementById("programName").innerHTML = "CrossFit";
                console.log("Complete");
            }

            function strengthBtnPress() {
                console.log("Start strengthBtnPress");
                document.getElementById("workout").style.display = "block";
                event.stopPropagation();
                document.getElementById("programName").innerHTML = "Strength Training";
                console.log("Complete");
            }

            function weightLossBtnPress() {
                console.log("Start weightLossBtnPress");
                document.getElementById("workout").style.display = "block";
                event.stopPropagation();
                document.getElementById("programName").innerHTML = "Weight Loss";
                console.log("Complete");
            }

            function backToMain() {
                console.log("Start backtoMain");
                document.getElementById("workout").style.display = "none";
                document.getElementById("programName").innerHTML = "Select a Program";
                console.log("Complete");
            }

            // Any touches to the workout window need to be stopped.
            function stopProp() {
                event.stopPropagation();
            }
            
            function updateCrossfit(){
                //Spreadsheet ID for the crossfit workouts
                var spreadsheetID = "14TxdxbJzsEoaCME1AOHAwjvYtP_G69t49RpvkSvAj2g";
                
                //Complete URL for crossfit workouts
                var url = "https://spreadsheets.google.com/feeds/list/" + spreadsheetID + "/od6/public/values?alt=json";
                
                //XMLHttpRequest to get Google sheet data
                var request = new XMLHttpRequest();
                request.open('GET', url, true);
                
                request.onload = function(){
                    if (request.status >= 200 && request.status < 400) {
                        //Success
                        var crossfit = JSON.parse(request.responseText);
                        console.log("Crossfit Data");
                        console.log(crossfit);
                        console.log(crossfit["feed"]["entry"].length);
                    }
                    else{
                        //Error
                    }
                };
                
                request.onerror = function() {
                    //There was a connection error of some sort
                };
                
                request.send();
            }
            
            /* Stub for the getWorkout function
             * getWorkout(key)
             *    GET JSON array of from Google sheets
             *    EXTRACT workout info from JSON array
             *    SET workout array from extracted info
             *    RETURN workout array
             * END
            */
           
           /* How to loop through the sheets object.
            *     Workout Day       = crossfit["feed"]["entry"]["0"]["gsx$day"]["$t"]
            *     Exercise Name     = crossfit["feed"]["entry"]["0"]["gsx$exercisename"]["$t"]
            *     Exercise Sets     = crossfit["feed"]["entry"]["0"]["gsx$sets"]["$t"]
            *     Exercise Reps     = crossfit["feed"]["entry"]["0"]["gsx$reps"]["$t"]
            *     Exercise Superset = crossfit["feed"]["entry"]["0"]["gsx$superset"]["$t"]
            */
           
            function getWorkout(){
                var key = "14TxdxbJzsEoaCME1AOHAwjvYtP_G69t49RpvkSvAj2g";
                var day = "Monday";
                //Get JSON array from Google Sheets
                //Complete URL for crossfit workouts
                var url = "https://spreadsheets.google.com/feeds/list/" + key + "/od6/public/values?alt=json";
                
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                    // Action to be performed when the document is read;
                    data = JSON.parse(this.responseText);
                    }
                };
                
                xhttp.open("GET", url, true);
                xhttp.send();
                
                //Extract workout info from JSON array
                var workout = new Array;
                var exercise = new Array;
                var length = data['feed']['entry'].length;
                
                //For loop to cycle through data transfer
                for (var count = 0; count < length; count++){
                    if ((data['feed']['entry'][count]['gsx$day']['$t']) == day){
                        exercise[0] = data['feed']['entry'][count]['gsx$day']['$t'];
                        exercise[1] = data["feed"]["entry"][count]['gsx$exercisename']['$t'];
                        exercise[2] = data['feed']['entry'][count]['gsx$sets']['$t'];
                        exercise[3] = data['feed']['entry'][count]['gsx$reps']['$t'];
                        exercise[4] = data['feed']['entry'][count]['gsx$superset']['$t'];
                        
                        console.log(exercise);
                        //Here the table of the workout will be built using that is if 
                        //I can use a table to display the data.
                       
                    }
                }
            }
            
           
           /*Stub for showing the workout
            * createCrossfitWorkout(day)
            *     SET googleKey to Google Key String
            *     SET workoutObject RUN getWorkout(googleKey)
            *     FOR each key in workoutObject
            *         IF day key == day
            *         THEN 
            *             ADD element to workout table
            *         END IF
            *     LOOP
            * END
            */
           
            // Used to get the day of the week and display it in top left
            function getWeekday() {
                console.log("Start getWeekday");
                var d = new Date();
                var weekday = new Array(7);
                weekday[0] = "Sunday";
                weekday[1] = "Monday";
                weekday[2] = "Tuesday";
                weekday[3] = "Wednesday";
                weekday[4] = "Thursday";
                weekday[5] = "Friday";
                weekday[6] = "Saturday";
                var n = weekday[d.getDay()];
                document.getElementById("dayDate").innerHTML = n;
            }

        </script>

        <title>Fit4Life</title>
    </head>
    <body onload="getWeekday(), getWorkout()" ontouchstart="backToMain()">
        <!-- Used to show day of the week, the date and username -->
        <div id="dayDate">Day</div>
        <div id="userName">Fit4Life</div>

        <!-- Used to display the program once it is selected from the main screen,
        and it is hidden on load -->
        <div id="programName">Select a Program</div>

        <!-- Main screen and shows the three main options -->
        <button type="button" id="xfitButton" ontouchstart="xfitBtnPress()">Crossfit</button>
        <button type="button" id="strengthButton" ontouchstart="strengthBtnPress()">Strength</button>
        <button type="button" id="weightLossButton" ontouchstart="weightLossBtnPress()">Weight Loss</button>
        <button type="button" id="backToMainBtn" ontouchstart="backtoMain()">To Main</button>

        <!-- User's View -->
        <!-- Here is where the xfit workout will show once the user selects the xfit option
        Objective: see how to use backend programming to change between xfit, strength
        or weight loss-->
        <div id="workout" class="workout" ontouchstart = "stopProp()">
            <table style="width:100%" id="workoutTable">
                <tr>
                    <th>Exercise</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>SS</th>
                </tr>
                <!--Here is where the rest of the workout information will be loaded.-->
        </div>
    </body>
</html>
