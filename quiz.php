<?php
	include("includes/header.html");
?>
<hr>
<div class="form-quiz">
	<form action="quiz.php" method="POST">
		<fieldset class="form-group">
	    <legend>What does the acronym USB stand for when referring to a computer port?</legend>
	    <div class="form-check">
	      <label class="form-check-label">
	        <input type="radio" class="form-check-input" name="optionsRadios1" id="optionsRadios1" value="option1" checked>
	          Universal Serial Bus
	      </label>
	    </div>
	    <div class="form-check">
	    <label class="form-check-label">
	        <input type="radio" class="form-check-input" name="optionsRadios1" id="optionsRadios2" value="option2">
	          Universal Super Bus
	      </label>
	    </div>
	    <div class="form-check">
	    <label class="form-check-label">
	        <input type="radio" class="form-check-input" name="optionsRadios1" id="optionsRadios3" value="option3">
	          Unicode Serial Boss
	      </label>
	    </div>
	  </fieldset>
	  <fieldset class="form-group">
	    <legend>What does the acronym USB stand for when referring to a computer port?</legend>
	    <div class="form-check">
	      <label class="form-check-label">
	        <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios4" value="option1" checked>
	          Universal Serial Bus
	      </label>
	    </div>
	    <div class="form-check">
	    <label class="form-check-label">
	        <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios5" value="option2">
	          Universal Super Bus
	      </label>
	    </div>
	    <div class="form-check">
	    <label class="form-check-label">
	        <input type="radio" class="form-check-input" name="optionsRadios2" id="optionsRadios6" value="option3">
	          Unicode Serial Boss
	      </label>
	    </div>
	  </fieldset>
	  <input type="submit" class="btn btn-success" />
	</form>
</div>
<hr>
<?php
	include("includes/footer.html");
?>