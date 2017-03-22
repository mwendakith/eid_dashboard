function format_date(data)
	{
		date = data.split(" ");
		var month = date[0];
	    month = month.toLowerCase();
	    var months = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
	    month = months.indexOf(month)+1;
		
		return [month, date[1]];
	}

function set_multiple_date(first, second){
	var f = first.split(" ");
	var s = second.split(" ");
	return f[0] + "-" + s[0] + " " + f[1];
}