<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
  header("location: ../public/login.php");
  exit;
}

?>

<!DOCTYPE html>
<html>

<head>
  <title>Create Survey</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link href="../css/private.creationform.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <?php include "../shared/navbar.php" ?>
  <div class="create-survey-form">
    <div class="container">
      <h1>Create Survey</h1>
      <form id="create-survey-form" method="post" action="../includes/create-survey.inc.php">
        <div class="form-group">
          <label for="survey-name">Survey Name</label>
          <input type="text" id="survey-name" name="survey_name">
        </div>
        <div class="form-group">
          <label for="question-type">Question Type</label>
          <select id="question-type">
            <option value="text">Text</option>
            <option value="multiple_choice">Multiple Choice</option>
          </select>
        </div>
        <div class="form-group">
          <label for="question-text">Question Text</label>
          <input type="text" id="question-text">
          <span class="error" id="question-add-error"></span>
        </div>
        <div class="form-group" id="options-group" style="display: none;">
          <div class="options-btns">
            <button type="button" id="add-option" class="btn btn-option">Add Option</button>
            <button type="button" id="remove-option" class="btn btn-remove-option" style="display: none;">Remove
              Option</button>
          </div>

          <div id="options-container"></div>
          <span class="error" id="options-error"></span>
        </div>
        <button type="button" id="add-question" class="btn btn-question">Add Question</button>
        <div class="survey-preview" id="preview"></div>

        <button type="submit" id="submit-survey" class="btn btn-submit" style="display: none;">Submit Survey</button>
      </form>
      <?php
      if (isset($_GET["error"])) {
        switch ($_GET["error"]) {
          case "invalidinput":
            echo "<p class=error>Please fill in all fields.</p>";
            break;
          default:
            break;
        }
      }
      ?>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      var questionCount = 1;
      var questionType;

      // Switch Question Type
      $('#question-type').on('change', function () {
        questionType = $(this).val();
        if (questionType == 'multiple_choice') {
          $('#options-group').show();
          while ($('#options-container').children().length != 2) {
            if ($('#options-container').children().length < 2) {
              addOption();
            } else removeOption();
          }
          console.log(typeof $('#options-container').children().length);

        } else {
          questionType = 'text';
          while ($('#options-container').children().length > 0) removeOption();
          $('#options-group').hide();
        }
      });

      // Add option to question
      $('#add-option').on('click', addOption);

      function addOption() {
        var optionCount = $('#options-container').children().length + 1;
        var optionHtml = '<div class="form-group option-group">';
        optionHtml += '<label for="option-' + optionCount + '">Option ' + String.fromCharCode(optionCount + 64) + '</label>';
        optionHtml += '<input type="text" id="option-' + optionCount + '">';
        optionHtml += '</div>';
        $('#options-container').append(optionHtml);
        if ($('#options-container').children().length > 2) {
          $('#remove-option').show();
        }
      }

      // Remove option from question
      $('#remove-option').on('click', removeOption);

      function removeOption() {
        $('#options-container').children().last().remove();
        if ($('#options-container').children().length == 2) {
          $('#remove-option').hide();
        }
      }

      // Add question to survey
      $('#add-question').on('click', function () {
        var questionText = $('#question-text').val();

        // ERROR- no question text
        if (!questionText) {
          $('#question-add-error').html("The question must have text.");
          return;
        }
        var type = $('#question-type').val();
        // ERROR- each option must have text
        console.log(type);
        let isOptionError = false;
        if (type == 'multiple_choice') {
          $('#options-container').children().each(function () {
            if (!$(this).children('input').val()) {
              isOptionError = true;
            }
          });
        }
        if (isOptionError) {
          $('#options-error').html("Each option must have text");
          return;
        }

        var questionHtml = '<div class="form-group question-group">';
        questionHtml += '<h2>Question ' + questionCount + ": " + questionText + '</h2>';
        questionHtml += '<input type="hidden" name="question_type[]" value="' + type + '">';
        questionHtml += '<input type="hidden" name="question_text[]" value="' + questionText + '">';
        var optionsHtml = '';
        // for multiple choice questions, output question and each option
        if ($('#question-type').val() == 'multiple_choice') {
          var optionIndex = 1;
          $('.option-group input').each(function () {
            var optionLetter = String.fromCharCode(optionIndex + 64);
            optionsHtml += '<input type="hidden" name="question_options[]" value="' + $(this).val() + '">';
            optionsHtml += '<div class="form-group">';
            optionsHtml += '<div  id="option-' + questionCount + '-' + optionIndex + '" value="' + optionLetter + '">';
            optionsHtml += '<p id="option-' + questionCount + '-' + optionIndex + '">' + optionLetter + '.) ' + $(this).val() + '</label>';
            optionsHtml += '</div></div>';
            optionIndex++;
          });
          optionsHtml += '<input type="hidden" name="options_count[]" value="' + (optionIndex - 1) + '">';
        }
        // only output question if text type question (free response)
        else if ($('#question-type').val() == 'text') {
          optionsHtml += '<input type="hidden" name="question_options[]" value="NULL">';
          optionsHtml += '<input type="hidden" name="options_count[]" value="1">';
          questionHtml += '</div>';
        }
        questionHtml += optionsHtml;
        questionHtml += '</div>';
        $('#preview').append(questionHtml);
        $('#submit-survey').show();
        questionCount++;
        $('#question-text').val('');
        $('#survey-name').prop('readonly', true);
      });
    });
  </script>
</body>

</html>