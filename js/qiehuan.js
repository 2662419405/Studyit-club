function miaovNext(aMotionData)
{
	var motion=null;
	var i=0;
	var complete=true;
	
	for(i=0;i<aMotionData.length;i++)
	{
		motion=aMotionData[i];
		
		//计算速度
		motion.speed=(motion.target-motion.cur)/8;
		motion.speed=motion.speed>0?Math.ceil(motion.speed):-Math.ceil(-motion.speed);
		
		//最大速度
		if(Math.abs(motion.speed)>motion.speedMax)
		{
			motion.speed=(motion.speed>0)?motion.speedMax:-motion.speedMax;
		}
		motion.cur+=motion.speed;
		
		if(motion.cur!=motion.target)
		{
			complete=false;
		}
	}
	
	if(complete)
	{
		for(i=0;i<aMotionData.length;i++)
		{
			aMotionData[i].cur=aMotionData[i].target;
			aMotionData[i].speed=0;
		}
		
		return true;
	}
	
	return false;
};

function MiaovMoveLib(aCur, aSpeedMax, fnDoMove, fnMoveEnd)
{
	var i=0;
	
	this.motionDatas=[];
	
	for(i=0;i<aCur.length;i++)
	{
		this.motionDatas[i]={target: aCur[i], speed:0, speedMax: aSpeedMax[i], cur:aCur[i]};
	}
	
	this.fnDoMove=fnDoMove;
	this.fnMoveEnd=fnMoveEnd;
	
	this.interval=40;
	
	this.timer=null;
	
	this.enabled=true;
}

MiaovMoveLib.prototype.setTarget=function (aValue)
{
	var t=(new Date()).getTime();
	var allSame=true;
	var i=0;

	for(i=0;i<aValue.length;i++)
	{
		this.motionDatas[i].target=parseInt(aValue[i]);
		if(this.motionDatas[i].target!=this.motionDatas[i].cur)
		{
			allSame=false;
		}
	}
	
	if(allSame)
	{
		if(!this.timer)
		{
			this.start();
		}
		return;
	}
	
	if(this.enabled)
	{
		if(!this.timer)
		{
			this.start();
		}
	}
};

MiaovMoveLib.prototype.setCurrent=function (aValue)
{
	var i=0;
	
	for(i=0;i<aValue.length;i++)
	{
		this.motionDatas[i].cur=parseInt(aValue[i]);
	}
};

MiaovMoveLib.prototype.start=function ()
{
	var obj=this;
	
	if(!this.enabled)
	{
		return;
	}
	
	if(this.timer)
	{
		clearInterval(this.timer);
	}
	else
	{
		this.timer=setInterval
		(
		 	function ()
			{
				obj.__timerHandler__();
			},
			this.interval
		);
	}
	
	this.iStartTime=((new Date()).getTime());
	this.iCounter=0;
};

MiaovMoveLib.prototype.stop=function ()
{
	if(this.timer)
	{
		clearInterval(this.timer);
		this.timer=null;
	}
};

MiaovMoveLib.prototype.__timerHandler__=function ()
{
	var bEnd=false;
	
	bEnd=miaovNext(this.motionDatas);
	
	if(bEnd)
	{
		if(this.fnMoveEnd)
		{
			this.fnMoveEnd(this.motionDatas);
		}
		
		this.fnDoMove(this.motionDatas);
		this.stop();
	}
	else
	{
		this.iCounter++;
		this.fnDoMove(this.motionDatas);
	}
};

