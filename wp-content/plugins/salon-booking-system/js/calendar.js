/**
 * Bootstrap based calendar full view.
 *
 * https://github.com/Serhioromano/bootstrap-calendar
 *
 * User: Sergey Romanov <serg4172@mail.ru>
 */
"use strict";
var sln_stats = [];
var sln_assistants = {};
var sln_assistants_order = [];
Date.prototype.getWeek = function() {
	var onejan = new Date(this.getFullYear(), 0, 1);
	return Math.ceil(
		((this.getTime() - onejan.getTime()) / 86400000 + onejan.getDay() + 1) /
		7
	);
};
Date.prototype.getMonthFormatted = function() {
	var month = this.getMonth() + 1;
	return month < 10 ? "0" + month : month;
};
Date.prototype.getDateFormatted = function() {
	var date = this.getDate();
	return date < 10 ? "0" + date : date;
};
if (!String.prototype.format) {
	String.prototype.format = function() {
		var args = arguments;
		return this.replace(/{(\d+)}/g, function(match, number) {
			return typeof args[number] != "undefined" ? args[number] : match;
		});
	};
}
if (!String.prototype.formatNum) {
	String.prototype.formatNum = function(decimal) {
		var r = "" + this;
		while (r.length < decimal) r = "0" + r;
		return r;
	};
}

