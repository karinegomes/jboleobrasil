(function(root, factory){
  root.StickyHeader = factory;
  if(typeof define === 'function' && define.amd){
    define([], function(){
      return root.StickyHeader;
    });
  } else if(typeof module === 'object' && module.exports){
    module.exports = root.StickyHeader;
  }
}(this, function(table){
	var
	insertAfter = function (newNode, referenceNode) {
		referenceNode.parentElement.insertBefore(newNode, referenceNode.nextElementSibling);
	},
	each = function(arr, handler){
		if(arr instanceof NodeList){ arr = Array.prototype.slice.call(arr, 0) };
		arr.forEach(handler);
	};

	if(!table.querySelectorAll('thead').length && !table.querySelectorAll('th').length) return;

	// Clone <thead>
	var
	$thead = table.querySelector('thead').cloneNode(true),
	$col   = table.querySelectorAll('thead th:first-of-type, tbody th'),
	$stickyWrap = document.createElement('div'),
	$stickyHead  = document.createElement('table'),
	$stickyCol   = null,
	$stickyInsct = null;

	// Add class, remove margins, reset width and wrap table
	table.classList.add('sticky-enabled');
	table.style.margin = 0;
	table.style.width = '100%';
	table.parentElement.insertBefore($stickyWrap, table);
	$stickyWrap.appendChild(table);

	$stickyWrap.classList.add('sticky-wrap');
	$stickyHead.classList.add('table', 'sticky-thead');

	if(table.classList.contains('overflow-y')){
		table.classList.remove('overflow-y');
		table.parentElement.classList.add('overflow-y');
	}

	// Create new sticky table head (basic)
	insertAfter($stickyHead, table);

	// If <tbody> contains <th>, then we create sticky column and intersect (advanced)
	if(table.querySelectorAll('tbody th').length > 0) {
		$stickyCol = document.createElement('table');
		$stickyInsct = document.createElement('table');
		$stickyCol.classList.add('sticky-col');
		$stickyInsct.classList.add('sticky-intersect');
		insertAfter($stickyCol, table);
		insertAfter($stickyInsct, table);
	}

	$stickyHead.appendChild($thead);

	if($stickyCol) each($col, function(cell){ $stickyCol.insertRow().appendChild(cell.cloneNode(true)) });
	if($stickyInsct) $stickyInsct.innerHTML = '<thead><tr><th>'+table.querySelector('thead th:first-child').innerHTML+'</th></tr></thead>';

	// Set widths
	var setWidths = function(){
		var headerCells = $stickyHead.querySelectorAll('th');
		each(table.querySelectorAll('thead th'), function (el, i) {
			headerCells[i].style.width = getComputedStyle(el).width;
		});

		if($stickyCol){
			var colRows = $stickyCol.querySelectorAll('tr');
			each(table.querySelectorAll('tr'), function (el, i) {
				colRows[i].style.height = getComputedStyle(el).height;
			});
		}

		// Set width of sticky table head
		$stickyHead.style.width = getComputedStyle(table).width;

		// Set width of sticky table col
		var firstCellWidth = getComputedStyle(table.querySelector('thead th')).width;
		$stickyCol && each($stickyCol.querySelectorAll('th'), function(el, i){ el.style.width = firstCellWidth });
		$stickyInsct && each($stickyInsct.querySelectorAll('th'), function(el, i){ el.style.width = firstCellWidth });
	},
	repositionStickyHead = function(){
		// Return value of calculated allowance
		var allowance = calcAllowance();

		// Check if wrapper parent is overflowing along the y-axis
		if(table.offsetHeight > $stickyWrap.offsetHeight) {
			// If it is overflowing (advanced layout)
			// Position sticky header based on wrapper scrollTop()
			if($stickyWrap.scrollTop > 0) {
				// When top of wrapping parent is out of view
				// $stickyHead.style.display = 'block';
				$stickyHead.style.top = $stickyWrap.scrollTop + 'px';

				if($stickyInsct){
					// $stickyInsct.style.display = 'block';
					$stickyInsct.style.top = $stickyWrap.scrollTop + 'px';
				}
			} else {
				// When top of wrapping parent is in view
				$stickyHead.style.top = 0;
				// $stickyHead.style.display = 'none';

				if($stickyInsct){
					$stickyInsct.style.top = 0;
					// $stickyInsct.style.display = 'none';
				}
			}
		} else {
			// If it is not overflowing (basic layout)
			// Position sticky header based on viewport scrollTop
			var tableScrollTop = tableScrollTop;
			if(window.scrollY > tableScrollTop && window.scrollTop() < tableScrollTop + table.offsetHeight - allowance) {
				// When top of viewport is in the table itself
				// $stickyHead.style.display = 'block';
				$stickyHead.style.top = window.scrollY - tableScrollTop;

				if($stickyInsct){
					// $stickyInsct.style.display = 'block';
					$stickyInsct.style.top = window.scrollY - tableScrollTop;
				}
			} else {
				// When top of viewport is above or below table
				$stickyHead.style.top = 0;
				// $stickyHead.style.display = 'none';

				if($stickyInsct){
					$stickyInsct.style.top = 0;
					// $stickyInsct.style.display = 'none';
				}
			}
		}
	},
	repositionStickyCol = function () {
		if($stickyWrap.scrollLeft > 0) {
			// When left of wrapping parent is out of view
			if($stickyCol){
				$stickyCol.style.display = 'block';
				$stickyCol.style.left = $stickyWrap.scrollLeft + 'px';
			}

			if($stickyInsct){
				$stickyInsct.style.display = 'block';
				$stickyInsct.style.left = $stickyWrap.scrollLeft + 'px';
			}
		} else {
			// When left of wrapping parent is in view
			if($stickyCol){
				$stickyCol.style.display = 'none';
				$stickyCol.style.left = 0;
			}
			if($stickyInsct){
				$stickyInsct.style.left = 0;
			}
		}
	},
	calcAllowance = function(){
		var a = 0;
		// Calculate allowance
		each(table.querySelectorAll('tbody tr:nth-child(-n+3)'), function(el){
			a += getComputedStyle(el).height;
		});

		// Set fail safe limit (last three row might be too tall)
		// Set arbitrary limit at 0.25 of viewport height, or you can use an arbitrary pixel value
		if(a > window.innerHeight*0.25) {
			a = window.innerHeight*0.25;
		}

		// Add the height of sticky header
		a += getComputedStyle($stickyHead).height;
		return a;
	},
	replaceHeaders = function(){
		$stickyHead.appendChild(table.replaceChild($thead, table.tHead));
	}

	setWidths();
	replaceHeaders();

	$stickyWrap.addEventListener('scroll', function(){
		repositionStickyHead();
		repositionStickyCol();
	});

	window.addEventListener('load', setWidths);
	window.addEventListener('scroll', repositionStickyHead);
	window.addEventListener('resize', function(){
		setWidths();
		repositionStickyHead();
		repositionStickyCol();
	});
}))