function MiaovQuirkyPopup(oEleMove, oEleDrag, oEleBtn, oCloseBtn, oMaxSize, fnGetPos, fnGetSize, fnDoMove, fnDoResize, fnOnShowEnd, fnOnHideEnd)
{
	var obj=this;
	
	var oSize=fnGetSize();
	var oPos=fnGetPos();
	
	//保存信息
	this.__oEleMove__=oEleMove;
	this.__oEleDrag__=oEleDrag;
	this.__oEleBtn__=oEleBtn;
	
	this.__oMaxSize__=oMaxSize;
	
	this.__fnGetPos__=fnGetPos;
	this.__fnGetSize__=fnGetSize;
	this.__fnDoMove__=fnDoMove;
	this.__fnDoResize__=fnDoResize;
	
	this.__fnOnShowEnd__=fnOnShowEnd;
	this.__fnOnHideEnd__=fnOnHideEnd;
	
	//初始化内部对象
	this.__oDivOuter__=document.createElement('div');
	this.__oDivOuter__.style.display='none';
	this.__oDivOuter__.style.background='white';
	this.__oDivOuter__.style.width='100%';
	this.__oDivOuter__.style.filter='alpha(opacity=0)';
	this.__oDivOuter__.style.opacity='0';
	this.__oDivOuter__.style.top='0px';
	this.__oDivOuter__.style.left='0px';
	this.__oDivOuter__.style.position='absolute';
	this.__oDivOuter__.style.zIndex='3003';
	this.__oDivOuter__.style.overflow='hidden';
	this.__oDivOuter__.style.height=document.body.offsetHeight+"px";
	
	document.body.appendChild(this.__oDivOuter__);
	
	this.__oDrag__=new MiaovPerfectDrag
	(
		oEleDrag, fnGetPos,
		function (x, y)
		{
			var top=document.body.scrollTop || document.documentElement.scrollTop;
			
			if(x<0)
			{
				x=0;
			}
			else if(x+obj.__oMaxSize__.x>document.body.offsetWidth)
			{
				x=document.body.offsetWidth-obj.__oMaxSize__.x;
			}
			
			if(y<top)
			{
				y=top;
			}
			else if(y+obj.__oMaxSize__.y>top+document.documentElement.clientHeight)
			{
				y=top+document.documentElement.clientHeight-obj.__oMaxSize__.y;
			}
			
			
			oEleMove.style.left=x+'px';
			oEleMove.style.top=y+'px';
			
			obj.__oSpeed__.x=x-obj.__oLastPos__.x;
			obj.__oSpeed__.y=y-obj.__oLastPos__.y;
			
			obj.__oLastPos__.x=x;
			obj.__oLastPos__.y=y;
		},
		function ()	//开始拖拽时
		{
			obj.__oLastPos__=obj.__fnGetPos__();
			obj.stopMove();
			obj.__oDivOuter__.style.display='block';
		},
		function ()	//结束拖拽时
		{
			obj.startMove();
			obj.__oDivOuter__.style.display='none';
		}
	);
	this.__oDrag__.disable();
	
	this.__oLastPos__={x:0, y:0};
	this.__oSpeed__={x:0, y:0};
	this.__oMoveTimer__=null;
	
	this.__oMLResize__=new MiaovMoveLib
	(
		[oSize.x, oSize.y], [60, 60],
		function (arr)
		{
			obj.__fnDoMove__(oPos.x, oPos.y-arr[1].cur/2);
			obj.__fnDoResize__(arr[0].cur, arr[1].cur);
		},
		function ()
		{
			obj.__oDrag__.enable();
			obj.startMove();
			
			oCloseBtn.onmousedown=function ()
			{
				obj.hide();
			};
		}
	);
	
	this.__oMLMove__=new MiaovMoveLib
	(
		[0, 0], [40, 40],
		function (arr)
		{
			obj.__fnDoMove__(arr[0].cur, arr[1].cur);
		},
		function ()
		{
			obj.startShowBtn();
			obj.__oDock__.fnOnResizeOrScroll=function (oPos)
			{
				obj.__oEleMove__.left=-obj.__oMaxSize__.x+'px';
			};
		}
	);
	
	this.__oMLBtn__=new MiaovMoveLib
	(
		[0], [40],
		function (arr)
		{
			obj.__oDock__.move({left:arr[0].cur, top:0});
		},
		function ()	//特效结束时
		{
			if(this.isOpening)
			{
				obj.__oSpeed__.x=150+Math.ceil(Math.random()*150);
				obj.__oSpeed__.y=0;
				
				obj.startMove();
				obj.__oDrag__.enable();
				this.isOpening=false;
			}
		}
	);
	this.__oMLBtn__.isOpening=false;
	
	this.iAcc=3;
	this.fScale=-0.7;
	
	this.__oEleBtn__.style.display='block';
	this.__oDock__=new Dock(oEleBtn, DockType.LEFT|DockType.TOP, {left:-oEleBtn.offsetWidth, top:0}, null, null);
	
	this.__oEleBtn__.onclick=function ()
	{
		var top=document.body.scrollTop || document.documentElement.scrollTop;
		
		oEleMove.style.top=top+'px';
		obj.show();
	};
}

MiaovQuirkyPopup.prototype.initShow=function ()
{
	var obj=this;
	
	this.__oMLResize__.setTarget([this.__oMaxSize__.x, this.__oMaxSize__.y]);
};

MiaovQuirkyPopup.prototype.show=function ()
{
	this.__oDrag__.disable();
	this.stopMove();
	
	this.__oMLBtn__.setCurrent([0]);
	this.__oMLBtn__.setTarget([-this.__oEleBtn__.offsetWidth]);
	
	this.__oMLBtn__.isOpening=true;
};

