var Setup = {
	run: function() {
		$.ajax("run-setup");
	},
	checkProgress: function() {
		var runInterval = setInterval(function() {
			$.getJSON("progress.json?" + (Math.random(10000000) * 10000000 + 1), function(json) {
				console.log(json);
				$(".progress").html(json);
				if (json == "Done.") {
					clearInterval(runInterval);
					$(".progress").append(" Hit back!");
				}
			})
		}, 1000);
	}
};

var Form = {
	submit: function(e) {
		e.preventDefault();
		var company_symbol = this.validateField("company_symbol");
		console.log(company_symbol);
		var start_date = this.validateField("start_date");
		console.log(start_date);
		var end_date = this.validateField("end_date");
		console.log(end_date);
		var email = this.validateField("email");
		console.log(email);
		
		if (company_symbol && start_date && end_date && email) {
			var request = $.ajax({
				method: "POST",
				url: "submit-form",
				data: {
					company_symbol: company_symbol,
					start_date: start_date,
					end_date: end_date,
					email: email
				},
				headers: {
					"X-CSRF-TOKEN": $("meta[name=\"csrf-token\"]").attr("content")
			    }
			});
			request.done(function(data) {
				$(".result").html(data);
			});
			request.fail(function(jqXHR, textStatus, errorThrown){
				console.log(jqXHR.responseJSON);
				$(".result").html("");
				for (var k in jqXHR.responseJSON) {
					console.log(jqXHR.responseJSON[k]);
					$(".result").html($(".result").html() + "<br>" + jqXHR.responseJSON[k]);
					$("#" + k).addClass("error");
				}
			});
		}
		
		return false;
	},
	validateField: function(fieldName) {
		var error = false;
		var field = $("#" + fieldName).val();
		if (field == "") {
			error = true;
			$("#" + fieldName).addClass("error");
			$("#" + fieldName).keypress(function() {
				$("#" + fieldName).removeClass("error");
			});
		}
		else {
			$("#" + fieldName).removeClass("error");
		}
		
		if (error) return false;
		
		return field;
	}
};