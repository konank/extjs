function weatherGeocode(search,output) {
    
		var status;
		var results;
		var html = '';
		var msg = '';

		// Set document elements
		var search = search
		var output = document.getElementById(output);

		if (search) {
			output.innerHTML = '';

			// Cache results for an hour to prevent overuse
			now = new Date();

			// Create Yahoo Weather feed API address
			var query = 'select * from geo.places where text="'+ search +'"';
			var api = 'http://query.yahooapis.com/v1/public/yql?q='+ encodeURIComponent(query) +'&rnd='+ now.getFullYear() + now.getMonth() + now.getDay() + now.getHours() +'&format=json&callback=?';

			// Send request
			$.ajax({
				type: 'GET',
				url: api,
				dataType: 'json',
				success: function(data) {
					if (data.query.count > 0 ) {						
                            _getWeatherAddress(data.query.results.place);
					} else {
						output.innerHTML = 'The location could not be found';
					}
				},
				error: function(data) {
					output.innerHTML = 'An error has occurred';
				}
			});

		} else {

			// No search given
			output.innerHTML = 'Please enter a location or partial address';
		}
	}
    
    function _getWeatherAddress(data) {

		// Get address
		var address = data.name;
		if (data.admin2) address += ', ' + data.admin2.content;
		if (data.admin1) address += ', ' + data.admin1.content;
		address += ', ' + data.country.content;

		// Get WEOID
		var woeid = data.woeid;
        $('#weatherReport').weatherfeed([woeid],{
			woeid: true
		});
        
    }