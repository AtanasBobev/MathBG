<?php session_start(); if(!isset($_SESSION[ "loggedin"]) || $_SESSION[ "loggedin"] !==true){ header( "location: login.php"); exit; }else{ unset($_SESSION[ "loggedin"]); } ?>
<html>

<head>
    <meta charset="utf-8">
    <script src="Scripts/jquery.min.js"></script>
    <title>Math OS</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300&display=swap" rel="stylesheet">
    <script src='Scripts/jquery.table2excel.js'></script>
    <script src="Scripts/alertify.min.js"></script>
    <link rel="stylesheet" href="Scripts/alertify.min.css" />
    <link rel="stylesheet" href="Scripts/default.min.css" />
    <script src='Scripts/jquery.highchartTable-min.js'></script>
    <script src='Scripts/highcharts.js'></script>
    <script src="Scripts/print.min.js"></script>
    <link rel="icon" href="Images/favicon.png" />

    <script>
        console.clear()

    </script>
    <div style='height:100vh;width:100vw;font-size:10vmax;z-index:9999;background-color:black;color:white;' id='overlay'>Loading... </div>

<body style='display:none;' onunload='unload();SpecialServer()' onload="load()">
    <h1 id='server'>
        <?php echo htmlspecialchars($_SESSION["data"]); ?>
    </h1>
    <div id='menu'>
        <div id='StartBackground'></div>
        <button onClick='PrepareGame()' id='StartGame'>Start</button>
        <button onClick="$('div#SettingsPanel').show();$('div#menu').hide();loadData()" id='Settings'>Settings
            <br>
            <hr>Statistics</button>
    </div>
    <div class='window' id='SettingsPanel'>
        <div class='window' id='setsDiv'>
            <div class='window' id='TextDiv'>
                <center>
                    <div class='explain'>
                        <h1>Sets</h1>
                        <br>
                        <p>Sets let you create profiles for different types of games. For example if you want to easily between two gaming profiles for your two children this menu lets ou do that. Start by going to the general setting and filling the fields. Then come here and press Load current settings. After confirming to the alert box, the current settings will be displayed in text field. You can put a title at the top. Now regardless if you change the settings you can always come back here.</p>
                    </div>
                    <br>
                    <br>
                    <br>
                    <button onClick='add()' id='new'>Add set</button>
                    <button class='downloadAll' onClick='downloadAll()'>Download all</button>
                    <div id='alltxt'></div>
                    <center>Click apply to save the current settings</center>
                    <div class="slidecontainer">
                        <input type="range" min="1" max="5" value="1" class="slider" id="myRange">
                        <br>
                        <p>Density: <span id="demo"></span></p>
                    </div>
                </center>
            </div>
        </div>
        <div class='window' id='statsDiv'>
            <center>
                <table data-graph-container-before="1" data-graph-type="column" id='StatsTable'>
                    <div style='width:85%' class='explain'>
                        <center>
                            <h1>Statistics</h1>
                            <br>
                            <p>Statistics tab lets you see the results from played games. Time/Date is the timestamp, when the game had been played. Average Time per question is the average time calculated based on all problems answered in the game. All problems count is the total number of problems. Problems left is the number of problems that had been left to be solved. Maximum and Minimum generated number are the minimum and maximum set by the basic settings. All time needed is the time needed for the whole game. Export to excel lets you export the whole table to excel.</p>
                        </center>
                    </div>
                    <br>
                    <thead>
                        <tr id='lead'>
                            <th>Time/Date</th>
                            <th>Average Time per question</th>
                            <th>All problems count</th>
                            <th>Problems left</th>
                            <th>Maximum generated Number</th>
                            <th>Minimum generated Number</th>
                            <th>All Time Needed</th>
                        </tr>
                    </thead>
                    <tbody> </tbody>
                </table>
            </center>
            <br>
            <br>
            <br>
            <button id='export'>Export to Excel</button>
            <div onClick='$("#statsDiv").hide()' id='Cancel'>Back</div>
        </div>
        <div class='window' id='help'>
          <center>
               <h1>Gettings Started</h1>
           </center>
           <b>1.</b> To set up a simple game go to the General tab.<br>
           <b>2.</b> Choose the type of problems that would be generated using buttons Addition, Subtraction, etc.<br>
           <b>3.</b> Next, choose how many problems you would want to be solved by changing All Problems Count field to the desired value. Should you want to simulate more problems than actually are going to be given, change Problems Left field; Otherwise leave blank.<br>
           <b>4.</b> Specify Min and Max generate a number. If e.g. you choose min to be 1 and max to be 3, the numbers 1,2,3 are only going to be generated. An example problem would be 2-1=; 2+2; 1-1= etc. These two values specify the range of the generated problems.<br>
           <b>5. </b> The number of elements per problem refers to the numbers used in the equation. E.g. 2 elements per problem would refer to the equation of the sort 1+1; 3 elements per problem would refer to the equation of the sort 3-2+1; 4 elements per problem would refer to the equation of the sort 1+2+3+2= etc.<br>
           <b>6.</b>  If you want to specify time per question, use the last field.<br>
           Click Apply, close the window and then press Start<br>
           <center>
               <h1>How to use the Speech tab?</h1>
           </center><br>
           In the Speech tab, you can get output and provide input for the math problems. To activate the options, click Speech I/O (input/output) in order to make it turn green. Click Speech Input option means that if you enable microphone permissions, every time a new problem is generated, you can say it out loud and the API will detect it and enter the data for you. Speech output is going to play a tone, indicating a solved problem through the current speaker/headphone configuration.
           <br><br>
           <center>
               <h1>How to use the Behavior tab?</h1>
           </center><br>
           In the behavior tab, you can specify the action in a specific situation. To change an option click the drop-down and select the option that suits you better.
           <br><br>
           <center>
               <h1>How to use the Print tab?</h1>
           </center><br>
           If you would like to print a hard or a soft copy of the problems, you can use this tab. It is very similar to the general tab. Enter the problems parameters and the number of problems in the field "All Problems". Next, click Generate. Three new buttons should appear. In case of an error, change the values. Clicking Print would open a dialog box to print the problems. If you would like to further modify the format, go to Advanced Print, where you can change the size of the text with values 1-7 with 1 the biggest and 7, the smallest. You can also print the problems' answers to the answer sheet. Use the clear button to clear the data in the preview field.
           <br><br>
           <center>
               <h1>How to use the Statistics tab?</h1>
           </center><br>
           Statistics tab lets you see the results from played games. Time/Date is the timestamp when the game had been played. Average Time per question is the average time calculated based on all problems answered in the game. All problems count is the total number of problems. Problems left is the number of problems that had been left to be solved. Maximum and Minimum generated numbers are the minimum and maximum set by the basic settings. All time needed is the time needed for the whole game. Export to excel lets you export the whole table to excel.

        </div>

        <div class='window' id='BigSpeech'>
            <center>
                <div class='explain'>
                    <h1>Speech</h1>
                    <br>
                    <br>
                    <center>
                        <div id='SpeechInfo'> When enabled, the speech I/O will speak the math problem. When the spacebar is clicked, the user will be able to speak the result. The system will automatically input it. </div>
                        <br>
                        <div style='width:65%;font-size:3vmax' class='enable' id='all' onClick='enableSpeech()'>Speech I/O</div>
                        <br>
                        <div id='AllSpeech'>
                            <div onClick='enableInput()' class='enable' id='input' onClick='enableInput()'>Allow Speech Input</div>
                            <div class='enable' onClick='enableOutput()' id='speech'>Allow Speech Output</div>
                            <div style='display:flex'>
                                <div style='flex:50%;'>Speech input lets you speak the answer to the system. You should allow microphone access.</div>
                                <div style='flex:50%;'>Speech output lets the system speak out the problem. You may consider using headphones or turning up the volume.</div>
                            </div>
                        </div>
                </div>
            </center>
            <br> </center>
        </div>
        <div id='general'>
            <div class='explain'>
                <center>
                    <h1>General settings</h1>
                    <br>
                    <p>Here you can customize the basic settings for a game. Types of problems lets you choose between four different operators. You can easily combine them by selecting multiple option. All problems count is the total number of problems and Problems left is the number of problems left to solve. For example: AllProblemsCount=15, ProblemsLeft=13. Then 2 problems will be automatically solved, the other 13 need to be solved by the player. Max generated number and Min generated number are the upper and lower limit of the generation algorithm. Time per question is the number of second 0-999s for each question.</p>
            </div>
            <fieldset>
                <legend>Types of problems</legend>
                <center>
                    <div onClick='Toggle("Addition")' id='Addition' class='button'>Addition</div>
                    <div onClick='Toggle("Subtraction")' id='Subtraction' class='button'>Subtraction</div>
                    <div onClick='Toggle("Multiplying")' id='Multiplying' class='button'>Multiplying</div>
                    <div onClick='Toggle("Division")' id='Division' class='button'>Division</div>
                </center>
            </fieldset>
            <fieldset>
                <legend>All problems count</legend>
                <input class='settings' id='AllCount' min='0' type='number'>
            </fieldset>
            <fieldset>
                <legend>Problems left</legend>
                <input class="settings" id='Solved' min='0' type='number'>
            </fieldset>
            <fieldset>
                <legend style='padding-top:5vmax'>Max generated number</legend>
                <input class="settings" id='MaxGen' min='0' type='number'>
            </fieldset>
            <fieldset id='min'>
                <legend style='padding-top:5vmax'>Min generated number</legend>
                <input class="settings" id='MinGen' min='0' type='number'>
            </fieldset>
            <fieldset>
                <legend>Number of elements for problem</legend>
                <input class='settings' id='elements' min='2' max='150' type='number'>
            </fieldset>
            <fieldset>
                <legend>Time per question</legend>
                <br>
                <center>
                    <enabled onClick='enableTime()' id='timeSwitch'>Click to turn on</enabled>
                </center>
                <input class="settings" id='timePro' min='0' max='999' type='number'>
            </fieldset>
            </center>
        </div>
        <div id='sidePanelBackground'> </div>
        <div id='sidePanel'>
            <hr>
            <br>
            <h1>
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </h1>
            <br>
            <hr>
            <br>
            <br>
            <div onClick='hide("#general");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>General</div>
            <div onClick='hide("#BigSpeech");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Speech</div>
            <div onClick='hide("#behavior");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Behavior</div>
            <div onClick='hide("#setsDiv");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Sets</div>
            <div onClick='hide("#print");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Print</div>
            <div onClick='hide("#statsDiv");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Statistics</div>
            <div onClick='$("#account").slideToggle();$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Account</div>
            <div id='account'> <a onClick='deleteData()'>Delete my data</a>
                <br> <a href='mailto:bobevatanas@gmail.com'>Contact support</a>
                <br> <a href="logout.php">Sign Out</a>
                <br> </div>
            <div onClick='hide("#moreSettings");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>More Settings</div>
            <div onClick='hide("#help");$(".item").css("border","none");$(this).css("border-left","1px solid white").css("border-right","1px solid white")' class='item'>Help & FAQ</div>

            <div href='https://www.facebook.com/Atanas.Bobev.2020/' onClick="window.open('https://www.facebook.com/Atanas.Bobev.2020/', ' _blank');" id='author'>Created by Atanas Bobev</div>
            <div id='links'>
                <div onClick='document.getElementById("SettingsPanel").style.display="none";$("div#menu").show();' id='Cancel'>x</div>
            </div>
            <div id='Save' onClick='apply()'>Apply</div>
        </div>
        <div id='print' class='window'>
            <div id='instrumentPanel'>
                <div class='height100'>
                    <div id='addition1' onClick='ChangeSpecial("addition")' class='problem'>Addition</div>
                    <div id='subtraction1' onClick='ChangeSpecial("subtraction")' class='problem'>Subtraction</div>
                </div>
                <div class='height100'>
                    <div id='multiplication1' onClick='ChangeSpecial("multiplication")' class='problem'>Multiply</div>
                    <div id='division1' onClick='ChangeSpecial("division")' class='problem'>Division</div>
                </div>
                <div class='height100'>
                    <p>Maximum gen number</p>
                    <input type='number' class='sp'>
                </div>
                <div class='height100'>
                    <p>Minimum gen number</p>
                    <input type='number' class='sp'>
                </div>
                <div class='height100'>
                    <p>Elements</p>
                    <input type='number' class='sp'>
                </div>
                <div class='height100'>
                    <p>All Problems</p>
                    <input type='number' class='sp'>
                </div>
                <div class='height100'>
                    <div onClick='RealPrintProblems()' class='problem aa'>Print</div>
                    <div onClick='AdvancedPrint()' class='problem aa'>Advanced print</div>
                </div>
                <div class='height100'>
                    <div onClick='SpecialGenerate()' class='problem aa'>Generate</div>
                    <div onClick='document.querySelector("#at").innerHTML="";document.querySelector("#col2").innerHTML="";  regulate()' class='problem aa'>Clear</div>
                </div>
            </div>
            <div id='block'>
                <div class="row">
                    <div id='col1' class="column"> </div>
                    <div id='col2' class="column"> </div>
                </div>
            </div>
        </div>
        <div id='moreSettings' class='window'>
            <center>

                <h1 style='font-size:4vmax'>Choose theme</h1>
                <div onClick='changeTheme()' id='theme'>Dark</div>
                <h1 style='font-size:4vmax'>Choose language</h1>
                <div onClick='SwitchLang()' id='language'>English</div>
            </center>
        </div>
        <div id='advancedPrint'>
            <center>
                <fieldset>
                    <legend>Custom title</legend>
                    <input placeholder="My problems" class="settings et">
                </fieldset>
                <fieldset>
                    <legend>Custom footer</legend>
                    <input placeholder="That's all folks!" class="settings et">
                </fieldset>
                <fieldset>
                    <legened>Problems size</legened>
                    <select id='ProblemsSize'>
                        <option>7</option>
                        <option>6</option>
                        <option>5</option>
                        <option>4</option>
                        <option>3</option>
                        <option>2</option>
                        <option>1</option>
                    </select>
                </fieldset>
                <fieldset>
                    <legened>Answer size</legened>
                    <select id='AnswerSize'>
                        <option>7</option>
                        <option>6</option>
                        <option>5</option>
                        <option>4</option>
                        <option>3</option>
                        <option>2</option>
                        <option>1</option>
                    </select>
                </fieldset>
                <fieldset>
                    <legened>Title size</legened>
                    <select id='TitleSize'>
                        <option>7</option>
                        <option>6</option>
                        <option>5</option>
                        <option>4</option>
                        <option>3</option>
                        <option>2</option>
                        <option>1</option>
                    </select>
                </fieldset>
                <fieldset>
                    <legened>Footer size</legened>
                    <select id='FooterSize'>
                        <option>7</option>
                        <option>6</option>
                        <option>5</option>
                        <option>4</option>
                        <option>3</option>
                        <option>2</option>
                        <option>1</option>
                    </select>
                </fieldset>
                <div onClick='PrintAnswersheet()' class='problem aa'>Print Answersheet</div>
                <div onClick='RealPrintProblems()' class='problem aa'>Print Problems</div>
            </center>
        </div>
        <div id='behavior'>
            <div class='explain'>
                <center>
                    <h1>Behavior</h1>
                </center>
            </div>
            <br>
            <br>
            <div class='explain'>
                <h2>1. When the time left for question is zero</h2>
                <br>
                <select id="timeAction">
                    <option selected="selected" value="1" selected>change problem and renew time</option>
                    <option value="2">do not change problem, renew time</option>
                    <option value="3">add one new problems, renew time</option>
                    <option value="4">add two new problems, renew time</option>
                    <option value="5">end game</option>
                </select>
                <br>
                <br>
                <h2>2. If the user reloads the page or exits</h2>
                <br>
                <select id="ExitsAction">
                    <option selected="selected" value="1" selected>continue game</option>
                    <option value="2">continue game, renew time</option>
                    <option value="3">continue game, add 1 more problem</option>
                    <option value="4">continue game, renew time and add 1 more problem</option>
                    <option value="5">Do not continue game</option>
                </select>
                <br>
                <br>
                <h2>3. When all problems are solved</h2>
                <br>
                <select id="solvedAction">
                    <option selected="selected" value="1" selected>go to menu</option>
                    <option value="2">continue game endlessly</option>
                    <option value="3">open custom link</option>
                    <br>
                    <br>
                    <center>
                        <input id='url' class='input' placeholder="Link"> </center>
                </select>
            </div>
        </div>
    </div>
    <div id='game'>
        <div id='gameBackground'></div>
        <div id='overAllBackground'></div>
        <div id='overAll'></div>
        <h1 id='rel'>...</h1>
        <h1 id='time'>...</h1>
        <div id='line1'></div>
        <div id='line2'></div>
        <div id='expression'>Loading...</div>
        <input onchange='Check()' type='number' onkeyup='Check()' min='0' placeholder='Answer' id='answer'> <img id='play' alt='Play music' onClick='ToggleMusic()' src='Images/pause.svg'> <img id='exit' alt='Exit game' src='Images/exit.svg' onClick='realFinish(false)'> <img id='fullscreenButton' alt='Toggle Fullscreen' src='Images/NotFullscreen.svg' onClick='ToggleFullscreen()'>
        <div id='TimeElapsed'>Loading...</div>
    </div>
    <div id='result1'>
        <center id='TextStartOver'>Game Over</center>
        <button onClick='$("#menu").show();$("#result1").hide()' id='StartOver'>Go to menu</button>
    </div>
    <div style='display:none' id='delete'>
        <center>
            <button onClick='deleteAllLocalData()'>Delete all local data.</button>
            <button onClick='deleteAllServerData()'>Delete all server data.</button>
            <button onClick='deleteAllLocalData();deleteAllServerData()'>Delete all data everywhere.</button>
            <br>
            <p style='color:black'> Your profile is not going to be deleted unless you send me a request to do so.</p>
            <br>
        </center>
    </div>
    <div id='so'>
        <div onclick='$("#so").hide(); $("#delete").hide();$("#advancedPrint").hide()' id='closeDiv'>x</div>
    </div>
    <div id='temp'>
        <div class="row">
            <div id='Acol1' class="column"> </div>
            <div id='Acol2' class="column"> </div>
        </div>
    </div>
    <div id='stemp'></div>
    <script>
        function SwitchLang() {
            if (currentLang == 'en') {
                changeLanguage('bg');
            } else {
                changeLanguage('en');

            }
        }
        const solvedActionLang = document.querySelector("#solvedAction");
        const ExitsActionLang = document.querySelector("#ExitsAction");
        const TimeActionLand = document.getElementById("timeAction");

        var currentLang = 'en';
        const changeLanguage = (to) => {
            if (to == 'bg') {
                try {
                  if(currentTheme=='dark'){
document.querySelector("#theme").innerText='Тъмна';
}else{
  document.querySelector("#theme").innerText='Светла';
}
$("#help").html(`<center> <h1>Стартиране</h1> </center> <b>1.</b> За да започнеш анстройките преди играта, натисни меню Общи<br> <b>2.</b>Избери кои видове задачи да бъдат дадени с бутоните Събиране, Изваждане, Умножение и Деление.<br> <b>3.</b> След това избери колко задачи искаш да дадеш като промениш Брой задачи. Ако искаш да симулираш сякаш няколко задачи са решени, избери, Увеличи броя на всички задачи над броя останали задачи; или се увери, че полето за Останали Задачи е равно на полето за всички задачи<br> <b>4.</b>Специфицирай минимално и максимално число за генериране в задачата с поелто Минимално и Максимално. Ако избереш минимално число 1 и максимално 3, можеш да очакваш задачи от типа 3+1; 2+1; 1+2 и т.н., със съответните знаци..<br> <b>5. </b> Брой елементи на задача са всъщност брой събираеми, делители и т.н. Ако избереш 3 елемента на задача, възможен резултат е 2+3+1; 1-1+0=; 2+2+6= и т.н..<br> 6. Ако искаш да специфицираш времето на всеки един въпрос в секунди използвай последното поле.<br> Натисни приложи, след това затвори менюто с настройки със съседния бутон и натисни старт.<br> <center> <h1>Как се използва менюто за звук?</h1> </center><br> В менюто за звук може да след избиране на опция Говор вход да изговаряте отговор на задачата на английски(изисква включен микрофон и позволение). В менюто Говор изход може да чувате задачата изговорена на английски и звук ако е решена вярно. <br><br> <center> <h1>Как да използваме менюто за Поведение??</h1> </center><br> В менюто за поведение, може да изберете какво да се направи в някои специфични ситуации. <br><br> <center> <h1>Как да използваме менюто за принтиране??</h1> </center><br> Менюто за принитране е със симетрични контроли на менюто Общи. Изберете брой задачи, вид задачи, брой елементи и натиснете генериране, ако не сте доволни от резултата може да натиснете изчистване. Можете да използвате Опции за Принтиране, за да зададете заглавие или размер на на текстовете. Оттам може да изпринтите отговорите, задачите или и двете заедно. <br><br> <center> <h1>Как да използваме менюто за статистика?</h1> </center><br> Табът за статистика ти позволява да видиш резултати от вече изиграните игри. Време/Дата показва кога играта е свършила. Средно време на въпрос изчислява средно аритметично колко време е отнело за решаването на задачите. Всички задачи кореспондират със зададеното в менюто време. Останали задачи кореспондира с дадения брой в менюто. Максимално и минимално генерирано число дават опция да се видят параметрите на всяка една игра. Време е цялото време нужно за изчисляване на задачите. Експортиране към Excel служи за изтегляне на файла във формат на таблица.(Преди експортиране езикът трябва да бъде настроен на английски`);
               $('#url:text').attr('placeholder', 'Линк');
                    solvedActionLang.options[0].text = "Към менюто";
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(1) > legend").innerText='Заглавие';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(2) > legend").innerText='Текст за край';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(3) > legened").innerText='Размер на задачите';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(4) > legened").innerText='Размер на заглавието';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(6) > legened").innerText='Размер на крайния текст';
document.querySelector("#advancedPrint > center > div:nth-child(7)").innerText='Изпринти листа с отгворотие';
document.querySelector("#advancedPrint > center > div:nth-child(8)").innerText='Изпринти задачите';
                    document.querySelector("#instrumentPanel > div:nth-child(6) > p").innerText='Всички задачи'
                    document.querySelector("#AllSpeech > div:nth-child(3) > div:nth-child(2)").innerText='Говор изход дава възможност на системата да изговори задачата на английски.';
                    solvedActionLang.options[1].text = "Продължи играта безкрайно";
                    solvedActionLang.options[2].text = "Отвори линк";
                    ExitsActionLang.options[0].text = "Продължи играта";
                    ExitsActionLang.options[1].text = "Продължи играта, презареди времето";
                    ExitsActionLang.options[2].text = "Продължи играта, добави още една задача";
                    ExitsActionLang.options[3].text = "Продължи играта, презареди времето, добави още една задача";
                    ExitsActionLang.options[4].text = "Не продължавай играта";
                    TimeActionLand.options[0].text = "Промени задачата и презареди времето";
                    TimeActionLand.options[1].text = "Не променяй задачата, презарди времето";
                    TimeActionLand.options[2].text = "Добави още една задача, презарди времето";
                    TimeActionLand.options[3].text = "Добави две нови задачи, презареди времето";
                    TimeActionLand.options[4].text = "Не продължавай играта";
                    document.querySelector("#AllSpeech > div:nth-child(3) > div:nth-child(1)").innerText = 'Говор вход дава възможност на потребителя да изговори  отговора на задачата на глас. За да използвате тази функция трябва да дадете достъп до миктрофона Ви. Отговорите се приемат само на английски.'
                    document.querySelector("#sidePanel > div:nth-child(8)").innerText = 'Общи';
                    document.querySelector("#sidePanel > div:nth-child(9)").innerText = 'Звук';
                    document.querySelector("#sidePanel > div:nth-child(10)").innerText = 'Поведение'
                    document.querySelector("#sidePanel > div:nth-child(11)").innerText = 'Сетове';
                    document.querySelector("#sidePanel > div:nth-child(12)").innerText = 'Принтиране';
                    document.querySelector("#general > fieldset:nth-child(2) > legend").innerText = 'Видове задачи';
                    document.querySelector("#Addition").innerText = 'Събиране';
                    document.querySelector("#Subtraction").innerText = 'Изваждане';
                    document.querySelector("#Multiplying").innerText = 'Умножение';
                    document.querySelector("#general > fieldset:nth-child(3) > legend").innerText = 'Брой задачи';
                    document.querySelector("#general > fieldset:nth-child(4) > legend").innerText = 'Останали задачи';
                    document.querySelector("#general > fieldset:nth-child(7) > legend").innerText = 'Брой елементи на задача';
                    document.querySelector("#general > fieldset:nth-child(8) > legend").innerText = 'Таймер на задача';
                    document.querySelector("#BigSpeech > center > div > h1").innerText = 'Говор и Звук'
                    document.querySelector("#all").innerText = 'Звук';
                    document.querySelector("#input").innerText = 'Говор вход';
                    document.querySelector("#speech").innerText = 'Говор изход'
                    document.querySelector("#behavior > div:nth-child(1) > center > h1").innerText = 'Поведение';
                    document.querySelector("#behavior > div:nth-child(4) > h2:nth-child(1)").innerText = '1. Когато времето свърши';
                    document.querySelector("#behavior > div:nth-child(4) > h2:nth-child(6)").innerText = '2. Ако потребителят презареди страницата';
                    document.querySelector("#behavior > div:nth-child(4) > h2:nth-child(11)").innerText = '3. Когато всички задачи са решени';
                    document.querySelector("#TextDiv > center > div.explain > h1").innerText = 'Сетове'
                    document.querySelector("#TextDiv > center > div.explain > p").innerText = 'Сетовете ти позволяват да автоматизираш конкретни действия. Пример: Можеш да сменяш настройките за двете си деца в зависимост от времето или денят от седмицата. За да заредиш настройките натисни "Зареди настройки" и потвърди текстовия прозорец. За да зададеш време, натисни програма и избери опцията, която работи най-добре за теб.'
                    document.querySelector("#new").innerText = 'Добави';
                    document.querySelector("#TextDiv > center > button.downloadAll").innerText = 'Изтегли всички';
                    document.querySelector("#addition1").innerText = 'Събиране';
                    document.querySelector("#subtraction1").innerText = 'Изваждане';
                    document.querySelector("#lead > th:nth-child(3)").innerText = 'Всички задачи';
                    document.querySelector("#instrumentPanel > div:nth-child(3) > p").innerText = 'Максимално генерирано число';
                    document.querySelector("#instrumentPanel > div:nth-child(4) > p").innerText = 'Минимално генерирано число';
                    document.querySelector("#instrumentPanel > div:nth-child(5) > p").innerText = 'Брой елементи';
                    document.querySelector("#instrumentPanel > div:nth-child(6) > p").innerTetx = 'Брой задачи';
                    document.querySelector("#instrumentPanel > div:nth-child(8) > div:nth-child(1)").innerText = 'Генериране';
                    document.querySelector("#instrumentPanel > div:nth-child(7) > div:nth-child(1)").innerText = 'Принтиране';
                    document.querySelector("#instrumentPanel > div:nth-child(7) > div:nth-child(2)").innerText = 'Опции за принтиране';
                    document.querySelector("#instrumentPanel > div:nth-child(8) > div:nth-child(2)").innerText = 'Изчистване';
                    document.querySelector("#sidePanel > div:nth-child(13)").innerText = 'Статистика';
                    document.querySelector("#statsDiv > center > div.explain > center > h1").innerText = 'Статистика';
                    document.querySelector("#statsDiv > center > div.explain > center > p").innerText = 'Табът за статистика ти позволява да видиш резултати от  вече изиграните игри. Време/Дата показва кога играта е свършила. Средно време на въпрос изчислява средно аритметично колко време е отнело за решаването на задачите. Всички задачи кореспондират със зададеното в менюто време. Остнали задачи кореспондира с дадения брой в менюто. Максимално и минимално генерирано число дават опция да се видят параметрите на всяка една игра. Време е цялото време нужно за изчлисляване на задачите. Експортиране към Excel служи за изтеляне на файла във формат на таблица.(Преди експортиране езикът трябва да бдъе настроен на английски)';
                    document.querySelector("#export").innerText = 'Експортиране към Ексел';
                    document.querySelector("#lead > th:nth-child(2)").innerText = 'Средно време на въпрос';
                    document.querySelector("#lead > th:nth-child(4)").innerText = 'Останали задачи';
                    document.querySelector("#lead > th:nth-child(5)").innerText = 'Максимално генерирано число';
                    document.querySelector("#lead > th:nth-child(6)").innerText = 'Минимално генерирано число';
                    document.querySelector("#lead > th:nth-child(7)").innerText = 'Време';
                    document.querySelector("#lead > th:nth-child(1)").innerText = 'Време/Дата';
                    document.querySelector("#sidePanel > div:nth-child(14)").innerText = 'Акаунт';
                    document.querySelector("#account > a:nth-child(1)").innerText = 'Изтрий данни';
                    document.querySelector("#account > a:nth-child(3)").innerText = 'Контакти';
                    document.querySelector("#account > a:nth-child(5)").innerText = 'Излизане';
                    document.querySelector("#sidePanel > div:nth-child(16)").innerText = 'Още настройки';
                    document.querySelector("#sidePanel > div:nth-child(17)").innerText = 'Помощ';
                    document.querySelector("#moreSettings > center > h1:nth-child(1)").innerText = 'Тема';
                    document.querySelector("#moreSettings > center > h1:nth-child(3)").innerText = 'Избери език';
                    document.querySelector("#author").innerText = 'Създадено от Атанас Бобев';
                    document.querySelector("#Save").innerText = 'Приложи'
                    document.querySelector("#division1").innerText = 'Деление';
                    document.querySelector("#multiplication1").innerText = 'Умножение';
                    document.querySelector("#Division").innerText = 'Деление';
                    document.querySelector("#StartGame").innerText = 'Старт';
                    document.querySelector("#Settings").innerHTML = 'Настройки<br><hr>Статистика';
                    document.querySelector("#TextStartOver").innerText = 'Край на играта';
                    document.querySelector("#StartOver").innerText = 'Към менюто';
                    document.querySelector("#min > legend").innerText = 'Минимално генерирано число';
                    document.querySelector("#language").innerText = 'Български';
                    document.querySelector("#SpeechInfo").innerText = 'Когато функцията бъде включена, системата ще изговаря задачите. Когато спейсът е натиснат, потебителят ще може да каже отговора на задачата на английски и системата ще го въведе автоматично.';
                    document.querySelector("#TextDiv > center > center").innerText = 'Натисно приложеи, за да запазиш сегашните сетове';
                    document.querySelector("#general > fieldset:nth-child(5) > legend").innerText = 'Максимално генерирано число';
                    document.querySelector('#general > div > center > p').innerText = 'Тук можеш да промениш основните настройки. Видове задачи ти дава опцията да избереш имежду четири различни вида оператора. Можеш да ги комбинираш като избереш повече опции. Пример: Брой задачи=15, Останали задачи=13. При такъв избор, 2 задачи ще бъдат решени, а останалите 13 ще бъдат оставени за играча. Максималното генерирано число и миниалното генерирато са долният и горният лимит на алгоритъма. Времето на всеки въпрос може да бъде между 0-999 секунди.';
                    document.querySelector("#sidePanel > div:nth-child(12)").innerText = 'Принтиране';
                    document.querySelector("#general > div > center > h1").innerText = 'Общи настройки';
                    currentLang = 'bg';

                } catch (err) {
                    alertify.alert('Грешка при промяната на езика', 'Беше забелязана грешка в опита за промяна на езика. Код на грешката(' + err + ")" + " Пробвайте отново по-късно!");
                }

            } else {
                try {
                  if(currentTheme=='dark'){
document.querySelector("#theme").innerText='Dark';
}else{
  document.querySelector("#theme").innerText='White';
}
$("#help").html(`<center> <h1>Gettings Started</h1> </center> <b>1.</b> To set up a simple game go to the General tab.<br> <b>2.</b> Choose the type of problems that would be generated using buttons Addition, Subtraction, etc.<br> <b>3.</b> Next, choose how many problems you would want to be solved by changing All Problems Count field to the desired value. Should you want to simulate more problems than actually are going to be given, change Problems Left field; Otherwise leave blank.<br> <b>4.</b> Specify Min and Max generate a number. If e.g. you choose min to be 1 and max to be 3, the numbers 1,2,3 are only going to be generated. An example problem would be 2-1=; 2+2; 1-1= etc. These two values specify the range of the generated problems.<br> <b>5. </b> The number of elements per problem refers to the numbers used in the equation. E.g. 2 elements per problem would refer to the equation of the sort 1+1; 3 elements per problem would refer to the equation of the sort 3-2+1; 4 elements per problem would refer to the equation of the sort 1+2+3+2= etc.<br> <b>6.</b> If you want to specify time per question, use the last field.<br> Click Apply, close the window and then press Start<br> <center> <h1>How to use the Speech tab?</h1> </center><br> In the Speech tab, you can get output and provide input for the math problems. To activate the options, click Speech I/O (input/output) in order to make it turn green. Click Speech Input option means that if you enable microphone permissions, every time a new problem is generated, you can say it out loud and the API will detect it and enter the data for you. Speech output is going to play a tone, indicating a solved problem through the current speaker/headphone configuration. <br><br> <center> <h1>How to use the Behavior tab?</h1> </center><br> In the behavior tab, you can specify the action in a specific situation. To change an option click the drop-down and select the option that suits you better. <br><br> <center> <h1>How to use the Print tab?</h1> </center><br> If you would like to print a hard or a soft copy of the problems, you can use this tab. It is very similar to the general tab. Enter the problems parameters and the number of problems in the field "All Problems". Next, click Generate. Three new buttons should appear. In case of an error, change the values. Clicking Print would open a dialog box to print the problems. If you would like to further modify the format, go to Advanced Print, where you can change the size of the text with values 1-7 with 1 the biggest and 7, the smallest. You can also print the problems' answers to the answer sheet. Use the clear button to clear the data in the preview field. <br><br> <center> <h1>How to use the Statistics tab?</h1> </center><br> Statistics tab lets you see the results from played games. Time/Date is the timestamp when the game had been played. Average Time per question is the average time calculated based on all problems answered in the game. All problems count is the total number of problems. Problems left is the number of problems that had been left to be solved. Maximum and Minimum generated numbers are the minimum and maximum set by the basic settings. All time needed is the time needed for the whole game. Export to excel lets you export the whole table to excel. </div>`);
$('#url:text').attr('placeholder', 'Линк');
document.querySelector("#AllSpeech > div:nth-child(3) > div:nth-child(2)").innerText='Speech output lets the system speak out the problem. You may consider using headphones or turning up the volume.';
document.querySelector("#instrumentPanel > div:nth-child(6) > p").innerText='All problems'
                    $('#url:text').attr('placeholder', 'Link');
                    document.querySelector("#advancedPrint > center > div:nth-child(7)").innerText='Print answersheet';
                    document.querySelector("#advancedPrint > center > div:nth-child(8)").innerText='Print problems.';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(1) > legend").innerText='Custom title';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(2) > legend").innerText='Custom footer';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(3) > legened").innerText='Problem size';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(4) > legened").innerText='Title size';
                    document.querySelector("#advancedPrint > center > fieldset:nth-child(6) > legened").innerText='Footer size';
                    solvedActionLang.options[0].text = "Go to Menu";
                    solvedActionLang.options[1].text = "Continue game endlessly";
                    solvedActionLang.options[2].text = "Open custom link";
                    ExitsActionLang.options[0].text = "Continue game";
                    ExitsActionLang.options[1].text = "Continue game, renew time";
                    ExitsActionLang.options[2].text = "Continue game, add one more problem";
                    ExitsActionLang.options[3].text = "Continue game, add one more problem, renew time";
                    ExitsActionLang.options[4].text = "Do not continue the game";
                    TimeActionLand.options[0].text = "Change the problem and renew the time";
                    TimeActionLand.options[1].text = "Do not change the problem, renew time";
                    TimeActionLand.options[2].text = "Add one more problem, renew time";
                    TimeActionLand.options[3].text = "Add two new problems, renew time";
                    TimeActionLand.options[4].text = "Do not continue the game";
                    document.querySelector("#sidePanel > div:nth-child(8)").innerText = 'General';
                    document.querySelector("#sidePanel > div:nth-child(9)").innerText = 'Speech';
                    document.querySelector("#sidePanel > div:nth-child(10)").innerText = 'Behavior'
                    document.querySelector("#sidePanel > div:nth-child(11)").innerText = 'Sets';
                    document.querySelector("#sidePanel > div:nth-child(12)").innerText = 'Print';
                    document.querySelector("#general > fieldset:nth-child(2) > legend").innerText = 'Types of Problems';
                    document.querySelector("#Addition").innerText = 'Addition';
                    document.querySelector("#Subtraction").innerText = 'Substraction';
                    document.querySelector("#Multiplying").innerText = 'Multiplying';
                    document.querySelector("#general > fieldset:nth-child(3) > legend").innerText = 'All problems count';
                    document.querySelector("#general > fieldset:nth-child(4) > legend").innerText = 'Problems left';
                    document.querySelector("#general > fieldset:nth-child(7) > legend").innerText = 'Number of elements for problem';
                    document.querySelector("#general > fieldset:nth-child(8) > legend").innerText = 'Time per question';
                    document.querySelector("#BigSpeech > center > div > h1").innerText = 'Speech'
                    document.querySelector("#all").innerText = 'Speech I/O';
                    document.querySelector("#input").innerText = 'Allow Speech Input';
                    document.querySelector("#speech").innerText = 'Allow Speech Output'
                    document.querySelector("#behavior > div:nth-child(1) > center > h1").innerText = 'Behavior';
                    document.querySelector("#behavior > div:nth-child(4) > h2:nth-child(1)").innerText = '1. When the time left for question is zero';
                    document.querySelector("#behavior > div:nth-child(4) > h2:nth-child(6)").innerText = '2. If the user reloads the page or exits';
                    document.querySelector("#behavior > div:nth-child(4) > h2:nth-child(11)").innerText = '3. When all problems are solved';
                    document.querySelector("#TextDiv > center > div.explain > h1").innerText = 'Sets'
                    document.querySelector("#TextDiv > center > div.explain > p").innerText = 'Sets let you create profiles for different types of games. For example if you want to easily between two gaming profiles for your two children this menu lets ou do that. Start by going to the general setting and filling the fields. Then come here and press Load current settings. After confirming to the alert box, the current settings will be displayed in text field. You can put a title at the top. Now regardless if you change the settings you can always come back here.';
                    document.querySelector("#new").innerText = 'Add set';
                    document.querySelector("#TextDiv > center > button.downloadAll").innerText = 'Download All';
                    document.querySelector("#addition1").innerText = 'Addition';
                    document.querySelector("#subtraction1").innerText = 'Substraction';
                    document.querySelector("#lead > th:nth-child(3)").innerText = 'All Problems';
                    document.querySelector("#instrumentPanel > div:nth-child(3) > p").innerText = 'Maximum gen number';
                    document.querySelector("#instrumentPanel > div:nth-child(4) > p").innerText = 'Minimum gen number';
                    document.querySelector("#instrumentPanel > div:nth-child(5) > p").innerText = 'Elements';
                    document.querySelector("#instrumentPanel > div:nth-child(6) > p").innerTetx = 'All Problems';
                    document.querySelector("#instrumentPanel > div:nth-child(8) > div:nth-child(1)").innerText = 'Generate';
                    document.querySelector("#instrumentPanel > div:nth-child(7) > div:nth-child(1)").innerText = 'Print';
                    document.querySelector("#instrumentPanel > div:nth-child(7) > div:nth-child(2)").innerText = 'Advanced print';
                    document.querySelector("#instrumentPanel > div:nth-child(8) > div:nth-child(2)").innerText = 'Clear';
                    document.querySelector("#sidePanel > div:nth-child(13)").innerText = 'Statistics';
                    document.querySelector("#statsDiv > center > div.explain > center > h1").innerText = 'Statistics';
                    document.querySelector("#statsDiv > center > div.explain > center > p").innerText = 'Statistics tab lets you see the results from played games. Time/Date is the timestamp, when the game had been played. Average Time per question is the average time calculated based on all problems answered in the game. All problems count is the total number of problems. Problems left is the number of problems that had been left to be solved. Maximum and Minimum generated number are the minimum and maximum set by the basic settings. All time needed is the time needed for the whole game. Export to excel lets you export the whole table to excel.';
                    document.querySelector("#export").innerText = 'Export to Excel';
                    document.querySelector("#lead > th:nth-child(2)").innerText = 'Average time per question.';
                    document.querySelector("#lead > th:nth-child(4)").innerText = 'Problems лeft';
                    document.querySelector("#lead > th:nth-child(5)").innerText = 'Maximum gen number';
                    document.querySelector("#lead > th:nth-child(6)").innerText = 'Minimum gen number';
                    document.querySelector("#lead > th:nth-child(7)").innerText = 'Time';
                    document.querySelector("#lead > th:nth-child(1)").innerText = 'Time/Date';
                    document.querySelector("#sidePanel > div:nth-child(14)").innerText = 'Account';
                    document.querySelector("#account > a:nth-child(1)").innerText = 'Delete my data';
                    document.querySelector("#account > a:nth-child(3)").innerText = 'Contacts Support';
                    document.querySelector("#account > a:nth-child(5)").innerText = 'Sign out';
                    document.querySelector("#sidePanel > div:nth-child(16)").innerText = 'More Settings';
                    document.querySelector("#sidePanel > div:nth-child(17)").innerText = 'Help & FAQ';
                    document.querySelector("#moreSettings > center > h1:nth-child(1)").innerText = 'Тема';
                    document.querySelector("#moreSettings > center > h1:nth-child(3)").innerText = 'Choose a language';
                    document.querySelector("#author").innerText = 'Created by Atanas Bobev';
                    document.querySelector("#Save").innerText = 'Apply'
                    document.querySelector("#division1").innerText = 'Division';
                    document.querySelector("#multiplication1").innerText = 'Multiplying';
                    document.querySelector("#Division").innerText = 'Division';
                    document.querySelector("#StartGame").innerText = 'Start';
                    document.querySelector("#Settings").innerHTML = 'Settings<br><hr>Statistics';
                    document.querySelector("#TextStartOver").innerText = 'Game Over';
                    document.querySelector("#StartOver").innerText = 'Go to menu';
                    document.querySelector("#min > legend").innerText = 'Minimum generated number';
                    document.querySelector("#SpeechInfo").innerText = 'When enabled, the speech I/O will speak the math problem. When the spacebar is clicked, the user will be able to speak the result. The system will automatically input it.';
                    document.querySelector("#TextDiv > center > center").innerText = 'Click apply to save the current settings';
                    document.querySelector("#general > fieldset:nth-child(5) > legend").innerText = 'Maximum generated numebr';
                    document.querySelector('#general > div > center > p').innerText = 'Here you can customize the basic settings for a game. Types of problems lets you choose between four different operators. You can easily combine them by selecting multiple option. All problems count is the total number of problems and Problems left is the number of problems left to solve. For example: AllProblemsCount=15, ProblemsLeft=13. Then 2 problems will be automatically solved, the other 13 need to be solved by the player. Max generated number and Min generated number are the upper and lower limit of the generation algorithm. Time per question is the number of second 0-999 for each question.';
                    document.querySelector("#sidePanel > div:nth-child(12)").innerText = 'Print';
                    document.querySelector("#general > div > center > h1").innerText = 'General Settings';
                    currentLang = 'en';
                    document.querySelector("#language").innerText = 'English';
                    document.querySelector("#moreSettings > center > h1:nth-child(1)").innerText = 'Choose a language';

                } catch (err) {
                    alertify.alert('Error in changing langauge', 'We have encountered an internal error trying to change the language. Error code(' + err + ")" + " Try again later!");
                }

            }
        }
        const myConfirmation = () => {
            apply();
            return 'You have to press the apply button in order to save the content! Are you sure you want to quit?';
        }

        window.onbeforeunload = myConfirmation;
        var currentTheme = 'dark';
        const changeTheme = () => {
            if (currentTheme === 'dark') {
              if(currentLang=='en'){
                document.querySelector("#theme").innerText = 'White';
              }else{
                document.querySelector("#theme").innerText = 'Светла';
              }
              document.querySelector("#help").style.color='black';
                $('#sidePanelBackground').css("background-image", "url(WhiteDashboard.jpg)");
                $('.window').css("background-color", "#F8F8F8");
                $('#moreSettings > center > h1').css("color", "black");
                $('div.explain').css("color", "black");
                $('div.explain').css("background-color", "white");
                $('div#instrumentPanel').css("background-color", "white");
                $('div#instrumentPanel p').css("color", "black");
                $('#block').css("background-color", "white");
                $('#block').css("color", "black");
                $('div#alltxt > div').css("background-color", "white");
                $('div#alltxt > div > textarea').css("background-color", "white");
                $('div#alltxt > div > textarea').css("color", "black");
                $('div#alltxt > div > input').css("background-color", "white");
                $('div#alltxt > div > input').css("color", "black");
                $('.f').css("background-color", "white");
                $('.f').css("color", "black");
                $('select').css("background", "white");
                $('select').css("color", "black");
                $('fieldset').css("background-color", "white");
                $('#theme').css("background-color", "black");
                $('#theme').css("color", "white");
                $('#language').css("background-color", "black");
                $('#language').css("color", "white");
                $('fieldset').css("color", "black");
                $('fieldset>input').css("background-color", "white");
                $('fieldset>input').css("color", "black");
                $('fieldset>input').css("border-bottom", "1px solid black");
                $('button#new').css("background-color", "white");
                $('button#new').css("color", "black");
                $('button#export').css("background-color", "white");
                $('button#export').css("color", "black");
                $('button.downloadAll').css("background-color", "white");
                $('button.downloadAll').css("color", "black");
                $('th').css("background-color", "white");
                $('th').css("color", "black");
                $('.aa').css("background-color", "white");
                $('.aa').css("color", "black");
                $('.aa').css("border", "1px solid black");
                $('div#advancedPrint').css("background-color", "white");
                $('div#advancedPrint').css("color", "black");
                $('#myRange').css("background-color", "black");
                $('.sp').css("color", "black");
                $('.sp').css("background-color", "white");
                $('.sp').css("border-radius", "0");
                $('.sp').css("border-bottom", "1px solid black");
                $('.problem aa').css("border", "none");
                $('#TextDiv > center > div.slidecontainer > p').css("color", "black");
                currentTheme = 'white';
                $('button.f').css("color", "black");
                $('button.f').css("background-color", "white");
                $('div#alltxt > div > textarea').css("background-color", "white");
                $('div#alltxt > div > input').css("background-color", "white");
                $('div#alltxt > div').css("background-color", "white");
                $('div#alltxt > div > textarea').css("color", "black");
                $('div#alltxt > div > input').css("color", "black");
                $('div#alltxt > div').css("color", "black");
                $('tr:nth-child(even)').css("background-color", "#F5F5F5");
                $('tr:nth-child(even)').css("color", "black");
                $('tr:nth-child(odd)').css("background-color", "#C8C8C8");
                $('tr:nth-child(odd)').css("color", "black");
            } else {
              if(currentLang=='en'){
                document.querySelector("#theme").innerText = 'Dark';
              }else{
                document.querySelector("#theme").innerText = 'Тъмна';
                ("Button changed to Тъмен");
              }
              document.querySelector("#help").style.color='white';
                $('tr:nth-child(even)').css("background-color", "grey");
                $('tr:nth-child(even)').css("color", "white");
                $('tr:nth-child(odd)').css("background-color", "#202020");
                $('tr:nth-child(odd)').css("background-color", "white");
                $('#theme').css("background-color", "white");
                $('#theme').css("color", "black");

                $('.problem aa').css("border", "none");
                $('#TextDiv > center > div.slidecontainer > p').css("color", "white");
                $('div#alltxt > div > textarea').css("background-color", "white");
                $('div#alltxt > div > input').css("background-color", "white");
                $('div#alltxt > div').css("background-color", "white");
                $('div#alltxt > div > textarea').css("color", "black");
                $('div#alltxt > div > input').css("color", "black");
                $('div#alltxt > div').css("color", "black");
                $('div#alltxt > div > textarea').css("background-color", "white");
                $('div#alltxt > div > input').css("background-color", "white");
                $('div#alltxt > div').css("background-color", "white");
                $('button.f').css("color", "black");
                $('button.f').css("background-color", "white");
                $('#myRange').css("background-color", "black");
                $('.aa').css("background-color", "#383838");
                $('.aa').css("color", "white");
                $('input.sp').css("background-color", "#383838");
                $('input.sp').css("color", "white");
                $('div#advancedPrint').css("background-color", "#383838");
                $('div#advancedPrint').css("color", "white");
                $('#theme').css("background-color", "black");
                $('#theme').css("color", "white");
                $('th').css("background-color", "black");
                $('th').css("color", "white");
                currentTheme = 'dark';
                $('button.downloadAll').css("background-color", "#202020");
                $('button.downloadAll').css("color", "white");
                $('button#export').css("background-color", "#202020");
                $('button#export').css("color", "white");
                $('button#new').css("background-color", "#202020");
                $('button#new').css("color", "white");
                $('fieldset>input').css("background-color", "black");
                $('fieldset>input').css("color", "white");
                $('fieldset>input').css("border-bottom", "1px solid #202020");
                $('fieldset').css("background-color", "black");
                $('fieldset').css("color", "white");
                $('select').css("background", "black");
                $('select').css("color", "white");
                $('.f').css("background-color", "black");
                $('.f').css("color", "white");
                $('div#alltxt > div > input').css("background-color", "#202020");
                $('div#alltxt > div > input').css("color", "white");
                $('div#alltxt > div').css("background-color", "#202020");
                $('div#alltxt > div > textarea').css("background-color", "#202020");
                $('div#alltxt > div > textarea').css("color", "white");
                $('#sidePanelBackground').css("background-image", "url(dashboard.jpg)");
                $('.window').css("background-color", "#383838");
                $('#moreSettings > center > h1').css("color", "white");
                $('div.explain').css("color", "white");
                $('div.explain').css("background-color", "black");
                $('div#instrumentPanel').css("background-color", "black");
                $('div#instrumentPanel p').css("color", "white");
                $('#block').css("background-color", "black");
                $('#block').css("color", "white");
            }
        }
        const regulate = () => {
            if (document.querySelector("#col1").innerHTML.replace(/\s/g, ' ') == ' ' && document.querySelector("#col2").innerHTML.replace(/\s/g, ' ') == ' ') {
                $("#instrumentPanel > div:nth-child(7)").hide();
                $("#instrumentPanel > div:nth-child(8) > div:nth-child(2)").hide();
            } else {
                $("#instrumentPanel > div:nth-child(7)").show();
                $("#instrumentPanel > div:nth-child(7) > div:nth-child(2)").show();
            }
        }
        const AdvancedPrint = () => {
            $("#so").toggle();
            $("#advancedPrint").toggle();
        }
        const Size = (DOM) => {
            switch (Number(DOM.value)) {
                case 7:
                    return "h1";
                    break;
                case 6:
                    return "h2";
                    break;
                case 5:
                    return "h3";
                    break;
                case 4:
                    return "h4";
                    break;
                case 3:
                    return "h5";
                    break;
                case 2:
                    return "h6";
                    break;
                case 1:
                    return "p";
                    break;
                default:
                    // ("An error occurred while estimating DOM element " + DOM + " 's value");
            }
        }
        const RealPrintProblems = () => {
            let header = document.querySelector("#advancedPrint > center > fieldset:nth-child(1) > input").value;
            let footer = document.querySelector("#advancedPrint > center > fieldset:nth-child(2) > input").value;
            document.getElementById('stemp').innerHTML = document.querySelector("#block").innerHTML;
            if (header) {
                document.getElementById('stemp').innerHTML = "<center><" + Size(document.querySelector("#TitleSize")) + ">" + header + "</" + Size(document.querySelector("#TitleSize")) + "></center><br>" + document.getElementById('stemp').innerHTML;
            }
            if (footer) {
                document.getElementById('stemp').innerHTML = document.getElementById('stemp').innerHTML + "<center><" + Size(document.querySelector("#TitleSize")) + ">" + footer + "</" + Size(document.querySelector("#TitleSize")) + "></center><br>";
            }
            document.getElementById("stemp").innerHTML = "<" + Size(document.getElementById("ProblemsSize")) + ">" + document.getElementById("stemp").innerHTML;
            document.getElementById("stemp").innerHTML += "</" + Size(document.getElementById("ProblemsSize")) + ">"
            printJS({
                printable: 'stemp',
                type: 'html',
                documentTitle: "Created using Math OS"
            });
        }
        const PrintAnswersheet = () => {
            document.getElementById("Acol1").innerHTML = '';
            document.getElementById("Acol2").innerHTML = '';
            document.getElementById("temp").innerHTML = "<" + Size(document.getElementById("AnswerSize")) + ">" + document.getElementById("temp").innerHTML;
            for (var o = 0; o < answerArray.length; o++) {
                if (answerArray.length / 2 < o + 1) {
                    document.getElementById("Acol2").innerHTML += ((o + 1) + ". | " + answerArray[o] + "<br>");
                } else {
                    document.getElementById("Acol1").innerHTML += ((o + 1) + ". | " + answerArray[o] + "<br>");
                }
                document.getElementById("temp").innerHTML += "</" + Size(document.getElementById("AnswerSize")) + ">";
            }
            printJS({
                printable: 'temp',
                type: 'html',
                documentTitle: "Created using Math OS"
            });
        }
        const getRandomInt = (min, max) => {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }
        var string = '';
        var answerArray = [];
        const probe = (p) => {
            for (var i = 0; i < Number(document.querySelector("#instrumentPanel > div:nth-child(5) > input").value); i++) {
                if (i == 0) {
                    string = '';
                }
                var ran = getRandomInt(Number(document.querySelector("#instrumentPanel > div:nth-child(4) > input").value), Number(document.querySelector("#instrumentPanel > div:nth-child(3) > input").value));
                var r = Math.round(Math.random() * (PrintProblems.length - 1));
                if (ran < 0) {
                    string += "(";
                    // (string);
                }
                string += ran;
                if (ran < 0) {
                    string += ")";
                    // (string);
                }
                if ((i + 1) !== Number(document.querySelector("#instrumentPanel > div:nth-child(5) > input").value)) {
                    switch (PrintProblems[r]) {
                        case "addition":
                            string += " + ";
                            break;
                        case "subtraction":
                            string += " - ";
                            break;
                        case "multiplication":
                            string += " * ";
                            break;
                        case "division":
                            string += " / ";
                            break;
                        default:
                            // ("An error occurred with generating sign " + r);
                            break;
                    }
                }
                if ((i + 1) == Number(document.querySelector("#instrumentPanel > div:nth-child(5) > input").value)) {
                    string = string.split(":").join("/").split("x").join("*");
                    if (eval(string) % 1 !== 0 || eval(string) < 0) {
                        probe();
                    } else {
                        answerArray.push(eval(string));
                    }
                    string = string.split("/").join(":").split("*").join("x");
                    return (((p + 1) + ". |      " + string + " =<br>"));
                }
            }
        }
        if (document.querySelector("#col1").innerHTML.replace(/\s/g, '') == '' && document.querySelector("#col2").innerHTML.replace(/\s/g, '') == '') {
            $("#instrumentPanel > div:nth-child(7)").hide();
            $("#instrumentPanel > div:nth-child(8) > div:nth-child(2)").hide();
        } else {
            $("#instrumentPanel > div:nth-child(7)").show();
            $("#instrumentPanel > div:nth-child(7) > div:nth-child(2)").show();
        }
        const SpecialGenerate = () => {
            if (document.querySelector("#instrumentPanel > div:nth-child(3) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(6) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(6) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value <= document.querySelector("#instrumentPanel > div:nth-child(4) > input").value || PrintProblems == []) {
                if (currentLang == 'en') {
                    alertify.alert('Error', 'Max generated number cannot be lower or equal to minimum  generated number. Only integers are allowed as values. No negative numbers or zero are allowed. You should choose at least one problem type.');
                } else {
                    alertify.alert('Грешка', 'Максимално генерирано число не може да бъде по-малко и равно на минимлно генерирано число. Само цели числа се приемат. Негативни числа и нули не се приемат. Трябва да изберете поне един вид задачи.');
                }
                return 0;
            }
            document.querySelector("#col1").innerHTML = "";
            document.querySelector("#col2").innerHTML = "";
            // (answerArray);
            answerArray = [];
            // (answerArray);
            // document.getElementById('block').innerHTML = '';
            for (var p = 0; p < Number(document.querySelector("#instrumentPanel > div:nth-child(6) > input").value); p++) {
                if ((Number(document.querySelector("#instrumentPanel > div:nth-child(6) > input").value / 2) < p + 1)) {
                    document.querySelector("#col2").innerHTML += probe(p);
                } else {
                    document.querySelector("#col1").innerHTML += probe(p);
                }
            }
            var all = document.getElementById('block').innerHTML;
            all = all.split("/").join(":").split("*").join("x");
            // (answerArray);
            // document.getElementById('block').innerHTML = all;
            if (document.querySelector("#block").innerHTML.replace(/\s/g, '') == '') {
                $("#instrumentPanel > div:nth-child(7)").hide();
                $("#instrumentPanel > div:nth-child(8) > div:nth-child(2)").hide();
            } else {
                $("#instrumentPanel > div:nth-child(7)").show();
                $("#instrumentPanel > div:nth-child(8) > div:nth-child(2)").show();
            }
        }
        var tableData;
        var Fullscreen;
        var PrintProblems = [];
        document.querySelector("#division1").style.backgroundColor = 'red';
        document.querySelector("#subtraction1").style.backgroundColor = 'red';
        document.querySelector("#addition1").style.backgroundColor = 'red';
        document.querySelector("#multiplication1").style.backgroundColor = 'red';
        const ChangeSpecial = (el) => {
            if (document.getElementById(el + "1").style.backgroundColor == 'green') {
                document.getElementById(el + "1").style.backgroundColor = 'red';
                removeItem(PrintProblems, el);
            } else {
                document.getElementById(el + "1").style.backgroundColor = 'green';
                PrintProblems.push(el);
            }
            uniq(PrintProblems);
        }
        const ToggleFullscreen = () => {
            if (!IsFullScreen()) {
                Fullscreen = true;
                openFullscreen();
                document.getElementById("fullscreenButton").src = 'Images/NotFullscreen.svg';
            } else {
                ExitFullScreen();
                document.getElementById("fullscreenButton").src = 'Images/fullscreen.svg';
                FullScreen = false;
            }
        }
        var elem = document.documentElement;
        const openFullscreen = () => {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                /* Firefox */
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                /* Chrome, Safari & Opera */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                /* IE/Edge */
                elem.msRequestFullscreen();
            }
        }
        const deleteAllServerData = () => {
            if (confirm("Would you want to delete all server data?")) {
                ToServer("null");
                alert("All server data has been deleted.")
            } else {
                alert("No changes has been made.");
            }
        }
        const deleteAllLocalData = () => {
            if (confirm("Would you want to delete all local data?")) {
                localStorage.clear();
                alert("All local data has been deleted.")
            } else {
                alert("No changes have been made.");
            }
        }
        const deleteData = () => {
            $("#so").show();
            $("#delete").show();
        }

        function BeforeEval(data) {
            try {
                eval(data);
            } catch (err) {
                console.warn(err);
            }
        }
        const ToServer = (data) => {
            if (data != '') {
                document.getElementById('data').value = '';
                document.getElementById('data').value = window.btoa(unescape(encodeURIComponent(data)));
                if (document.getElementById('data').value) {
                    document.getElementById('submit').click();
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        var TextareaContent = [];
        var InputContent = [];
        const GetServer = () => {
            if (document.getElementById('server').innerHTML == '') {
                return false;
            } else {
                return decodeURIComponent(escape(window.atob(document.getElementById('server').innerHTML)))
            }
        }
        var element = 2;
        hide("#general");
        $("#schedule").hide();
        $("#moreSettings").hide();

        function hide(show) {
            $("#setsDiv").hide();
            $("#statsDiv").hide();
            $("#BigSpeech").hide();
            $("#behavior").hide();
            $("#general").hide();
            $("#schedule").hide();
            $("#account").hide();
            $("#print").hide();
            $("#easySetup").hide();
            $("#moreSettings").hide();
            $("#help").hide();

            $(show).show();
        }
        document.getElementById("solvedAction").addEventListener("click", check);
        var music = new Audio('Fredji - Happy Life.mp3');
        music.loop = true;

        function check() {
            if (Number(document.getElementById("solvedAction").value) == 3) {
                $("#url").show();
            } else {
                $("#url").hide();
            }
        }
        var SpeechInput = false;
        var SpeechOutput = false;
        document.getElementById("speech").style.backgroundColor = 'red';
        document.getElementById("input").style.backgroundColor = 'red';
        $(document).ready(function() {
            $("input[type=number]").on("focus", function() {
                $(this).on("keydown", function(event) {
                    if (event.keyCode === 38 || event.keyCode === 40) {
                        event.preventDefault();
                    }
                });
            });
        });
        var timeAction = 1,
            exitsAction = 1,
            solvedAction = 1;
        if (isLocalStorageAvailable() && localStorage.getItem("timeAction") && localStorage.getItem("exitsAction") && localStorage.getItem("solvedAction")) {
            timeAction = localStorage.getItem("timeAction");
            exitsAction = localStorage.getItem("exitsAction");
            solvedAction = localStorage.getItem("solvedAction");
        }
        document.getElementById("timeAction").selectedIndex = Number(timeAction - 1);
        document.getElementById("ExitsAction").selectedIndex = Number(exitsAction - 1);
        document.getElementById("solvedAction").selectedIndex = Number(solvedAction - 1);
        if (localStorage.getItem("SpeechOutput")) {
            SpeechOutput = localStorage.getItem("SpeechOutput");
        } else {
            localStorage.setItem("SpeechOutput", false);
        }
        if (SpeechOutput == false || SpeechOutput == "false") {
            document.getElementById("speech").style.backgroundColor = 'red';
        } else {
            document.getElementById("speech").style.backgroundColor = 'green';
        }
        document.getElementById("input").style.backgroundColor = 'red';
        if (localStorage.getItem("SpeechInput")) {
            SpeechInput = localStorage.getItem("SpeechInput");
        } else {
            localStorage.setItem("SpeechInput", false);
        }
        if (SpeechInput == false || SpeechInput == "false") {
            document.getElementById("input").style.backgroundColor = 'red';
        } else {
            document.getElementById("input").style.backgroundColor = 'green';
        }

        function enableOutput() {
            if (document.getElementById("speech").style.backgroundColor == 'red') {
                document.getElementById("speech").style.backgroundColor = 'green';
            } else {
                document.getElementById("speech").style.backgroundColor = 'red';
            }
            if (document.getElementById("speech").style.backgroundColor == 'red' && document.getElementById("input").style.backgroundColor == 'red') {
                document.getElementById('AllSpeech').style.display = 'none';
                enableSpeech();
            }
        }

        function enableInput() {
            if (document.getElementById("input").style.backgroundColor == 'red') {
                document.getElementById("input").style.backgroundColor = 'green';
            } else {
                document.getElementById("input").style.backgroundColor = 'red';
            }
        }
        if (document.getElementById("speech").style.backgroundColor == 'red' && document.getElementById("input").style.backgroundColor == 'red') {
            document.getElementById('AllSpeech').style.display = 'none';
            enableSpeech();
        }
        var ProblemsLeft = 12;
        var AllProblemsCount = ProblemsLeft;
        var score = 0;
        var num1, num2;
        var MaximumGeneratedNumber = 6;
        var CountdownAllowed;
        var CountdownTime = 10;
        var MinimumGeneratedNumber = 1;
        var Timer;
        var density1;
        var game = false;
        if (localStorage.getItem("Speech") == 'true' || localStorage.getItem("Speech") == true) {
            Speech = localStorage.getItem("Speech");
        } else {
            Speech = false;
        }
        if (Speech == "true" || Speech == true) {
            document.querySelector("#all").style.backgroundColor = 'green';
            document.querySelector("#AllSpeech").style.display = 'block';
        } else {
            document.querySelector("#AllSpeech").style.display = 'none';
            document.querySelector("#all").style.backgroundColor = 'red';
        }
        if (isLocalStorageAvailable) {
            if (localStorage.getItem("density")) {
                density1 = Number(localStorage.getItem("density"));
                density2(density1);
            } else {
                density1 = 3;
                density2(3);
            }
            document.querySelector("#myRange").value = density1;
        }
        document.getElementById('timeSwitch').style.background = 'red';
        $("#setsDiv").hide()
        $('#timePro').hide();
        if (isLocalStorageAvailable() && localStorage.getItem('AllProblemsCount') && localStorage.getItem('MaximumGeneratedNumber') && localStorage.getItem('ProblemsLeft') && localStorage.getItem('MinimumGeneratedNumber') && localStorage.getItem('CountdownTime') && localStorage.getItem('CountdownAllowed')) {
            ProblemsLeft = Number(localStorage.getItem('ProblemsLeft'));
            MaximumGeneratedNumber = Number(localStorage.getItem('MaximumGeneratedNumber'));
            MinimumGeneratedNumber = Number(localStorage.getItem('MinimumGeneratedNumber'));
            CountdownTime = Number(localStorage.getItem('CountdownTime'));
            CountdownAllowed = localStorage.getItem('CountdownAllowed');
            // ("execute 2");
            if (CountdownAllowed == true || CountdownAllowed == "true") {
                document.getElementById('timeSwitch').style.background = 'green';
                document.getElementById('timeSwitch').innerHTML = 'Click to turn off';
                $('#timePro').show();
            } else {
                document.getElementById('timeSwitch').style.background = 'red';
                $('#timePro').hide();
                document.getElementById('timeSwitch').innerHTML = 'Click to turn on';
            }
            // (AllProblemsCount);
        } else {
            ProblemsLeft = 12;
            AllProblemsCount = 12;
            CountdownTime = 10;
        }

        const Speak = (a) => {
            if (game && (SpeechOutput || SpeechOutput == 'true') && (Speech != "false" && Speech != false)) {
                for (let i = 0; i < 3; i++) {
                    a = a.replace(":", " divided by ");
                    a = a.replace("x", " multiplied by ");
                    a = a.replace("+", " plus ");
                    a = a.replace("-", " minus ");
                }
                try {
                    window.speechSynthesis.speak(new SpeechSynthesisUtterance(a));
                } catch (err) {
                    console.warn(err);
                }
            }
        }

        const listen = () => {
            if ((game && (SpeechInput || SpeechInput == 'true')) != "false" && ((game && (SpeechInput || SpeechInput == 'true')) != false)) {
                var recognition = new(window.SpeechRecognition || window.webkitSpeechRecognition || window.mozSpeechRecognition || window.msSpeechRecognition)();
                recognition.lang = 'en-US';
                recognition.interimResults = false;
                recognition.maxAlternatives = 5;
                recognition.start();
                recognition.onresult = function(event) {
                    // (event.results[0][0].transcript);
                    document.getElementById("answer").value = event.results[0][0].transcript;
                    Check();
                }
            }
        }
        var allowedTypes;
        if (localStorage.getItem("TrueAllowedTypes")) {
            var TrueAllowedTypes = localStorage.getItem("TrueAllowedTypes");
            TrueAllowedTypes = JSON.parse(TrueAllowedTypes);
            if (TrueAllowedTypes.includes("Addition")) {
                document.querySelector("#Addition").style.background = 'green'
            } else {
                document.querySelector("#Addition").style.background = 'red'
            }
            if (TrueAllowedTypes.includes("Subtraction")) {
                document.querySelector("#Subtraction").style.background = 'green'
            } else {
                document.querySelector("#Subtraction").style.background = 'red'
            }
            if (TrueAllowedTypes.includes("Multiplying")) {
                document.querySelector("#Multiplying").style.background = 'green'
            } else {
                document.querySelector("#Multiplying").style.background = 'red'
            }
            if (TrueAllowedTypes.includes("Division")) {
                document.querySelector("#Division").style.background = 'green'
            } else {
                document.querySelector("#Division").style.background = 'red'
            }
        } else {
            TrueAllowedTypes = ["Addition", "Subtraction", "Multiplying", "Division"];
            var allowedTypes = TrueAllowedTypes;
        }
        if (localStorage.allowedTypes) {
            allowedTypes = JSON.parse(localStorage.getItem('allowedTypes'));
        } else {
            allowedTypes = ["Addition", "Subtraction", "Multiplying", "Division"];
        }
        for (var i = 0; i < TrueAllowedTypes.length; i++) {
            switch (TrueAllowedTypes[i]) {
                case "Addition":
                    document.getElementById("Addition").style.backgroundColor = 'green';
                    break;
                case "Subtraction":
                    document.getElementById("Subtraction").style.backgroundColor = 'green';
                    break;
                case "Multiplying":
                    document.getElementById("Multiplying").style.backgroundColor = 'green';
                    break;
                case "Division":
                    document.getElementById("Division").style.backgroundColor = 'green';
                    break;
            }
        }
        randBack();

        function enableSpeech() {
            if (document.querySelector("#all").style.backgroundColor == 'green') {
                document.querySelector("#all").style.backgroundColor = 'red';
                document.getElementById("AllSpeech").style.display = 'none';
                //Speech=false;
            } else {
                document.querySelector("#all").style.backgroundColor = 'green';
                document.getElementById("AllSpeech").style.display = 'block';
                document.getElementById('input').style.backgroundColor = 'red';
                document.getElementById('speech').style.backgroundColor = 'red';
                document.getElementById('AllSpeech').style.display = 'block';
                // Speech=true;
            }
        }

        function randBack() {
            var rand = Math.floor(Math.random() * (42)) + 1;
            document.getElementById("StartBackground").style.background = "url('Images/(" + rand + ").jpg')";
            document.getElementById("gameBackground").style.background = "url('Images/(" + rand + ").jpg')";
        }

        function Toggle(type) {
            if (window.getComputedStyle(document.getElementById(type), null).getPropertyValue("background-color") == 'rgb(255, 0, 0)') {
                allowedTypes.push(String(type));
                document.getElementById(type).style.backgroundColor = 'green';
            } else {
                removeItem(allowedTypes, String(type));
                document.getElementById(type).style.backgroundColor = 'rgb(255, 0, 0)';
            }
        }
        var slider = document.getElementById("myRange");
        var output = document.getElementById("demo");
        output.innerHTML = slider.value;
        slider.oninput = function() {
            density2(this.value);
            // (this.value);
            density1 = Number(this.value);
            document.getElementById("demo").innerHTML = 100 - this.value * 20 + 20 + "%";
        }
        document.getElementById("demo").innerHTML = 100 - localStorage.getItem("density") * 20 + 20 + "%";

        function density2(val) {
            // (val);
            var a = val;
            for (i in AllSets) {
                $(".textarea" + AllSets[i]).css('width', ((100 / val - 5) + "vw"));
                //$("#h"+d).css('width', ((100 / val - 5) + "%"));
                if (isLocalStorageAvailable) {
                    localStorage.setItem("density", Number(a));
                }
                document.getElementById("demo").innerHTML = 100 - localStorage.getItem("density") * 20 + 20 + "%";
            }
            document.querySelector("#myRange").value = val;
        }

        function removeItem(array, item) {
            for (var i in array) {
                if (array[i] == item) {
                    array.splice(i, 1);
                    break;
                }
            }
        }
        document.body.onkeyup = function(e) {
            if (e.keyCode == 32) {
                listen()
            }
        }

        function loadCurrent(i) {
            if (confirm("This will overwrite your current set!")) {
                var str = '';
                for (a in allowedTypes) {
                    if (allowedTypes.length - 1 == i) {
                        str += "'" + allowedTypes[a] + "'";
                    } else {
                        str += "'" + allowedTypes[a] + "',";
                    }
                }
                document.getElementById("txt" + i).value = "AllProblemsCount=" + Number(document.getElementById('AllCount').value) + "; ProblemsLeft=" + Number(document.getElementById('Solved').value) + "; CountdownTime=" + Number(document.getElementById('timePro').value) + "; MinimumGeneratedNumber=" + Number(document.getElementById('MinGen').value) + "; MaximumGeneratedNumber=" + Number(document.getElementById('MaxGen').value) + ";allowedTypes=[" + str + "]" + ";density1=" + density1;
            }
        }

        function Apply(i) {
            if (confirm("This will overwrite your current settings!")) {
                try {
                    BeforeEval(document.getElementById("txt" + i).value);
                    if (isLocalStorageAvailable()) {
                        localStorage.setItem('AllProblemsCount', AllProblemsCount);
                        localStorage.setItem("ProblemsLeft", ProblemsLeft);
                        localStorage.setItem("MaximumGeneratedNumber", MaximumGeneratedNumber);
                        localStorage.setItem("MinimumGeneratedNumber", MinimumGeneratedNumber);
                        localStorage.setItem("CountdownTime", CountdownTime);
                        localStorage.setItem("CountdownAllowed", CountdownAllowed);
                    }
                } catch (e) {
                    if (e instanceof SyntaxError) {
                        if (currentLang = 'en') {
                            alertify.alert('Error', 'You have a syntax error');
                        } else {
                            alertify.alert('Грешка', 'Имате синтактична грешка! Имайте предвид, че само текстове на латиница се приемат.');

                        }
                    }
                }
            }
        }

        function textFull(num) {
            var elem = document.getElementById("txt" + num);
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.mozRequestFullScreen) {
                elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullscreen) {
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) {
                elem.msRequestFullscreen();
            }
        }

        function download(num) {
            // (num);
            var data = document.getElementById("txt" + num).value;
            var title = document.getElementById("h" + num).value;
            var type = 'text/plain';
            var filename = title + "/" + data.slice(0, 50);
            var file = new Blob([data], {
                type: type
            });
            if (window.navigator.msSaveOrOpenBlob) window.navigator.msSaveOrOpenBlob(file, filename);
            else { // Others
                var a = document.createElement("a"),
                    url = URL.createObjectURL(file);
                a.href = url;
                a.download = filename;
                document.body.appendChild(a);
                a.click();
                setTimeout(function() {
                    document.body.removeChild(a);
                    window.URL.revokeObjectURL(url);
                }, 0);
            }
        }
        Element.prototype.remove = function() {
            this.parentElement.removeChild(this);
        }
        NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
            for (var i = this.length - 1; i >= 0; i--) {
                if (this[i] && this[i].parentElement) {
                    this[i].parentElement.removeChild(this[i]);
                }
            }
        }
        //result=0;
        function DeleteT(num) {
            removeItem(AllSets, num);
            // ("Removed: " + num);
            document.getElementsByClassName("textarea" + num).remove();
            save();
        }

        function downloadAll() {
            for (i in AllSets) {
                download(AllSets[i]);
            }
        }
        var sign;
        $('div#SettingsPanel').hide();
        $('div#game').hide();
        $('div#result1').hide();
        var timeleft = CountdownTime;
        if (localStorage.ProblemsLeft) {
            ProblemsLeft = localStorage.ProblemsLeft;
            document.querySelector("#Solved").value = ProblemsLeft;
        } else {
            ProblemsLeft = 12;
            document.querySelector("#Solved").value = ProblemsLeft;
        }

        function PrepareGame(arg = true) {
            localStorage.removeItem("temporaryData");
            var interval_id = window.setInterval("", 9999);
            for (var i = 1; i < interval_id; i++) {
                window.clearInterval(i);
            }
            clearInterval(temp);
            clearInterval(AllCountdown);
            //Mind localStorage
            if (arg) {
                allTimes = [];
            }
            //-------------------
            ProblemsLeft = document.querySelector("#Solved").value;
            game = true;
            $('div#menu').hide();
            $('div#game').show(0);
            $('div#game').css('color', 'white');
            $('div#game').css('background-color', 'black');
            if (!IsFullScreen()) {
                fullScreen(document.body);
            }
            problemsLeft = localStorage.getItem("problemsLeft");
            gameTime = 0;
            SetTimer(CountdownTime);
            startCountdownAll();
            StartGame();
            document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
            document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
            if (localStorage.getItem('MusicAllowed') == 'true' || localStorage.getItem('MusicAllowed') == 'true') {
                music.play();
                document.getElementById("play").src = 'Images/pause.svg';
            } else {
                music.pause();
                document.getElementById("play").src = 'Images/play.svg';
            }
        }
        if (localStorage.getItem("AllSets")) {
            var AllSets = JSON.parse(localStorage.getItem("AllSets"))
            // ('full all stets')
        } else {
            var AllSets = [];
            // ('empty allsets')
        }
        var i = 0;
        var i = localStorage.getItem('AllNum');
        load();
        var a;
        // ("In the beginning i is: " + i);
        $("#hidesch").hide();

        function add() {
            i = Math.round(Math.random() * 9999999999);
            AllSets.push(i);
            // ("I is: " + i);
            // (i, localStorage.getItem('AllNum'));
            $('#alltxt').append('<div class="textarea' + i + '"><input data-enable-grammarly="true" onkeyup="save()" id="h' + i + '"></input><textarea data-enable-grammarly="true" value="" onkeyup="save()" id="txt' + i + '"></textarea><br>        <button onClick="download(' + i + ')" class="f a">Save locally</button> <button onClick="loadCurrent(' + i + ')" class="f">Load current settings</button> <button onClick="Apply(' + i + ')" class="f">Apply</button><button onClick="textFull(' + i + ')" class="f">Fullscreen</button><button onClick="schedule(' + i + ')" class="f">Schedule</button> <div class="hidesch" id="hidesch' + i + '"><button onClick="morning(' + i + ')" class="f">Execute in the morning</button> <button onClick="afternoon(' + i + ')" class="f">Execute in the afternoon</button><hr><button onClick="Monday(' + i + ')" class="f">Execute on Monday</button><button onClick="Tuesday(' + i + ')" class="f">Execute on Tuesday</button><button onClick="Wednesday(' + i + ')" class="f">Execute on Wednesday</button><button onClick="Thursday(' + i + ')" class="f">Execute on Thursday</button><button onClick="Friday(' + i + ')" class="f">Execute on Friday</button><button onClick="Saturday(' + i + ')" class="f">Execute on Saturday</button><button onClick="Sunday(' + i + ')" class="f">Execute on Sunday</button><hr><button onClick="always(' + i + ')" class="f">Execute on every reload</button></div> <button onClick="DeleteT(' + i + ')" class="f">Delete</button> </div>');
            save();
            confirmWhite();
        }
        var morningArray = [];
        var afternoonArray = [];
        var MondayArray = [],
            TuesdayArray = [],
            WednesdayArray = [],
            ThursdayArray = [],
            FridayArray = [],
            SaturdayArray = [],
            SundayArray = [],
            alwaysArray = [];

        function always(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(12)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(12)")).style.background = 'red';
                removeItem(alwaysArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(12)")).style.background = 'green';
                alwaysArray.push(i);
            }
        }

        function morning(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(1)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(1)")).style.background = 'red';
                removeItem(morningArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(1)")).style.background = 'green';
                morningArray.push(i);
            }
        }

        function afternoon(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(2)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(2)")).style.background = 'red';
                removeItem(afternoonArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(2)")).style.background = 'green';
                afternoonArray.push(i);
            }
        }

        function Monday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(4)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(4)")).style.background = 'red';
                removeItem(MondayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(4)")).style.background = 'green';
                MondayArray.push(i);
            }
        }

        function Tuesday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(5)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(5)")).style.background = 'red';
                removeItem(TuesdayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(5)")).style.background = 'green';
                TuesdayArray.push(i);
            }
        }

        function Wednesday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(6)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(6)")).style.background = 'red';
                removeItem(WednesdayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(6)")).style.background = 'green';
                WednesdayArray.push(i);
            }
        }

        function Thursday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(7)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(7)")).style.background = 'red';
                removeItem(ThursdayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(7)")).style.background = 'green';
                ThursdayArray.push(i);
            }
        }

        function Friday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(8)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(8)")).style.background = 'red';
                removeItem(FridayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(8)")).style.background = 'green';
                FridayArray.push(i);
            }
        }

        function Sunday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(10)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(10)")).style.background = 'red';
                removeItem(SundayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(10)")).style.background = 'green';
                SundayArray.push(i);
            }
        }

        function Saturday(i) {
            if (document.querySelector(("#hidesch" + i + " > button:nth-child(9)")).style.background == 'green') {
                document.querySelector(("#hidesch" + i + " > button:nth-child(9)")).style.background = 'red';
                removeItem(SaturdayArray, i);
            } else {
                document.querySelector(("#hidesch" + i + " > button:nth-child(9)")).style.background = 'green';
                SaturdayArray.push(i);
            }
        }

        function save() {
            TextareaContent = [];
            InputContent = [];
            localStorage.setItem("Sets", document.getElementById("alltxt").innerHTML);
            localStorage.setItem("AllSets", JSON.stringify(AllSets));
            for (b in AllSets) {
                if (/[а-яА-ЯЁё]/.test(document.getElementById(("txt" + Number(AllSets[b]))).value) || /[а-яА-ЯЁё]/.test(document.getElementById(("h" + AllSets[b])).value)) {
                    if (currentLang == 'en') {
                        alertify.alert('Error', 'Cyrillic is not allowed.');
                    } else {
                        alertify.alert('Грешка', 'Кирилица не се приема.');

                    }
                }
                // ("txt" + AllSets[b]);
                localStorage.setItem(("txt" + AllSets[b]), document.getElementById(("txt" + Number(AllSets[b]))).value);
                TextareaContent.push(document.getElementById(("txt" + Number(AllSets[b]))).value);
                localStorage.setItem(("h" + AllSets[b]), document.getElementById(("h" + AllSets[b])).value);
                InputContent.push(document.getElementById(("h" + AllSets[b])).value);
            }
            if (document.getElementById('alltxt').children.length == 0) {
                AllSets = [];
            }
        }

        function load() {
            var v = 0;
            if (TextareaContent != [] || TextareaContent != undefined) {
                for (v in TextareaContent) {
                    document.getElementById("h" + AllSets[v]).value = TextareaContent[v];
                    document.getElementById("txt" + AllSets[v]).value = TextareaContent[v];
                }
            }
            if (document.getElementById('alltxt').children.length == 0) {
                AllSets = [];
            }
        }

        function isLocalStorageAvailable() {
            try {
                var valueToStore = 'test';
                var mykey = 'key';
                localStorage.setItem(mykey, valueToStore);
                var recoveredValue = localStorage.getItem(mykey);
                localStorage.removeItem(mykey);
                return recoveredValue === valueToStore;
            } catch (e) {
                return false;
            }
        }
        var timeAll = 0;
        var AllCountdown;
        var url;
        if (localStorage.getItem("url")) {
            document.getElementById("url").value = localStorage.getItem("url");
            url = localStorage.getItem("url");
        }
        var pointer;

        function startCountdownAll(timeAll = 0) {
            timeleft = 0;
            AllCountdown = setInterval(function() {
                document.getElementById("TimeElapsed").innerHTML = "+" + secondsToHms(timeAll) + "s";
                timeAll++;
                pointer = timeAll;
            }, 1000);
        }
        // (CountdownAllowed);
        if (Number(solvedAction) == 3) {
            $("#url").show();
        } else {
            $("#url").hide();
        }

        function loadData() {
            document.getElementById('AllCount').value = AllProblemsCount;
            document.getElementById('Solved').value = ProblemsLeft;
            document.getElementById('MaxGen').value = MaximumGeneratedNumber;
            document.getElementById('MinGen').value = MinimumGeneratedNumber;
            document.getElementById('timePro').value = CountdownTime;
        }

        function enableTime() {
            if (document.getElementById('timeSwitch').style.background == 'red') {
                document.getElementById('timeSwitch').style.background = 'green';
                document.getElementById('timeSwitch').innerHTML = 'Click to turn off';
                CountdownAllowed = true;
                $('#timePro').show();
            } else {
                CountdownAllowed = false;
                document.getElementById('timeSwitch').style.background = 'red';
                $('#timePro').hide();
                document.getElementById('timeSwitch').innerHTML = 'Click to turn on';
                CountdownAllowed = false;
            }
        }
        if (localStorage.getItem('elements')) {
            element = localStorage.getItem('elements');
            document.querySelector("#elements").value = element;
        }

        function uniq(a) {
            return a.sort().filter(function(item, pos, ary) {
                return !pos || item != ary[pos - 1];
            })
        }

        function schedule(num) {
            $("#hidesch" + num).toggle();
        }
        var PrintMinimum, PrintMaximum, PrintElements, PrintAllProblems;

        function apply() {
            if (document.querySelector("#instrumentPanel > div:nth-child(3) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(6) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(6) > input").value % 1 != 0 || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value <= document.querySelector("#instrumentPanel > div:nth-child(4) > input").value || PrintProblems == []) {
                if (currentLang == 'en') {
                    alertify.alert('Error', 'Max generated number cannot be lower or equal to minimum  generated number. Only integers are allowed as values. No negative numbers or zero are allowed. You should choose at least one problem type.');
                } else {
                    alertify.alert('Грешка', 'Максимално генеирано число не мжое да е равно или о-малко от минимално генерирано число. Only integers are allowed as values. No negative numbers or zero are allowed. You should choose at least one problem type.');

                }
                return 0;
            }
            if (!document.querySelector('#advancedPrint > center > fieldset:nth-child(2) > input').value || !document.querySelector('#advancedPrint > center > fieldset:nth-child(1) > input').value) {
                if (currentLang == 'en') {
                    alertify.alert('Error', 'Custom title and Custom footer must be set!');
                } else {
                    alertify.alert('Грешка', 'Заглавие и крайно заглавие трябва да бъдат въведени!');
                }
                return 0;
            }
            if (document.getElementById('AllCount').value == '' || document.getElementById('Solved').value == '' || document.getElementById('MaxGen').value == '' || document.getElementById('MinGen').value == '') {
                if (currentLang == 'en') {
                    alertify.alert('Error', 'Some fields are not filled out');
                } else {
                    alertify.alert('Грешка', 'Някои полета са останали непопълнени');

                }
                return;
            } else {
                if (document.querySelector("#AllCount").value <= 0 || ((document.querySelector("#AllCount").value) % 1 !== 0) || document.querySelector("#Solved").value <= 0 || document.querySelector("#Solved").value % 1 !== 0 || document.querySelector("#MaxGen").value % 1 !== 0 || document.querySelector("#MaxGen").value <= 0 || document.querySelector("#MinGen").value <= 0 || document.querySelector("#MinGen").value % 1 !== 0 || document.querySelector("#elements").value % 1 !== 0) {
                    if (currentLang == 'en') {
                        alertify.alert('Error', 'All must be over 0 and an integer');
                    } else {
                        alertify.alert('Грешка', 'Всички въведени данни трябва да бъдат над нула и цели числа');

                    }
                    return;
                }
                if (Number(document.querySelector("#elements").value) > 1 && Number(document.querySelector("#elements").value) < 160) {
                    if (document.querySelector("#timePro").value < 5) {
                        if (currentLang == 'en') {
                            alertify.alert('Error', 'Time must be at least 5.');
                        } else {
                            alertify.alert('Грешка', 'Времето трябва да е поне 5');

                        }
                        return;
                    }
                    if (document.querySelector("#instrumentPanel > div:nth-child(6) > input").value == '' || document.querySelector("#instrumentPanel > div:nth-child(6) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(6) > input").value % 1 !== 0 || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value == '' || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(5) > input").value % 1 !== 0 || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value == '' || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value % 1 !== 0 || document.querySelector("#instrumentPanel > div:nth-child(4) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value == '' || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value <= 0 || document.querySelector("#instrumentPanel > div:nth-child(3) > input").value % 1 !== 0 || PrintProblems == []) {
                        if (currentLang == 'en') {
                            alertify.alert('Error in Print tab', 'There are empty fields and/or you have to  choose problems type.');
                        } else {
                            alertify.alert('Грешка', 'Има останали празни полета и/или има не сте избрали вид задачи.');
                        }
                        return;
                    }
                    if (Number(document.querySelector("#instrumentPanel > div:nth-child(3) > input").value) <= Number(document.querySelector("#instrumentPanel > div:nth-child(4) > input").value)) {
                        if (currentLang == 'en') {
                            alertify.alert('Error in Print tab', 'Make sure that Minimum generated number is less than and not equal to  maximum generated number');
                        } else {
                            alertify.alert('Грешка', 'Уверете се, че максимално генерирано число е по-голямо от минимално генерирано число.');
                        }
                        return;
                    }
                    PrintAllProblems = document.querySelector("#instrumentPanel > div:nth-child(6) > input").value;
                    PrintElements = document.querySelector("#instrumentPanel > div:nth-child(5) > input").value;
                    PrintMinimum = document.querySelector("#instrumentPanel > div:nth-child(4) > input").value;
                    PrintMaximum = document.querySelector("#instrumentPanel > div:nth-child(3) > input").value;
                    CountdownAllowed == true ? CountdownTime = Number(document.getElementById('timePro')) : CountdownTime = CountdownTime;
                    if (Number(document.getElementById('AllCoфunt').value) >= Number(document.getElementById('Solved').value)) {
                        if (Number(document.getElementById('MaxGen').value) == Number(document.getElementById('MinGen').value)) {
                            if (currentLang == 'en') {
                                alertify.alert('Error', 'Minimum and maximum generated number cannot be equal');
                            } else {
                                alertify.alert('Грешка', 'Минимално и максимално генеирано число не могат да са еднакви');

                            }
                            return;
                        } else {
                            if (Number(document.getElementById('timePro').value) > 999) {
                                if (currentLang == 'en') {
                                    alertify.alert('Error', 'Time cannot be more than 999s');
                                } else {
                                    alertify.alert('Грешка', 'Времето не може да бъде над 999 секунди');

                                }
                            } else {
                                timeAction = Number(document.querySelector("#timeAction").value);
                                exitsAction = Number(document.querySelector("#ExitsAction").value);
                                solvedAction = Number(document.querySelector("#solvedAction").value);
                                if (allowedTypes.length > 0) {
                                    //alertify.alert('Error', 'You should either choose Addition or/and Subtraction or select Number of element for problem=2');
                                    // return;
                                    element = document.querySelector("#elements").value;
                                    localStorage.setItem('elements', element);
                                    if (Number(document.querySelector("#MinGen").value) > Number(document.querySelector("#MaxGen").value)) {
                                        if (currentLang == 'en') {
                                            alertify.alert('Error', 'Minimum generated number should be lower than maximum generated number.');
                                        } else {
                                            alertify.alert('Грешка', 'Минимално генерирано число трябва да бъде под максимално генерирано число');
                                        }
                                        return;
                                    }
                                    AllProblemsCount = Number(document.getElementById('AllCount').value);
                                    ProblemsLeft = Number(document.getElementById('Solved').value);
                                    MaximumGeneratedNumber = Number(document.getElementById('MaxGen').value);
                                    MinimumGeneratedNumber = Number(document.getElementById('MinGen').value);
                                    CountdownTime = Number(document.getElementById('timePro').value);
                                    if (document.getElementById("input").style.backgroundColor == "green") {
                                        SpeechInput = true;
                                        localStorage.setItem('SpeechInput', SpeechInput);
                                    } else {
                                        SpeechInput = false;
                                        localStorage.setItem('SpeechInput', SpeechInput);
                                    }
                                    if (document.getElementById("speech").style.backgroundColor == "green") {
                                        SpeechOutput = true;
                                        localStorage.setItem('SpeechOutput', SpeechOutput);
                                    } else {
                                        SpeechOutput = false;
                                        localStorage.setItem('SpeechOutput', SpeechOutput);
                                    }
                                    localStorage.setItem("allowedTypes", JSON.stringify(allowedTypes));
                                    TrueAllowedTypes = allowedTypes;
                                    // (TrueAllowedTypes);
                                    document.getElementById("SettingsPanel").style.display = "none";
                                    if (isLocalStorageAvailable()) {
                                        localStorage.setItem("timeAction", timeAction);
                                        localStorage.setItem("exitsAction", exitsAction);
                                        localStorage.setItem("solvedAction", solvedAction);
                                        localStorage.setItem('AllProblemsCount', AllProblemsCount);
                                        localStorage.setItem("ProblemsLeft", ProblemsLeft);
                                        localStorage.setItem("MaximumGeneratedNumber", MaximumGeneratedNumber);
                                        localStorage.setItem("MinimumGeneratedNumber", MinimumGeneratedNumber);
                                        localStorage.setItem("CountdownTime", CountdownTime);
                                        localStorage.setItem("CountdownAllowed", CountdownAllowed);
                                        localStorage.setItem("TrueAllowedTypes", JSON.stringify(TrueAllowedTypes));
                                        if (document.querySelector("#all").style.backgroundColor == 'green') {
                                            Speech = true;
                                            localStorage.setItem("Speech", Speech);
                                        } else {
                                            Speech = false;
                                            localStorage.setItem("Speech", Speech);
                                        }
                                        if (Number(solvedAction) == 3) {
                                            $("#url").show();
                                            localStorage.setItem("url", document.getElementById("url").value);
                                        } else {
                                            $("#url").hide();
                                        }
                                    }
                                    //   localStorage.setItem('AllProblemsCount')
                                    $('div#menu').show();
                                } else {
                                    if (currentLang == 'en') {
                                        alertify.alert('Error', 'You have to choose at least one problems type');
                                    } else {
                                        alertify.alert('Грешка', 'Трябва да избереш поне един вид задача');

                                    }
                                }
                            }
                        }
                    } else {
                        if (currentLang == 'en') {
                            alertify.alert('Error', 'All problems count must be bigger or equal to problems left');
                        } else {
                            alertify.alert('Грешка', 'Всички задачи трябва да бъде повече или равни на останали задачи');

                        }
                    }
                    uniq(TrueAllowedTypes);
                    uniq(allowedTypes);
                    SpecialServer();
                } else {
                    if (currentLang == 'en') {
                        alertify.alert('Error', 'Elements must be between 2 and 150');
                    } else {
                        alertify.alert('Грешка', 'Броят елементи на задача трябва да бъде между 2 и 150');

                    }
                    return;
                }
            }
        }

        function SpecialServer() {
            if (document.getElementById('alltxt').children.length == 0) {
                AllSets = [];
            }
            url = document.querySelector("#url").value;
            ToServer("density2(" + density1 + ");AllProblemsCount=" + AllProblemsCount + ";ProblemsLeft=" + ProblemsLeft + ";TrueAllowedTypes=" + JSON.stringify(TrueAllowedTypes) + ";CountdownTime=" + CountdownTime + ";CountdownAllowed=" + CountdownAllowed + ";Speech=" + Speech + ";density=" + density1 + ";timeAction=" + timeAction + ";ProblemsLeft=" + ProblemsLeft + ";MinimumGeneratedNumber=" + MinimumGeneratedNumber + ";element=" + element + ';solvedAction=' + solvedAction + ";exitsAction=" + exitsAction + ";SpeechInput=" + SpeechInput + ";SpeechOutput=" + SpeechOutput + ";game=" + game + ";timeLeft=" + timeleft + ";sign='" + sign + "';num1=" + num1 + ";num2=" + num2 + ";result=" + result + ";document.querySelector('#StatsTable').innerHTML='" + document.querySelector("#StatsTable").innerHTML.replace(/\r/g, "").replace(/\n/g, "") + "'" + ";document.querySelector('#allTxt').innerHTML='" + document.querySelector("#allTxt").innerHTML.replace(/\n/g, "") + "'" + ";AllSets=" + JSON.stringify(AllSets) + ";TextareaContent=" + JSON.stringify(TextareaContent) + ";InputContent=" + JSON.stringify(InputContent) + ";morningArray=" + JSON.stringify(morningArray) + ";afternoonArray=" + JSON.stringify(afternoonArray) + ";MondayArray=" + JSON.stringify(MondayArray) + ";TuesdayArray=" + JSON.stringify(TuesdayArray) + ";WednesdayArray=" + JSON.stringify(WednesdayArray) + ";ThursdayArray=" + JSON.stringify(ThursdayArray) + ";FridayArray=" + JSON.stringify(FridayArray) + ";SaturdayArray=" + JSON.stringify(SaturdayArray) + ";SundayArray=" + JSON.stringify(SundayArray) + ";alwaysArray=" + JSON.stringify(alwaysArray) + ";MaximumGeneratedNumber=" + MaximumGeneratedNumber + ";url='" + url + "';PrintAllProblems=" + PrintAllProblems + ";PrintElements=" + PrintElements + ";PrintMaximum=" + PrintMaximum + ";PrintMinimum=" + PrintMinimum + ";PrintProblems=" + JSON.stringify(PrintProblems) + ";document.querySelector('#block').innerHTML='" + document.querySelector("#block").innerHTML.replace(/\r/g, "").replace(/\n/g, "") + "';document.querySelector('#advancedPrint > center > fieldset:nth-child(1) > input').value='" + document.querySelector("#advancedPrint > center > fieldset:nth-child(1) > input").value + "';document.querySelector('#advancedPrint > center > fieldset:nth-child(2) > input').value='" + document.querySelector("#advancedPrint > center > fieldset:nth-child(2) > input").value + "';document.querySelector('#ProblemsSize').selectedIndex=" + document.querySelector("#ProblemsSize").selectedIndex + ";document.querySelector('#AnswerSize').selectedIndex=" + document.querySelector('#AnswerSize').selectedIndex + ";document.querySelector('#TitleSize').selectedIndex=" + document.querySelector("#TitleSize").selectedIndex + ";document.querySelector('#FooterSize').selectedIndex=" + document.querySelector("#FooterSize").selectedIndex + ";currentTheme='" + currentTheme + "';changeLanguage('" + currentLang + "')");
        }

        function SetTimer(time) {
            if (CountdownAllowed != "false" && CountdownAllowed) {
                $("#line1").show();
                $("#line2").show();
                document.getElementById('time').style.visibility = 'visible';
                timeleft = time;
                Timer = setInterval(function() {
                    document.getElementById("time").innerHTML = timeleft;
                    timeleft -= 1;
                    document.getElementById("line1").style.width = (((timeleft * 100) / CountdownTime) / 2 + "vw");
                    document.getElementById("line2").style.width = (((timeleft * 100) / CountdownTime) / 2 + "vw");
                    if (timeleft <= 0) {
                        //  timeleft=time; Time needs to be reseted!
                        EndGame();
                        // ("Game should be ended");
                    }
                }, 1000);
            } else {
                document.getElementById('time').style.visibility = 'hidden';
                timeleft = CountdownTime;
                $("#line1").hide();
                $("#line2").hide();
            }
        }
        allTimes = [];
        var result;
        var string = '';

        function getExp() {
            string = '';
            for (var i = 0; i < element; i++) {
                let temporaryNum = Math.round(Math.random() * (MaximumGeneratedNumber - MinimumGeneratedNumber) + MinimumGeneratedNumber);
                string += temporaryNum;
                if ((i + 1) != Number(element)) {
                    switch (TrueAllowedTypes[Math.round(Math.random() * (TrueAllowedTypes.length - 1))]) {
                        case "Addition":
                            string += " + ";
                            break;
                        case "Subtraction":
                            string += " - ";
                            break;
                        case "Multiplying":
                            string += "*";
                            break;
                        case "Division":
                            string += "/";
                            break;
                        default:
                            // ("An error occurred with generating sign");
                    }
                }
            }
            if (eval(string) < 0 || eval(string.replace("x", "*").replace(":", "/")) % 1 != 0) {

                getExp();
            } else {
                console.warn("Exits exp" + string);
            }
        }

        function StartGame() {
            let times0 = 1;
            if (ProblemsLeft !== document.querySelector("#Solved").value && times0 !== 0) {
                // ("called");
                if (currentLang == 'en') {
                    alertify.success(currentPointer.toString() + "s needed");
                } else {
                    alertify.success(currentPointer.toString() + " секунди нужни");

                }
                times0 = 0;
            }
            document.getElementById('expression').innerHTML = '';
            string = '';
            try {
                window.speechSynthesis.cancel();
            } catch (err) {
                console.warn(err);
            }
            temporaryTimer();
            result = 0;
            document.getElementById('answer').innerHTML = '';
            document.getElementById('answer').focus();
            if (ProblemsLeft <= 0) {
                document.getElementById("overAll").style.width = "0vw";
                EndGame();
            } else {
                document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
            }
            try {
                getExp();
            } catch (err) {
                if (currentLang == 'en') {
                    alert("You have narrowed the algorithm too much. Allow other types of problems or decrease the elements per problem.");
                } else {
                    alert("Стеснили сте прекалено много алгоритъма. Позволете други видове задачи или увеличете елементите на задача.");
                }
            }
            result = eval(string);
            for (var i = 0; i < element; i++) {
                string = string.replace("*", " x ");
                string = string.replace("/", " : ");
                document.getElementById('expression').innerHTML = string;
            }
            document.getElementById("gameBackground").style.webkitFilter = "blur(" + (ProblemsLeft / AllProblemsCount) * 10 + "px)";
            if (CountdownAllowed == "true" || CountdownAllowed == true) {
                timeleft = CountdownTime;
                $("#time").show();
            } else {
                $("#time").hide();
            }
            listen();
            document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
            Speak(document.querySelector("#expression").innerHTML);
            if (document.querySelector("#expression").innerText.length <= 10) {
                document.querySelector("#expression").style.fontSize = '15vmax';
            } else if (document.querySelector("#expression").innerText.length > 10 && document.querySelector("#expression").innerText.length <= 20) {
                document.querySelector("#expression").style.fontSize = '10vmax';
            } else if (document.querySelector("#expression").innerText.length > 20 && document.querySelector("#expression").innerText.length <= 40) {
                document.querySelector("#expression").style.fontSize = '8vmax';
            } else if (document.querySelector("#expression").innerText.length > 40 && document.querySelector("#expression").innerText.length <= 80) {
                document.querySelector("#expression").style.fontSize = '5.5vmax';
            } else if (document.querySelector("#expression").innerText.length > 80 && document.querySelector("#expression").innerText.length <= 100) {
                document.querySelector("#expression").style.fontSize = '4vmax';
            } else if (document.querySelector("#expression").innerText.length > 100) {
                document.querySelector("#expression").style.fontSize = '1.5vmax';
                document.querySelector("#expression").style.marginTop = '9vmax'
            }
        }
        var currentTime = 0;
        var temp;

        function temporaryTimer(currentTime = 0) {
            temp = setInterval(function() {
                currentTime += 1;
                currentPointer = currentTime;
                //  clearInterval(temp);
            }, 1000);
        }
        var num3, num4, num5;

        function Check() {
            if (result == document.getElementById('answer').value) {
                document.getElementById('answer').value = '';
                $('#answer').css('border', '1px solid white');
                $('#answer').css('color', 'white');
                ProblemsLeft--;
                if (ProblemsLeft <= 0) {
                    EndGame();
                } else {
                    if (CountdownAllowed == "true" || CountdownAllowed == true) {
                        allTimes.push(Number(currentPointer));
                        clearInterval(temp);
                    } else {
                        allTimes.push(currentPointer);
                        clearInterval(temp);
                    }
                    StartGame();
                    if (Speech && (SpeechOutput == 'true' || SpeechOutput == true)) {
                        var audio = new Audio('success.mp3');
                        audio.play();
                    }
                }
            } else {
                if (document.getElementById('answer').value == '') {
                    $('#answer').css('border', '1px solid white');
                    $('#answer').css('color', 'white');
                } else {
                    $('#answer').css('color', 'red');
                }
            }
        }
        var gameTime = 0;
        var d;

        function EndGame() {
            try {
                window.speechSynthesis.cancel();
            } catch (err) {
                console.warn(err);
            }
            d = new Date();
            if (ProblemsLeft <= 0) {
                switch (Number(solvedAction)) {
                    case 1:
                        realFinish();
                        return;
                        break;
                    case 2:
                        ProblemsLeft = Infinity;
                        AllProblemsCount = Infinity;
                        clearInterval(Timer);
                        SetTimer(CountdownTime);
                        document.getElementById("overAll").style.width = "100vw";
                        StartGame();
                        return;
                        break;
                    case 3:
                        if (document.getElementById("url").value) {
                            location.href = document.getElementById("url").value;
                            realFinish();
                        } else {
                            realFinish();
                        }
                        game = false;
                        return;
                        break;
                }
            } else {
                if (CountdownAllowed = !null && CountdownAllowed != false && timeleft <= 0) {
                    if (AllProblemsCount > ProblemsLeft) {
                        if (timeAction == 1) {
                            StartGame();
                        } else if (timeAction == 2) {
                            clearInterval(Timer);
                            SetTimer(CountdownTime);
                        } else if (timeAction == 3) {
                            if (ProblemsLeft + 1 > AllProblemsCount) {
                                clearInterval(Timer);
                                SetTimer(CountdownTime);
                            } else {
                                if (currentLang == 'en') {
                                    alertify.success('+1 problem');
                                } else {
                                    alertify.success('+1 задача');

                                }
                                ProblemsLeft++;
                                clearInterval(Timer);
                                SetTimer(CountdownTime);
                            }
                        } else if (timeAction == 4) {
                            if (ProblemsLeft + 2 == AllProblemsCount) {
                                ProblemsLeft++;
                                if (currentLang == 'en') {
                                    alertify.success('+1 problem');
                                } else {
                                    alertify.success('+1 задача');

                                }
                                clearInterval(Timer);
                                SetTimer(CountdownTime);
                            } else if (ProblemsLeft + 1 == AllProblemsCount) {
                                ProblemsLeft++;
                                if (currentLang == 'en') {
                                    alertify.success('+1 problem');
                                } else {
                                    alertify.success('+1 задача');

                                }
                                clearInterval(Timer);
                                SetTimer(CountdownTime);
                            } else if (ProblemsLeft == AllProblemsCount) {
                                clearInterval(Timer);
                                SetTimer(CountdownTime);
                            } else {
                                ProblemsLeft++;
                                ProblemsLeft++;
                                if (currentLang == 'en') {
                                    alertify.success('+2 problem');
                                } else {
                                    alertify.success('+2 задача');

                                }
                                clearInterval(Timer);
                                SetTimer(CountdownTime);
                            }
                        } else if (timeAction == 5) {
                            realFinish();
                        }
                    } else if (ProblemsLeft == AllProblemsCount) {
                        if (timeAction == 2) {
                            clearInterval(Timer);
                            SetTimer(CountdownTime);
                        } else if (timeAction == 1 || timeAction == 3 || timeAction == 4) {
                            StartGame();
                            clearInterval(Timer);
                            SetTimer(CountdownTime);
                        } else {
                            //timeAction=5
                            realFinish();
                            game = false;
                        }
                    }
                } else {
                    realFinish();
                    game = false;
                }
                document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
                document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
            }
        }

        function ToggleMusic() {
            if (music.paused) {
                music.play();
                localStorage.setItem('MusicAllowed', true);
                document.getElementById("play").src = 'Images/pause.svg';
            } else {
                music.pause();
                localStorage.setItem('MusicAllowed', false);
                document.getElementById("play").src = 'Images/play.svg';
            }
        }
        $('table').highchartTable();

        function realFinish(condition = true) {
            game = false;
            localStorage.removeItem("temporaryData");
            var interval_id = window.setInterval("", 9999);
            for (var i = 1; i < interval_id; i++) {
                window.clearInterval(i);
            }
            clearInterval(temp);
            clearInterval(AllCountdown);
            music.pause();
            music.currentTime = 0
            ProblemsLeft = document.querySelector("#Solved").value;
            $('div#game').hide();
            $('div#result1').show();
            // ("Game End");
            clearInterval(Timer);
            clearInterval(AllCountdown);
            if (condition) {
                for (v in allTimes) {
                    gameTime += allTimes[v];
                }
                gameTime = gameTime / allTimes.length;
                allTimes = [];
                var d = new Date();
                $("tbody").prepend("<tr><td>" + d + "</td><td>" + gameTime.toFixed(2) + "s</td><td>" + AllProblemsCount + "</td><td>" + ProblemsLeft + "</td><td>" + MaximumGeneratedNumber + "</td><td>" + MinimumGeneratedNumber + "</td><td>" + secondsToHms(pointer) + "</tr>");
                // (CountdownAllowed);
                game = false;
                $(".highcharts-container").hide()
                $('table').highchartTable();
            }
        }

        function secondsToHms(d) {
            d = Number(d);
            var h = Math.floor(d / 3600);
            var m = Math.floor(d % 3600 / 60);
            var s = Math.floor(d % 3600 % 60);
            return ('0' + h).slice(-2) + ":" + ('0' + m).slice(-2) + ":" + ('0' + s).slice(-2);
        }
        $(".highcharts-container").hide()
        $('table').highchartTable();

        function IsFullScreen() {
            if (document.fullscreenElement || document.webkitFullscreenElement || document.mozFullScreenElement || document.msFullscreenElement) {
                return true;
            } else {
                return false;
            }
        }
        if (document.getElementById('StatsTable').rows.length == 0) {
            $("#export").hide();
        }
        $("#export").click(function() {
            if (document.getElementById('StatsTable').rows.length > 0) {
                $("#StatsTable").table2excel({
                    // exclude CSS class
                    exclude: ".noExl",
                    name: "MathBgTable Name",
                    filename: "MathBgTable", //do not include extension
                    fileext: ".xls" // file extension
                });
            } else {
                if (currentLang == 'en') {
                    alertify.alert('Error', 'There are no rows to be exported');
                } else {
                    alertify.alert('Грешка', 'Няма данни, които да бъдат експортирани');
                }
            }
        });

        function ExitFullScreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }

        function fullScreen(elem) {
            try {
                var i = elem;
                // go full-screen
                if (i.requestFullscreen) {
                    i.requestFullscreen();
                } else if (i.webkitRequestFullscreen) {
                    i.webkitRequestFullscreen();
                } else if (i.mozRequestFullScreen) {
                    i.mozRequestFullScreen();
                } else if (i.msRequestFullscreen) {
                    i.msRequestFullscreen();
                }
            } catch (err) {
                if (i.requestFullscreen) {
                    i.requestFullscreen();
                } else if (i.webkitRequestFullscreen) {
                    i.webkitRequestFullscreen();
                } else if (i.mozRequestFullScreen) {
                    i.mozRequestFullScreen();
                } else if (i.msRequestFullscreen) {
                    i.msRequestFullscreen();
                }
            }
        }
        if (Number(document.getElementById("solvedAction").value) == 3) {
            $("#url").show();
        } else {
            $("#url").hide();
        }
        window.onbeforeunload = function() {
            localStorage.setItem("temporaryData", ("AllProblemsCount=" + AllProblemsCount + ";ProblemsLeft=" + ProblemsLeft + ";timeleft=" + timeleft + ";game=" + game + ";MaximumGeneratedNumber=" + MaximumGeneratedNumber + ";MinimumGeneratedNumber=" + MinimumGeneratedNumber + ";num1=" + num1 + ";num2=" + num2 + ";sign='" + sign + "';result=" + result + ";document.querySelector('#expression').innerText='" + document.querySelector("#expression").innerText + "'" + ";startCountdownAll(" + pointer + ");allTimes=" + JSON.stringify(allTimes)));
            localStorage.setItem("allTimes", allTimes);
            alert(game);
        }
        window.onload = function() {
            var interval_id = window.setInterval("", 9999);
            for (var i = 1; i < interval_id; i++) {
                window.clearInterval(i);
            }
            if (localStorage.getItem('temporaryData') != null) {
                BeforeEval(localStorage.getItem("temporaryData"));
                allTimes = JSON.parse("[" + localStorage.getItem('allTimes') + "]");
                if (game == 'true' || game) {
                    try {
                        if (localStorage.getItem('MusicAllowed') == 'true' || localStorage.getItem('MusicAllowed') == 'true') {
                            music.play();
                            document.getElementById("play").src = 'Images/pause.svg';
                        } else {
                            music.pause();
                            document.getElementById("play").src = 'Images/play.svg';
                        }
                    } catch (err) {
                        if (localStorage.getItem('MusicAllowed') == 'true' || localStorage.getItem('MusicAllowed') == 'true') {
                            music.play();
                            document.getElementById("play").src = 'Images/pause.svg';
                        } else {
                            music.pause();
                            document.getElementById("play").src = 'Images/play.svg';
                        }
                    }
                    if (exitsAction == 1) {
                        // ("this line");
                        PrepareGame(false);
                        BeforeEval(localStorage.getItem("temporaryData"));
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                        document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
                        document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
                        document.getElementById("gameBackground").style.webkitFilter = "blur(" + (ProblemsLeft / AllProblemsCount) * 10 + "px)";
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                    } else if (exitsAction == 2) {
                        // ("this line");
                        PrepareGame(false);
                        BeforeEval(localStorage.getItem("temporaryData"));
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                        document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
                        document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
                        document.getElementById("gameBackground").style.webkitFilter = "blur(" + (ProblemsLeft / AllProblemsCount) * 10 + "px)";
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                        clearInterval(Timer);
                        SetTimer(CountdownTime);
                    } else if (exitsAction == 3) {
                        // ("this line");
                        PrepareGame(false);
                        // ('case 3');
                        BeforeEval(localStorage.getItem("temporaryData"));
                        if (AllProblemsCount > ProblemsLeft) {
                            if (currentLang == 'en') {
                                alertify.success('+1 problem');
                            } else {
                                alertify.success('+1 задача');

                            }
                            ProblemsLeft++;
                        }
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                        document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
                        document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
                        document.getElementById("gameBackground").style.webkitFilter = "blur(" + (ProblemsLeft / AllProblemsCount) * 10 + "px)";
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                    } else if (exitsAction == 4) {
                        PrepareGame(false);
                        // ("this line");
                        BeforeEval(localStorage.getItem("temporaryData"));
                        if (AllProblemsCount > ProblemsLeft) {
                            ProblemsLeft++;
                            if (currentLang == 'en') {
                                alertify.success('+1 problem');
                            } else {
                                alertify.success('+1 задача');

                            }
                        }
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                        document.getElementById("overAll").style.width = (((100 * ProblemsLeft) / AllProblemsCount)) + "vw";
                        document.getElementById('rel').innerHTML = ProblemsLeft + "/" + AllProblemsCount;
                        document.getElementById("gameBackground").style.webkitFilter = "blur(" + (ProblemsLeft / AllProblemsCount) * 10 + "px)";
                        document.getElementById('expression').innerHTML = num1 + ' ' + sign + ' ' + num2;
                        clearInterval(Timer);
                        SetTimer(CountdownTime);
                    }
                    BeforeEval(localStorage.getItem("temporaryData"));
                    //Do not continue in any other case!
                    //Start Game generates new number. Should be overwritten
                }
            }
            // (game)
        };
        getLoad();

        function getLoad() {
            try {
                BeforeEval(GetServer());
            } catch (err) {
                alert("There has been an error loading your data! " + err);
            }
            if (document.getElementById('alltxt').children.length == 0) {
                AllSets = [];
            }
            if (GetServer() == "null" || !GetServer()) {
                document.querySelector("#instrumentPanel > div:nth-child(3) > input").value = 10;
                document.querySelector("#instrumentPanel > div:nth-child(4) > input").value = 1;
                document.querySelector("#instrumentPanel > div:nth-child(5) > input").value = 3;
                document.querySelector("#instrumentPanel > div:nth-child(6) > input").value = 100;
                PrintProblems = ["addition", "subtraction"];
                document.querySelector("#addition1").style.backgroundColor = 'green';
                document.querySelector("#subtraction1").style.backgroundColor = 'green';
                document.querySelector("#elements").value = 2;
                return false;
            }
            regulate();
            // document.querySelector("#instrumentPanel > div:nth-child(6) > input").value=PrintAllProblems;
            document.querySelector("#AllCount").value = AllProblemsCount;
            document.querySelector("#Solved").value = AllProblemsCount;
            document.querySelector("#MaxGen").value = MaximumGeneratedNumber;
            document.querySelector("#MinGen").value = MinimumGeneratedNumber;
            document.querySelector("#elements").value = element;
            document.querySelector("#instrumentPanel > div:nth-child(6) > input").value = PrintAllProblems;
            document.querySelector("#instrumentPanel > div:nth-child(5) > input").value = PrintElements;
            document.querySelector("#instrumentPanel > div:nth-child(4) > input").value = PrintMinimum;
            document.querySelector("#instrumentPanel > div:nth-child(3) > input").value = PrintMaximum;
            if (PrintProblems.includes("addition")) {
                document.querySelector("#addition1").style.backgroundColor = 'green';
            } else {
                document.querySelector("#addition1").style.backgroundColor = 'red';
            }
            if (PrintProblems.includes("subtraction")) {
                document.querySelector("#subtraction1").style.backgroundColor = 'green';
            } else {
                document.querySelector("#subtraction1").style.backgroundColor = 'red';
            }
            if (PrintProblems.includes("division")) {
                document.querySelector("#division1").style.backgroundColor = 'green';
            } else {
                document.querySelector("#division1").style.backgroundColor = 'red';
            }
            if (PrintProblems.includes("multiplication")) {
                document.querySelector("#multiplication1").style.backgroundColor = 'green';
            } else {
                document.querySelector("#multiplication1").style.backgroundColor = 'red';
            }
            if (CountdownAllowed == true || CountdownAllowed == 'true') {
                document.querySelector("#timeSwitch").style.background = 'green';
                $("#timePro").show();
            } else {
                document.querySelector("#timeSwitch").style.background = 'red';
                $("#timePro").hide();
            }
            document.querySelector("#timePro").value = CountdownTime;
            document.getElementById("timeAction").selectedIndex = Number(timeAction - 1);
            document.getElementById("ExitsAction").selectedIndex = Number(exitsAction - 1);
            document.getElementById("solvedAction").selectedIndex = Number(solvedAction - 1);
            if (Speech == "true" || Speech == true) {
                document.querySelector("#all").style.backgroundColor = 'green';
                document.querySelector("#AllSpeech").style.display = 'block';
            } else {
                document.querySelector("#AllSpeech").style.display = 'none';
                document.querySelector("#all").style.backgroundColor = 'red';
            }
            for (v in TextareaContent) {
                document.getElementById("h" + AllSets[v]).value = TextareaContent[v];
                document.getElementById("txt" + AllSets[v]).value = TextareaContent[v];
            }
            /*
            if (isValid(new Date(), 00, 00, 12, 00)) {
                for (p in morningArray) {
                    // (p);
                    document.querySelector(("#hidesch" + morningArray[p] + " > button:nth-child(1)")).style.background = 'green';
                    BeforeEval(document.querySelector("#txt" + morningArray[p]).value);
                }
            }
            if (isValid(new Date(), 12, 00, 23, 59)) {
                for (r in afternoonArray) {
                    // (r);
                    document.querySelector(("#hidesch" + afternoonArray[r] + " > button:nth-child(2)")).style.background = 'green';
                    BeforeEval(document.querySelector("#txt" + afternoonArray[r]).value);
                }
            }
            */
            // ("The current Theme is: "+currentTheme);

            $(".hidesch").hide();
            switch (Number(new Date().getDay())) {
                case 1:
                    for (i in MondayArray) {
                        if (morningArray.includes(MondayArray[i])) {
                            if (isValid(new Date(), 00, 00, 12, 00)) {
                                BeforeEval(document.querySelector("#txt" + MondayArray[i]).value);
                                return;
                            }
                        } else if (afternoonArray.includes(MondayArray[i])) {
                            if (isValid(new Date(), 12, 00, 23, 59)) {
                                BeforeEval(document.querySelector("#txt" + MondayArray[i]).value);
                                return;
                            }
                        }
                    }
                    break;
                case 2:
                    for (i in TuesdayArray) {
                        if (morningArray.includes(TuesdayArray[i])) {
                            if (isValid(new Date(), 00, 00, 12, 00)) {
                                BeforeEval(document.querySelector("#txt" + TuesdayArray[i]).value);
                                return;
                            }
                        } else if (afternoonArray.includes(TuesdayArray[i])) {
                            if (isValid(new Date(), 12, 00, 23, 59)) {
                                BeforeEval(document.querySelector("#txt" + TuesdayArray[i]).value);
                                return;
                            }
                        }
                    }
                    break;
                case 3:
                    for (i in WednesdayArray) {
                        if (morningArray.includes(WednesdayArray[i])) {
                            if (isValid(new Date(), 00, 00, 12, 00)) {
                                BeforeEval(document.querySelector("#txt" + WednesdayArray[i]).value);
                                return;
                            }
                        } else if (afternoonArray.includes(WednesdayArray[i])) {
                            if (isValid(new Date(), 12, 00, 23, 59)) {
                                BeforeEval(document.querySelector("#txt" + WednesdayArray[i]).value);
                                return;
                            }
                        }
                    }
                    break;
                case 4:
                    for (i in ThursdayArray) {
                        if (morningArray.includes(ThursdayArray[i])) {
                            if (isValid(new Date(), 00, 00, 12, 00)) {
                                BeforeEval(document.querySelector("#txt" + ThursdayArray[i]).value);
                                return;
                            }
                        } else if (afternoonArray.includes(ThursdayArray[i])) {
                            if (isValid(new Date(), 12, 00, 23, 59)) {
                                BeforeEval(document.querySelector("#txt" + ThursdayArray[i]).value);
                                return;
                            }
                        }
                    }
                    break;
                case 5:
                    for (i in FridayArray) {
                        if (morningArray.includes(FridayArray[i])) {
                            if (isValid(new Date(), 00, 00, 12, 00)) {
                                BeforeEval(document.querySelector("#txt" + FridayArray[i]).value);
                                return;
                            }
                        } else if (afternoonArray.includes(FridayArray[i])) {
                            if (isValid(new Date(), 12, 00, 23, 59)) {
                                BeforeEval(document.querySelector("#txt" + FridayArray[i]).value);
                                return;
                            }
                        }
                    }
                    break;
                case 6:
                    for (i in SaturdayArray) {
                        if (morningArray.includes(SaturdayArray[i])) {
                            if (isValid(new Date(), 00, 00, 12, 00)) {
                                BeforeEval(document.querySelector("#txt" + SaturdayArray[i]).value);
                                return;
                            }
                        } else if (afternoonArray.includes(SaturdayArray[i])) {
                            if (isValid(new Date(), 12, 00, 23, 59)) {
                                BeforeEval(document.querySelector("#txt" + SaturdayArray[i]).value);
                                return;
                            }
                        }
                    }
                    case 0:
                        for (i in SundayArray) {
                            if (morningArray.includes(SundayArray[i])) {
                                if (isValid(new Date(), 00, 00, 12, 00)) {
                                    BeforeEval(document.querySelector("#txt" + SundayArray[i]).value);
                                    return;
                                }
                            } else if (afternoonArray.includes(SundayArray[i])) {
                                if (isValid(new Date(), 12, 00, 23, 59)) {
                                    BeforeEval(document.querySelector("#txt" + SundayArray[i]).value);
                                    return;
                                }
                            }
                        }
                        break;
                    default:
                        // ("An exception occurred!");
            }
            for (i in alwaysArray) {
                BeforeEval(document.querySelector("#txt" + alwaysArray[i]).value);
            }
            if (TrueAllowedTypes.includes("Addition")) {
                document.querySelector("#Addition").style.background = 'green'
            } else {
                document.querySelector("#Addition").style.background = 'red'
            }
            if (TrueAllowedTypes.includes("Subtraction")) {
                document.querySelector("#Subtraction").style.background = 'green'
            } else {
                document.querySelector("#Subtraction").style.background = 'red'
            }
            if (TrueAllowedTypes.includes("Multiplying")) {
                document.querySelector("#Multiplying").style.background = 'green'
            } else {
                document.querySelector("#Multiplying").style.background = 'red'
            }
            if (TrueAllowedTypes.includes("Division")) {
                document.querySelector("#Division").style.background = 'green'
            } else {
                document.querySelector("#Division").style.background = 'red'
            }
            if (SpeechInput == false || SpeechInput == "false") {
                document.getElementById("input").style.backgroundColor = 'red';
            } else {
                document.getElementById("input").style.backgroundColor = 'green';
            }
            if (SpeechOutput == false || SpeechOutput == "false") {
                document.getElementById("speech").style.backgroundColor = 'red';
            } else {
                document.getElementById("speech").style.backgroundColor = 'green';
            }
            check();
            document.querySelector("#url").value = url;
            //AllProblemsCount=AllAllProblemsCount;
            document.querySelector("#AllCount").value = AllProblemsCount;
            if (CountdownAllowed == true || CountdownAllowed == "true") {
                document.getElementById('timeSwitch').style.background = 'green';
                document.getElementById('timeSwitch').innerHTML = 'Click to turn off';
                $('#timePro').show();
            } else {
                document.getElementById('timeSwitch').style.background = 'red';
                $('#timePro').hide();
                document.getElementById('timeSwitch').innerHTML = 'Click to turn on';
            }
            document.querySelector("#Solved").value = ProblemsLeft;
            $(".highcharts-container").hide()
            $('table').highchartTable();
            load();
            density2(density);
            confirmWhite();
        }

        $("body").show();
        $("#overlay").hide();

        function isValid(date, h1, m1, h2, m2) {
            var h = date.getHours();
            var m = date.getMinutes();
            return (h1 < h || h1 == h && m1 <= m) && (h < h2 || h == h2 && m <= m2);
        }
        getLoad();

        function confirmWhite() {
            if (currentTheme == 'white') {
              document.querySelector("#help").style.color='black';
                $('#sidePanelBackground').css("background-image", "url(WhiteDashboard.jpg)");
                $('.window').css("background-color", "#F8F8F8");
                $('#moreSettings > center > h1').css("color", "black");
                $('div.explain').css("color", "black");
                $('div.explain').css("background-color", "white");
                $('div#instrumentPanel').css("background-color", "white");
                $('div#instrumentPanel p').css("color", "black");
                $('#block').css("background-color", "white");
                $('#block').css("color", "black");
                $('div#alltxt > div').css("background-color", "white");
                $('div#alltxt > div > textarea').css("background-color", "white");
                $('div#alltxt > div > textarea').css("color", "black");
                $('div#alltxt > div > input').css("background-color", "white");
                $('div#alltxt > div > input').css("color", "black");
                $('.f').css("background-color", "white");
                $('.f').css("color", "black");
                $('select').css("background", "white");
                $('select').css("color", "black");
                $('fieldset').css("background-color", "white");
                $('#theme').css("background-color", "white");
                $('#theme').css("color", "black");
                $('#language').css("background-color", "black");
                $('#language').css("color", "white");
                $('fieldset').css("color", "black");
                $('fieldset>input').css("background-color", "white");
                $('fieldset>input').css("color", "black");
                $('fieldset>input').css("border-bottom", "1px solid black");
                $('button#new').css("background-color", "white");
                $('button#new').css("color", "black");
                $('button#export').css("background-color", "white");
                $('button#export').css("color", "black");
                $('button.downloadAll').css("background-color", "white");
                $('button.downloadAll').css("color", "black");
                $('th').css("background-color", "white");
                $('th').css("color", "black");
                $('.aa').css("background-color", "white");
                $('.aa').css("color", "black");
                $('.aa').css("border", "1px solid black");
                $('div#advancedPrint').css("background-color", "white");
                $('div#advancedPrint').css("color", "black");
                $('#myRange').css("background-color", "black");
                $('.sp').css("color", "black");
                $('.sp').css("background-color", "white");
                $('.sp').css("border-radius", "0");
                $('.sp').css("border-bottom", "1px solid black");
                $('.problem aa').css("border", "none");
                $('#TextDiv > center > div.slidecontainer > p').css("color", "black");
                currentTheme = 'white';
                $('button.f').css("color", "black");
                $('button.f').css("background-color", "white");
                $('div#alltxt > div > textarea').css("background-color", "white");
                $('div#alltxt > div > input').css("background-color", "white");
                $('div#alltxt > div').css("background-color", "white");
                $('div#alltxt > div > textarea').css("color", "black");
                $('div#alltxt > div > input').css("color", "black");
                $('div#alltxt > div').css("color", "black");
                $('tr:nth-child(even)').css("background-color", "#F5F5F5");
                $('tr:nth-child(even)').css("color", "black");
                $('tr:nth-child(odd)').css("background-color", "#C8C8C8");
                $('tr:nth-child(odd)').css("color", "black");
            } else {
                // ("No theme change applied")
            }
        }

    </script>
    <form id='special' target="_blank" method="post" action="insert.php">
        <input type="text" id='data' name="data" required>
        <br>
        <br>
        <input id='submit' type="submit" value="Submit"> </form>
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-594dbbe50ec22c36"></script>
</body>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-99190836-2"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'UA-99190836-2');

</script>


</html>
