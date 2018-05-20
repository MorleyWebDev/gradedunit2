<!DOCTYPE html>
<html lang="en">
	<head>
						<?php require('threebg.php'); ?>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <title>Chatbot</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="botstyle.css">

  </head>
	  </html>

<body>
  <a href="javascript:history.back()"><button type="button" class="botBack" name="button">Back</button></a>
	<div id="output"></div>
	<div class="container botContainer">
			<input	id="input" type="text"	placeholder="Start typing!" class="botInputs botUserInput" autocomplete="off" />
			<button class="botInputs" id="rec">Speak</button>
			<button class="botInputs" id="clearChat">Clear Chat</button>
	</div>

</body>




  <script type="text/javascript">
  	var output = document.getElementById('output');
    var accessToken ="7951cae54e344503883199507d26264b";
    var baseUrl = "https://api.dialogflow.com/v1/";

  	$(document).ready(function() {
  	  $("#input").keypress(function(event) {
  	    if (event.which == 13) {
  	      event.preventDefault();
  	      send();
  				this.value = '';
  	    }
  	  });
  	$("#rec").click(function(event) {
			event.preventDefault();
			send();
			this.value = '';
  	});
  });

	$('#clearChat').click(function(event){
		console.log('ClearChat');
		$("#output").empty();
	})

    var recognition;
    function startRecognition() {
  	  recognition = new webkitSpeechRecognition();
  	  recognition.onstart = function(event) {
  	      updateRec();
  		};
      recognition.onresult = function(event) {
          var text = "";
          for (var i = event.resultIndex; i < event.results.length; ++i) {
              text += event.results[i][0].transcript;
          }
          setInput(text);
          stopRecognition();
  		};
      recognition.onend = function() {
          stopRecognition();
      };
      recognition.lang = "en-US";
      recognition.start();
  	}
      function stopRecognition() {
          if (recognition) {
              recognition.stop();
              recognition = null;
          }
          updateRec();
      }
      function switchRecognition() {
          if (recognition) {
              stopRecognition();
          } else {
              startRecognition();
          }
      }
      function setInput(text) {
          $("#input").val(text);
          send();
      }
      function updateRec() {
          $("#rec").text(recognition ? "Stop" : "Speak");
      }
  function send() {
          var text = $("#input").val();
    //  conversation.push("Me: " + text + '\r\n');
  				output.innerHTML += "<p id='meSmile'>Me: " + text + "</p>";
          $.ajax({
              type: "POST",
              url: baseUrl + "query?v=20150910",
              contentType: "application/json; charset=utf-8",
              dataType: "json",
              headers: {
                  "Authorization": "Bearer " + accessToken
              },
              data: JSON.stringify({ query: text, lang: "en", sessionId: "somerandomthing" }),
              success: function(data) {
                  var respText = data.result.fulfillment.speech;
                  console.log("response: " + respText);
                  setResponse(respText);
                  $("#response").scrollTop($("#response").height());
              },
              error: function() {
                  setResponse("can't connect to df server");
              }
          });
      }
      function setResponse(val) {
          // conversation.push("museumBot: " + val + '\r\n');
          // $("#response").text(conversation.join(""));
  				output.innerHTML += "<p id='botSmile'>Bot : " +  val + "</p>";
      }
      var conversation = [];

  </script>
