var addRow = function(num) {
    var newDiv = $("<div></div>");
    newDiv.attr('id', "bucketRow"+num);
    newDiv.attr('class', "bucketRow");
    $("#bucketContainers").append(newDiv);
};
var initBucket = function(bucketNum, capacity) {
	var rowNum = Math.floor((bucketNum-1)/4)+1;
	if (!$("#bucketRow"+rowNum).is('*')) {
		addRow(rowNum);
	}
    var newDiv = $("<div></div>");
    newDiv.addClass("bucketValue");
    newDiv.attr('id', "bucketValue"+bucketNum);
    newDiv.css("height", capacity*50);	
    newDiv.css("left", ((bucketNum-1 % 4))*220);
    var textVal = '<span id="text'+bucketNum+'">0</span>/'+capacity+' Gallons';
    var newText = $("<div>Bucket "+bucketNum+": "+textVal+"</div>");
    newText.addClass("bucketText");
    newText.attr('id', "bucketText"+bucketNum);
    newText.css("left", ((bucketNum-1 % 4))*220);
    $("#bucketRow"+rowNum).prepend(newDiv);
    $("#bucketRow"+rowNum).prepend(newText);
};
var clearResponses = function() {
    $('#emailSection').css("visibility", "hidden");
    $('#emailResponse').empty();
};
var fillBucket = function(bucketNum, current) {
    var elementHeight = 50;
    $("#bucketValue"+bucketNum).empty();
    for (var x=0; x<current; x++) {
        var newDiv = $("<div></div>");
        newDiv.addClass("bucketSpace");
        newDiv.css('height', elementHeight);
        newDiv.css('bottom', x*elementHeight);
        $("#bucketValue"+bucketNum).prepend(newDiv.hide().fadeIn());
    }
    $("#text"+bucketNum).text(current);
};
var displayResult = function(solutionSteps) {
    setTimeout(
        function(){
            step = solutionSteps.shift();
            for (var x=1; x<=$("#bucketNum").val(); x++) {
                fillBucket(x, step[x]);
            }
            if (solutionSteps.length > 0) {
                displayResult(solutionSteps);
            } else {
            	$('#emailSection').css("visibility", "visible");
            }
        }, 3000
    )
};
