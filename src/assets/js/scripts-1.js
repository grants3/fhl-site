
//function scroll_to(clicked_link, nav_height) {
//	var element_class = clicked_link.attr('href').replace('#', '.');
//	var scroll_to = 0;
//	if(element_class != '.top-content') {
//		element_class += '-container';
//		scroll_to = $(element_class).offset().top - nav_height;
//	}
//	if($(window).scrollTop() != scroll_to) {
//		$('html, body').stop().animate({scrollTop: scroll_to}, 1000);
//	}
//}


jQuery(document).ready(function() {
	
    /*
        Background slideshow
    */
	if ($('.top-container').length){
		
		// $('.top-content').backstretch("assets/img/backgrounds/1.jpg");

	    /*
	     * Top container of each page. 
	     */
		$('.top-container').waypoint(function() {
			$('nav').toggleClass('navbar-no-bg');
		});
	}
   
    

	
});

function sortTable(table, col, reverse) {
    var tb = table.tBodies[0], // use `<tbody>` to ignore `<thead>` and `<tfoot>` rows
        tr = Array.prototype.slice.call(tb.rows, 0), // put rows into array
        i;
    reverse = -((+reverse) || -1);
    tr = tr.sort(function (a, b) { // sort rows
        return reverse // `-1 *` if want opposite order
            * (a.cells[col].textContent.trim() // using `.textContent.trim()` for test
                .localeCompare(b.cells[col].textContent.trim())
               );
    });
    for(i = 0; i < tr.length; ++i) tb.appendChild(tr[i]); // append each row in order
}

/*
 * 
 */
function makeSortable(table) {
    var th = table.tHead, i;
    th && (th = th.rows[0]) && (th = th.cells);
    if (th) i = th.length;
    else return; // if no `<thead>` then do nothing
    while (--i >= 0) (function (i) {
        var dir = 1; //0 for largest to smallest, 1 for smallest to largest
        th[i].addEventListener('click', function () {sortTable(table, i, (dir = 1 - dir))});
        
        //add blank link, swap text from header.
        var newLinkText = th[i].innerHTML;
        var newlink = document.createElement('a');
        newlink.setAttribute('href', '#');
        newlink.innerHTML = newLinkText;
        th[i].innerHTML = "";
        th[i].appendChild(newlink);
        
    }(i));
}

function makeAllSortable(parent) {
    parent = parent || document.body;
    var t = parent.getElementsByTagName('table'), i = t.length;
    while (--i >= 0) makeSortable(t[i]);
}

/*window.onload = function () {makeAllSortable();}; */


function makeTableSortable(tableId) {
    var t = document.getElementById(tableId);
    makeSortable(t);
}
