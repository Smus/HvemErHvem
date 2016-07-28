
<!doctype html>
<html lang="da-dk">
<?php
// automatik reload json fead hver 100 spil, eller en gang om måndeden
?>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=utf-8" />
      <title>Quiz</title>
      <link href="http://hjaltelinstahl.com/templates/lauritzz/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
      <link rel="stylesheet" href="css/master.css" media="screen" title="no title" charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  </head>

  <body>
      <div class="start stage1 boxer active">
          <h1>Hvem er hvem</h1>
          <p>Hvor mange af dine kollegaer kender du navnet på? Du har <span id="sek">0</span> sekunder til at gætte så mange som muligt</p>
          <div class="buttons startquiz">
              Start quizzen
          </div>
      </div>
      <div class="scoreboard stage2">
          <div id="totalpoints" class="point">
              POINT:
              <span class="pValue">0</span>
          </div>
          <div class="timerOuter">
              <div class="timerInner" style="width:100%;height:20px; background-color:#1be861;margin-top:5px;">
              </div>
          </div>
      </div>
      <div class="quizcard stage2 boxer">
          <div id="image">
              <img src="" data-name="">
          </div>
          <div id="name0" class="buttons"></div>
          <div id="name1" class="buttons"></div>
          <div id="name2" class="buttons"></div>
          <div id="name3" class="buttons"></div>
      </div>
      <div class="finish stage3 boxer">
          <h1>Slut</h1>
          <p>
              Du fik <span class="pValue">0</span> rigtige
          </p>
          <div class="buttons quizigen">Quiz igen</div>
          <div class="buttons statistik">Se statistik</div>
      </div>
      <script src="lib/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="lib/jquery.transit.min.js" type="text/javascript"></script>
      <script src="js/main.js" type="text/javascript"></script>
  </body>
</html>
