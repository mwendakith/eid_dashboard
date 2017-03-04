function format_date(data)
	{
		date = data.split(" ");
		var month = date[0];
	    month = month.toLowerCase();
	    var months = ["january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december"];
	    month = months.indexOf(month)+1;
		
		return [month, date[1]];
	}