MiaovQuirkyPopup.prototype.hide=function ()
{
	var obj=this;
	var oPos=this.__fnGetPos__();
	var oSize=this.__oDock__.getScreen();
	var top=document.body.scrollTop || document.documentElement.scrollTop;
	
	this.__oDrag__.disable();
	this.stopMove();
	
	this.__oMLMove__.setCurrent([oPos.x, oPos.y]);
	this.__oMLMove__.setTarget([-this.__oMaxSize__.x, oSize.top]);
	
	this.__oDock__.fnOnResizeOrScroll=function (oSize)
	{
		obj.__oMLMove__.setTarget([-obj.__oMaxSize__.x, oSize.top]);
	};
};

MiaovQuirkyPopup.prototype.startShowBtn=function ()
{
	this.__oMLBtn__.setCurrent([-this.__oEleBtn__.offsetWidth]);
	this.__oMLBtn__.setTarget([0]);
};

MiaovQuirkyPopup.prototype.startMove=function ()
{
	var obj=this;
	
	if(this.__oMoveTimer__)
	{
		clearInterval(this.__oMoveTimer__);
	}
	
	this.__oMoveTimer__=setInterval
	(
		function ()
		{
			obj.__doMove__();
		},
		30
	);
};

MiaovQuirkyPopup.prototype.stopMove=function ()
{
	clearInterval(this.__oMoveTimer__);
	this.__oMoveTimer__=null;
};

MiaovQuirkyPopup.prototype.__doMove__=function ()
{
	var oPos=this.__fnGetPos__();
	var r=document.body.offsetWidth-this.__oMaxSize__.x;
	var t=document.body.scrollTop || document.documentElement.scrollTop;
	var b=t+document.documentElement.clientHeight-this.__oMaxSize__.y;
	
	this.__oSpeed__.y+=this.iAcc;
	
	/*if(Math.abs(this.__oSpeed__.y)>10)
	{
		this.__oSpeed__.y=this.__oSpeed__.y>0?10:-10;
	}*/
	
	oPos.x+=this.__oSpeed__.x;
	oPos.y+=this.__oSpeed__.y;
	
	if(Math.abs(this.__oSpeed__.x)<1)
	{
		this.__oSpeed__.x=0;
	}
	
	if(Math.abs(this.__oSpeed__.y)<1)
	{
		this.__oSpeed__.y=0;
	}
	
	if(oPos.x<=0)
	{
		oPos.x=0;
		this.__oSpeed__.x*=this.fScale;
	}
	else if(oPos.x>=r)
	{
		oPos.x=r;
		this.__oSpeed__.x*=this.fScale;
	}
	
	if(oPos.y<=t)
	{
		oPos.y=t;
		this.__oSpeed__.y*=this.fScale;
	}
	else if(oPos.y>=b)
	{
		oPos.y=b;
		this.__oSpeed__.y*=this.fScale;
		this.__oSpeed__.x*=-this.fScale;
	}
	
	if(Math.abs(this.__oSpeed__.x)>0 || Math.abs(this.__oSpeed__.y)>0)
	{
		this.__fnDoMove__(oPos.x, oPos.y);
	}
};

if(typeof DockType == "undefined")
{
	DockType = 
	{
		LEFT:1,
		RIGHT:2,
		TOP:4,
		BOTTOM:8
	};
}


function Dock(oEle, iDirection, oDistance, fnOnBrowserChecked, fnOnResizeOrScroll)
{
	var bIsIe6=false;
	var obj=this;
	
	this.__oEle__=oEle;
	this.__iDir__=iDirection;
	this.__oDis__=oDistance;
	
	this.fnOnResizeOrScroll=fnOnResizeOrScroll;
	
	//check browser
	if(-1!=window.navigator.userAgent.indexOf('MSIE 6.0'))
	{
		if(-1!=window.navigator.userAgent.indexOf('MSIE 7.0') || -1!=window.navigator.userAgent.indexOf('MSIE 8.0'))
		{
			bIsIe6=false;
		}
		else
		{
			bIsIe6=true;
		}
	}
	else
	{
		bIsIe6=false;
	}
	
	this.bIsIe6=bIsIe6;
	
	if(fnOnBrowserChecked)
	{
		fnOnBrowserChecked(bIsIe6);
	}
	
	//change position
	if(bIsIe6)
	{
		oEle.style.position='absolute';
	}
	else
	{
		oEle.style.position='fixed';
	}
	
	//bind event
	if(bIsIe6)
	{
		miaovAppendEventListener
		(
			window, "scroll",
			function ()
			{
				obj.fixItem();
			}
		);
	}
	
	miaovAppendEventListener
	(
		window, "resize",
		function ()
		{
			obj.fixItem();
		}
	);
	
	this.fixItem();
}

Dock.prototype.getScreen=function ()
{
	var t=document.body.scrollTop || document.documentElement.scrollTop;
	
	return {left:0, right:document.documentElement.clientWidth, top:t, bottom:t+document.documentElement.clientHeight};
};

Dock.prototype.move=function (oDistance)
{
	this.__oDis__=oDistance;
	this.fixItem();
};

