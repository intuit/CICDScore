function calculate(argument) {
	//document.getElementById('result').innerHTML="OK";
	inps = document.getElementsByTagName('input');
	score = 0;
	comp = "";
	for (var i = 0; i < inps.length; i++) {
		if(inps[i].type == "checkbox")
		{
			if (inps[i].checked)
			{
				score += parseInt(inps[i].value);
				comp+='1';
			}
			else
				comp+='0';
		}
	}
	var res = "";
	var gifdiv = document.getElementById('gif-div');
	gifdiv.innerHTML = "";
	var gif = document.createElement('img');
	gif.height = '170';
	gif.width = '170';
	div = document.getElementById('result');
	div.style.height = "70px";
	if(score >= 90)
	{
		res = "Your score is "+score+". You have earned the <b>&quot;Fly badge!&quot;</b> <br> Hi 5! You are practicing CICD";
		div.style.backgroundColor = "#1abc9c";
		div.style.color="white";
		gif.src = 'img/fly.gif';
		
	}
	else if(score >=70 && score <=89)
	{
		//diff = 80-score;
		res = "Your score is "+score+". You have earned the <b>&quot;Advanced badge!&quot;</b> <br> Solid foundation, Practicing CICD";
		div.style.backgroundColor = "#2980b9";
		div.style.color="white";
		gif.src = 'img/advanced.gif';
	}
	else if(score >=45 && score <=69)
	{
		//diff = 60-score;
		res = "Your score is "+score+". You have earned the <b>&quot;Skilled badge!&quot;</b> <br> You are probably halfway through to CICD";
		div.style.backgroundColor = "#f1c40f";
		div.style.color="black";
		gif.src = 'img/skilled.gif';
	}
	else if(score >=27 && score <=44)
	{
		//diff = 25-score;
		res = "Your score is "+score+". You have earned the <b>&quot;Ready to Fly badge!&quot;</b> <br> Your prerequisites to get into CICD is completed";
		div.style.backgroundColor = "#e67e22";
		div.style.color="white";
		gif.src = 'img/ready to fly.gif';
	}
	else
	{
		//diff = 15-score;
		res = "Your score is "+score+". You have earned the <b>&quot;Newbie badge!&quot;</b> <br> You have realized the need for CICD";
		div.style.backgroundColor = "#c0392b";
		div.style.color="white";
		gif.src = 'img/newbie.gif';
	}
	div.innerHTML=res;
	gifdiv.appendChild(gif);
        window.scrollBy(0,275);
    return score;
}

function get_badge(score)
{
        var res = "";
        if(score >= 90)
        {
                res = "Your score is "+score+". You have earned the <b>&quot;Fly badge!&quot;</b> <br> Hi 5! You are practicing CICD";
                return 'Fly'

        }
        else if(score >=70 && score <=89)
        {
                //diff = 80-score;
                res = "Your score is "+score+". You have earned the <b>&quot;Advanced badge!&quot;</b> <br> Solid foundation, Practicing CICD";
                return 'Advanced'
        }
        else if(score >=45 && score <=69)
        {
                //diff = 60-score;
                res = "Your score is "+score+". You have earned the <b>&quot;Skilled badge!&quot;</b> <br> You are probably halfway through to CICD";
                return 'Skilled'
        }
        else if(score >=27 && score <=44)
        {
                //diff = 25-score;
                res = "Your score is "+score+". You have earned the <b>&quot;Ready to Fly badge!&quot;</b> <br> Your prerequisites to get into CICD is completed";
                return 'Ready_to_Fly'
        }
        else
        {
                //diff = 15-score;
                res = "Your score is "+score+". You have earned the <b>&quot;Newbie badge!&quot;</b> <br> You have realized the need for CICD";
                return 'Newbie'
        }
}

function reset() 
{
	inps = document.getElementsByTagName('input');

	document.getElementById('result').innerHTML="";
	document.getElementById('result').style.backgroundColor = "white";
	score = 0;
	url = window.location.href ;
	document.location.href = url ;
	/*
	for (var i = 0; i < inps.length; i++) 
	{
		if(inps[i].type == "checkbox")
		{
			if(!inps[i].disabled)
				inps[i].checked = false;
		}
	}
	var gifdiv = document.getElementById('gif-div');
	gifdiv.innerHTML = "";*/
}

/*function create_chart()
{
	$.ajax({
		url: 'get_data.php?app='+
	});
	var data = {
    labels: ["Q1", "Q2", "Q3"],
    datasets: [
        {
            label: "CICD Journey",
            fill: false,
            lineTension: 0.1,
            backgroundColor: "rgba(75,192,192,0.4)",
            borderColor: "rgba(75,192,192,1)",
            borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
            pointBorderColor: "rgba(75,192,192,1)",
            pointBackgroundColor: "#fff",
            pointBorderWidth: 1,
            pointHoverRadius: 5,
            pointHoverBackgroundColor: "rgba(75,192,192,1)",
            pointHoverBorderColor: "rgba(220,220,220,1)",
            pointHoverBorderWidth: 2,
            pointRadius: 1,
            pointHitRadius: 10,
            data: [13,36,101],
            spanGaps: false,
        }
    ]
};
	var ctx = document.getElementById("myChart");
	var myLineChart = new Chart(ctx, {
    type: 'line',
    data: data,
});

}*/



function uncheck_prev(event,type)
{
	if ( type == "deploy" )
	{
		if (event.target.checked)
			document.getElementsByTagName('input')[18].checked=false
	//	else
	//		document.getElementsByTagName('input')[18].checked=true
	}
	else if ( type == "git" )
	{
		if (event.target.checked)
                        document.getElementsByTagName('input')[16].checked=false
         //       else
           //             document.getElementsByTagName('input')[16].checked=true
	}
}

exports._test2 = {
    get_badge: get_badge
}