(function($) {
	var defaults = {
		// Width of the calendar
		width: "100%",
		// Initial view (can be 'month', 'week', 'day')
		view: "month",
		// Initial date. No matter month, week or day this will be a starting point. Can be 'now' or a date in format 'yyyy-mm-dd'
		day: "now",
		// Day Start time and end time with time intervals. Time split 10, 15 or 30.
		time_start: "06:00",
		time_end: "22:00",
		time_split: "30",
		// Source of events data. It can be one of the following:
		// - URL to return JSON list of events in special format.
		//   {success:1, result: [....]} or for error {success:0, error:'Something terrible happened'}
		//   events: [...] as described in events property description
		//   The start and end variables will be sent to this url
		// - A function that received the start and end date, and that
		//   returns an array of events (as described in events property description)
		// - An array containing the events
		events_source: "",
		// Path to templates should end with slash /. It can be as relative
		// /component/bootstrap-calendar/tmpls/
		// or absolute
		// http://.../component/bootstrap-calendar/tmpls/
		tmpl_path: "tmpls/",
		tmpl_cache: true,
		classes: {
			months: {
				inmonth: "cal-day-inmonth",
				outmonth: "cal-day-outmonth",
				saturday: "cal-day-weekend",
				sunday: "cal-day-weekend",
				holidays: "cal-day-holiday",
				today: "cal-day-today",
			},
			week: {
				workday: "cal-day-workday",
				saturday: "cal-day-weekend",
				sunday: "cal-day-weekend",
				holidays: "cal-day-holiday",
				today: "cal-day-today",
			},
		},
		// ID of the element of modal window. If set, events URLs will be opened in modal windows.
		modal: null,
		//	modal handling setting, one of "iframe", "ajax" or "template"
		modal_type: "iframe",
		//	function to set modal title, will be passed the event as a parameter
		modal_title: null,
		views: {
			year: {
				slide_events: 1,
				enable: 1,
			},
			month: {
				slide_events: 1,
				enable: 1,
			},
			week: {
				enable: 1,
			},
			day: {
				enable: 1,
			},
		},
		merge_holidays: false,
		// ------------------------------------------------------------
		// CALLBACKS. Events triggered by calendar class. You can use
		// those to affect you UI
		// ------------------------------------------------------------
		onAfterEventsLoad: function(events) {
			// Inside this function 'this' is the calendar instance
		},
		onBeforeEventsLoad: function(next) {
			// Inside this function 'this' is the calendar instance
			next();
		},
		onAfterViewLoad: function(view) {
			// Inside this function 'this' is the calendar instance
		},
		onAfterModalShown: function(events) {
			// Inside this function 'this' is the calendar instance
		},
		onAfterModalHidden: function(events) {
			// Inside this function 'this' is the calendar instance
		},
		// -------------------------------------------------------------
		// INTERNAL USE ONLY. DO NOT ASSIGN IT WILL BE OVERRIDDEN ANYWAY
		// -------------------------------------------------------------
		events: [],
		templates: {
			year: "",
			month: "",
			week: "",
			day: "",
		},
		stop_cycling: false,
	};

	var defaults_extended = {
		first_day: 2,
		holidays: {
			// January 1
			"01-01": "New Year's Day",
			// Third (+3*) Monday (1) in January (01)
			"01+3*1": "Birthday of Dr. Martin Luther King, Jr.",
			// Third (+3*) Monday (1) in February (02)
			"02+3*1": "Washington's Birthday",
			// Last (-1*) Monday (1) in May (05)
			"05-1*1": "Memorial Day",
			// July 4
			"04-07": "Independence Day",
			// First (+1*) Monday (1) in September (09)
			"09+1*1": "Labor Day",
			// Second (+2*) Monday (1) in October (10)
			"10+2*1": "Columbus Day",
			// November 11
			"11-11": "Veterans Day",
			// Fourth (+4*) Thursday (4) in November (11)
			"11+4*4": "Thanksgiving Day",
			// December 25
			"25-12": "Christmas",
		},
	};

	var strings = {
		error_noview: "Calendar: View {0} not found",
		error_dateformat:
			'Calendar: Wrong date format {0}. Should be either "now" or "yyyy-mm-dd"',
		error_loadurl: "Calendar: Event URL is not set",
		error_where:
			'Calendar: Wrong navigation direction {0}. Can be only "next" or "prev" or "today"',
		error_timedevide:
			"Calendar: Time split parameter should divide 60 without decimals. Something like 10, 15, 30",

		no_events_in_day: "No events in this day.",

		select: "SELECT",
		click_row_block: 'Click on the "ending time" row',

		add_event: "Add book",

		title_year: "{0}",
		title_month: "{0} {1}",
		title_week: "week {0} of {1}",
		title_day: "{0} {1} {2}, {3}",

		week: "Week {0}",
		all_day: "All day",
		time: "Time",
		events: "Events",
		before_time: "Ends before timeline",
		after_time: "Starts after timeline",

		total_amount: "Total amount",
		discount: "Discount",
		deposit: "Deposit",
		due: "Due",
		confirm: window.salon_calendar.confirm_title,
		delete: window.salon_calendar.delete_title,
		click_plus: "Click or tap on plus icon",

		m0: "January",
		m1: "February",
		m2: "March",
		m3: "April",
		m4: "May",
		m5: "June",
		m6: "July",
		m7: "August",
		m8: "September",
		m9: "October",
		m10: "November",
		m11: "December",

		ms0: "Jan",
		ms1: "Feb",
		ms2: "Mar",
		ms3: "Apr",
		ms4: "May",
		ms5: "Jun",
		ms6: "Jul",
		ms7: "Aug",
		ms8: "Sep",
		ms9: "Oct",
		ms10: "Nov",
		ms11: "Dec",

		d0: "Sunday",
		d1: "Monday",
		d2: "Tuesday",
		d3: "Wednesday",
		d4: "Thursday",
		d5: "Friday",
		d6: "Saturday",
	};

	var browser_timezone = "";
	try {
		if (
			window.jstz &&
			typeof window.jstz == "object" &&
			typeof jstz.determine == "function"
		) {
			browser_timezone = jstz.determine().name();
			if (typeof browser_timezone !== "string") {
				browser_timezone = "";
			}
		}
	} catch (e) {}

	function buildEventsUrl(events_url, data) {
		var separator, key, url;
		url = events_url;
		separator = events_url.indexOf("?") < 0 ? "?" : "&";
		for (key in data) {
			url += separator + key + "=" + encodeURIComponent(data[key]);
			separator = "&";
		}
		return url;
	}

	function getExtentedOption(cal, option_name) {
		var fromOptions =
			cal.options[option_name] != null ? cal.options[option_name] : null;
		var fromLanguage =
			cal.locale[option_name] != null ? cal.locale[option_name] : null;
		if (option_name == "holidays" && cal.options.merge_holidays) {
			var holidays = {};
			$.extend(
				true,
				holidays,
				fromLanguage ? fromLanguage : defaults_extended.holidays
			);
			if (fromOptions) {
				$.extend(true, holidays, fromOptions);
			}
			return holidays;
		} else if (option_name == "first_day" && fromOptions != null) {
			return fromOptions;
		} else {
			if (fromOptions != null) {
				return fromOptions;
			}
			if (fromLanguage != null) {
				return fromLanguage;
			}
			return defaults_extended[option_name];
		}
	}

	function getHolidays(cal, year) {
		var hash = [];
		var holidays_def = getExtentedOption(cal, "holidays");
		for (var k in holidays_def) {
			hash.push(k + ":" + holidays_def[k]);
		}
		hash.push(year);
		hash = hash.join("|");
		if (hash in getHolidays.cache) {
			return getHolidays.cache[hash];
		}
		var holidays = [];
		$.each(holidays_def, function(key, name) {
			var firstDay = null,
				lastDay = null,
				failed = false;
			$.each(key.split(">"), function(i, chunk) {
				var m,
					date = null;
				if ((m = /^(\d\d)-(\d\d)$/.exec(chunk))) {
					date = new Date(
						year,
						parseInt(m[2], 10) - 1,
						parseInt(m[1], 10)
					);
				} else if ((m = /^(\d\d)-(\d\d)-(\d\d\d\d)$/.exec(chunk))) {
					if (parseInt(m[3], 10) == year) {
						date = new Date(
							year,
							parseInt(m[2], 10) - 1,
							parseInt(m[1], 10)
						);
					}
				} else if ((m = /^easter(([+\-])(\d+))?$/.exec(chunk))) {
					date = getEasterDate(year, m[1] ? parseInt(m[1], 10) : 0);
				} else if (
					(m = /^(\d\d)([+\-])([1-5])\*([0-6])$/.exec(chunk))
				) {
					var month = parseInt(m[1], 10) - 1;
					var direction = m[2];
					var offset = parseInt(m[3]);
					var weekday = parseInt(m[4]);
					switch (direction) {
						case "+":
							var d = new Date(year, month, 1 - 7);
							while (d.getDay() != weekday) {
								d = new Date(
									d.getFullYear(),
									d.getMonth(),
									d.getDate() + 1
								);
							}
							date = new Date(
								d.getFullYear(),
								d.getMonth(),
								d.getDate() + 7 * offset
							);
							break;
						case "-":
							var d = new Date(year, month + 1, 0 + 7);
							while (d.getDay() != weekday) {
								d = new Date(
									d.getFullYear(),
									d.getMonth(),
									d.getDate() - 1
								);
							}
							date = new Date(
								d.getFullYear(),
								d.getMonth(),
								d.getDate() - 7 * offset
							);
							break;
					}
				}
				if (!date) {
					warn("Unknown holiday: " + key);
					failed = true;
					return false;
				}
				switch (i) {
					case 0:
						firstDay = date;
						break;
					case 1:
						if (date.getTime() <= firstDay.getTime()) {
							warn("Unknown holiday: " + key);
							failed = true;
							return false;
						}
						lastDay = date;
						break;
					default:
						warn("Unknown holiday: " + key);
						failed = true;
						return false;
				}
			});
			if (!failed) {
				var days = [];
				if (lastDay) {
					for (
						var date = new Date(firstDay.getTime());
						date.getTime() <= lastDay.getTime();
						date.setDate(date.getDate() + 1)
					) {
						days.push(new Date(date.getTime()));
					}
				} else {
					days.push(firstDay);
				}
				holidays.push({ name: name, days: days });
			}
		});
		getHolidays.cache[hash] = holidays;
		return getHolidays.cache[hash];
	}

	getHolidays.cache = {};

	function warn(message) {
		if (
			window.console &&
			typeof window.console == "object" &&
			typeof window.console.warn == "function"
		) {
			window.console.warn("[Bootstrap-Calendar] " + message);
		}
	}

	function eventOverlap(start, end, events) {
		var col = 0;

		var events_by_columns = {};

		events.forEach(function(event) {
			var event_col = event[2];

			if (typeof events_by_columns[event_col] === "undefined") {
				events_by_columns[event_col] = {};
			}

			var booking_id = event[3].id;

			if (
				typeof events_by_columns[event_col][booking_id] === "undefined"
			) {
				events_by_columns[event_col][booking_id] = [];
			}

			events_by_columns[event_col][booking_id].push(event);
		});

		$.each(events_by_columns, function(_col, _events) {
			var available_col = true;

			$.each(_events, function(booking_id, _items) {
				//first service of booking
				var _eventStart = _items[0][0];
				//last service of booking
				var _eventEnd =
					_items[_items.length - 1][0] + _items[_items.length - 1][1];
				if (!(end <= _eventStart || start >= _eventEnd)) {
					available_col = false;
				}
			});

			if (available_col) {
				col = parseInt(_col);
				return false;
			}

			col = parseInt(_col) + 1;
		});

		return col;
	}

	function Calendar(params, context) {
		this.options = $.extend(
			true,
			{ position: { start: new Date(), end: new Date() } },
			defaults,
			params
		);
		this.setLanguage(this.options.language);
		this.context = context;

		context.css("width", this.options.width).addClass("cal-context");
		let $this = this;
		setInterval(() => {
			if(!$this.is_tooltip_shown()){
				$('.current-view--title').addClass('sln-box--loading');
				$this.view()
				$('body .tooltip.fade.top.in').hide();
			}
		}, 50000);

		this.view();
		return this;
	}

	Calendar.prototype.setOptions = function(object) {
		$.extend(this.options, object);
		if ("language" in object) {
			this.setLanguage(object.language);
		}
		if ("modal" in object) {
			this._update_modal();
		}
	};

	Calendar.prototype.setLanguage = function(lang) {
		if (window.calendar_languages && lang in window.calendar_languages) {
			this.locale = $.extend(
				true,
				{},
				strings,
				window.calendar_locale || {},
				calendar_languages[lang]
			);
			this.options.language = lang;
		} else {
			this.locale = $.extend(
				true,
				{},
				strings,
				window.calendar_locale || {}
			);
			delete this.options.language;
		}
	};

	Calendar.prototype._render = function() {
		this.context.html("");
		this._loadTemplate(this.options.view);
		this.stop_cycling = false;

		var data = {};
		data.cal = this;
		data.day = 1;

		// Getting list of days in a week in correct order. Works for month and week views
		data.months = [
			this.locale.d0,
			this.locale.d1,
			this.locale.d2,
			this.locale.d3,
			this.locale.d4,
			this.locale.d5,
			this.locale.d6,
		];
		var first_day = getExtentedOption(this, "first_day");
		if (first_day)
			data.months = data.months.concat(data.months.splice(0, first_day));

		// Get all events between start and end
		var start = parseInt(this.options.position.start.getTime());
		var end = parseInt(this.options.position.end.getTime());

		data.events = this.getEventsBetween(start, end);

		switch (this.options.view) {
			case "month":
				break;
			case "week":
				this._calculate_hour_minutes_weekly(data);
				break;
			case "day":
				this._calculate_hour_minutes_daily(data);
				break;
		}
		data.start = new Date(this.options.position.start.getTime());
		data.lang = this.locale;
		data.assistants_mode = this.options._assistants_mode;
		this.context.append(this.options.templates[this.options.view](data));
		this._update();
		let calendar = this;
		$('.cal-day-assistant').on('mousedown', function(e_down){
			var start_pos = e_down.pageX;
			$(this).addClass('cal-day-assistants--move');
			$(this).css('left', start_pos - $(this).parent().offset().left - $(this).width()/2);
			var $self = $(this);
			$(this).parent().on('mousemove', function(e_move){
				$self.css('left', e_move.pageX - $self.parent().offset().left - $self.width()/2);
			});
			$('.cal-day-assistant').on('mouseup', function(e_down){
				$(this).parent().off('mousemove');
				let new_sort = '';
				let is_find = false;
				$('.cal-day-assistant').each(function(id, el){
					if($(el).data('assistant') == $self.data('assistant')){
						return;
					}
					if($(el).offset().left < $self.offset().left || is_find){
						new_sort += el.outerHTML ;
					}else{
						$(this).removeClass('cal-day-assistants--move');
						$(this).removeAttr('style');
						new_sort += $self[0].outerHTML + el.outerHTML ;
						is_find = true;
					}
				});
				if(!is_find){
					$(this).removeClass('cal-day-assistants--move');
					$(this).removeAttr('style');
					new_sort += $self[0].outerHTML;
				}
				if(new_sort){
					$(this).parent().html(new_sort);
					calendar.view();
				}
			});
		});
	};

	Calendar.prototype._cell_class = function() {
		return this.options._assistants_mode ? 'cal-cell0': 'cal-cell1';
	};

	Calendar.prototype._addServiceToAssistance = function(
		item,
		e,
		attendants,
		service_start,
		start,
		service_end,
		end,
		classes,
		border_top,
		lines,
		ms_per_line,
		display_state
	) {
		let is_main = e.items[0] == item;
		var objs = this.applyAdvancedFilters([
			{
				id: e.id,
				title: e.title,
				from: is_main ? e.from : "",
				to: is_main ? e.to : "",
				from_label: is_main ? e.from_label : "",
				to_label: is_main ? e.to_label : "",
				main: is_main,
				amount: e.amount,
				discount: e.discount,
				deposit: e.deposit,
				due: e.due,
				status: !is_main ? e.status : "",
				customer: e.customer,
				customer_id: e.customer_id,
				is_pro_version: e.is_pro_version,
				border_top: border_top,
				services: [item.service],
				is_parallel_exec: item.is_parallel_exec,
				class: e.class + (classes || ""),
				calendar_day: e.calendar_day_assistants[item.service],
				calendar_day_common: e.calendar_day_assistants_common,
				url: e.url,
				delete_url: e.delete_url,
				duplicate_url: e.duplicate_url,
				_start: service_start,
				_end: service_end,
				display_state: display_state
			},
		]); // create event and apply filters

		if (!objs.length) {
			return;
		}
		var obj = objs[0];

		if (
			obj._start > end.getTime() ||
			obj._end < start.getTime()
		) {
			return;
		}

		if (obj._start <= start.getTime()) {
			obj._start = start.getTime();
		}

		if (obj._end >= end.getTime()) {
			obj._end = end.getTime();
			obj.status = e.status;
		}

		var event_start = start.getTime() - obj._start;

		if (event_start >= 0) {
			obj.top = 0;
		} else {
			obj.top = Math.abs(event_start) / ms_per_line;
		}

		var lines_left = Math.abs(lines - obj.top);
		var lines_in_event =
			(obj._end - obj._start) / ms_per_line;
		if (event_start >= 0) {
			lines_in_event =
				(obj._end - start.getTime()) / ms_per_line;
		}

		obj.lines = lines_in_event;
		if (lines_in_event > lines_left) {
			obj.lines = lines_left;
		}

		var eventVal = [obj.top, obj.lines, 0, obj];

		if(!Array.isArray(item.attendant)){
			if (typeof attendants[item.attendant] === "undefined") {
				attendants[item.attendant] = [];
			}
			attendants[item.attendant].push(eventVal);
		}else{
			item.attendant.forEach(function(_id){
				if(typeof attendants[_id] === 'undefined'){
					attendants[_id] = [];
				}
				attendants[_id].push(eventVal);
			});
		}
	};

	Calendar.prototype._addServiceToEvent = function(
		event,
		service_start,
		start,
		service_end,
		end,
		classes,
		border_top,
		e,
		item,
		lines,
		ms_per_line,
		display_state
	) {
		let is_main = e.items[0] == item;
		var objs = this.applyAdvancedFilters([
			{
				id: e.id,
				title: e.title,
				from: is_main ? e.from : "",
				to: is_main ? e.to : "",
				from_label: is_main ? e.from_label : "",
				to_label: is_main ? e.to_label : "",
				main: is_main,
				amount: e.amount,
				discount: e.discount,
				deposit: e.deposit,
				due: e.due,
				status: is_main ? e.status : "",
				customer: is_main ? e.customer : "",
				customer_id: e.customer_id,
				is_pro_version: e.is_pro_version,
				border_top: border_top,
				services: [item.service],
				class: e.class + (classes || ""),
				calendar_day: is_main ? e.calendar_day : "",
				calendar_day_common: e.calendar_day_assistants_common,
				url: e.url,
				delete_url: e.delete_url,
				duplicate_url: e.duplicate_url,
				_start: service_start,
				_end: service_end,
				display_state: display_state
			},
		]); // create event and apply filters

		if (!objs.length) {
			return;
		}
		var obj = objs[0];

		if (
			obj._start > end.getTime() ||
			obj._end < start.getTime()
		) {
			return;
		}

		if (obj._start <= start.getTime()) {
			obj._start = start.getTime();
		}

		if (obj._end >= end.getTime()) {
			obj._end = end.getTime();
			obj.status = e.status;
		}

		var event_start = start.getTime() - obj._start;

		if (event_start >= 0) {
			obj.top = 0;
		} else {
			obj.top = Math.abs(event_start) / ms_per_line;
		}

		var lines_left = Math.abs(lines - obj.top);
		var lines_in_event =
			(obj._end - obj._start) / ms_per_line;
		if (event_start >= 0) {
			lines_in_event =
				(obj._end - start.getTime()) / ms_per_line;
		}

		obj.lines = lines_in_event;
		if (lines_in_event > lines_left) {
			obj.lines = lines_left;
		}

		event.push(obj);
	};

	function timeToMinutes(time) {

		var formattedTime = time;

		if(time.includes('pm') || time.includes('am')) {
			var timeArray = time.split(":");
			var hours = parseInt(timeArray[0]);
			var minutes = parseInt(timeArray[1]);
			var meridian = timeArray[1].slice(-2);
		
			if (meridian === "pm" && hours !== 12) {
				hours += 12;
			}
			if (meridian === "am" && hours === 12) {
				hours = 0;
			}

			var formattedHours = ("0" + hours).slice(-2);
			var formattedMinutes = ("0" + minutes).slice(-2);

			formattedTime = formattedHours + ":" + formattedMinutes;
		}

		var parts = formattedTime.split(":");
    	return parseInt(parts[0]) * 60 + parseInt(parts[1]);
	}

	Calendar.prototype._check_holidays = function (time) {
		var to = $.extend({}, this.options.position);
		var dateString = to.start.getFullYear() + "-" + to.start.getMonthFormatted() + "-" + to.start.getDateFormatted();
		var date = new Date(dateString);
		
		var holidaysData = $("#holidays_arr").data("holidays");

		if(!holidaysData) return false;

		for (var i = 0; i < holidaysData.length; i++) {

			var holiday = holidaysData[i];
			var from_date = new Date(holiday.from_date);
			var to_date = new Date(holiday.to_date);
			
			var targetMinutes = timeToMinutes(time);

			if (date.getTime() == from_date.getTime() && date.getTime() == to_date.getTime()) {
				var fromMinutes = timeToMinutes(holiday.from_time);
				var toMinutes = timeToMinutes(holiday.to_time);

				if (targetMinutes >= fromMinutes && targetMinutes <= toMinutes) {
					return true;
				}
			} else if (date.getTime() == from_date.getTime() && date.getTime() != to_date.getTime()) {
				var fromMinutes = timeToMinutes(holiday.from_time);
				var toMinutes = 1440;

				if (targetMinutes >= fromMinutes && targetMinutes <= toMinutes) {
					return true;
				}
			} else if (date.getTime() != from_date.getTime() && date.getTime() == to_date.getTime()) {
				var fromMinutes = 0;
				var toMinutes = timeToMinutes(holiday.to_time);

				if (targetMinutes >= fromMinutes && targetMinutes <= toMinutes) {
					return true;
				}
			} else if (date.getTime() >= from_date.getTime() && date.getTime() <= to_date.getTime()) {
				var fromMinutes = 0;
				var toMinutes = 1440;

				if (targetMinutes >= fromMinutes && targetMinutes <= toMinutes) {
					return true;
				}
			}
		}

		return false;
	}

	Calendar.prototype._calculate_hour_minutes_daily = function(data) {
		var $self = this;

		data.events = $self.applyAdvancedFilters(data.events);

		var time_split = parseInt(this.options.time_split);

		if (time_split <= 0) {
			$.error(this.locale.error_timedevide);
		}

		var start = new Date(this.options.position.start.getTime());
		start.setHours(...this.options.time_start.split(':'));
		var end = new Date(this.options.position.start.getTime());
		end.setHours(...this.options.time_end.split(':'));
		var ms_per_line = 60000 * time_split;

		var time_diff = (end - start) / 60000

		var lines = parseInt(time_diff / time_split);

		var grid = {};
		var by_page = [];
		var max_page = 0;
		var current_page = !isNaN(parseInt($self.options._page))
			? parseInt($self.options._page)
			: 0;
		var on_page = parseInt($self.options.on_page);

		data.lines = lines;
		//data.borders = on_page + 1;
		data.borders = on_page;
		data.headers = [];
		data.all_day = [];
		data.by_hour = [];
		data.after_time = [];
		data.before_time = [];
		data.events.sort(function(a, b) {
			return a.start < b.start ? -1 : 1;
		});

		if ($self.options._assistants_mode) {
			var assistants = [];
			$.each(data.events, function(k, e) {

				e._start =
					e.start + new Date(e.start).getTimezoneOffset() * 60 * 1000;
				e._end =
					e.end + new Date(e.end).getTimezoneOffset() * 60 * 1000;

				if (e._end < start.getTime()) {
					start = new Date(parseInt(e._start));
					$self.options.time_start = start.getHours().toString().formatNum(2) + ':' + start.getMinutes().toString().formatNum(2);
					let time_diff = (end - start) / 60000;
					data.lines = time_diff / time_split;
				}

				if (e._start > end.getTime()) {
					end = new Date(parseInt(e._end));
					if(end < start){
						$self.options.time_end = (end.getHours() + 24).toString().formatNum(2) + ':' + end.getMinutes().toString().formatNum(2);
						end.setHours(end.getHours() + 24);
					} else{
						$self.options.time_end = end.getHours().toString().formatNum(2) + ':' + end.getMinutes().toString().formatNum(2);
					}
					let time_diff =(end - start) / 60000;
					data.lines = time_diff / time_split;
				}
				var service_start =
					e.start + new Date(e.start).getTimezoneOffset() * 60 * 1000;
				var service_end = service_start;

				var _assistants = [];

				$.each(e.items, function(j, item) {
					if(!item.is_parallel_exec) {
						service_start = service_end;
					}

					var duration = item.duration.split(":");

					var durationMs =
						duration[0] === "00" && duration[1] === "00"
							? salon_default_duration * 60000
							: (parseInt(duration[0]) * 3600 +
								parseInt(duration[1]) * 60) *
							1000;

					if (!item.attendant) {
						return;
					}

					var break_duration = item.break_duration.split(":");
					var break_duration_data = item.break_duration_data;

					var breakDurationMs =
						(parseInt(break_duration[0]) * 3600 +
							parseInt(break_duration[1]) * 60) *
						1000;

					if (breakDurationMs > 0) {

						var _service_end = service_start + durationMs + breakDurationMs;
						service_end = service_start + break_duration_data.from * 60 * 1000;
						$self._addServiceToAssistance(
							item,
							e,
							_assistants,
							service_start,
							start,
							service_end,
							end,
							" break-down no-border-top",
							true,
							lines,
							ms_per_line,
							"block"
						);

						service_start = service_start + break_duration_data.to * 60 * 1000;
						service_end = _service_end;
						$self._addServiceToAssistance(
							item,
							e,
							_assistants,
							service_start,
							start,
							service_end,
							end,
							" break-up no-border-top",
							false,
							lines,
							ms_per_line,
							"none"
						);
					} else {
						service_end = service_start + durationMs;
						$self._addServiceToAssistance(
							item,
							e,
							_assistants,
							service_start,
							start,
							service_end,
							end,
							" no-border-top",
							true,
							lines,
							ms_per_line,
							"block"
						);
					}


				});
				$.each(sln_assistants, function(att_id, attendant){
					if(typeof assistants[att_id] === 'undefined'){
						assistants[att_id] = [];
						assistants[att_id].eventCount = 0;
					}
					if(typeof _assistants[att_id] === 'undefined'){
						return;
					}else{
						let _event_start = _assistants[att_id][0][0];
						let _event_end =
							_assistants[att_id][_assistants[att_id].length - 1][0] +
							_assistants[att_id][_assistants[att_id].length - 1][1];
						let checkifcontained = eventOverlap(_event_start, _event_end, assistants[att_id]);
						if(checkifcontained){
							assistants[att_id].eventCount = Math.max(assistants[att_id].eventCount, checkifcontained);
						}
						_assistants[att_id].forEach(function(_event){
							_event[2] = checkifcontained;
							assistants[att_id].push(_event);
						});
					}

				});
			});
			var i = 0;
			var ret = [];
			let assistant_order = [];
			assistant_order = new Set(assistant_order.concat(Object.values(sln_assistants_order), Object.keys(sln_assistants).map(Number)));
			assistant_order.forEach(function(ord, att_id){
				if(typeof assistants[att_id] === 'undefined'){
					ret.push(att_id);
					return;
				}
				assistants[att_id].forEach(function(event){
					event[3].left = i + event[2];

					event[3].page = Math.floor(event[3].left / on_page);
					max_page = Math.max(event[3].page, max_page);
					if(by_page.indexOf(event[3]) == -1){
						by_page.push(Object.assign({}, event[3]));
					}else{
						by_page.push(event[3]);
					}
				});
				i += assistants[att_id].eventCount + 1;
				ret.push(att_id);
				if(assistants[att_id].eventCount){
					ret = ret.concat(
						Array.apply(
							null,
							Array(assistants[att_id].eventCount).map(function(){return 'undefined';})
						)
					);
				}
			});
			console.log(max_page);
			current_page = Math.max(current_page, max_page);
			$self.options._page = current_page;
			$self.options._max_page = max_page;

			ret = ret.slice(
				current_page * on_page,
				(current_page + 1) * on_page
			);
			$.each(ret, function(pos, att_id) {
				//needed for highlight unavailable att timeslots
				if(sln_assistants[att_id]) {
					var unavailable_times = {};
					var index = 0;
					for(var i = start; i < end; i = new Date(i.getTime() + ms_per_line)) {
						var timeString = i.getHours().toString().formatNum(2) + ':' + i.getMinutes().toString().formatNum(2);
						if(!sln_assistants[att_id].times.includes(timeString)) {
							unavailable_times[index] = i;
						}
						index++;
					}
					sln_assistants[att_id].unavailable_times = unavailable_times;

					sln_assistants[att_id].id = att_id;
				}
				data.headers.push(sln_assistants[att_id]);
			});

			data.by_hour = by_page;
			console.log(data.by_hour);
			console.log(assistants);
		} else {
			$.each(data.events, function(k, e) {
				e._start =
					e.start + new Date(e.start).getTimezoneOffset() * 60 * 1000;
				e._end =
					e.end + new Date(e.end).getTimezoneOffset() * 60 * 1000;

				var s = new Date(parseInt(e._start));
				var f = new Date(parseInt(e._end));

				e.start_hour =
					s
						.getHours()
						.toString()
						.formatNum(2) +
					":" +
					s
						.getMinutes()
						.toString()
						.formatNum(2);
				e.end_hour =
					f
						.getHours()
						.toString()
						.formatNum(2) +
					":" +
					f
						.getMinutes()
						.toString()
						.formatNum(2);

				if (e._start < start.getTime()) {
					start = s;
					$self.options.time_start = e.start_hour;
					let time_diff = (end - start) / 60000;
					data.lines = time_diff / time_split;
				}

				if (e._end > end.getTime()) {
					end = f;
					if(end.getHours() < start.getHours()){
						$self.options.time_end = (end.getHours() + 24).toString().formatNum(2) + ':' + end.getMinutes().toString().formatNum(2);
						end.setHours(end.getHours() + 24);
					}else{
						$self.options.time_end = end.getHours().toString().formatNum(2) + ':' + end.getMinutes().toString().formatNum(2);
					}
					let time_diff = (end - start) / 60000;
					data.lines = time_diff / time_split;
				}

				var service_start = e._start;
				var service_end = service_start;

				var event = [];

				var parallelServiceProcessed = false;

				var items = e.items;

				$.each(items, function(j, item) {
					if (!item.is_parallel_exec) {
						service_start = service_end;
					} else {
						if (parallelServiceProcessed) {
							return;
						} else {
							parallelServiceProcessed = true;
						}
					}

					var duration = item.duration.split(":");

					var durationMs =
						duration[0] === "00" && duration[1] === "00"
							? salon_default_duration * (60 * 1000)
							: (parseInt(duration[0]) * 60 * 60 +
								parseInt(duration[1]) * 60) *
							1000;

					var break_duration = item.break_duration.split(":");
					var break_duration_data = item.break_duration_data;

					var breakDurationMs =
						(parseInt(break_duration[0]) * 60 * 60 +
							parseInt(break_duration[1]) * 60) *
						1000;

					if (breakDurationMs > 0) {

						var _service_end = service_start + durationMs + breakDurationMs;
						service_end =
							service_start + break_duration_data.from * 60 * 1000;
						$self._addServiceToEvent(
							event,
							service_start,
							start,
							service_end,
							end,
							" break-down no-border-top",
							true,
							e,
							item,
							lines,
							ms_per_line,
							"block"
						);

						service_start = service_start + break_duration_data.to * 60 * 1000;
						service_end = _service_end;
						$self._addServiceToEvent(
							event,
							service_start,
							start,
							service_end,
							end,
							" break-up no-border-top",
							false,
							e,
							item,
							lines,
							ms_per_line,
							"none"
						);
					} else {
						service_end = service_start + durationMs;
						$self._addServiceToEvent(
							event,
							service_start,
							start,
							service_end,
							end,
							" no-border-top",
							false,
							e,
							item,
							lines,
							ms_per_line,
							"block"
						);
					}
				});

				console.log("event", event);

				var col = 0;

				$.each(event, function(j, obj) {
					let added = false;
					while(!added){
						var row = obj.top;
						var row_rounded = parseFloat(row.toFixed(4));
						if (grid[row_rounded] == undefined) {
							grid[row_rounded] = {};
						}

						if (grid[row_rounded][col] == undefined) {
							added = true;
							obj.left = col;

							for (
								var offset = 0;
								parseFloat(offset.toFixed(4)) < obj.lines;
								offset += 1
							) {
								var _row_rounded = parseFloat(
									(row + offset).toFixed(4)
								);
								var _col = col;

								if (grid[_row_rounded] == undefined) {
									grid[_row_rounded] = {};
								}

								grid[_row_rounded][_col] = obj.id;
							}
						} else {
							col++;
						}
					}

					obj.page = Math.floor(obj.left / on_page);
					obj.left = obj.left % on_page;
					max_page = Math.max(max_page, obj.page);

					if (by_page[obj.page] === undefined) {
						by_page[obj.page] = [];
					}

					by_page[obj.page].push(obj);
				});
			});

			current_page = Math.max(current_page, max_page);
			$self.options._page = current_page;
			$self.options._max_page = max_page;

			data.by_hour = by_page[current_page];

			console.log(grid);
		}
	};

	Calendar.prototype._calculate_hour_minutes_weekly = function(data) {
		var $self = this;
		var time_split = parseInt(this.options.time_split);
		var time_split_count = 60 / time_split;
		var time_split_hour = Math.min(time_split_count, 1);

		if (time_split <= 0) {
			$.error(this.locale.error_timedevide);
		}

		var time_start = this.options.time_start.split(":");
		var time_end = this.options.time_end.split(":");

		data.hours =
			(parseInt(time_end[0]) - parseInt(time_start[0])) * time_split_hour;
		var lines =
			data.hours * time_split_count -
			parseInt(time_start[1]) / time_split;
		var ms_per_line = 60000 * time_split;

		var start = new Date(this.options.position.start.getTime());
		start.setHours(time_start[0]);
		start.setMinutes(time_start[1]);
		var end = new Date(this.options.position.start.getTime());
		end.setHours(time_end[0]);
		end.setMinutes(time_end[1]);

		data.all_day = [];
		data.by_hour = [];
		data.after_time = [];
		data.before_time = [];
		$.each(data.events, function(k, e) {
			e.start = e.start + new Date().getTimezoneOffset() * 60 * 1000;
			e.end = e.end + new Date().getTimezoneOffset() * 60 * 1000;
			var s = new Date(parseInt(e.start));
			var f = new Date(parseInt(e.end));
			e.start_hour =
				s
					.getHours()
					.toString()
					.formatNum(2) +
				":" +
				s
					.getMinutes()
					.toString()
					.formatNum(2);
			e.end_hour =
				f
					.getHours()
					.toString()
					.formatNum(2) +
				":" +
				f
					.getMinutes()
					.toString()
					.formatNum(2);

			if (e.start < start.getTime()) {
				warn(1);
				e.start_hour =
					s.getDate() +
					" " +
					$self.locale["ms" + s.getMonth()] +
					" " +
					e.start_hour;
			}

			if (e.end > end.getTime()) {
				warn(1);
				e.end_hour =
					f.getDate() +
					" " +
					$self.locale["ms" + f.getMonth()] +
					" " +
					e.end_hour;
			}

			if (e.start < start.getTime() && e.end > end.getTime()) {
				data.all_day.push(e);
				return;
			}

			if (e.end < start.getTime()) {
				data.before_time.push(e);
				return;
			}

			if (e.start > end.getTime()) {
				data.after_time.push(e);
				return;
			}

			var event_start = start.getTime() - e.start;

			if (event_start >= 0) {
				e.top = 0;
			} else {
				e.top = Math.abs(event_start) / ms_per_line;
			}

			var lines_left = Math.abs(lines - e.top);
			var lines_in_event = (e.end - e.start) / ms_per_line;
			if (event_start >= 0) {
				lines_in_event = (e.end - start.getTime()) / ms_per_line;
			}

			e.lines = lines_in_event;
			if (lines_in_event > lines_left) {
				e.lines = lines_left;
			}

			data.by_hour.push(e);
		});
	};

	Calendar.prototype._hour_min = function(hour) {
		var time_start = this.options.time_start.split(":");
		var time_split = parseInt(this.options.time_split);
		var in_hour = 60 / time_split;
		return hour == 0
			? in_hour - parseInt(time_start[1]) / time_split
			: in_hour;
	};
	/** BEGIN SLN CUSTOMIZATIONS */
	Calendar.prototype._hour = sln_calendar_getHourFunc();
	Calendar.prototype._trans = sln_calendar_getTransFunc();
	Calendar.prototype._time = sln_calendar_getTimeFunc();

	/** END SLN CUSTOMIZATIONS **/

	Calendar.prototype._week_group_by_assistants = function(events){
		let assistants_events = {};
		events.forEach(function(event){
			event.items.forEach(function(item){
				if(assistants_events[item.attendant] !== undefined){
					assistants_events[item.attendant].push(event);
				}else{
					assistants_events[item.attendant] = [event];
				}
			})
		});
		return assistants_events;
	};

	Calendar.prototype._week = function(event) {
		this._loadTemplate("week-days");

		var t = {};
		var start = parseInt(this.options.position.start.getTime());
		var end = parseInt(this.options.position.end.getTime());
		var events = [];
		var self = this;
		var first_day = parseInt(getExtentedOption(this, "first_day"));
		$.each(this.getEventsBetween(start, end), function(k, event) {
			event.start_day = new Date(parseInt(event.start)).getDay();
			if (first_day - event.start_day === 0) {
				event.start_day = 0;
			} else if (first_day - event.start_day > 0) {
				event.start_day = event.start_day + (7 - first_day);
			} else if (first_day - event.start_day < 0) {
				event.start_day = event.start_day - first_day;
			}

			if (event.end - event.start <= 86400000) {
				event.days = 1;
			} else {
				event.days = (event.end - event.start) / 86400000;
			}

			if (event.start < start) {
				event.days = event.days - (start - event.start) / 86400000;
				event.start_day = 0;
			}

			event.days = Math.ceil(event.days);

			if (event.start_day + event.days > 7) {
				event.days = 7 - event.start_day;
			}

			events.push(event);
		});
		if(this.options._assistants_mode){
			events = this._week_group_by_assistants(events);
			t.assistants_order = [];
			t.assistants_order = new Set(t.assistants_order.concat(Object.values(sln_assistants_order), Object.keys(sln_assistants).map(Number)));
			console.log(t.assistants_order);
			t.assistants_names = sln_assistants;
		}
		t.assistants_mode = this.options._assistants_mode;
		t.events = events;
		t.cal = this;
		return this.options.templates["week-days"](t);
	};

	Calendar.prototype._save_scroll_pos = function(){
		this._scroll_pos_x = this.context.find('.cal-day-panel__wrapper.clearfix').scrollTop();
		this._scroll_pos_y = this.context.find('.cal-day-panel__wrapper.clearfix').scrollLeft();
	};

	Calendar.prototype._recover_scroll_pos = function(){
		this.context.find('.cal-day-panel__wrapper.clearfix').scrollTop(this._scroll_pos_x);
		this.context.find('.cal-day-panel__wrapper.clearfix').scrollLeft(this._scroll_pos_y)
	}

	Calendar.prototype._month = function(month) {
		this._loadTemplate("year-month");

		var t = { cal: this };
		var newmonth = month + 1;
		t.data_day =
			this.options.position.start.getFullYear() +
			"-" +
			(newmonth < 10 ? "0" + newmonth : newmonth) +
			"-" +
			"01";
		t.month_name = this.locale["m" + month];

		var curdate = new Date(
			this.options.position.start.getFullYear(),
			month,
			1,
			0,
			0,
			0
		);
		t.start = parseInt(curdate.getTime());
		t.end = parseInt(
			new Date(
				this.options.position.start.getFullYear(),
				month + 1,
				1,
				0,
				0,
				0
			).getTime()
		);
		t.events = this.getEventsBetween(t.start, t.end);
		return this.options.templates["year-month"](t);
	};

	Calendar.prototype._day = function(week, day) {
		this._loadTemplate("month-day");

		var t = { tooltip: "", cal: this };
		var cls = this.options.classes.months.outmonth;

		var firstday = this.options.position.start.getDay();
		var weekday = parseInt(getExtentedOption(this, "first_day"));
		if (weekday === 0) weekday = 7;
		if (firstday - weekday === 0) {
			firstday = 1;
		} else if (firstday - weekday > 0) {
			firstday = 1 + (firstday - weekday);
		} else if (firstday - weekday < 0) {
			firstday = 1 + (7 - (weekday - firstday));
		}

		day = day - firstday + 1;
		var curdate = new Date(
			this.options.position.start.getFullYear(),
			this.options.position.start.getMonth(),
			day,
			0,
			0,
			0
		);

		// if day of the current month
		if (day > 0) {
			cls = this.options.classes.months.inmonth;
		}
		// stop cycling table rows;
		var daysinmonth = new Date(
			this.options.position.end.getTime() - 1
		).getDate();
		if (day + 1 > daysinmonth) {
			this.stop_cycling = true;
		}
		// if day of the next month
		if (day > daysinmonth) {
			day = day - daysinmonth;
			cls = this.options.classes.months.outmonth;
		}

		cls = (cls + " " + this._getDayClass("months", curdate)).trim();

		if (day <= 0) {
			var daysinprevmonth = new Date(
				this.options.position.start.getFullYear(),
				this.options.position.start.getMonth(),
				0
			).getDate();
			day = daysinprevmonth - Math.abs(day);
			cls += " cal-month-first-row";
		}

		var holiday = this._getHoliday(curdate);
		if (holiday !== false) {
			t.tooltip = holiday;
		}

		t.data_day =
			curdate.getFullYear() +
			"-" +
			curdate.getMonthFormatted() +
			"-" +
			(day < 10 ? "0" + day : day);
		t.cls = cls;
		t.day = day;

		t.start = parseInt(curdate.getTime());
		t.end = parseInt(t.start + 86400000);
		t.events = this.getEventsBetween(t.start, t.end);
		return this.options.templates["month-day"](t);
	};

	Calendar.prototype._getHoliday = function(date) {
		var result = false;
		$.each(getHolidays(this, date.getFullYear()), function() {
			var found = false;
			$.each(this.days, function() {
				if (this.toDateString() == date.toDateString()) {
					found = true;
					return false;
				}
			});
			if (found) {
				result = this.name;
				return false;
			}
		});
		return result;
	};

	Calendar.prototype._getHolidayName = function(date) {
		var holiday = this._getHoliday(date);
		return holiday === false ? "" : holiday;
	};

	Calendar.prototype._getDayClass = function(class_group, date) {
		var self = this;
		var addClass = function(which, to) {
			var cls;
			cls =
				self.options.classes &&
				class_group in self.options.classes &&
				which in self.options.classes[class_group]
					? self.options.classes[class_group][which]
					: "";
			if (typeof cls == "string" && cls.length) {
				to.push(cls);
			}
		};
		var classes = [];
		if (date.toDateString() == new Date().toDateString()) {
			addClass("today", classes);
		}
		var holiday = this._getHoliday(date);
		if (holiday !== false) {
			addClass("holidays", classes);
		}
		switch (date.getDay()) {
			case 0:
				addClass("sunday", classes);
				break;
			case 6:
				addClass("saturday", classes);
				break;
		}

		addClass(date.toDateString(), classes);

		return classes.join(" ");
	};

	Calendar.prototype.view = function(view) {
		this._save_scroll_pos();
		if (view) {
			if (!this.options.views[view].enable) {
				return;
			}
			this.options.view = view;
		}

		this._init_position();
		this._loadEvents();
		this._render();
		$('.current-view--title').addClass('sln-box--loading');
		setTimeout(() => {$('.current-view--title').removeClass('sln-box--loading');}, 3000)
		this._recover_scroll_pos();
		this.options.onAfterViewLoad.call(this, this.options.view);
	};

	Calendar.prototype.navigate = function(where, next) {
		var to = $.extend({}, this.options.position);
		if (where == "next") {
			switch (this.options.view) {
				case "year":
					to.start.setFullYear(
						this.options.position.start.getFullYear() + 1
					);
					break;
				case "month":
					to.start.setMonth(
						this.options.position.start.getMonth() + 1
					);
					break;
				case "week":
					to.start.setDate(this.options.position.start.getDate() + 7);
					break;
				case "day":
					to.start.setDate(this.options.position.start.getDate() + 1);
					break;
			}
		} else if (where == "prev") {
			switch (this.options.view) {
				case "year":
					to.start.setFullYear(
						this.options.position.start.getFullYear() - 1
					);
					break;
				case "month":
					to.start.setMonth(
						this.options.position.start.getMonth() - 1
					);
					break;
				case "week":
					to.start.setDate(this.options.position.start.getDate() - 7);
					break;
				case "day":
					to.start.setDate(this.options.position.start.getDate() - 1);
					break;
			}
		} else if (where == "today") {
			to.start.setTime(new Date().getTime());
		} else {
			$.error(this.locale.error_where.format(where));
		}
		this.options.day =
			to.start.getFullYear() +
			"-" +
			to.start.getMonthFormatted() +
			"-" +
			to.start.getDateFormatted();
		this.view();
		if (_.isFunction(next)) {
			next();
		}
	};

	Calendar.prototype._init_position = function() {
		var year, month, day;

		if (this.options.day == "now") {
			var date = new Date();
			year = date.getFullYear();
			month = date.getMonth();
			day = date.getDate();
		} else if (this.options.day.match(/^\d{4}-\d{2}-\d{2}$/g)) {
			var list = this.options.day.split("-");
			year = parseInt(list[0], 10);
			month = parseInt(list[1], 10) - 1;
			day = parseInt(list[2], 10);
		} else {
			$.error(this.locale.error_dateformat.format(this.options.day));
		}

		switch (this.options.view) {
			case "year":
				this.options.position.start.setTime(
					new Date(year, 0, 1).getTime()
				);
				this.options.position.end.setTime(
					new Date(year + 1, 0, 1).getTime()
				);
				break;
			case "month":
				this.options.position.start.setTime(
					new Date(year, month, 1).getTime()
				);
				this.options.position.end.setTime(
					new Date(year, month + 1, 1).getTime()
				);
				break;
			case "day":
				this.options.position.start.setTime(
					new Date(year, month, day).getTime()
				);
				this.options.position.end.setTime(
					new Date(year, month, day + 1).getTime()
				);
				break;
			case "week":
				var curr = new Date(year, month, day);
				var first;
				var firstday = curr.getDay();
				var weekday = parseInt(getExtentedOption(this, "first_day"));
				if (weekday === 0) weekday = 7;
				if (firstday - weekday === 0) {
					first = curr.getDate();
				} else if (firstday - weekday > 0) {
					first = curr.getDate() - (firstday - weekday);
				} else if (firstday - weekday < 0) {
					first = curr.getDate() - (7 - (weekday - firstday));
				}
				this.options.position.start.setTime(
					new Date(year, month, first).getTime()
				);
				this.options.position.end.setTime(
					new Date(year, month, first + 7).getTime()
				);
				break;
			default:
				$.error(this.locale.error_noview.format(this.options.view));
		}
		return this;
	};

	Calendar.prototype.getTitle = function() {
		var p = this.options.position.start;
		switch (this.options.view) {
			case "year":
				return this.locale.title_year.format(p.getFullYear());
				break;
			case "month":
				return this.locale.title_month.format(
					this.locale["m" + p.getMonth()],
					p.getFullYear()
				);
				break;
			case "week":
				return this.locale.title_week.format(
					p.getWeek(),
					p.getFullYear()
				);
				break;
			case "day":
				return this.locale.title_day.format(
					this.locale["d" + p.getDay()],
					p.getDate(),
					this.locale["m" + p.getMonth()],
					p.getFullYear()
				);
				break;
		}
		return;
	};

	Calendar.prototype.isToday = function() {
		var now = new Date().getTime();

		return (
			now > this.options.position.start && now < this.options.position.end
		);
	};

	Calendar.prototype.getStartDate = function() {
		return this.options.position.start;
	};

	Calendar.prototype.getEndDate = function() {
		return this.options.position.end;
	};

	Calendar.prototype.get_assistant_position = function(){
		let ret = [];
		$('.cal-day-assistant').each(function(id, el){
			ret.push($(el).data('assistant'));
		})
		return ret;
	}

	Calendar.prototype._loadEvents = function() {
		var self = this;
		var source = null;
		if (
			"events_source" in this.options &&
			this.options.events_source !== ""
		) {
			source = this.options.events_source;
		} else if ("events_url" in this.options) {
			source = this.options.events_url;
			warn(
				"The events_url option is DEPRECATED and it will be REMOVED in near future. Please use events_source instead."
			);
		}
		var loader;
		var source_type = typeof source;
		switch (source_type) {
			case "function":
				loader = function() {
					return source(
						self.options.position.start,
						self.options.position.end,
						browser_timezone
					);
				};
				break;
			case "array":
				loader = function() {
					return [].concat(source);
				};
				break;
			case "string":
				if (source.length) {
					loader = function() {
						var events = [];
						var params = {
							from: self.options.position.start.getTime(),
							to: self.options.position.end.getTime(),
							offset: self.options.position.start.getTimezoneOffset(),
							offsetEnd: self.options.position.end.getTimezoneOffset(),
							assistant_position: self.get_assistant_position()
						};
						if (browser_timezone.length) {
							params.browser_timezone = browser_timezone;
						}
						$.ajax({
							url: buildEventsUrl(source, params),
							dataType: "json",
							type: "GET",
							async: false,
						}).done(function(json) {
							if (!json.success) {
								$.error(json.error);
							}
							if (json.result) {
								events = json.result.events;
								sln_stats = json.result.stats;
								sln_assistants = json.result.assistants;
								sln_assistants_order = json.result.assistants_order;
							}
						});
						return events;
					};
				}
				break;
		}
		if (!loader) {
			$.error(this.locale.error_loadurl);
		}
		this.options.onBeforeEventsLoad.call(this, function() {
			self.options.events = loader();
			self.options.events.sort(function(a, b) {
				var delta;
				delta = a.start - b.start;
				if (delta == 0) {
					delta = a.end - b.end;
				}
				return delta;
			});
			self.options.onAfterEventsLoad.call(self, self.options.events);
		});
	};

	Calendar.prototype._templatePath = function(name) {
		if (typeof this.options.tmpl_path == "function") {
			return this.options.tmpl_path(name);
		} else {
			return this.options.tmpl_path + name + ".html";
		}
	};

	Calendar.prototype._loadTemplate = function(name) {
		if (this.options.templates[name]) {
			return;
		}
		var self = this;
		$.ajax({
			url: self._templatePath(name),
			dataType: "html",
			type: "GET",
			async: false,
			cache: this.options.tmpl_cache,
		}).done(function(html) {
			self.options.templates[name] = _.template(html);
		});
	};

	Calendar.prototype._update = function() {
		var self = this;
		// var is_touch_device = "ontouchstart" in document.documentElement;
		var tooltipShown = false;
		var currentTooltipId = null;
		Calendar.prototype.is_tooltip_shown = function(){
			return tooltipShown;
		};

		// if (!is_touch_device) {
			if($('*[data-option="day"]').length > 0)
			{
				$('*[data-option="day"]').on('show.bs.tooltip', function () {
					$('*[data-option="day"]').not(this).tooltip('hide');
				});
				$('*[data-option="day"]').tooltip({
					trigger: 'manual',
					placement: 'right',
				});

				$('[data-toggle="tooltip"]').tooltip({}).on('shown.bs.tooltip', function () {
					var $tooltip = $(this).next('.tooltip');
					var leftOffset = 10;
					var $arrow = $tooltip.find('.arrow');

					if(parseFloat($tooltip.css('top')) < 0){
						$tooltip.find('.tooltip-arrow').css('top', '+=' + $tooltip.css('top'));
						$tooltip.css('top', 0);
					}
					$tooltip.css('left', parseFloat($tooltip.css('left')) + leftOffset);
					$arrow.css('left', '-=' + leftOffset + 'px');
					$('.tooltip-inner').css('background-color', '#EFEFEF');
				});

				$(document).on('click', '.right-sln-tooltip-header', function() {
					$('*[data-option="day"]').tooltip('hide');

					$('[data-tooltip-id="' + currentTooltipId + '"].sln-event-header-more-icon').removeClass('sln-event-header-more-icon-horizontal')
						.addClass('sln-event-header-more-icon-vertical');
					$('.tooltip-arrow').css('border-right-color', '#EFEFEF');
					tooltipShown = false;
					currentTooltipId = null;

				});

			}else {
				$('*[data-toggle="tooltip"]').tooltip({ container: "body"});
			}
		// }

		$(".sln-event-header-more-icon").on("click", function () {

			var tooltipId = $(this).data("tooltip-id");

			if(tooltipShown)
			{
				$('*[data-option="day"]').tooltip('hide');
				$('[data-tooltip-id="' + currentTooltipId + '"].sln-event-header-more-icon').removeClass('sln-event-header-more-icon-horizontal')
					.addClass('sln-event-header-more-icon-vertical');
				$('.tooltip-arrow').css('border-right-color', '#EFEFEF');
				tooltipShown = false;
				currentTooltipId = null;

			} else {
				if(currentTooltipId != tooltipId && currentTooltipId != null)
				{
					$('[data-tooltip-id="' + currentTooltipId + '"]').tooltip('hide');
					$('[data-tooltip-id="' + currentTooltipId + '"].sln-event-header-more-icon').removeClass('sln-event-header-more-icon-horizontal')
						.addClass('sln-event-header-more-icon-vertical');
					tooltipShown = false;
				}

				if (!tooltipShown) {

					$(this).closest('div[data-tooltip-id="' + tooltipId + '"]').tooltip('show');
					$('.tooltip-arrow').css('border-right-color', '#EFEFEF');

					tooltipShown = true;
					currentTooltipId =  tooltipId;

					$('[data-tooltip-id="' + currentTooltipId + '"].sln-event-header-more-icon').removeClass('sln-event-header-more-icon-vertical')
						.addClass('sln-event-header-more-icon-horizontal');
				}

				if($('div[data-dup-icon]').attr('data-dup-icon') == "false") {
					$('[data-bookingid="' + currentTooltipId + '"].sln-dup-icon-tooltip').removeClass('sln-dup-icon-tooltip').addClass('sln-dup-close-icon-tooltip');
				}

				if (!($('#data-disc-sys').length > 0)) {
					$('#due-tooltip').hide();
					$('#discount-tooltip').hide();
					$('#deposit-tooltip').hide();
				}
			}
		});

		$("*[data-cal-date]").on("click", function() {
			var view = $(this).data("cal-view");
			self.options.day = $(this).data("cal-date");
			self.view(view);
		});
		$(".cal-cell").on("dblclick", function() {
			var view = $("[data-cal-date]", this).data("cal-view");
			self.options.day = $("[data-cal-date]", this).data("cal-date");
			self.view(view);
		});

		this["_update_" + this.options.view]();
		if (this.options.view !== "day" && this.options.view !== "week") {
			$(".cal-day-filter").addClass("hide");
			$(".sln-free-locked-slots").addClass("hide");
		}

		this._update_modal();
	};

	Calendar.prototype._update_modal = function() {
		var self = this;

		$("a[data-event-id]", this.context).off("click");

		if (!self.options.modal) {
			return;
		}

		var modal = $(self.options.modal);

		if (!modal.length) {
			return;
		}

		var ifrm = null;
		if (self.options.modal_type == "iframe") {
			ifrm = $(document.createElement("iframe")).attr({
				width: "100%",
				frameborder: "0",
			});
		}

		$("a[data-event-id]", this.context).on("click", function(event) {
			event.preventDefault();
			event.stopPropagation();

			var url = $(this).attr("href");
			var id = $(this).data("event-id");
			var event = _.find(self.options.events, function(event) {
				return event.id == id;
			});

			if (self.options.modal_type == "iframe") {
				ifrm.attr("src", url);
				$(".modal-body", modal).html(ifrm);
			}

			if (
				!modal.data("handled.bootstrap-calendar") ||
				(modal.data("handled.bootstrap-calendar") &&
					modal.data("handled.event-id") != event.id)
			) {
				modal
					.on("show.bs.modal", function() {
						var modal_body = $(this).find(".modal-body");
						switch (self.options.modal_type) {
							case "iframe":
								var height =
									modal_body.height() -
									parseInt(
										modal_body.css("padding-top"),
										10
									) -
									parseInt(
										modal_body.css("padding-bottom"),
										10
									);
								$(this)
									.find("iframe")
									.height(Math.max(height, 50));
								break;

							case "ajax":
								$.ajax({
									url: url,
									dataType: "html",
									async: false,
									success: function(data) {
										modal_body.html(data);
									},
								});
								break;

							case "template":
								self._loadTemplate("modal");
								//	also serve calendar instance to underscore template to be able to access current language strings
								modal_body.html(
									self.options.templates["modal"]({
										event: event,
										calendar: self,
									})
								);
								break;
						}

						//	set the title of the bootstrap modal
						if (_.isFunction(self.options.modal_title)) {
							modal
								.find("h3")
								.html(self.options.modal_title(event));
						}
					})
					.on("shown.bs.modal", function() {
						self.options.onAfterModalShown.call(
							self,
							self.options.events
						);
					})
					.on("hidden.bs.modal", function() {
						self.options.onAfterModalHidden.call(
							self,
							self.options.events
						);
					})
					.data("handled.bootstrap-calendar", true)
					.data("handled.event-id", event.id);
			}
			modal.modal("show");
		});
	};

	Calendar.prototype._update_day = function() {
		$("#cal-day-panel").height($("#cal-day-panel-hour").height());

		$("#cal-day-panel").width(
			$(".cal-day-panel__wrapper")[0].scrollWidth - 60
		);

		$(".cal-row-head").width($(".cal-day-panel__wrapper")[0].scrollWidth);

		var self = this;

		var pagination = "";

		var page = this.options._page;
		var max = this.options._max_page;
		for (var i = 0; i <= max; i++) {
			pagination += this.options.cal_day_pagination
				.replace(/%class/, i === page ? "active" : "")
				.replace(/%page/, i);
		}
		$(".cal-day-pagination").html(pagination);
		$(".cal-day-filter").removeClass("hide");
		$(".sln-free-locked-slots").removeClass("hide");
		$(".cal-day-pagination")
			.find(".btn")
			.on("click", function() {
				self.options._page = $(this).data("page");
				self._render();
			});

		self._update_day_prepare_sln_booking_editor();
	};

	Calendar.prototype._update_day_prepare_sln_booking_editor = function() {
		var calendar = this;

		var bookingId;
		var bookingDate;
		var bookingTime;
		var bookingCopy;


		$(document).on('click', ".sln-pen-icon-tooltip", function(event){
			$('*[data-toggle="tooltip"]').tooltip('hide');
			event.preventDefault();


			$('[data-action=duplicate-edited-booking]').show();

			var date = $(this)
				.closest("#cal-slide-box")
				.data("cal-date");
			//open active cell
			$("body").one("sln.calendar.after-view-load", function() {
				setTimeout(function() {
					$('[data-cal-date="' + date + '"]')
						.closest(".cal-month-day")
						.trigger("mouseenter")
						.trigger("click");
				}, 500);
			});

			bookingDate = bookingTime = undefined;
			bookingId = $(this).data('bookingid');
			show_modal_booking_editor();

		});

		$(".sln-icon--pen")
			.off("click")
			.on("click", function(e) {
				e.preventDefault();
				$('[data-action=duplicate-edited-booking]').show();

				var date = $(this)
					.closest("#cal-slide-box")
					.data("cal-date");
				//open active cell
				$("body").one("sln.calendar.after-view-load", function() {
					setTimeout(function() {
						$('[data-cal-date="' + date + '"]')
							.closest(".cal-month-day")
							.trigger("mouseenter")
							.trigger("click");
					}, 500);
				});

				bookingDate = bookingTime = undefined;
				bookingId = $(this)
					.closest(".event-item")
					.data("event-id");
				show_modal_booking_editor();
			});

		$(".events-list .event, .cal-cell1 .cal-event-week, .events-list .event, .cal-cell0 .cal-event-week")
			.off("click")
			.on("click", function(e) {
				e.preventDefault();
				e.stopPropagation();
				$('[data-action=duplicate-edited-booking]').show();

				bookingDate = bookingTime = undefined;
				bookingId = $(this).data("event-id");
				show_modal_booking_editor();
			}).off('mouseenter').on('mouseenter', function(e){
			$(this).closest('.cal-month-day').find('.sln-event-popup[data-event-id="' + $(this).data('event-id') + '"]').show();
		}).off('mouseleave').on('mouseleave', function(e){
			let event = $(this);
			setTimeout(function(){
				event.closest('.cal-month-day').find('.sln-event-popup[data-event-id="' + event.data('event-id') + '"]').removeAttr('style');
			}, 300);
		});
		$(".events-list .sln-booking-title-phone").off('click').on('click', function(e){
			// e.preventDefault();
			e.stopPropagation();
		});

		$("[data-action=add-event-by-date]")
			.off("click")
			.on("click", function() {
				bookingDate = $(this).data("event-date");
				bookingTime = $(this).data("event-time");
				console.log(
					"bookingDate=" + bookingDate + " bookingTime=" + bookingTime
				);
				bookingId = undefined;
				show_modal_booking_editor();
			});

		function show_modal_booking_editor() {
			if (replaceBookingModalWithPopup) {
				show_booking_editor_popup();
			} else {
				show_booking_editor();
			}
		}

		function show_booking_editor_popup() {
			var srcTemplate =
				bookingCopy === 'copy'
					? "src-template-duplicate-booking"
					: bookingId === undefined
						? "src-template-new-booking"
						: "src-template-edit-booking";
			bookingCopy = undefined;
			var $editor = $(".booking-editor");
			var editorLink = $editor
				.data(srcTemplate)
				.replace("%id", bookingId)
				.replace("%date", bookingDate)
				.replace("%time", bookingTime);

			editorLink = editorLink + '&sln_editor_popup=1'

			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=800,height=400,left=100,top=100`;
			var newWin = window.open(editorLink, 'window', params);
		}

		function show_booking_editor() {
			$("#wpwrap").css("z-index", "auto");
			$("#sln-booking-editor-modal")
				.off("show.bs.modal")
				.on("show.bs.modal", onShowModal)
				.off("hide.bs.modal")
				.on("hide.bs.modal", onHideModal)
				.modal();
		}

		function onShowModal() {
			launchLoadingSpinner();

			var $editor = $(".booking-editor");
			$editor
				.off("load.dismiss_spinner")
				.on("load.dismiss_spinner", onLoadDismissSpinner);
			$editor.off("load.hide_modal");

			var srcTemplate =
				bookingCopy === 'copy'
					? "src-template-duplicate-booking"
					: bookingId === undefined
						? "src-template-new-booking"
						: "src-template-edit-booking";
			bookingCopy = undefined;
			var editorLink = $editor
				.data(srcTemplate)
				.replace("%id", bookingId)
				.replace("%date", bookingDate)
				.replace("%time", bookingTime);
			$(function() {
				$(document).trigger("sln.iframeEditor.ready", [
					bookingId,
					bookingDate,
					srcTemplate,
					editorLink,
				]);
			});
			$editor.attr("src", editorLink);

			$("[data-action=save-edited-booking]")
				.off("click")
				.on("click", onClickSaveEditedBooking);
			$("[data-action=delete-edited-booking]")
				.off("click")
				.on("click", onClickDeleteEditedBooking);
			$("[data-action=duplicate-edited-booking]")
				.off("click")
				.on("click", onClickDuplicateEditedBooking);
		}

		function onHideModal() {
			$(".booking-editor").off("load");
			$(".booking-editor").attr("src", "");
			$("#sln-booking-editor-modal .booking-last-edit-div").html("");
			calendar.view();
		}

		function onClickSaveEditedBooking() {
			var $editor = $(".booking-editor");
			$editor
				.off("load.hide_modal")
				.on("load.hide_modal", onLoadAfterSubmit);
			$editor
				.off("load.dismiss_spinner")
				.on("load.dismiss_spinner", onLoadDismissSpinner);

			try {
				var validateBooking = window.frames[0].sln_validateBooking;
			} catch (e) {
				var validateBooking = window.frames[1].sln_validateBooking;
			}

			if (validateBooking()) {
				if(!$editor.contents().find('#save-post').attr('disabled')){
					launchLoadingSpinner();
				}else{
					$editor.contents().scrollTop($editor.contents().find('#sln_booking_services').offset().top);
					$editor.contents().find("#sln-alert-noservices").fadeIn();
				}
				$editor
					.contents()
					.find("#save-post")
					.trigger("click");
			}
		}

		function onClickDeleteEditedBooking() {
			var $editor = $(".booking-editor");
			$editor
				.off("load.hide_modal")
				.on("load.hide_modal", onLoadAfterSubmit);
			$editor
				.off("load.dismiss_spinner")
				.on("load.dismiss_spinner", onLoadDismissSpinner);

			try {
				var validateBooking = window.frames[0].sln_validateBooking;
			} catch (e) {
				var validateBooking = window.frames[1].sln_validateBooking;
			}

			if (validateBooking()) {
				launchLoadingSpinner();
				var href = $editor
					.contents()
					.find(".submitdelete")
					.attr("href");
				$.get(href);
				$("#sln-booking-editor-modal").modal("hide");
			}
		}

		function onClickDuplicateEditedBooking() {

			if ($(this).closest('.sln-duplicate-booking--disabled').length > 0) {
				return false;
			}

			var $editor = $(".booking-editor");
			bookingCopy = 'copy';
			bookingId = $('#post_ID', window.frames[0].document).val()
			$editor
				.off("load.hide_modal")
				.on("load.hide_modal", onLoadAfterSubmit);
			$editor
				.off("load.dismiss_spinner")
				.on("load.dismiss_spinner", onLoadDismissSpinner);

			try {
				var validateBooking = window.frames[0].sln_validateBooking;
			} catch (e) {
				var validateBooking = window.frames[1].sln_validateBooking;
			}

			if (validateBooking()) {
				launchLoadingSpinner();
				var href = $editor
					.contents()
					.find(".submitduplicate")
					.attr("href");
				$.get(href).success(function(data){
					$("#sln-booking-editor-modal").modal("hide");
					setTimeout(function(){
						show_modal_booking_editor();
						$('[data-action=duplicate-edited-booking]').hide();
					}, 1000);
				});
			}
		}

		function onLoadDismissSpinner() {
			cancelLoadingSpinner();
		}

		function onLoadAfterSubmit() {
			$("#sln-booking-editor-modal").modal("hide");
		}

		function launchLoadingSpinner() {
			var $modal = $("#sln-booking-editor-modal");
			if ($modal.find(".sln-booking-editor--wrapper").length) {
				$modal
					.find(".sln-booking-editor--wrapper--sub")
					.css("opacity", "0");
				$modal
					.find(".sln-booking-editor--wrapper")
					.addClass("sln-booking-editor--wrapper--loading");
			}
		}
		function cancelLoadingSpinner() {
			var $modal = $("#sln-booking-editor-modal");
			if ($modal.find(".sln-booking-editor--wrapper").length) {
				$modal
					.find(".sln-booking-editor--wrapper--sub")
					.css("opacity", "1");
				$modal
					.find(".sln-booking-editor--wrapper")
					.removeClass("sln-booking-editor--wrapper--loading");
			}
		}

		$(".day-event-item__calendar-day .sln-icon--plus-circle")
			.off("click")
			.on("click", function(event, triggered) {
				var dayEvent = $(event.target).closest(".day-event");
				var md = $(event.target).siblings(".more_details");
				var duration15 = $(this)
					.parent()
					.find(".duration-15");
				var dayContent = $(this)
					.parent()
					.find(".service_wrapper");
				if (!triggered) {
					$(".more_details").each(function() {
						if (
							$(this).css("display") != "none" &&
							$(this)[0] !== md[0]
						) {
							$(this)
								.siblings(".sln-icon--plus-circle")
								.trigger("click", true);
						}
					});
				}
				if (duration15.length) {
					$(duration15).each(function() {
						if ($(this).css("display") != "none") {
							$(this).hide();
							$(this)
								.parent()
								.addClass("duration-15__wrapper--closed");
						} else {
							$(this).show();
							$(this)
								.parent()
								.removeClass("duration-15__wrapper--closed");
						}
					});
				}
				if (md.css("display") == "none") {
					var neededHeight =
						230 +
						($(event.target)
							.siblings(".service_wrapper")
							.outerHeight(true) || 0);
					if (dayEvent.height() < neededHeight) {
						dayEvent.data("height", dayEvent.height());
						dayEvent.height(neededHeight);
					}
					dayEvent.css("z-index", 1001);
				} else {
					dayEvent.height(dayEvent.data("height"));
					dayEvent.removeData("height");
					dayEvent.css(
						"z-index",
						dayEvent.hasClass("day-event-main-block") ? 1000 : 999
					);
				}
				md.toggle();
				$(this).toggleClass("rotate");
			});
		if ($(".duration-15").length) {
			$(".duration-15").each(function() {
				3;
				$(this)
					.parent()
					.addClass(
						"duration-15__wrapper duration-15__wrapper--closed"
					);
			});
		}

		$(document).off('click', '.sln-dtn-danger-tooltip').on("click", ".sln-dtn-danger-tooltip", function(event) {
				event.preventDefault();
				var url = $(event.target).attr("href");
				$.get(url);

				$(event.target)
					.closest(".event-item")
					.trigger("mouseleave");

				calendar.view();
			});

		$(document).off('click', '.sln-btn-duplicate').on('click', ".sln-btn-duplicate", function(event){
			$('*[data-toggle="tooltip"]').tooltip('hide');
			event.preventDefault();
			bookingCopy = 'copy';
			bookingId = $(this).data('bookingid');
			show_modal_booking_editor();

			$('[data-action=duplicate-edited-booking]').hide();
		})

		$(document).off('click', '.sln-dtn-close-tooltip').on('click', ".sln-dtn-close-tooltip", function(event){
			event.preventDefault();
			$(".sln-confirm-delete-tooltip").css("display", "none");
		})

		$(document).off('click', '.sln-trash-icon-tooltip').on('click', ".sln-trash-icon-tooltip", function(event){
			event.preventDefault();
			$('[data-action=duplicate-edited-booking]').show();

			if ($(this).closest(".sln-free-version").length) {
				return false;
			}

			$(".sln-confirm-delete-tooltip").css("display", "block");
			$(".sln-confirm-delete-tooltip").css("color", "black");
			$(".sln-confirm-delete-tooltip").css("font-size", "1rem");
		})

		$(document).off('click', '.sln-dup-icon-tooltip').on('click', ".sln-dup-icon-tooltip", function(event){
			$('*[data-toggle="tooltip"]').tooltip('hide');
			event.preventDefault();
			bookingCopy = 'copy';
			bookingId = $(this).data('bookingid');
			show_modal_booking_editor();

			$('[data-action=duplicate-edited-booking]').hide();
		});

		$(".booking_tool_item .sln-icon--user-check")
			.off("click")
			.on("click", function(event) {
				event.preventDefault();
				if ($(this).closest(".sln-free-version").length) {
					return false;
				}
				var eventItem = $(event.target).closest(".event-item");
				var bookingId = eventItem.data("event-id");
				$.ajax({
					url:
						salon.ajax_url +
						"&action=salon&method=SetBookingOnProcess&id=" +
						bookingId,
					type: "POST",
					success: function($data) {
						var iconCheckmark = $(
							'.event-item[data-event-id="' +
							bookingId +
							'"] .sln-icon--checkmark'
						);
						if (!$data["on_process"]) {
							if (!iconCheckmark.hasClass("hide")) {
								iconCheckmark.addClass("hide");
							}
						} else {
							iconCheckmark.removeClass("hide");
						}
					},
				});
			});
	};

	Calendar.prototype._update_week = function() {
		var self = this;
		$(".cal-day-filter").removeClass("hide");
		setTimeout(function() {
			self._update_day_prepare_sln_booking_editor();
		}, 500);
	};

	Calendar.prototype._update_year = function() {
		this._update_month_year();
	};

	Calendar.prototype._update_month = function() {
		this._update_month_year();

		var self = this;

		var week = $(document.createElement("div")).attr("id", "cal-week-box");
		var start =
			this.options.position.start.getFullYear() +
			"-" +
			this.options.position.start.getMonthFormatted() +
			"-";
		$(".cal-month-box .cal-row-fluid")
			.on("mouseenter", function() {
				var p = new Date(self.options.position.start);
				var child = $(".cal-cell1:first-child .cal-month-day", this);
				var day = child.hasClass("cal-month-first-row")
					? 1
					: $("[data-cal-date]", child).text();
				p.setDate(parseInt(day));
				day = day < 10 ? "0" + day : day;
				week.html(self.locale.week.format(p.getWeek()));
				week.attr("data-cal-week", start + day)
					.show()
					.appendTo(child);
			})
			.on("mouseleave", function() {
				week.hide();
			});

		week.on("click", function() {
			self.options.day = $(this).data("cal-week");
			self.view("week");
		});

		$("a.event").on("mouseenter", function() {
			$('a[data-event-id="' + $(this).data("event-id") + '"]')
				.closest(".cal-cell1")
				.addClass("day-highlight dh-" + $(this).data("event-class"));
		});
		$("a.event").on("mouseleave", function() {
			$("div.cal-cell1").removeClass(
				"day-highlight dh-" + $(this).data("event-class")
			);
		});
	};

	Calendar.prototype._update_month_year = function() {
		if (!this.options.views[this.options.view].slide_events) {
			return;
		}
		var self = this;
		var activecell = 0;
		var downbox = $(document.createElement("div"))
			.attr("id", "cal-day-tick")
			.html(
				'<i class="icon-chevron-down glyphicon glyphicon-chevron-down"></i>'
			);

		$(".cal-month-day, .cal-year-box .span3")
			.on("mouseenter", function() {
				if ($(".events-list", this).length == 0) return;
				downbox.show().appendTo(this);
			})
			.on("mouseleave", function() {
				downbox.hide();
			})
			.on("click", function(event) {
				if ($(".events-list", this).length == 0) return;
				if (
					$(this)
						.children("[data-cal-date]")
						.text() == self.activecell
				)
					return;
				showEventsList(event, downbox, slider, self);
			});

		var slider = $(document.createElement("div")).attr(
			"id",
			"cal-slide-box"
		);
		slider.hide().on("click", function(event) {
			event.stopPropagation();
		});

		this._loadTemplate("events-list");

		downbox.on("click", function(event) {
			showEventsList(event, $(this), slider, self);
		});

		if (self.activecell) {
			$(".cal-month-day.cal-day-inmonth, .cal-year-box .span3").each(function () {
				if ($(this).find("[data-cal-date]").text() === self.activecell) {
					downbox.show().appendTo(this)
					downbox.trigger('click')
				}
			})
		}

		setTimeout(function() {
			self._update_day_prepare_sln_booking_editor();
		}, 500);
	};

	Calendar.prototype.getEventsBetween = function(start, end) {
		var events = [];

		$.each(this.options.events, function() {
			var s = this.start + new Date().getTimezoneOffset() * 60 * 1000;
			var e = this.end + new Date().getTimezoneOffset() * 60 * 1000;

			if (this.start == null) {
				return true;
			}
			var event_end = e || s;
			if (parseInt(s) < end && parseInt(event_end) >= start) {
				events.push(this);
			}
		});
		return events;
	};

	Calendar.prototype.applyAdvancedFilters = function(events) {
		var _events = [];

		var _customer = parseInt(this.options._customer);
		var _services = Array.isArray(this.options._services)
			? this.options._services
			: [];

		if (_customer || _services.length) {
			$.each(events, function() {
				var add = true;
				if (_customer && _customer !== this.customer_id) {
					add = false;
				}
				if (add && _services.length) {
					var intersect = this.services.filter(function(n) {
						return _services.indexOf(n) !== -1;
					});
					if (!intersect.length) {
						add = false;
					}
				}

				if (add) {
					_events.push(this);
				}
			});
		} else {
			_events = events;
		}

		return _events;
	};

	function showEventsList(event, that, slider, self) {
		event.stopPropagation();

		// NICO
		$(".selected").removeClass("selected");

		var that = $(that);
		var cell = that.closest(".cal-cell");
		var row = cell.closest(".cal-before-eventlist");
		var tick_position = cell.data("cal-row");
		var selectedDay = cell.children(".cal-month-day");

		slider.slideUp("fast", function() {
			// NICO
			cell.addClass("selected");
			var event_list = $(".events-list", cell);
			console.log(
				self.getEventsBetween(
					parseInt(event_list.data("cal-start")),
					parseInt(event_list.data("cal-end"))
				)
			);
			slider.html(
				self.options.templates["events-list"]({
					cal: self,
					events: self.getEventsBetween(
						parseInt(event_list.data("cal-start")),
						parseInt(event_list.data("cal-end"))
					),
				})
			);
			row.after(slider);
			self.activecell = $("[data-cal-date]", cell).text();
			slider.attr(
				"data-cal-date",
				$("[data-cal-date]", cell).data("cal-date")
			);

			slider.slideDown("fast", function() {
				$("body").one("click", function() {
					slider.slideUp("fast");
					// NICO
					cell.removeClass("selected");
					self.activecell = 0;
				});
			});
		});

		$("a.event-item").on("mouseenter", function() {
			$('a[data-event-id="' + $(this).data("event-id") + '"]')
				.closest(".cal-cell1")
				.addClass("day-highlight dh-" + $(this).data("event-class"));
		});
		$("a.event-item").on("mouseleave", function() {
			$("div.cal-cell1").removeClass(
				"day-highlight dh-" + $(this).data("event-class")
			);
		});

		// Wait 400ms before updating the modal (400ms is the time for the slider to fade out and slide up)
		setTimeout(function() {
			self._update_modal();
			self._update_day_prepare_sln_booking_editor();
		}, 400);
	}

	function getEasterDate(year, offsetDays) {
		var a = year % 19;
		var b = Math.floor(year / 100);
		var c = year % 100;
		var d = Math.floor(b / 4);
		var e = b % 4;
		var f = Math.floor((b + 8) / 25);
		var g = Math.floor((b - f + 1) / 3);
		var h = (19 * a + b - d - g + 15) % 30;
		var i = Math.floor(c / 4);
		var k = c % 4;
		var l = (32 + 2 * e + 2 * i - h - k) % 7;
		var m = Math.floor((a + 11 * h + 22 * l) / 451);
		var n0 = h + l + 7 * m + 114;
		var n = Math.floor(n0 / 31) - 1;
		var p = (n0 % 31) + 1;
		return new Date(year, n, p + (offsetDays ? offsetDays : 0), 0, 0, 0);
	}

	$.fn.calendar = function(params) {
		return new Calendar(params, this);
	};
	Beacon("once", "ready", () => {
		console.log(
			"This will only get called the first time the open event is triggered"
		);
		$("#beacon-container .BeaconContainer").prepend(
			'<a href="#nogo" class="sln-helpchat__close"><span class="sr-only">Close help chat</span></a>'
		);
	});
	$('#sln-note-phone-device .sln-popup--close').on('click', function(){
		$(this).closest('#sln-note-phone-device').hide();
	});
	$(document).on("click", ".sln-helpchat__close", function() {
		Beacon("close");
	});
})(jQuery);
