var keypressSlider = document.getElementById('keypress');
var input0 = document.getElementById('min_salary_range');
var input1 = document.getElementById('max_salary_range');
var inputs = [input0, input1];
var param1,param2;

noUiSlider.create(keypressSlider, {
	start: [0,0],
	connect: true,
	tooltips: [true, wNumb({ decimals: 1 })],
	range: {
		'min': [0],
		'10%': [2000],
		'50%': [100000],
		'80%': 150,
		'max': 200000
	},
});

keypressSlider.noUiSlider.on('update', function( values, handle ) {
	inputs[handle].value = values[handle];
});

function setSliderHandle(i, value) {
	var r = [null,null];
	r[i] = value;
	keypressSlider.noUiSlider.set(r);
}

function updateSlider(min,max){
	min = parseInt(min);
	max = parseInt(max);
	keypressSlider.noUiSlider.updateOptions({
		start:[min,max]
	})
}

// Listen to keydown events on the input field.
inputs.forEach(function(input, handle) {

	input.addEventListener('change', function(){
		setSliderHandle(handle, this.value);
	});

	input.addEventListener('keydown', function( e ) {

		var values = keypressSlider.noUiSlider.get();
		var value = Number(values[handle]);

		// [[handle0_down, handle0_up], [handle1_down, handle1_up]]
		var steps = keypressSlider.noUiSlider.steps();

		// [down, up]
		var step = steps[handle];

		var position;

		// 13 is enter,
		// 38 is key up,
		// 40 is key down.
		switch ( e.which ) {

			case 13:
				setSliderHandle(handle, this.value);
				break;

			case 38:

				// Get step to go increase slider value (up)
				position = step[1];

				// false = no step is set
				if ( position === false ) {
					position = 1;
				}

				// null = edge of slider
				if ( position !== null ) {
					setSliderHandle(handle, value + position);
				}

				break;

			case 40:

				position = step[0];

				if ( position === false ) {
					position = 1;
				}

				if ( position !== null ) {
					setSliderHandle(handle, value - position);
				}

				break;
		}
	});
});