Dock.prototype.fixItem=function ()
{
	var t=document.body.scrollTop || document.documentElement.scrollTop;
	
	if(this.__iDir__&DockType.LEFT)
	{
		this.__oEle__.style.left=this.__oDis__.left+'px';
	}
	else if(this.__iDir__&DockType.RIGHT)
	{
		this.__oEle__.style.left=document.documentElement.clientWidth-this.__oDis__.right-this.__oEle__.offsetWidth+'px';
	}
	else if(this.__iDir__&DockType.BOTTOM)
	{
		if(this.bIsIe6)
		{
			this.__oEle__.style.top=t+document.documentElement.clientHeight-this.__oDis__.bottom-this.__oEle__.offsetHeight;
		}
		else
		{
			this.__oEle__.style.top=document.documentElement.clientHeight-this.__oDis__.bottom-this.__oEle__.offsetHeight;
		}
	}
	else if(this.__iDir__&DockType.TOP)
	{
		if(this.bIsIe6)
		{
			this.__oEle__.style.top=t+this.__oDis__.top+'px';
		}
		else
		{
			this.__oEle__.style.top=this.__oDis__.top+'px';
		}
	}
	
	if(this.fnOnResizeOrScroll)
	{
		this.fnOnResizeOrScroll({left:0, right:document.documentElement.clientWidth, top:t, bottom:t+document.documentElement.clientHeight});
	}
};

function MiaovPerfectDrag(oElementDrag, fnGetPos, fnDoMove, fnOnDragStart, fnOnDragEnd)
{
	var obj=this;
	
	this.oElement=oElementDrag;
	
	this.oElement.style.overflow='hidden';
	
	this.fnGetPos=fnGetPos;
	this.fnDoMove=fnDoMove;
	this.fnOnDragStart=fnOnDragStart;
	this.fnOnDragEnd=fnOnDragEnd;
	
	this.__oStartOffset__={x:0, y:0};
	
	this.oElement.onmousedown=function (ev)
	{
		obj.startDrag(window.event || ev);
	};
	
	this.fnOnMouseUp=function (ev)
	{
		obj.stopDrag(window.event || ev);
	};
	
	this.fnOnMouseMove=function (ev)
	{
		obj.doDrag(window.event || ev);
	};
}

MiaovPerfectDrag.prototype.enable=function ()
{
	var obj=this;
	
	this.oElement.onmousedown=function (ev)
	{
		obj.startDrag(window.event || ev);
	};
};

MiaovPerfectDrag.prototype.disable=function ()
{
	this.oElement.onmousedown=null;
};

MiaovPerfectDrag.prototype.startDrag=function (oEvent)
{
	var oPos=this.fnGetPos();
	
	var x=oEvent.clientX;
	var y=oEvent.clientY;
	
	if(this.fnOnDragStart)
	{
		this.fnOnDragStart();
	}
	
	this.__oStartOffset__.x=x-oPos.x;
	this.__oStartOffset__.y=y-oPos.y;
	
	if(this.oElement.setCapture)
	{
		this.oElement.setCapture();
		
		this.oElement.onmouseup=this.fnOnMouseUp;
		this.oElement.onmousemove=this.fnOnMouseMove;
	}
	else
	{
		document.addEventListener("mouseup", this.fnOnMouseUp, true);
		document.addEventListener("mousemove", this.fnOnMouseMove, true);
		
		window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP);
	}
};

MiaovPerfectDrag.prototype.stopDrag=function (oEvent)
{
	if(this.oElement.releaseCapture)
	{
		this.oElement.releaseCapture();
		
		this.oElement.onmouseup=null;
		this.oElement.onmousemove=null;
	}
	else
	{
		document.removeEventListener("mouseup", this.fnOnMouseUp, true);
		document.removeEventListener("mousemove", this.fnOnMouseMove, true);
		
		window.releaseEvents(Event.MOUSE_MOVE | Event.MOUSE_UP);
	}
	
	if(this.fnOnDragEnd)
	{
		if(oEvent.clientX==this.__oStartOffset__.x && oEvent.clientY==this.__oStartOffset__.y)
		{
			this.fnOnDragEnd(false);
		}
		else
		{
			this.fnOnDragEnd(true);
		}
	}
};

MiaovPerfectDrag.prototype.doDrag=function (oEvent)
{
	var x=oEvent.clientX;
	var y=oEvent.clientY;
	
	this.fnDoMove(x-this.__oStartOffset__.x, y-this.__oStartOffset__.y);
};

//事件辅助函数
function miaovAppendEventListener(obj, sEventName, fnEvent)
{
	if(obj.attachEvent)
	{
		obj.attachEvent('on'+sEventName, fnEvent);
	}
	else
	{
		obj.addEventListener(sEventName, fnEvent, false);
	}
}