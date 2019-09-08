function id(id) {
	return document.getElementById(id);
}

function toBrowser() {
	var browser = navigator.appName;
	var b_version = navigator.appVersion;
	if(browser == "Netscape") {
		return true;
	}
	var version = b_version.split(";");
	var trim_Version = version[1].replace(/[ ]/g, "");

	if(browser == "Microsoft Internet Explorer" && (trim_Version == "MSIE7.0" || trim_Version == "MSIE6.0" || trim_Version == "MSIE8.0")) {
		return false;
	} else {
		return true;
	}
}

function starMove(obj, target, iType, fnEnd, iDate) {
	if(obj.timer) {
		clearInterval(obj.timer);
	}
	if(iType == 1) {
		var sAttr = "";
		obj.iSpeed = {};
		for(sAttr in target) {
			obj.iSpeed[sAttr] = 0;
		}
	}
	if(target["transform"]) {
		if(obj["transform"]) {
			target["transform"] += obj["transform"];
		} else {
			css(obj, sAttr, 0);
		}
	}
	switch(iType) {
		case 0:
			obj.timer = setInterval(function() {
				doMoveBuffer(obj, target, fnEnd);
			}, 24);
			break;
		case 1:
			obj.timer = setInterval(function() {
				domoveFlexible(obj, target, fnEnd);
			}, 24);
			break;
	}
}

function doMoveBuffer(obj, target, fnEnd) {
	var sAttr = "";
	var iEnd = 1;
	for(sAttr in target) {
		if(toBrowser() == false && target["transform"]) {
			continue;
		}
		var iNow = parseFloat(css(obj, sAttr));
		if(iNow == target[sAttr]) {
			continue;
		} else {
			var iSpeed = (target[sAttr] - iNow) / 5;
			iSpeed *= 0.75;
			if(iSpeed > 0) {
				iSpeed = Math.ceil(iSpeed);
			} else {
				iSpeed = Math.floor(iSpeed);
			}
			css(obj, sAttr, iNow += iSpeed);
			iEnd = 0;
		}
	}
	if(iEnd) {
		clearInterval(obj.timer);
		if(fnEnd) {
			fnEnd.call(obj);
		}
	}
}

function domoveFlexible(obj, target, fnEnd) {
	var sAttr = "";
	var iEnd = 1;

	for(sAttr in target) {
		if(toBrowser() == false && target["transform"]) {
			continue;
		}
		var iNow = parseFloat(css(obj, sAttr));
		obj.iSpeed[sAttr] += (target[sAttr] - iNow) / 5;
		obj.iSpeed[sAttr] *= 0.75;
		if(Math.round(iNow) == target[sAttr] && Math.abs(obj.iSpeed[sAttr]) < 1) {
			continue;
		} else {
			iNow = Math.round(iNow + obj.iSpeed[sAttr]);
			css(obj, sAttr, iNow);
			iEnd = 0;
		}
	}
	if(iEnd) {
		clearInterval(obj.timer);
		if(fnEnd) {
			fnEnd.call(obj);
		}
	}
}

function css(obj, attr, value) {
	if(arguments.length == 2) {
		if(attr == "transform") {
			return obj.transform;
		}
		var i = parseFloat(obj.currentStyle ? obj.currentStyle[attr] : document.defaultView.getComputedStyle(obj, false)[attr]);
		var val = i ? i : 0;
		if(attr == "opacity") {
			val *= 100;
		}
		return val;
	} else if(arguments.length == 3) {
		switch(attr) {
			case 'width':
			case 'height':
			case 'paddingLeft':
			case 'paddingTop':
			case 'paddingRight':
			case 'paddingBottom':
				value = Math.max(value, 0);
			case 'left':
			case 'top':
			case 'marginLeft':
			case 'marginTop':
			case 'marginRight':
			case 'marginBottom':
				obj.style[attr] = value + 'px';
				break;
			case 'opacity':
				if(value < 0) {
					value = 0;
				}
				obj.style.filter = "alpha(opacity:" + value + ")";

				obj.style.opacity = value / 100;
				break;
			case 'transform':
				obj.transform = value;
				obj.style["transform"] = "rotate(" + value + "deg)";
				obj.style["MsTransform"] = "rotate(" + value + "deg)";
				obj.style["MozTransform"] = "rotate(" + value + "deg)";
				obj.style["WebkitTransform"] = "rotate(" + value + "deg)";
				obj.style["OTransform"] = "rotate(" + value + "deg)";
				break;
			default:
				obj.style[attr] = value;
		}

		return function(attr_in, value_in) {
			css(obj, attr_in, value_in)
		};
	}
}

function getClass(sClass, obj) {
	var aRr = [];
	if(obj) {
		var aTag = obj.getElementsByTagName('*');
	} else {
		var aTag = document.getElementsByTagName('*');
	}
	for(var i = 0; i < aTag.length; i++) {
		var aClass = aTag[i].className.split(" ");
		for(var j = 0; j < aClass.length; j++) {
			if(aClass[j] == sClass) {
				aRr.push(aTag[i]);
			}
		}
	}
	return aRr;
}

function byClient(obj, attr) {
	if(attr == "width") {
		return css(obj, "borderLeft") + css(obj, "borderRight") + css(obj, "paddingLeft") + css(obj, "paddingWidth") + css(obj, "paddingWidth");
	} else if(attr == "height") {
		return css(obj, "borderTop") + css(obj, "borderBottom") + css(obj, "paddingTop") + css(obj, "paddingBottom") + css(obj, "paddingHeight");
	}
}