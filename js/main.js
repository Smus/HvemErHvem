/** http://ricostacruz.com/jquery.transit/ **/
/** https://github.com/rstacruz/jquery.transit#readme **/
var totalPoints = 0;
var randomNumber = 0;
var cardArray = [];
var realtime = 60000;

$(document).ready(function() {
  $('#sek').html(realtime / 1000);
  $('#name0').unbind("click");
  $('#name1').unbind("click");
  $('#name2').unbind("click");
  $('#name3').unbind("click");
  newGame();

});

function nulstil() {
  totalPoints = 0;
  $('.pValue').html(totalPoints);
  $(".timerInner").css('width', '100%');
  $(".timerInner").css('background-color', '#1be861');
  $(".timerInner").css('borderColor', '#1be861');
  randomNumber = 0;
}

function newGame() {
  var RandomNumber = getRandom(0, 3);
  picknames(RandomNumber, 1, employees); // vælger nye kort
  clicks(RandomNumber);
}

function clicks(number) {
  var rigtignavn = $('#name' + number).html();
  $('#name' + number).click(function() {
    correctAnswer(number, rigtignavn);
    postdata(rigtignavn, "correct");
  });
  $('#name' + number).siblings().click(function() {
    wrongAnswer(this.id);
    postdata(rigtignavn, "wrong");
  });
}

//Correct answer and points
function correctAnswer(x, correctName) {
  calcPoint(1);
  $('#name' + x).addClass('correct') //lav grøn
    //remove correct object from array
  employees = employees.filter(function(returnableObjects) {
    return returnableObjects.Name !== correctName;
  });
  setTimeout(function() {
    $('.correct').removeClass('correct'); //fjern grøn
    nextQuestion(); //næste  spørgsmål
  }, 1000);
}

//Correct answer and points
function wrongAnswer(id) {
  //calcPoint(-1);
  $('#' + id).addClass('wrong')
  setTimeout(function() {
    $('.wrong').removeClass('wrong');
    nextQuestion();
  }, 1000);
}

//Random number
function getRandom(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

// Sets json into a variable
var employees = (function() {
  var employees = null;
  $.ajax({
    'async': false,
    'global': false,
    'url': 'json/employees.json',
    'dataType': "json",
    'success': function(data) {
      employees = data;
    }
  });
  return employees;
})();

//Get new cards
function picknames(number, gametype, jd) {
  //Gametype, 1=gender, 2=titler
  if (gametype == 1) { //gender
    var chooseGender = getRandom(1, 2);
    console.log("Gender: " + chooseGender);
    if (chooseGender == 1) {
      var picks = $.grep(jd, function(n, i) {
        return n.Gender === 'Female';
      });
    } else {
      var picks = $.grep(jd, function(n, i) {
        return n.Gender === 'Male';
      });
    }
  } else if (gametype == 2) { // Names-Titel
  } else {};

  cardArray = shuffleArray(picks); //byt rundt på rækkefølgende
  cardArray.length = 4; // get 4 random elements

  $('#image img').attr('src', 'crawl/' + cardArray[number].Image);
  for (var i = 0; i < cardArray.length; i++) {
    $('#name' + i).html(cardArray[i].Name);
    console.log("Navn: " + cardArray[i].Name);
  }
}

//Random array
function shuffleArray(array) {
  var counter = array.length,
    temp, index;
  while (counter--) {
    index = (Math.random() * counter) | 0;
    temp = array[counter];
    array[counter] = array[index];
    array[index] = temp;
  }
  return array;
}

//Calculate total points
function calcPoint(point) {
  totalPoints = totalPoints + point
  $('.pValue').html(totalPoints);
}

//Next question
function nextQuestion() {
  var female1;
  var male1;
  female1 = employees.filter(function(returnableObjects) {
    return returnableObjects.Gender == "Female";
  });
  male1 = employees.filter(function(returnableObjects) {
    return returnableObjects.Gender == "Male";
  });
  if (female1.length == 4 || male1.length == 4) {
    stopgame();
  } else {
    newGame();
  }
}

//progressbar
var time = realtime / 2;

//Start timer
function startTimer() {
    $(".timerInner").animate({
        width: "50%",
        backgroundColor: "#e8d71b",
			  borderColor: "#e8d71b"
    }, time, 'linear', function () {
        part2();
    });
}

function part2() {
  $(".timerInner").animate({
    width: "0%",
    backgroundColor: "#e8381b",
    borderColor: "#e8381b"
  }, time, 'linear', function() {
    stopTimer();
  });
}

//End progressbar
function stopTimer() {
  $(".timerInner").stop(true, true);
  stopgame();
};

//Post to db
function postdata(name, answer) {
  $('#name0').unbind("click");
  $('#name1').unbind("click");
  $('#name2').unbind("click");
  $('#name3').unbind("click");
  $.ajax({
    url: "db/postdata.php",
    type: "POST",
    data: {
      name: name,
      answer: answer
    },
    success: function(data) {
      console.log("respons: " + data);
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
    }
  });
}

// Start quiz
$('.startquiz').click(function(event) {
  $('.active').removeClass('active');
  $('.stage2').addClass('active');
  startTimer();
});
$('.quizigen').click(function(event) {
  nulstil();
  newGame();
  startTimer();
  $('.active').removeClass('active');
  $('.stage2').addClass('active');

});
$('.statistik').click(function(event) {
  var url = "stat.php";
  $(location).attr('href', url);
});

$('.tilbagetilquiz').click(function(event) {
  var url = "index.php";
  $(location).attr('href', url);
});



//Stop quiz
function stopgame() {
  $('.active').removeClass('active');
  $('.stage3').addClass('active');
};
