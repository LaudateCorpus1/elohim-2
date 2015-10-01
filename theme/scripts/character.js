var dot_empty = "/images/dots/dot_empty.png",
    dot_filled = "/images/dots/dot_filled.png",
    box_empty = "/images/dots/box_empty.png",
    box_filled = "/images/dots/box_filled.png",
    icon_path = "/images/icons/";


var character = {
    init: function() {
        character.venues.init();
    },
    sheet: {
        init: function() {
            character.sheet.setDots();
        },
        setDots: function() {
            var dots = $('span.dot-block');

            console.log(dots.first().html());

            $.each(dots, function() {
                var row = $(this),
                    min = row.data('min'),
                    max = row.data('max'),
                    initial = row.data('initial'),
                    current = typeof row.data('current') == "undefined"?initial:row.data('current'),
                    type = row.data('type'),
                    empty = typeof type == "undefined" || type == "dot"?dot_empty:box_empty,
                    filled = typeof type == "undefined" || type == "dot"?dot_filled:box_filled,
                    html = "";

                for (var i = 0; i < max; i++) {
                    html += "<img src='" + (i < current || i < min?filled:empty) + "' data-value='" + (i + 1) + "' />";
                }
                row.html(html);

            });
        }
    },
    venues: {
        venues: false,
        venueModel: false,
        venueSelected: {},
        init: function() {
            character.venues.getVenues();
            character.venues.getVenueModel();
        },
        getVenues: function() {
            $.ajax({
                url: '/static/venues',
                dataType: 'json',
                type: 'get',
                success: function(data) {
                    character.venues.venues = data;
                    character.venues.buildVenues();
                }
            });
        },
        getVenueModel: function() {
            $.ajax({
                url: '/static/venuesModel',
                dataType: 'json',
                type: 'get',
                success: function(data) {
                    character.venues.venueModel = data;
                    character.venues.buildVenues();
                }
            })
        },
        buildVenues: function() {
            if (!character.venues.venues || !character.venues.venueModel) return false;

            character.venues.buildVenueOptions(character.venues.venueModel);

            $('#venues').find('button.venue-continue').bind('click.setVenue', function() {
                $('#characterSheetWrapper').addClass('venue-selected');
            });

            $('#venues').find('button.venue-reset').bind('click.resetSelections', function() {
                $('#venueOptions').html('');
                character.venues.venueSelected = {};
                character.venues.buildVenueOptions(character.venues.venueModel);
            });

            // DEBUGGER
            $('#venues').find('#venueOptions .venue').first().click();
            $('#venues').find('.venue-continue').click();

            return true;
        },
        buildVenueOptions: function(model) {
            var $venues = $('#venues'),
                $options = $venues.find('#venueOptions');

            $venues.removeClass('venue-selected');

            character.venues.buildVenueSelected();

            $.each(model, function(k, v) {
                if (!character.venues.venues[k].restricted) {
                    $options.append('<div class="venue"><h4>' + character.venues.venues[k].name + '</h4><img src="' + icon_path + '120/' + character.venues.venues[k].icon + '.png" /></div>');
                    $options.find('div.venue').last().bind('click.setVenue', function() {
                        $options.html('');
                        character.venues.venueSelected[k] = k;

                        var $_model;

                        $.each(character.venues.venueSelected, function(i, x) {
                            if (typeof model[i] == "object")
                                $_model = model[i];
                        });

                        if (typeof $_model == "object")
                            character.venues.buildVenueOptions($_model);
                        else {
                            character.venues.buildVenueSelected();
                            $venues.addClass('venue-selected');
                            character.venues.showVenueSelection();
                        }
                    });
                }
            });
        },
        buildVenueSelected: function () {
            var $venues = $('#venues'),
                $selected = $venues.find('#venueSelected');

            $selected.html('');

            $.each(character.venues.venueSelected, function(k, v) {
                $selected.append('<img src="' + icon_path + '40/' + character.venues.venues[k].icon + '.png" />')
            });
        },
        showVenueSelection: function() {
            var $venues = $('#venues'),
                $options = $venues.find('#venueOptions');

            $.each(character.venues.venueSelected, function(k, v) {
                $options.append('<div class="venue selected"><h4>' + character.venues.venues[k].name + '</h4><img src="' + icon_path + '120/' + character.venues.venues[k].icon + '.png" /></div>');
            });
        }
    }
};