/*
Copyright (c) 2009, www.redips.net  All rights reserved.
Code licensed under the BSD License: http://www.redips.net/license/

http://www.redips.net/javascript/drag-and-drop-table-content/
version 1.9.5
Mar 12, 2010.
*/

/*jslint white: true, browser: true, undef: true, nomen: true, eqeqeq: true, plusplus: false, bitwise: true, regexp: true, strict: true, newcap: true, immed: true, maxerr: 14 */
/*global window: false */



/* enable strict mode */
"use strict";

// create REDIPS namespace
var REDIPS = {};



REDIPS.drag = (function () {
	
		// function declaration
	var	init,					// initialization
		img_onmousemove,		// needed to set onmousemove event handler for images
		handler_onmousedown,	// onmousedown handler
		handler_onmouseup,		// onmouseup handler
		handler_onmousemove,	// onmousemove handler for the document level
		handler_onresize,		// onresize window event handler
		set_trc,				// function sets current table, row and cell
		set_color,				// function sets color for the current table cell and remembers previous location and color
		box_offset,				// calculates object (box) offset (top, right, bottom, left)
		calculate_cells,		// calculates table colums and row offsets (cells dimensions)
		getScrollPosition,		// returns scroll positions in array
		autoscrollX,			// horizontal auto scroll function
		autoscrollY,			// vertical auto scroll function
		clone_object,			// clone object
		clone_limit,			// clone limit (after cloning object, take care about climit1_X or climit2_X classnames)
		elementControl,			// function returns true or false if element needs to have control
		trash_delete,			// delete DIV object
		enable_drag,			// function attach / detach onmousedown event for DIV elements
		save_content,			// scan tables, prepare query string and sent to the multiple-parameters.php
	
		// private parameters
		obj_margin = null,		// space from clicked point to the object bounds (top, right, bottom, left)
		mouseButton = 0,		// if mouseButton == 1 then first mouse button is pressed
		mouseX = null,			// mouse coordinates (used in onmousedown, onmousemove and autoscroll)
		mouseY = null,
		window_width = 0,		// window width and height (parameters are set in onload and onresize event handler)
		window_height = 0,
		scroll_width = null,	// scroll width and height of the window (it is usually greater then window)
		scroll_height = null,
		edgeX = 0,				// autoscroll bound values (closer to the page edge, faster scroll) calculated in onmousemove handler
		edgeY = 0,
		bgcolor_old = null,		// old cell background color
		tables = [],			// table offsets and row offsets (initialized in onload event)
		autoscrollX_flag = 0,	// needed to prevent multiple calls of autoscrollX and autoscrollY from onmousemove event handler
		autoscrollY_flag = 0,
		moved_flag = 0,			// if object is moved, flag gets value 1  
		cloned_flag = 0,		// if object is cloned, flag gets value 1
		cloned_id = [],			// needed for increment ID of cloned elements
		currentCell = [],		// current cell bounds: top, right, bottom, left (decrease number calls of set_trc)
		div_drag = null,		// reference to the div drag
		div_box = null,			// div drag box: top, right, bottom and left margin (decrease number calls of set_trc)
		
		// selected, previous and source table, row and cell (private parameters too)
		table = null,
		table_old = null,
		table_source = null,
		row = null,
		row_old = null,
		row_source = null,
		cell = null,
		cell_old = null,
		cell_source = null,
		
		// variables in the private scope revealed as public (please see init())
		obj = false,				// (object) moved object
		obj_old = false,			// (object) previously moved object (before clicked or cloned)
		hover_color = '#E7AB83',	// (string) hover color
		bound = 25,					// (integer) bound width for autoscroll
		speed = 20,					// (integer) scroll speed in milliseconds
		mark_cname = 'mark',		// (string) class name for marked cells (default is 'mark')
		marked_cell = 'deny',		// (string) allow or deny access to the marked cell (values are 'allow' or 'deny' - default is 'deny')
		marked_exception = [],		// (array) DIVid -> classname, defined DIV elements that can be placed to the certain marked table cell
		trash = 'trash',			// (string) cell class name where draggable element will be destroyed
		trash_ask = true,			// (boolean) confirm object deletion (ask a question "Are you sure?" before delete)
		drop_option = 'multiple',	// (string) drop_option has three options: multiple, single and switch
		delete_cloned = true,		// (boolean) delete cloned div if the cloned div is dragged outside of any table
		target_cell = null,			// (object) target table cell (defined in onmouseup) 
		source_cell = null;			// (object) source table cell (defined in onmouse down and in onmouseup)



	// initialization
	init = function () {
		// define local variables
		var self = this,		// assign reference to current object to "self"
			i, j,				// used in local for loops
			imgs,				// collect images inside div=drag
			evt,				// event
			element,			// used in searhing parent nodes of found tables below div id="drag"
			table_nested,		// (boolean) flag - true / false
			tables_nodeList;	// live nodelist of tables found inside div=drag
		
		// set reference to the div with id=drag
		div_drag = document.getElementById('drag');
		// collect tables inside div with id=drag and make static nodeList
		tables_nodeList = div_drag.getElementsByTagName('table');
		// search for not nested tables
		for (i = 0, j = 0; i < tables_nodeList.length; i++) {
			// set table_nested flag to true and define parent node as search point
			table_nested = true;
			element = tables_nodeList[i].parentNode;
			// go up through DOM and search for id="drag" (DIV container)
			do {
				// id="drag" is found, set table_nested flag to false and break while loop
				if (element.id === 'drag') {
					table_nested = false;
					break;
				}
				// huh, this is nested table - break loop (table_nested flag remains "true") 
				if (element.nodeName === 'TABLE') {
					break;
				}
				// go one level up
				element = element.parentNode;
			} while (element);
			// if table isn't nested include it to tables[] array
			if (!table_nested) {
				tables[j] = tables_nodeList[i];
				j++;
			}
		}
		// set initial window width/height, scroll width/height and define onresize event handler
		// onresize event handler calls calculate columns
		handler_onresize();
		window.onresize = handler_onresize;
		// attach onmousedown event handler to the DIV elements
		enable_drag(true);
		// collect images inside div=drag to prevent default action of onmousemove event (needed for IE to enable dragging on image)
		imgs = div_drag.getElementsByTagName('img');
		// disable onmousemove event for images
		for (i = 0; i < imgs.length; i++) {
			imgs[i].onmousemove = img_onmousemove;
		}
		// dissable text selection (but not for links and form elements)
		div_drag.onselectstart = function (e) {
			evt = e || window.event;
			if (!elementControl(evt)) {
			    return false;
			}
		};
		// attach onscroll event (needed for recalculating table cells positions)
		window.onscroll = calculate_cells;
	};


	// needed to set onmousemove event handler for images (for IE to enable dragging DIV on image click)
	// used in init() function
	img_onmousemove = function () {
		return false;
	};


	// onmousedown handler
	handler_onmousedown = function (e) {
		var evt = e || window.event,	// define event (cross browser)
			offset;						// object offset
		// enable control for form elements
		if (elementControl(evt)) {
			return true;
		}
		// remember previous object if defined or set to the clicked object
		REDIPS.drag.obj_old = obj_old = obj || this;
		// set reference to the clicked object
		REDIPS.drag.obj = obj = this;
		// set high z-index if object isn't "clone" type - clone object is motionless
		if (obj.className.indexOf('clone') === -1) {
			obj.style.zIndex = 999;
		}
		// set clicked position
		mouseX = evt.clientX;
		mouseY = evt.clientY;
		// set current table, row and cell
		set_trc(evt);
		// remember start position (table, row and cell)
		table_source = table;
		row_source   = row;
		cell_source  = cell;
		// define source cell (needed for myhandlers)
		REDIPS.drag.source_cell = source_cell = tables[table_source].rows[row_source].cells[cell_source];
		// define pressed mouse button
		if (evt.which) {
			mouseButton = evt.which;
		}
		else {
			mouseButton = evt.button;
		}
		// activate onmousemove and onmouseup event handlers on document level
		// if left mouse button is pressed
		if (mouseButton === 1) {
			moved_flag  = 0; // reset moved_flag (needed for clone object in handler_onmousemove)
			cloned_flag = 0; // reset cloned_flag
			document.onmousemove = handler_onmousemove;
			document.onmouseup   = handler_onmouseup;
			REDIPS.drag.myhandler_clicked(); // call myhandler (public method)
		}
		// remember background cell color
		if (table !== null || row !== null || cell !== null) {
			bgcolor_old = tables[table].rows[row].cells[cell].style.backgroundColor;
		}
		// define object offset
		offset = box_offset(obj);
		// calculate ofsset from the clicked point inside element to the
		// top, right, bottom and left side of the element
		obj_margin = [mouseY - offset[0], offset[1] - mouseX, offset[2] - mouseY, mouseX - offset[3]];
		// disable text selection
		return false;
	};



	// onmouseup handler
	handler_onmouseup = function (e) {
		var evt = e || window.event,	// define event (FF & IE)
			target_table,				// needed for test if cloned element is dropped outside table
			i,							// used in local loop
			// define target elements and target elements length needed for switching table cells
			// target_elements_length is needed because nodeList objects in the DOM are live 
			// please see http://www.redips.net/javascript/nodelist-objects-are-live/
			target_elements, target_elements_length;
		// reset mouseButton variable
		mouseButton = 0;
		// reset left and top styles
		obj.style.left = 0;
		obj.style.top  = 0;
		// return z-index
		obj.style.zIndex = 10;
		// detach onmousemove and onmouseup events
		document.onmousemove = null;
		document.onmouseup   = null;
		// document.body.scroll... only works in compatibility (aka quirks) mode,
		// for standard mode, use: document.documentElement.scroll...
		scroll_width  = document.documentElement.scrollWidth;
		scroll_height = document.documentElement.scrollHeight;	
		// reset autoscroll flags
		autoscrollX_flag = autoscrollY_flag = 0;
		// this could happen if 'clone' element is placed in unmovable table cell
		if (cloned_flag === 1 && (table === null || row === null || cell === null)) {
			obj.parentNode.removeChild(obj);
			// decrease cloned_id counter
			cloned_id[obj_old.id] -= 1;
			REDIPS.drag.myhandler_notcloned();
		}
		// if ordinary element was clicked and left button was released, but element is placed inside unmovable table cell
		else if (table === null || row === null || cell === null) {
			REDIPS.drag.myhandler_notmoved();
		}		
		else {
			// if current table is in range, use table for current location
			if (table < tables.length) {
				target_table = tables[table];
				REDIPS.drag.target_cell = target_cell = target_table.rows[row].cells[cell];
			}
			// if any level of old position is undefined, then use source location
			else if (table_old === null || row_old === null || cell_old === null) {
				target_table = tables[table_source];
				REDIPS.drag.target_cell = target_cell = target_table.rows[row_source].cells[cell_source];
			}
			// or use the previous location
			else {
				target_table = tables[table_old];
				REDIPS.drag.target_cell = target_cell = target_table.rows[row_old].cells[cell_old];
			}
			// return background color for destination color (cell had hover color)
			target_cell.style.backgroundColor = bgcolor_old;

			// element was not moved - button was clicked and released
			// call myhandler_notmoved handler and place clicked element to the bottom of TD (if table cell contains more than one element)
			if (moved_flag === 0) {
				REDIPS.drag.myhandler_notmoved();
				target_cell.appendChild(obj);
			}
			// delete cloned object if dropped on the start position
			else if (cloned_flag === 1 && table_source === table && row_source === row && cell_source === cell) {
				obj.parentNode.removeChild(obj);
				// decrease cloned_id counter
				cloned_id[obj_old.id] -= 1;
				REDIPS.drag.myhandler_notcloned();
			}
			// delete cloned object if dropped outside current table and delete_cloned flag is true
			else if (cloned_flag === 1 && REDIPS.drag.delete_cloned === true &&
					(evt.clientX < target_table.offset[3] || evt.clientX > target_table.offset[1] || evt.clientY < target_table.offset[0] || evt.clientY > target_table.offset[2])) {
				obj.parentNode.removeChild(obj);
				// decrease cloned_id counter
				cloned_id[obj_old.id] -= 1;
				REDIPS.drag.myhandler_notcloned();
			}
			// remove object if destination cell has "trash" in class name
			else if (target_cell.className.indexOf(REDIPS.drag.trash) > -1) {
				// remove child from DOM (node still exists in memory)
				obj.parentNode.removeChild(obj);
				// if parameter trash_ask is "true", confirm deletion (function trash_delete is at bottom of this script)
				if (REDIPS.drag.trash_ask) {
					setTimeout(trash_delete, 10);
				}
				// else call myhandler_deleted handler (reference to the obj still exists)
				else {
					REDIPS.drag.myhandler_deleted();
					// if object is cloned, update climit1_X or climit2_X classname
					if (cloned_flag === 1) {
						clone_limit();
					}
				}
			}
			// switch source and destination content
			else if (REDIPS.drag.drop_option === 'switch') {
				// remove dragged element from DOM (source cell) - node still exists in memory
				obj.parentNode.removeChild(obj);
				// move object from the destination to the source cell
				target_elements        = target_cell.getElementsByTagName('DIV');
				target_elements_length = target_elements.length;
				for (i = 0; i < target_elements_length; i++) {
					// source_cell is defined in onmouseup
					source_cell.appendChild(target_elements[0]); // '0', not 'i' because NodeList objects in the DOM are live
				}
				// and finaly, append dragged object to the destination table cell
				target_cell.appendChild(obj);
				// if destination element exists, than elements are switched
				if (target_elements_length) {
					// call myhandler_switched because clone_limit could call myhandler_clonedend1 or myhandler_clonedend2
					REDIPS.drag.myhandler_switched();
					// and myhandler_dropped
					REDIPS.drag.myhandler_dropped(target_cell);
					// if object is cloned, update climit1_X or climit2_X classname
					if (cloned_flag === 1) {
						clone_limit();
					}
				}
				// otherwise element is dropped to the empty cells
				else {
					// call myhandler_dropped because clone_limit could call myhandler_clonedend1 or myhandler_clonedend2
					REDIPS.drag.myhandler_dropped(target_cell);
					// if object is cloned, update climit1_X or climit2_X classname
					if (cloned_flag === 1) {
						clone_limit();
					}
				}
			}
			// else append object to the cell and call myhandler_dropped 
			else {
				// append object to the target cell
				target_cell.appendChild(obj);
				// call myhandler_dropped because clone_limit could call myhandler_clonedend1 or myhandler_clonedend2
				REDIPS.drag.myhandler_dropped(target_cell);
				// if object is cloned, update climit1_X or climit2_X classname
				if (cloned_flag === 1) {
					clone_limit();
				}
			}
			// force naughty browsers (IE6, IE7 ...) to redraw source and destination row (element.className = element.className does the trick)
			// but careful (table_source || row_source could be null if clone element was clicked in denied table cell)
			if (table_source !== null && row_source !== null) {
				tables[table_source].rows[row_source].className = tables[table_source].rows[row_source].className;
			}
			target_cell.parentNode.className = target_cell.parentNode.className;
			// recalculate table cells and scrollers because cell content could change row dimensions 
			calculate_cells();
		}
		// reset old positions
		table_old = row_old = cell_old = null;
	};
	


	// onmousemove handler for the document level
	// activated after left mouse button is pressed on draggable element
	handler_onmousemove = function (e) {
		var evt = e || window.event,	// define event (FF & IE)
			bound = REDIPS.drag.bound;	// read "bound" public property (maybe code will be faster, and it will be easier to reference in onmousemove handler)
		// if moved_flag isn't set and object has clone in class name, then duplicate object, set cloned flag and call myhandler_cloned
		if (moved_flag === 0 && obj.className.indexOf('clone') > -1) {
			clone_object();
			cloned_flag = 1;
			REDIPS.drag.myhandler_cloned();
			// set color for the current table cell and remembers previous location and color
			set_color();
		}
		// object is only moved, call myhandler_moved and set color
		else if (moved_flag === 0) {
			REDIPS.drag.myhandler_moved();
			// set color for the current table cell and remembers previous location and color
			set_color();
		}
		// set moved_flag
		moved_flag = 1;
		// set left and top styles for the moved element if element is inside window
		// this conditions will stop element on window bounds
		if (evt.clientX > obj_margin[3] && evt.clientX < window_width - obj_margin[1]) {
			obj.style.left = (evt.clientX - mouseX) + "px";
		}
		if (evt.clientY > obj_margin[0] && evt.clientY < window_height - obj_margin[2]) {
			obj.style.top  = (evt.clientY - mouseY) + "px";
		}
		// set current table, row and cell if mouse pointer is inside div id=drag but out of the current cell (spare CPU)
		if (evt.clientX < div_box[1] &&	evt.clientX > div_box[3] &&
			evt.clientY < div_box[2] &&	evt.clientY > div_box[0] &&	
			(evt.clientX < currentCell[3] || evt.clientX > currentCell[1] || evt.clientY < currentCell[0] || evt.clientY > currentCell[2])) {
			set_trc(evt);
			// if new location is inside table and new location is different then old location
			// set background colors for the previous and new table cell
			if (table < tables.length && (table !== table_old || row !== row_old || cell !== cell_old)) {
				// set cell background color to the previous cell
				if (table_old !== null && row_old !== null && cell_old !== null) {
					tables[table_old].rows[row_old].cells[cell_old].style.backgroundColor = bgcolor_old;
				}
				// set color for the current table cell and remembers previous location and color
				set_color();
			}
		}
		// test if is still first mouse button pressed (in case when user release mouse button out of a window)
		if (evt.which) {
			mouseButton = evt.which;
		}
		else {
			mouseButton = evt.button;
		}
		// if first mouse button is released
		if (mouseButton !== 1) {
			handler_onmouseup(evt);
			return;
		}	
		// calculate horizontally crossed page bound
		edgeX = bound - (window_width / 2  > evt.clientX ? evt.clientX - obj_margin[3] : window_width - evt.clientX - obj_margin[1]);
		// if element crosses page bound then set scroll direction and call auto scroll 
		if (edgeX > 0) {
			// in case when object is only half visible (page is scrolled on that object)
			if (edgeX > bound) {
				edgeX = bound;
			}
			// set scroll direction: negative - left, positive - right
			edgeX *= evt.clientX < window_width / 2 ? -1 : 1; 
			// remove onscroll event handler and call autoscrollY function only once
			if (autoscrollX_flag++ === 0) {
				window.onscroll = null;
				autoscrollX('start');
			}
		}
		else {
			edgeX = 0;
		}
		// calculate vertically crossed page bound
		edgeY = bound - (window_height / 2 > evt.clientY ? evt.clientY - obj_margin[0] : window_height - evt.clientY - obj_margin[2]);
		// if element crosses page bound then set scroll direction and call auto scroll
		if (edgeY > 0) {
			// in case when object is only half visible (page is scrolled on that object)
			if (edgeY > bound) {
				edgeY = bound;
			}
			// set scroll direction: negative - up, positive - down
			edgeY *= evt.clientY < window_height / 2 ? -1 : 1;
			// remove onscroll event handler and call autoscrollY function only once
			if (autoscrollY_flag++ === 0) {
				window.onscroll = null;
				autoscrollY('start');
			}
		}
		else {
			edgeY = 0;
		}
		// stop all propagation of the event in the bubbling phase.
		// (save system resources by turning off bubbling)
		evt.cancelBubble = true;
		if (evt.stopPropagation) {
			evt.stopPropagation();
		}
	};



	// onresize window event handler
	// this event handler sets window_width and window_height variables used in onmousemove handler
	handler_onresize = function () {
		// Non-IE
		if (typeof(window.innerWidth) === 'number') {
			window_width  = window.innerWidth;
			window_height = window.innerHeight;
		}
		// IE 6+ in 'standards compliant mode'
		else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
			window_width  = document.documentElement.clientWidth;
			window_height = document.documentElement.clientHeight;
		}
		// IE 4 compatible
		else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
			window_width  = document.body.clientWidth;
			window_height = document.body.clientHeight;
		}
		// set scroll size (onresize, onload and onmouseup event)
		scroll_width  = document.documentElement.scrollWidth;
		scroll_height = document.documentElement.scrollHeight;
		// calculate colums and rows offset (cells dimensions)
		calculate_cells();  
	};


	
	// function sets current table, row and cell
	set_trc = function (evt) {
		var cell_current,				// define current cell (needed for some test at the function bottom)
			row_offset,					// row offsets for the selected table (row box bounds)
			cells,						// number of cells in the selected row
			has_content,				// has_content flag
			mark_found,					// found mark class name (-1 means not found)
			single_cell,				// table cell can be defined as single
			i;							// used in local loop
		// find table below draggable object
		for (table = 0; table < tables.length; table++) {
			// mouse pointer is inside table
			if (tables[table].offset[3] < evt.clientX  &&  evt.clientX < tables[table].offset[1] &&	
				tables[table].offset[0] < evt.clientY  &&  evt.clientY < tables[table].offset[2]) {
				// define row offsets for the selected table (row box bounds)
				row_offset = tables[table].row_offset;
				
				// find the current row (loop will stop at the current row; row_offset[row][0] is row top offset)
				for (row = 0; row < row_offset.length - 1 && row_offset[row][0] < evt.clientY; row++) {
					// set top and bottom cell bounds
					currentCell[0] = row_offset[row][0];
					currentCell[2] = row_offset[row + 1][0];
					// top bound of the next row
					if (evt.clientY <= currentCell[2]) {
						break;
					}
				}
				// if loop exceeds, then set bounds for the last row (offset for the last row doesn't work in IE8, so use table bounds) 
				if (row === row_offset.length - 1) {
					currentCell[0] = row_offset[row][0];
					currentCell[2] = tables[table].offset[2];
				}
				// do loop - needed for rowspaned cells (if there is any)
				do {
					// set the number of cells in the selected row
					cells = tables[table].rows[row].cells.length - 1;
					// find current cell (X mouse position between cell offset left and right)
					for (cell = cells; cell >= 0; cell--) {
						// row left offset + cell left offset
						currentCell[3] = row_offset[row][3] + tables[table].rows[row].cells[cell].offsetLeft;
						// cell right offset is left offset + cell width  
						currentCell[1] = currentCell[3] + tables[table].rows[row].cells[cell].offsetWidth;
						// is mouse pointer is between left and right offset, then cell is found
						if (currentCell[3] <= evt.clientX && evt.clientX < currentCell[1]) {
							break;
						}
					}
				} // mouse pointer is inside table but cell not found (hmm, rowspaned cell - try in upper row)
				while (cell === -1 && row-- > 0);
				// if cell < 0 or row < 0 use last possible location
				if (row < 0 || cell < 0) {
					table = table_old;
					row = row_old;
					cell = cell_old;
				}
				// set current cell
				cell_current = tables[table].rows[row].cells[cell];
				// if current cell isn't trash cell, then search for marks in class name								
				if (cell_current.className.indexOf(REDIPS.drag.trash) === -1) {
					// search for 'mark' class name
					mark_found = cell_current.className.indexOf(REDIPS.drag.mark_cname) > -1 ? true : false;
					// if current cell is marked and access type is 'deny' or current cell isn't marked and access type is 'allow'
					// then return previous location
					if ((mark_found === true && marked_cell === 'deny') || (mark_found === false && marked_cell === 'allow')) {
						// marked cell found, but make exception if defined pairs (DIV id -> class name) exists
						// means to bypass code
						if (cell_current.className.indexOf(marked_exception[obj.id]) === -1) {
							// if old location exists then assign old location
							if ((table_old !== null && row_old !== null && cell_old !== null)) {
								table = table_old;
								row = row_old;
								cell = cell_old;
							}
							break;
						}
					}
				}
				// test if current cell is defined as single
				single_cell = cell_current.className.indexOf('single') > -1 ? true : false;
				// if drop_option == single or current cell is single and current cell has child nodes then test if cell is occupied
				if ((REDIPS.drag.drop_option === 'single' || single_cell) && cell_current.childNodes.length > 0) {
					// if cell has only one node and that is text node then break - because this is empty cell
					if (cell_current.childNodes.length === 1 && cell_current.firstChild.nodeType === 3) {
						break;
					}
					// define and set has_content flag to false
					has_content = false;
					// open loop for each child node and jump out if 'drag' className found
					for (i = cell_current.childNodes.length - 1; i >= 0; i--) {
						if (cell_current.childNodes[i].className && cell_current.childNodes[i].className.indexOf('drag') > -1) {
							has_content = true;
							break;
						} 
					}
					// if cell has content and old position exists ...
					if (has_content && table_old !== null && row_old !== null && cell_old !== null) {
						// .. and current position is different then source position then return previous position
						if (table_source !== table || row_source !== row || cell_source !== cell) {
							table = table_old;
							row = row_old;
							cell = cell_old;
							break;
						}
					}
				}
				// break table loop 
				break;
			}
		}
	};



	// function sets color for the current table cell and remembers previous location and color
	// (it's called twice in handler_onmousemove)
	set_color = function () {
		// in case if ordinary element is placed inside 'deny' table cell
		if (table !== null && row !== null && cell !== null) {
			// remember background color before setting the new background color
			bgcolor_old = tables[table].rows[row].cells[cell].style.backgroundColor;
			// set background color to the current table cell
			tables[table].rows[row].cells[cell].style.backgroundColor = REDIPS.drag.hover_color;
			// remember current position (for table, row and cell)
			table_old = table;
			row_old = row;
			cell_old = cell;
		}
	};



	// calculates object (box) offset (top, right, bottom, left)
	// function returns array of box bounds
	// used in calculate_cells and onmousedown event handler
	box_offset = function (box) {
		var scrollPosition = getScrollPosition(),	// get scroll position
			oLeft = 0 - scrollPosition[0],			// define offset left (take care of horizontal scroll position)
			oTop  = 0 - scrollPosition[1],			// define offset top (take care od vertical scroll position)
			box_old = box;							// remember box object
		// loop to the root element and return box offset (top, right, bottom, left)
		do {
			oLeft += box.offsetLeft;
			oTop += box.offsetTop;
			box = box.offsetParent;
		}
		while (box);
		// return box offset array
		//       top               right,                     bottom             left
		return [ oTop, oLeft + box_old.offsetWidth, oTop + box_old.offsetHeight, oLeft ];
	};



	// calculates table colums and row offsets (cells dimensions) 
	calculate_cells = function () {
		var i, j,		// local variables used in loops
			row_offset;	// row box
		// open loop for each HTML table inside id=drag (tables array is initialized in onload event)
		for (i = 0; i < tables.length; i++) {
			// initialize row_offset array
			row_offset = [];
			// backward loop has better perfomance
			for (j = tables[i].rows.length - 1; j >= 0; j--) {
				row_offset[j] = box_offset(tables[i].rows[j]);
			}
			// save table informations (table offset and row offsets)
			tables[i].offset     = box_offset(tables[i]);
			tables[i].row_offset = row_offset;
		}
		// calculate box offset for the div id=drag
		div_box = box_offset(div_drag);
	};



	// function returns scroll positions in array
	getScrollPosition = function () {
		// define local scroll position variables
		var scrollX, scrollY;
		// Netscape compliant
		if (typeof(window.pageYOffset) === 'number') {
			scrollX = window.pageXOffset;
			scrollY = window.pageYOffset;
		}
		// DOM compliant
		else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
			scrollX = document.body.scrollLeft;
			scrollY = document.body.scrollTop;
		}
		// IE6 standards compliant mode
		else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
			scrollX = document.documentElement.scrollLeft;
			scrollY = document.documentElement.scrollTop;
		}
		// needed for IE6 (when vertical scroll bar was on the top)
		else {
			scrollX = scrollY = 0;
		}
		// return scroll positions
		return [ scrollX, scrollY ];
	};


	
	// horizontal auto scroll function
	autoscrollX = function (call) {
		// define old scroll position and current scroll position
		var old = 0, 
			scrollPosition = getScrollPosition()[0];
		// mouse button should be pressed and
		// if moved element is over left or right margin
		// scroll_width - window_width returns maximum horizontal scroll position
		if (mouseButton === 1 && ((edgeX < 0 && scrollPosition > 0) || (edgeX > 0 && scrollPosition < (scroll_width - window_width)))) {
			// horizontal window scroll 
			window.scrollBy(edgeX, 0);
			// set previous scroll position and new after window is scrolled
			old = scrollPosition;
			scrollPosition = getScrollPosition()[0];
			// set style left for the moved element
			obj.style.left = (parseInt(obj.style.left, 10) + scrollPosition - old) + "px";
			// move X point
			mouseX -= scrollPosition - old; 
			// recursive autoscroll call 
			setTimeout(REDIPS.drag.autoscrollX, REDIPS.drag.speed);
		}
		// autoscroll stopped after moving element out of the page edge
		// or element faced maximum position (left or right)
		else {
			// recalculate cell positions after autoscroll stopped
			if (call !== null) {
				calculate_cells();
			}
			// return onscroll event handler and reset auto scroll flag
			window.onscroll  = calculate_cells;
			autoscrollX_flag = 0;
		}
	};
	

	
	// vertical auto scroll function
	autoscrollY = function (call) {
		var top,		// top style
			old = 0,	// define old scroll position
			scrollPosition = getScrollPosition()[1];	// define current scroll position
		// mouse button should be pressed and 
		// if moved element is over page top or page bottom
		// scroll_height - window_height returns maximum vertical scroll position
		if (mouseButton === 1 && ((edgeY < 0 && scrollPosition > 0) || (edgeY > 0 && scrollPosition < (scroll_height - window_height)))) {
			// vertical window scroll 
			window.scrollBy(0, edgeY);
			// set previous scroll position and new after window is scrolled
			old = scrollPosition;
			scrollPosition = getScrollPosition()[1];
			// set top style of the object
			top = (isNaN(parseInt(obj.style.top, 10)) ? 0 : parseInt(obj.style.top, 10));
			// set style top for the moved element
			obj.style.top = (top + scrollPosition - old) + "px";
			// move Y point
			mouseY -= scrollPosition - old; 
			// recursive autoscroll call 
			setTimeout(REDIPS.drag.autoscrollY, REDIPS.drag.speed);
		}
		// autoscroll stopped after moving element out of the page edge
		// or element faced maximum position (top or bottom)
		else {
			// recalculate cell positions after autoscroll stopped
			if (call !== null) {
				calculate_cells();
			}
			// return onscroll event handler and reset auto scroll flag
			window.onscroll  = calculate_cells;
			autoscrollY_flag = 0;
		}
	};
	


	// clone object
	clone_object = function () {
		var obj_new = obj.cloneNode(true),	// clone object 
			offset,							// offset of the original object
			offset_dragged;					// offset of the new object (cloned)
		// append cloned element to the div element (id="obj_new")
		document.getElementById('obj_new').appendChild(obj_new);
		// define offset for original and cloned element
		offset = box_offset(obj);
		offset_dragged = box_offset(obj_new);
		// calculate top and left offset of the new object
		obj_new.style.top   = (offset[0] - offset_dragged[0]) + "px";
		obj_new.style.left  = (offset[3] - offset_dragged[3]) + "px";
		// set onmouse down event for the new object
		obj_new.onmousedown = handler_onmousedown;
		// remove clone from the class name of the new object
		obj_new.className = obj_new.className.replace('clone', '');
		// if counter is undefined, set 0
		if (cloned_id[obj.id] === undefined) {
			cloned_id[obj.id] = 0;
		}
		// set id for cloned element (append id of "clone" element - tracking the origin)
		// id is separated with "c" ("_" is already used to compound id, table, row and column)  
		obj_new.id = obj.id + 'c' + cloned_id[obj.id];
		// increment cloned_id for cloned element
		cloned_id[obj.id] += 1;
		// set new position because div is appended to div id="obj_new"
		mouseX -= parseInt(obj_new.style.left, 10);
		mouseY -= parseInt(obj_new.style.top, 10);
		// remember previous object (this is clone object)
		REDIPS.drag.obj_old = obj_old = obj;
		// set reference to the cloned object	
		REDIPS.drag.obj = obj = obj_new;
	};


	// after cloning object, take care about climit1_X or climit2_X classnames
	// function is called from handler_onmouseup
	// obj_old is reference to the clone object not cloned
	clone_limit = function () {
		// declare local variables 
		var match_arr,	// match array
			limit_type,	// limit type (1 - clone becomes "normal" drag element at last; 2 - clone element stays immovable)
			limit,		// limit number
			classes;	// class names of clone element
		// set classes of clone object
		classes = obj_old.className;
		// match climit class name		
		match_arr = classes.match(/climit(\d)_(\d+)/);
		// if class name contains climit option
		if (match_arr !== null) {
			// prepare limit_type (1 or 2) and limit
			limit_type = parseInt(match_arr[1], 10); 
			limit = parseInt(match_arr[2], 10);
			// decrease limit number and cut out "climit" class
			limit -= 1;
			classes = classes.replace(/climit\d_\d+/g, '');
			// test if limit drop to zero
			if (limit <= 0) {
				// no more cloning, cut "clone" from class names
				classes = classes.replace('clone', '');
				// if limit type is 2 then clone object becomes immovable
				if (limit_type === 2) {
					classes = classes.replace('drag', '');	// cut "drag" class
					obj_old.onmousedown = null;				// remove onmousedown event handler
					obj_old.style.cursor = 'auto';			// set cursor style to auto
					REDIPS.drag.myhandler_clonedend2();		// call myhandler_clonedend2 handler 
				}
				else {
					// call myhandler_clonedend1 handler
					REDIPS.drag.myhandler_clonedend1();
				}
			}
			// return "climit" class but with decreased limit_number
			else {
				classes = classes + ' climit' + limit_type + '_' + limit;
			}
			// normalize spaces and return classes to the clone object 
			classes = classes.replace(/^\s+|\s+$/g, '').replace(/\s{2,}/g, ' ');
			obj_old.className = classes;
		}
	};


	// function returns true or false if element needs to have control
	elementControl = function (evt) {
		// declare form element and source tag name
		var formElement, srcName;
		// set source tag name for IE and FF
		if (evt.srcElement) {
			srcName = evt.srcElement.tagName;
		}
		else {
			srcName = evt.target.tagName;
		}
		// set flag (true or false) for named elements
		switch (srcName) {
		case 'A':
		case 'INPUT':
		case 'SELECT':
		case 'OPTION':
			formElement = true;
			break;
		default:
			formElement = false;
		}
		// return formElement flag
		return formElement;
	};


	
	// delete DIV object
	trash_delete = function () {
		var div_text = 'element',	// div content (inner text)
			border;					// border color (green or blue)
		// find the border color of DIV element (t1 - green, t2 - blue, t3 - orange)
		if (obj.className.indexOf('t1') > 0) {
			border = 'green';
		}
		else if (obj.className.indexOf('t2') > 0) {
			border = 'blue';
		}
		else {
			border = 'orange';
		}
		// set div text (cross browser)
		if (obj.getElementsByTagName('INPUT').length || obj.getElementsByTagName('SELECT').length) {
			div_text = 'form element';
		}
		else if (obj.innerText || obj.textContent) {
			div_text = '"' + (obj.innerText || obj.textContent) + '"';
		}
		// ask if user is sure
		if (confirm('Delete ' + div_text + ' (' + border + ') from\n table ' + table_source + ', row ' + row_source + ' and column ' + cell_source + '?')) {
			// yes, user is sure only call myhandler_deleted function
			REDIPS.drag.myhandler_deleted();
			// if object is cloned, update climit1_X or climit2_X classname
			if (cloned_flag === 1) {
				clone_limit();
			}
		}
		// user is unsure - do undelete
		else {
			// undelete ordinary movable element
			if (cloned_flag !== 1) {
				// append removed object to the source table cell
				tables[table_source].rows[row_source].cells[cell_source].appendChild(obj);
				// and recalculate table cells because undelete can change row dimensions 
				calculate_cells();
			}
			// call undeleted handler
			REDIPS.drag.myhandler_undeleted();	
		}
	};



	// function attach / detach onmousedown event for DIV elements
	// input parameter is true or false
	enable_drag = function (enable) {
		// define local variables
		var i,				// for loop
			divs,			// collection of div elements contained in tables
			borderStyle,	// border style (solid or dotted)
			cursor,			// cursor style (move or auto)
			handler;		// onmousedown handler or null
		// define onmousedown handler and styles or null
		if (enable === true) {
			handler = handler_onmousedown;
			borderStyle = 'solid';
			cursor = 'move';
		}
		else {
			handler = null;
			borderStyle = 'dotted';
			cursor = 'auto';
		}
		// collect div elements inside tables (draggable elements)
		divs = document.getElementById('drag').getElementsByTagName('div');
		// attach onmousedown event handler only to DIV elements that have "drag" in class name
		// allow other div elements inside <div id="drag" ...
		for (i = 0; i < divs.length; i = i + 1) { 
			if (divs[i].className.indexOf('drag') > -1) {
				divs[i].onmousedown = handler;
				divs[i].style.borderStyle = borderStyle;
				divs[i].style.cursor = cursor;
			}
		}
	};



	// scan table content
	// table ordinal defines table to scan (so it could be first, second, third table ...)
	// if input parameter is not defined, function will prepare parameters for the first table
	save_content = function (tbl) {
		var query = '',		// define query parameter
			tbl_rows,		// number of table rows
			cells,			// number of cells in the current row
			tbl_cell,		// reference to the table cell		
			t, r, c, d;		// variables used in for loops
		// test input parameter
		if (tbl === undefined || tbl < 0 || tbl > tables.length - 1) {
			tbl = 0;
		}
		// define number of table rows
		tbl_rows = tables[tbl].rows.length;
		// iterate through each table row
		for (r = 0; r < tbl_rows; r++) {
			// set the number of cells in the current row
			cells = tables[tbl].rows[r].cells.length;
			// iterate through each table cell
			for (c = 0; c < cells; c++) {
				// set reference to the table cell
				tbl_cell = tables[tbl].rows[r].cells[c];
				// if cells isn't empty (no matter is it allowed or denied cell) 
				if (tbl_cell.childNodes.length > 0) {
					// cell can contain many DIV elements
					for (d = 0; d < tbl_cell.childNodes.length; d++) {
						// childNodes should be DIVs, not \n childs
						if (tbl_cell.childNodes[d].tagName === 'DIV') { // and yes, it should be uppercase
							query += 'p[]=' + tbl_cell.childNodes[d].id + '_' + r + '_' + c + '&';
						}
					}
				}
			}
		}
		// cut last '&'
		query = query.substring(0, query.length - 1);
		// return prepared parameters (if tables are empty, returned value could be empty too) 
		return query;
	};


	//
	// public methods and properties
	//

	return {
		obj					: obj,				// (object) moved object
		obj_old				: obj_old,			// (object) previously moved object (before clicked or cloned)
		target_cell			: target_cell,		// (object) target table cell (defined in onmouseup) 
		source_cell			: source_cell,		// (object) source table cell (defined in onmousedown)
		hover_color			: hover_color,		// (string) hover color
		bound				: bound,			// (integer) bound width for autoscroll
		speed				: speed,			// (integer)scroll speed in milliseconds
		mark_cname			: mark_cname,		// (string) class name for the marked table cell (default is 'mark')
		marked_cell			: marked_cell,		// (string) allow or deny access to the marked cell (values are 'allow' or 'deny' - default is 'deny')
		marked_exception	: marked_exception,	// (array) DIVid -> classname, defined DIV elements that can be placed to the certain marked table cell
		trash				: trash,			// (string) cell class name where draggable element will be destroyed		
		trash_ask			: trash_ask,		// (boolean) confirm object deletion (ask a question "Are you sure?" before delete)
		drop_option			: drop_option,		// (string) drop_option has three options: multiple, single and switch
		delete_cloned		: delete_cloned,	// (boolean)delete cloned div if the cloned div is dragged outside of any table
		cloned_id			: cloned_id,		// (array) needed for increment ID of cloned elements
        
		// assign public pointers
		init				: init,
		enable_drag			: enable_drag,
		save_content		: save_content,
		
		// autoscroll should be public because of setTimeout recursive call in autoscroll
		autoscrollX			: autoscrollX,
		autoscrollY			: autoscrollY,

		// needed for setting onmousedown event in myhandler actions  
		handler_onmousedown	: handler_onmousedown,

		/*
		 * Action handlers
		 * Each handler sees REDIPS.drag.obj, REDIPS.drag.obj_old, REDIPS.drag.target_cell ... reference
		 * Note: for the first dragging, REDIPS.drag.obj_old === REDIPS.drag.obj because REDIPS.drag.obj_old does not exist yet
		 */
		myhandler_clicked    : function () {},
		myhandler_moved      : function () {},
		myhandler_notmoved   : function () {},
		myhandler_dropped    : function () {},
		myhandler_switched   : function () {},
		myhandler_cloned     : function () {},
		myhandler_clonedend1 : function () {},
		myhandler_clonedend2 : function () {},
		myhandler_notcloned  : function () {},
		myhandler_deleted    : function () {},
		myhandler_undeleted  : function () {}
		
	}; // end of public (return statement)	
	
}());

