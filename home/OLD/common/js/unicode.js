//------------- FROM VnExpress ------------------------------
var RefBanner = new Array();
var RefAdLogo = new Array();
var RefAdLBox = new Array();
var RefAdLBar = new Array();
var RefColumn = new Array();
var RefAdLeft = new Array();
var RefAdStay = 0;
var SkpFolder = true;
var CurBanner = 0;
var LastChild = 0;
var BannerLnk = 0;
var LComplete = 0;

if (typeof(SkipTopWindow) == 'undefined') { 

	if (window.parent!=window) {	

		alert('This website violate "The nhacSO.net © Copyright Notice".\r\nClick OK to Access nhacSO.net!');

		window.open(location.href, '_top', '');

	}

}

if (typeof(PageHost) == 'undefined') {
	var PageHost = '';
}

function UnicodeSet(iStr)
{
	for (i=0, oStr=''; i < iStr.length; i++)
	{
		switch ((j=iStr.charCodeAt(i)))
		{
		case 34:
			oStr=oStr.concat('&quot;');
			break;
		case 38:
			oStr=oStr.concat('&amp;');
			break;
		case 39:
			oStr = oStr.concat('&#39;');
			break;
		case 60:
			oStr = oStr.concat('&lt;');
			break;
		case 62:
			oStr = oStr.concat('&gt;');
			break;
		default:
			if (j < 32 || j > 127 || j==34 || j==39)
			{
				oStr=oStr.concat('&#').concat(j).concat(';');
			}
			else
			{
				oStr=oStr.concat(iStr.charAt(i)); 
			}
			break;
		}
	}
	
	return oStr;
}
function UnicodeGet(iStr)
{
	for (i=0, oStr=''; i < iStr.length; )
	{
		if (iStr.charCodeAt(i)==38)
		{
			if (iStr.charCodeAt(i + 1)==35)
			{
				p=iStr.indexOf(';', i  + 2);
				if (p!=-1)
				{
					if (p - i <= 7)
					{
						if (isFinite(iStr.substr(i + 2, p - i - 2)))
						{
							oStr = oStr.concat(String.fromCharCode(iStr.substr(i + 2, p - i - 2)));
							i = p + 1;
							continue;
						}
					}
				}
			}
			else
			{
				p=iStr.indexOf(';', i  + 1);
				if (p!=-1)
				{
					switch (iStr.substr(i + 1, p - i - 1))
					{
					case 'amp':
						oStr = oStr.concat('&');
						i = p + 1;
						break;
					case 'quot':
						oStr = oStr.concat('"');
						i = p + 1;
						break;
					case 'lt':
						oStr = oStr.concat('<');
						i = p + 1;
						break;
					case 'gt':
						oStr = oStr.concat('>');
						i = p + 1;
						break;
					}
				}
			}
		}
	
	
		oStr=oStr.concat(iStr.charAt(i));
		i++;
	}
	
	return oStr;
}


function openMeExt(vLink, vStatus, vResizeable, vScrollbars, vToolbar, vLocation, vFullscreen, vTitlebar, vCentered, vHeight, vWidth, vTop, vLeft, vID, vCounter)
{
	var sLink = (typeof(vLink.href) == 'undefined') ? vLink : vLink.href;

	winDef = '';
	winDef = winDef.concat('status=').concat((vStatus) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('resizable=').concat((vResizeable) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('scrollbars=').concat((vScrollbars) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('toolbar=').concat((vToolbar) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('location=').concat((vLocation) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('fullscreen=').concat((vFullscreen) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('titlebar=').concat((vTitlebar) ? 'yes' : 'no').concat(',');
	winDef = winDef.concat('height=').concat(vHeight).concat(',');
	winDef = winDef.concat('width=').concat(vWidth).concat(',');


	if (vCentered)
	{
		winDef = winDef.concat('top=').concat((screen.height - vHeight)/2).concat(',');
		winDef = winDef.concat('left=').concat((screen.width - vWidth)/2);
	}
	else
	{
		winDef = winDef.concat('top=').concat(vTop).concat(',');
		winDef = winDef.concat('left=').concat(vLeft);
	}

	if (typeof(vCounter) == 'undefined')
	{
		vCounter = 0;
	}

	if (typeof(vID) == 'undefined')
	{
		vID = 0;
	}

	if (vCounter)
	{
		//sLink = '';
	}
	
	open(sLink, '_blank', winDef);
	
	if (typeof(vLink.href) != 'undefined')
	{
		return false;
	}
}


function SetParameter(pFile, pName, pVal)
{
	if ((cPost=pFile.indexOf('&'.concat(pName).concat('=')))==-1)
	cPost=pFile.indexOf('?'.concat(pName).concat('='));

	if (cPost >= 0)
	{
		if ((pPost=pFile.indexOf('&', cPost + 1))==-1)
		{
			pFile=pFile.substring(0, cPost + pName.length + 2).concat(pVal);
		}
		else
		{
			pFile=pFile.substring(0, cPost + pName.length + 2).concat(pVal).concat(pFile.substr(pPost));
		}
	}
	else
	{
		if (pFile.indexOf('?')==-1)
		{
			pFile=pFile.concat('?').concat(pName).concat('=').concat(pVal);
		}
		else
		{
			pFile=pFile.concat('&').concat(pName).concat('=').concat(pVal);
		}
	}
	return pFile;
}
function PageSet(vPage)
{
	location.replace(SetParameter(location.href, 'p', vPage));
}

function ChangeBanner()
{
	if (RefBanner.length==0)
		return;

	CurBanner++;
	if (CurBanner >= RefBanner.length)
	{
		CurBanner=0;
	}

	document.links[BannerLnk].href= RefBanner[CurBanner][1];
	document.images['TopBanner'].src = PageHost.concat(RefBanner[CurBanner][0]);
	if (RefBanner[CurBanner][1] == '')
	{
		document.links[BannerLnk].onclick = function() { return false; };
	}
	else
	{
		document.links[BannerLnk].onclick = function() { return eval('openMeExt(this, '.concat(RefBanner[CurBanner][2]).concat(', 1)')); };
	}
}

function ChangeBanner_Outside()
{

	var ken_ad = new Array;	
	var total=3;
	//ken_ad[0]='<a href="http://www.cyworld.vn" target="_blank"><img src="/Images/khachhang/bannerTop_468X60.gif" border="0"></a>';		
//	ken_ad[0]='<a href="http://tl.gate.vn" target="_blank"><img src="/Images/khachhang/banner468x60.gif" border="0"></a>';
	ken_ad[0]='<a href="http://tl.gate.vn" target="_blank"><img src="/Images/khachhang/468x60.gif" border="0"></a>';
	ken_ad[2]='<a href="http://www.htmobile.com.vn/htmobile/htmls/index.php?tpl=info&mod=subinfo&p=85" target="_blank"><img src="/Images/khachhang/Nhacso-(468-X-60).gif" border="0"></a>';	
	ken_ad[1]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="480" height="60"><param name="movie" value="/Images/khachhang/viettel_468x60_270707.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/viettel_468x60_270707.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';
	//ken_ad[1]='<a href="http://www.viettelmobile.com.vn/home/news.jsp" target="_blank"><img src="/Images/khachhang/468-x-60px.gif" border="0"></a>';	
	
	ken_counter=ken_counter+1; if( ken_counter > (total-1) ) ken_counter = 0;
	
	findObj('ken').innerHTML = ken_ad[ken_counter]; 
	window.status = 'Banner #' + ken_counter + '/' + total;
}


function ChangeBanner_Inside()
{
	var ken_ad = new Array;	
	var total=3;
	//ken_ad[0]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="480" height="60"><param name="movie" value="/Images/khachhang/honda46860.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/honda46860.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';
	//ken_ad[1]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="480" height="60"><param name="movie" value="/Images/khachhang/honda46860.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/honda46860.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';	
	//ken_ad[0]='<a href="http://www.cyworld.vn" target="_blank"><img src="/Images/khachhang/bannerTop_468X60.gif" border="0"></a>';	
	ken_ad[2]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="480" height="60"><param name="movie" value="/Images/khachhang/viettel_468x60_270707.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/viettel_468x60_270707.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';
	ken_ad[1]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="468" height="60"><param name="movie" value="/Images/khachhang/nivea_468x60.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/nivea_468x60.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';
	ken_ad[0]='<a href="http://www.htmobile.com.vn/htmobile/htmls/index.php?tpl=info&mod=subinfo&p=85" target="_blank"><img src="/Images/khachhang/Nhacso-(468-X-60).gif" border="0"></a>';	
//	ken_ad[1]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="480" height="60"><param name="movie" value="/Images/khachhang/bannerQC_nhacso.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/bannerQC_nhacso.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';
	
//	ken_ad[2]='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="480" height="60"><param name="movie" value="/Images/khachhang/Castrol_468x60_150507.swf" /><param name="quality" value="high" /><PARAM NAME="WMode" VALUE="Transparent"><embed src="/Images/khachhang/Castrol_468x60_150507.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="480" height="60"></embed></object>';
	
	ken_counter=ken_counter+1; if( ken_counter > (total-1) ) ken_counter = 0;
	
	findObj('ken').innerHTML = ken_ad[ken_counter]; 
	window.status = 'Banner #' + ken_counter + '/' + total;
}


var ran_unrounded, ken_counter, ken_total;
function DisplayBanner(rbn)
{
	//-- Hacked by LongNN
	//
	if(rbn>=1000)
	{
		var left=400;
		var epsilon = (1024-screen.width)/2;
		
		left -= epsilon;
		
		document.write('<div id="ken" style="z-index: 100; position: absolute; top: 55px; left: '+left+'px; height: 60px; width: 468px;"></div>');

		ken_total = rbn/1000;
		ran_unrounded=Math.random()*ken_total ; ken_counter=Math.floor(ran_unrounded);
		
		if (typeof(rbn) == 'undefined')
		{
			rbn = 1;
		}

		if (rbn)
		{
			if( self.location == 'http://ns.gate.vn/Music/' || self.location == 'http://nhacso.net/Music/' || self.location == 'http://www.nhacso.net/Music/' ){
				
				ChangeBanner_Outside();
				setInterval('ChangeBanner_Outside()', 15000);				
			}	
			else{		
							
				ChangeBanner_Inside();
				setInterval('ChangeBanner_Inside()', 15000);
			}
		
		}
	}
	else
	{
		if (RefBanner.length==0)
		{
			return;
		}

		CurBanner=Math.floor(Math.random()*12321) % RefBanner.length;
		BannerLnk=document.links.length;
		if (RefBanner[CurBanner][1]=='')
		{
			document.write('<a href="', RefBanner[CurBanner][1], '" onClick="return false"><img name="TopBanner" src="', PageHost.concat(RefBanner[CurBanner][0]), '" width=468 height=60 border=0 style="padding-top: 10px; padding-left: 8px"></a>');
		}
		else
		{
			document.write('<a target="_blank" href="', RefBanner[CurBanner][1], '"><img name="TopBanner" src="', PageHost.concat(RefBanner[CurBanner][0]), '" width=468 height=60 border=0 style="padding-top: 10px; padding-left: 8px"></a>');
		}

		if (typeof(rbn) == 'undefined')
		{
			rbn = 1;
		}

		if (rbn)
		{
			setInterval('ChangeBanner()', 15000);
		}
	}
}

function ShowAdBox()
{
	if (RefAdLBox.length==0)
		return;

	//document.writeln('<table width="100%" cellspacing=0 cellpadding=0 border=0 bgcolor=red>');
	//document.writeln('<tr>');
	//document.writeln('<td width=190>');
	if (RefAdLBox[0][1] != '')
	{
		document.writeln('<a href="javascript:openMe(\'', RefAdLBox[0][1], '\', ', RefAdLBox[0][2], ')"><img src="', RefAdLBox[0][0], '" border=0></a>');
	}
	else
	{
		document.writeln('<img src="', RefAdLBox[0][0], '" border=0>');
	}
	//document.writeln('</td>');
	//document.writeln('<td width=1 bgcolor="#FFFFFF"><img src="/Images/white.gif" border=0></td>');
	//document.writeln('<td><img src="/Images/Advertising.gif" border=0></td>');
	//document.writeln('</tr>');
	//document.writeln('</table>');
}

function ShowAdLogoNew(sType)
{
	if (typeof(sType)=='undefined')
		sType = 2;

	switch (sType)
	{
	case 1:
		ShowAdLogoLeft();
		break;
	case 2:
		ShowAdLogoRight();
		break;
	}
}

function ShowAdLogoLeft()
{
	if (RefAdLeft.length==0)
	{
		//document.write('<table width=130 cellspacing=0 cellpadding=0 border=0 bgcolor="#808080">');
		//document.write('<tr>');
		//document.write('<td valign=top>');
		//document.write('<table cellspacing=1 cellpadding=4 border=0 width="100%">');

		//document.write('<tr><td height=60 align=center bgcolor="#ffffff"><a href="http://nhacso.net/Advertising" class=AdTitle>D&#224;nh cho <BR>Qu&#7843;ng c&#225;o</a></td></tr>');
	
		//document.write('</table>');	
		//document.write('</td>');
		//document.write('</tr>');
		//document.write('</table>');
	
		return;
	}

	//document.writeln('<table cellspacing=0 cellpadding=0 border=0>');

	for (i=0; i < RefAdLeft.length; i++)
	{
		if (i > 0)
		{
			//document.writeln('<tr><td height=2><img src="/Images/white.gif" border=0 height=1 width=1></td></tr>');
		}		

		//document.writeln('<tr><td>');

		w = 130;
		h = RefAdLeft[i][4];

		if (RefAdLeft[i][1] != '')
		{
			document.writeln('<a href="', RefAdLeft[i][1], '" onClick="return openMeExt(this, ', RefAdLeft[i][2], ', 1)"><img align=center src="', PageHost.concat(RefAdLeft[i][0]), '" width=', w, ' height=', h, ' border=0></a>');
		}
		else
		{
			document.writeln('<img align=center src="', PageHost.concat(RefAdLeft[i][0]), '" width=', w, ' height=', h, ' border=0>');
		}
		//document.writeln('</td></tr>');
	}

	//document.writeln('</table>');
}

function ShowAdLogoRight()
{
	if (RefAdLBox.length > 0)
	{
		//document.writeln('<table cellspacing=0 cellpadding=0 border=0>');

		for (i=0; i < RefAdLBox.length; i++)
		{
			//document.writeln('<tr><td>');

			w = 198;
			h = RefAdLBox[i][4];

			if (RefAdLBox[i][1] != '')
			{
				document.writeln('<a href="', RefAdLBox[i][1], '" onClick="return openMeExt(this, ', RefAdLBox[i][2], ', 1)"><img src="', PageHost.concat(RefAdLBox[i][0]), '" width=', w, ' height=', h, ' border=0 style=\'padding-left: 4px;\'></a>');
			}
			else
			{
				document.writeln('<img src="', PageHost.concat(RefAdLBox[i][0]), '" width=', w, ' height=', h, ' border=0 style=\'padding-left: 4px;\'>');
			}
			//document.writeln('</td></tr>');
		}

		//document.writeln('</table>');
	}

	if (RefColumn.length > 0)
	{
		//document.writeln('<table cellspacing=0 cellpadding=0 border=0>');

		for (i=0; i < RefColumn.length; i++)
		{
			//document.writeln('<tr><td>');

			w = 210;
			h = RefColumn[i][4];

			if (RefColumn[i][1] != '')
			{
				document.writeln('<a href="', RefColumn[i][1], '" onClick="return openMeExt(this, ', RefColumn[i][2], ', 1)"><img src="', PageHost.concat(RefColumn[i][0]), '" width=', w, ' height=', h, ' border=0 style=\'padding-left: 4px;\'></a>');
			}
			else
			{
				document.writeln('<img src="', PageHost.concat(RefColumn[i][0]), '" width=', w, ' height=', h, ' border=0 style=\'padding-left: 4px;\'>');
			}
			//document.writeln('</td></tr>');
		}

		//document.writeln('</table>');
	}
	
	//document.write('<table width=210 cellspacing=0 cellpadding=0 border=0 bgcolor="#808080">');
	//document.write('<tr>');
	//document.write('<td valign=top>');
	//document.write('<table cellspacing=1 cellpadding=4 border=0 width="100%">');

	if (RefAdLogo.length==0)
	{
		//document.write('<tr><td height=64 align=center bgcolor="#ffffff"><a href="http://nhacso.net/Advertising" class=TopStory>D&#224;nh cho Qu&#7843;ng c&#225;o</a></td></tr>');
	}
	else
	{
		CurAdLogo=RefAdStay + (Math.floor(Math.random()*12311) % (RefAdLogo.length - RefAdStay));

		var AdPost = new Array(new Array(0, RefAdStay), new Array(CurAdLogo, RefAdLogo.length), new Array(RefAdStay, CurAdLogo));

		for (k=0, j=0; k < 3; k++)
		{
			for (i=AdPost[k][0]; i < AdPost[k][1]; i++, j++)
			{
				//document.write('<tr>');
				if (RefAdLogo[i][1] != '')
				{
					document.write('<a href="', RefAdLogo[i][1], '" onClick="return openMeExt(this, ', RefAdLogo[i][2], ', 1)"><img src="', PageHost.concat(RefAdLogo[i][0]), '" border=0 width=210></a>');
				}
				else
				{
					document.write('<img src="', PageHost.concat(RefAdLogo[i][0]), '" border=0 width=210>');
				}

				if (j == 0)
				{
					//document.write('<td valign=top rowspan=', RefAdLogo.length, ' bgcolor="#FFFFFF">');
					//document.write('<table width="100%" cellspacing=0 cellpadding=0 border=0>');

					if (RefColumn.length==0)
					{
						//document.write('<tr><td height=64 align=center bgcolor="#CC0000"><a href="http://nhacso.net/Advertising" class=PnDTitle>D&#224;nh<BR>cho<BR>Qu&#7843;ng<BR>c&#225;o</a></td></tr>');
					}
					else
					{
						for (p=0; p < RefColumn.length; p++)
						{
							//document.write('<tr>');
							h = Math.floor(RefColumn[p][4]/60);
							h = (h > 1) ? h*60 + (h - 1)*9 : h*60;

							if (RefColumn[p][1] != '')
							{
								document.write('<a href="', RefColumn[p][1], '" onClick="return openMeExt(this, ', RefColumn[p][2], ', 1)"><img src="', PageHost.concat(RefColumn[p][0]), '" border=0 height=', h, ' width=60></a>');
							}
							else
							{
								document.write('<img src="', PageHost.concat(RefColumn[p][0]), '" border=0 height=', h, ' width=60>');
							}
							//document.write('</tr>');
							//document.write('<tr><td height=9></td></tr>');
						}
					}

					//document.write('</table>');	
					//document.write('</td>');
				}

				//document.write('</tr>');
			}
		}
	}

	//document.write('</table>');	
	//document.write('</td>');
	//document.write('</tr>');
	//document.write('</table>');
}

function xoadau(keyword)
{
	var len = keyword.length;
	var str = '', c;
	for(i=0; i < len; i++)
	{
		c = keyword.charCodeAt(i);
		// alert(c);
		

		if(( c>= 192 && c <= 195) || ( c>= 224 && c <= 227) || c==258 || c==259 || ( c>= 461 && c <= 7863))
		{
			str+='a';
		}else
			if(c==272 || c==273 )
			{
				str+='d';
			}else
				if((c>=200 && c<=202) || (c>=232 && c<=234) || ( c>= 7864 && c <= 7879))
				{
					str+='e';
				}else
					if(c==204 || c==205 ||c==236 || c==237 ||c==296 || c==297 || ( c>= 7880 && c <= 7883))
					{
						str+='i';
					}else
						if(c==217 || c==218 || c==249 || c==250 || c==360 || c==361 || c==431 || c==432 || ( c>= 7908 && c <= 7921))
						{
							str+='u';
						}else
							if((c>=210 && c<=213) || (c>=242 && c<=245) || c==416 || c==417 || ( c>= 7884 && c <= 7907))
							{
								str+='o';
							} else
								if(c==221 || c==253 || (c>= 7922 && c <= 7929))
								{
									str+='y';
								} else
									str+= keyword.charAt(i);
		// alert(c);
		//alert(keyword.charAt(i));
	}
	//alert(str);
	return str;
}

//-- Added by MrdotCOM
//
var req;
var caution = false
function loadXMLDoc(url, callbackFunction, desc, QUERY_STRING) 
{
	if(desc) window.status = desc;
	
    // branch for native XMLHttpRequest object
    if (window.XMLHttpRequest) {
        req = new XMLHttpRequest();
		req.onreadystatechange =	function()
									{
										// only if req shows "complete"
										if (req.readyState == 4) {
											eval(callbackFunction);
										}
									}
		if(QUERY_STRING)
		{
		    req.open("POST", url, true);
			req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			req.send(QUERY_STRING);
		}
        else
        {
	        req.open("GET", url, true);
	        req.send(null);
	    }
    // branch for IE/Windows ActiveX version
    } else if (window.ActiveXObject) {
        req = new ActiveXObject("Microsoft.XMLHTTP");
        if (req) {
        	req.onreadystatechange =	function()
										{
											// only if req shows "complete"
											if (req.readyState == 4) {
												eval(callbackFunction);
											}
										}
			if(QUERY_STRING)
			{
			    req.open("POST", url, true);
				req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
				req.send(QUERY_STRING);
			}
			else
			{
			    req.open("GET", url, true);
			    req.send(null);
			}
        }
    }
}
/**********************************************/
function findObj(id)
{
	return document.getElementById(id);
}
/**********************************************/
function showPLayer(link)
{
	var height = 60;
	var e = link.split('.'); e = e[e.length-1];

	height =300;

	var WMP7;
	try
	{
		if ( navigator.appName != "Netscape" )
		{
			WMP7 = new ActiveXObject('WMPlayer.OCX');
		}
	}
	catch (error)
	{
		;
	}
	var HTML = '';

	// Windows Media Player 7 Code
	if ( WMP7 )
	{
	HTML +=  ('<OBJECT height="'+height+'" width="100%" classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" VIEWASTEXT>');
	HTML +=  ('<PARAM NAME="URL" VALUE="'+link+'">');
	HTML +=  ('<PARAM NAME="rate" VALUE="1">');
	HTML +=  ('<PARAM NAME="balance" VALUE="0">');
	HTML +=  ('<PARAM NAME="currentPosition" VALUE="0">');
	HTML +=  ('<PARAM NAME="defaultFrame" VALUE="">');
	HTML +=  ('<PARAM NAME="playCount" VALUE="999">');
	HTML +=  ('<PARAM NAME="autoStart" VALUE="1">');
	HTML +=  ('<PARAM NAME="currentMarker" VALUE="0">');
	HTML +=  ('<PARAM NAME="invokeURLs" VALUE="-1">');
	HTML +=  ('<PARAM NAME="baseURL" VALUE="">');
	HTML +=  ('<PARAM NAME="mute" VALUE="0">');
	HTML +=  ('<PARAM NAME="uiMode" VALUE="full">');
	HTML +=  ('<PARAM NAME="stretchToFit" VALUE="0">');
	HTML +=  ('<PARAM NAME="windowlessVideo" VALUE="1">');
	HTML +=  ('<PARAM NAME="enabled" VALUE="-1">');
	HTML +=  ('<PARAM NAME="enableContextMenu" VALUE="0">');
	HTML +=  ('<PARAM NAME="fullScreen" VALUE="0">');
	HTML +=  ('<PARAM NAME="SAMIStyle" VALUE="">');
	HTML +=  ('<PARAM NAME="SAMILang" VALUE="">');
	HTML +=  ('<PARAM NAME="SAMIFilename" VALUE="">');
	HTML +=  ('<PARAM NAME="captioningID" VALUE="">');
	HTML +=  ('<PARAM NAME="Volume" VALUE="100">');
	HTML +=  ('</OBJECT>');
	}

	// Windows Media Player 6.4 Code
	else
	{
	HTML +=  ('<OBJECT  classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" ');
	HTML +=  ('codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" ');
	HTML +=  ('width="100%" height="'+height+'"');
	HTML +=  ('standby="Loading Microsoft Windows Media Player components..." ');
	HTML +=  ('type="application/x-oleobject" VIEWASTEXT> ');
	HTML +=  ('<PARAM NAME="FileName"           VALUE="'+link+'">');
	HTML +=  ('<PARAM NAME="TransparentAtStart" Value="false">');
	HTML +=  ('<PARAM NAME="AutoStart"          Value="true">');
	HTML +=  ('<PARAM NAME="AnimationatStart"   Value="false">');
	HTML +=  ('<PARAM NAME="ShowControls"       Value="false">');
	HTML +=  ('<PARAM NAME="ShowDisplay"	 value ="false">');
	HTML +=  ('<PARAM NAME="playCount" VALUE="999">');
	HTML +=  ('<PARAM NAME="displaySize" 	 Value="0">');
	HTML +=  ('<PARAM NAME="Volume" VALUE="100">');
	HTML +=  ('<Embed type="application/x-mplayer2" ');
	HTML +=  ('pluginspage= ');
	HTML +=  ('"http://www.microsoft.com/Windows/MediaPlayer/" ');
	HTML +=  ('src="'+link+'" ');
	HTML +=  ('Name=MediaPlayer ');
	HTML +=  ('transparentAtStart=0 ');
	HTML +=  ('autostart=1 ');
	HTML +=  ('playcount=999 ');
	HTML +=  ('volume=100');
	HTML +=  ('animationAtStart=0 '); 
	HTML +=  ('width="100%" height="'+height+'"');	
	HTML +=  ('displaySize=0></embed> ');
	HTML +=  ('</OBJECT> ');
	}	
	
		
	return '<div style="float: left; background: #000; border: 4px solid #000" align="center"><script type="text/javascript">new fadeshow(fadeimages_player, 340, 62, 0, 5000, 1, 0);</script><div align=right><a href="/Music/tuyenchon.asp" style="color: #fff; font-weight: bold; font-family: verdana; text-decoration: none">Xem các album khác >></a></div>' + HTML + '</div>';	
//	return '<div style="float: left; background: #000; border: 4px solid #000" align="center"><object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="340" height="62" id="image_loader" align="middle"><param name="allowScriptAccess" value="sameDomain" /><param name="movie" value="/Library/image_loader.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#000000" /><embed src="/Library/image_loader.swf" quality="high" bgcolor="#000000" width="340" height="62" name="image_loader" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object><div align=right><a href="/Music/tuyenchon.asp" style="color: #fff; font-weight: bold; font-family: verdana; text-decoration: none">Xem các album khác >></a></div>' + HTML + '</div>';	
}

function dd(linkz)
{
	var url = linkz.split('`');
	var key = findObj('vietkar9').getElementsByTagName('span'); key = key.length;
	
	var link = '';
	for(var i=0; i<=url.length - 2; i++)
	{
		link = link + String.fromCharCode(parseInt(parseInt(url[i])- key));
	}
	
	return link;
}

function showPLayerz(link)
{
	link = dd(link);

	var height=60;
	var addOn = '<div style="float: left; background: #000; border: 4px solid #000" align="center">';
	var e = link.split('.'); e = e[e.length-1];

//	var top100 	= '05F61B48|05F5FFF1|05F6098D|05F604E8|05F60809|05F60314|05F60A78|05F61700|05F6149B|05F61D1E|05F61D1F|05F61D23|05F61D3E|05F61D3C|05F61C5E|05F61B49|05F61C4D|05F61C53|05F61C50|05F61C56|05F61D1D|05F61D41|05F61B3E|05F618EC|05F61D3D|05F61C5C|05F61D40|05F61D42|05F61D22|05F61D21|05F60CCE|05F60AC1|05F61D20|05F61D26|05F61AB4|05F61C61|05F61C76|05F61C63|05F61B4B|05F61B89|05F618F3|05F61B46|05F61C51|05F61C4E|05F61B4C|05F61C5D|05F61C55|05F618F2|05F61B85|05F5EDDF|05F61C4F|05F60FAD|05F60990|05F619AD|05F5F152|05F61715|05F61C52|05F618EF|05F604EB|05F61D25|05F61B47|05F60C1A|05F60C15|05F61C64|05F61D28|05F5F089|05F61D45|05F619AE|05F61C54|05F61075|05F61B8B|05F60F46|05F604E9|05F60728|05F6095A|05F60F4B|05F60C18|05F61063|05F61065|05F604EC|05F616FD|05F61C57|05F61001|05F5FB1F|05F60C17|05F61D54|05F612CF|05F61C9C|05F61C60|05F60313|05F61D29|05F60CD1|05F5E41B|05F5F707|05F6098E|05F60B55|05F618F0|05F618EB|05F60C19|05F60F49';
	var top100 	= '';
	var selfL 	= ' ' + self.location;
		selfL	= selfL.split('/'); 
		selfL 	= selfL[selfL.length-2];
	if( top100.indexOf(selfL) == -1 )
	{
		height = 300; 
		addOn = '<div style="float: left; background: #000; border: 4px solid #000" align="center"><script type="text/javascript">new fadeshow(fadeimages_player, 340, 62, 0, 5000, 1, 0);</script><div align=right><a href="/Music/tuyenchon.asp" style="color: #fff; font-weight: bold; font-family: verdana; text-decoration: none">Xem các album khác >></a></div>';
	}
	else
	{
		height = 60;
		//addOn = '<div style="float: left; background: #000; border: 4px solid #000" align="center"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="350" height="240"><param name="movie" value="/Images/flashs/vnwoman350240.swf" /><param name="quality" value="high" /><embed src="/Images/flashs/vnwoman350240.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="350" height="240"></embed></object>';
	}
	
	var WMP7;
	try
	{
		if ( navigator.appName != "Netscape" )
		{
			WMP7 = new ActiveXObject('WMPlayer.OCX');
		}
	}
	catch (error)
	{
		;
	}
	var HTML = '';

	// Windows Media Player 7 Code
	if ( WMP7 )
	{
	HTML +=  ('<OBJECT height="'+height+'" width="100%" classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" VIEWASTEXT>');
	HTML +=  ('<PARAM NAME="URL" VALUE="'+link+'">');
	HTML +=  ('<PARAM NAME="rate" VALUE="1">');
	HTML +=  ('<PARAM NAME="balance" VALUE="0">');
	HTML +=  ('<PARAM NAME="currentPosition" VALUE="0">');
	HTML +=  ('<PARAM NAME="defaultFrame" VALUE="">');
	HTML +=  ('<PARAM NAME="playCount" VALUE="999">');
	HTML +=  ('<PARAM NAME="autoStart" VALUE="1">');
	HTML +=  ('<PARAM NAME="currentMarker" VALUE="0">');
	HTML +=  ('<PARAM NAME="invokeURLs" VALUE="-1">');
	HTML +=  ('<PARAM NAME="baseURL" VALUE="">');
	HTML +=  ('<PARAM NAME="mute" VALUE="0">');
	HTML +=  ('<PARAM NAME="uiMode" VALUE="full">');
	HTML +=  ('<PARAM NAME="stretchToFit" VALUE="0">');
	HTML +=  ('<PARAM NAME="windowlessVideo" VALUE="1">');
	HTML +=  ('<PARAM NAME="enabled" VALUE="-1">');
	HTML +=  ('<PARAM NAME="enableContextMenu" VALUE="0">');
	HTML +=  ('<PARAM NAME="fullScreen" VALUE="0">');
	HTML +=  ('<PARAM NAME="SAMIStyle" VALUE="">');
	HTML +=  ('<PARAM NAME="SAMILang" VALUE="">');
	HTML +=  ('<PARAM NAME="SAMIFilename" VALUE="">');
	HTML +=  ('<PARAM NAME="captioningID" VALUE="">');
	HTML +=  ('<PARAM NAME="Volume" VALUE="100">');
	HTML +=  ('</OBJECT>');
	}

	// Windows Media Player 6.4 Code
	else
	{
	HTML +=  ('<OBJECT classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" ');
	HTML +=  ('codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" ');
	HTML +=  ('width="100%" height="'+height+'"');
	HTML +=  ('standby="Loading Microsoft Windows Media Player components..." ');
	HTML +=  ('type="application/x-oleobject" VIEWASTEXT> ');
	HTML +=  ('<PARAM NAME="FileName"           VALUE="'+link+'">');
	HTML +=  ('<PARAM NAME="TransparentAtStart" Value="false">');
	HTML +=  ('<PARAM NAME="AutoStart"          Value="true">');
	HTML +=  ('<PARAM NAME="AnimationatStart"   Value="false">');
	HTML +=  ('<PARAM NAME="ShowControls"       Value="false">');
	HTML +=  ('<PARAM NAME="ShowDisplay"	 value ="false">');
	HTML +=  ('<PARAM NAME="playCount" VALUE="999">');
	HTML +=  ('<PARAM NAME="displaySize" 	 Value="0">');
	HTML +=  ('<PARAM NAME="Volume" VALUE="100">');
	HTML +=  ('<Embed type="application/x-mplayer2" ');
	HTML +=  ('pluginspage= ');
	HTML +=  ('"http://www.microsoft.com/Windows/MediaPlayer/" ');
	HTML +=  ('src="'+link+'" ');
	HTML +=  ('Name=MediaPlayer ');
	HTML +=  ('transparentAtStart=0 ');
	HTML +=  ('autostart=1 ');
	HTML +=  ('playcount=999 ');
	HTML +=  ('volume=100');
	HTML +=  ('animationAtStart=0 ');
	HTML +=  ('width="100%" height="'+height+'"');	
	HTML +=  ('displaySize=0></embed> ');
	HTML +=  ('</OBJECT> ');
	}
	
	return addOn + HTML + '</div>';	
}

function showPLayer_song(link)
{
	var height = 60;
	var e = link.split('.'); e = e[e.length-1];

	height =300;

	var WMP7;
	try
	{
		if ( navigator.appName != "Netscape" )
		{
			WMP7 = new ActiveXObject('WMPlayer.OCX');
		}
	}
	catch (error)
	{
		;
	}
	var HTML = '';

	// Windows Media Player 7 Code
	if ( WMP7 )
	{
	HTML +=  ('<OBJECT height="'+height+'" width="100%" classid="clsid:6BF52A52-394A-11d3-B153-00C04F79FAA6" VIEWASTEXT>');
	HTML +=  ('<PARAM NAME="URL" VALUE="'+link+'">');
	HTML +=  ('<PARAM NAME="rate" VALUE="1">');
	HTML +=  ('<PARAM NAME="balance" VALUE="0">');
	HTML +=  ('<PARAM NAME="currentPosition" VALUE="0">');
	HTML +=  ('<PARAM NAME="defaultFrame" VALUE="">');
	HTML +=  ('<PARAM NAME="playCount" VALUE="999">');
	HTML +=  ('<PARAM NAME="autoStart" VALUE="1">');
	HTML +=  ('<PARAM NAME="currentMarker" VALUE="0">');
	HTML +=  ('<PARAM NAME="invokeURLs" VALUE="-1">');
	HTML +=  ('<PARAM NAME="baseURL" VALUE="">');
	HTML +=  ('<PARAM NAME="mute" VALUE="0">');
	HTML +=  ('<PARAM NAME="uiMode" VALUE="full">');
	HTML +=  ('<PARAM NAME="stretchToFit" VALUE="0">');
	HTML +=  ('<PARAM NAME="windowlessVideo" VALUE="1">');
	HTML +=  ('<PARAM NAME="enabled" VALUE="-1">');
	HTML +=  ('<PARAM NAME="enableContextMenu" VALUE="0">');
	HTML +=  ('<PARAM NAME="fullScreen" VALUE="0">');
	HTML +=  ('<PARAM NAME="SAMIStyle" VALUE="">');
	HTML +=  ('<PARAM NAME="SAMILang" VALUE="">');
	HTML +=  ('<PARAM NAME="SAMIFilename" VALUE="">');
	HTML +=  ('<PARAM NAME="captioningID" VALUE="">');
	HTML +=  ('<PARAM NAME="Volume" VALUE="100">');
	HTML +=  ('</OBJECT>');
	}

	// Windows Media Player 6.4 Code
	else
	{
	HTML +=  ('<OBJECT  classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" ');
	HTML +=  ('codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,5,715" ');
	HTML +=  ('width="100%" height="'+height+'"');
	HTML +=  ('standby="Loading Microsoft Windows Media Player components..." ');
	HTML +=  ('type="application/x-oleobject" VIEWASTEXT> ');
	HTML +=  ('<PARAM NAME="FileName"           VALUE="'+link+'">');
	HTML +=  ('<PARAM NAME="TransparentAtStart" Value="false">');
	HTML +=  ('<PARAM NAME="AutoStart"          Value="true">');
	HTML +=  ('<PARAM NAME="AnimationatStart"   Value="false">');
	HTML +=  ('<PARAM NAME="ShowControls"       Value="false">');
	HTML +=  ('<PARAM NAME="ShowDisplay"	 value ="false">');
	HTML +=  ('<PARAM NAME="playCount" VALUE="999">');
	HTML +=  ('<PARAM NAME="displaySize" 	 Value="0">');
	HTML +=  ('<PARAM NAME="Volume" VALUE="100">');
	HTML +=  ('<Embed type="application/x-mplayer2" ');
	HTML +=  ('pluginspage= ');
	HTML +=  ('"http://www.microsoft.com/Windows/MediaPlayer/" ');
	HTML +=  ('src="'+link+'" ');
	HTML +=  ('Name=MediaPlayer ');
	HTML +=  ('transparentAtStart=0 ');
	HTML +=  ('autostart=1 ');
	HTML +=  ('playcount=999 ');
	HTML +=  ('volume=100');
	HTML +=  ('animationAtStart=0 ');
	HTML +=  ('width="100%" height="'+height+'"');	
	HTML +=  ('displaySize=0></embed> ');
	HTML +=  ('</OBJECT> ');
	}	
		
	return HTML;	
}

var adsl_no = 0;
function change_adsl()
{
	adsl_no++;
	if(adsl_no>2) adsl_no = 0;
	
	if(adsl_no == 0)
	{
		findObj('adsl').innerHTML = '<a href="/Music/top2005/" target="_blank"><img src="/Images/ads/top10_my_tam.gif" border="0"></a>';
		findObj('adsl0').innerHTML = '<a href="/Music/Album/2005/12/05F601A0/?playAlbum=1" target="_blank"><img src="/Music/Album/2005/12/05F601A0/MatNgoc1.jpg" border="0"><br>Mắt Ngọc - Unreleased</a>';
	}
	
	if(adsl_no == 1)
	{
		findObj('adsl').innerHTML = '<a href="/Music/top2005/" target="_blank"><img src="/Images/ads/top10_phuongthanh.gif" border="0"></a>';
		findObj('adsl0').innerHTML = '<a href="/Music/Album/2005/12/05F60150/?playAlbum=1" target="_blank"><img src="/Music/Album/2005/12/05F60150/LoiSamHoi1.jpg" border="0"><br>Duy Mạnh - Lời Sám Hối</a>';
	}
	
	if(adsl_no == 2)
	{
		findObj('adsl').innerHTML = '<a href="/Music/top2005/" target="_blank"><img src="/Images/ads/top10_hoquynhhuong.gif" border="0"></a>';
		findObj('adsl0').innerHTML = '<a href="/Music/xuan2006/" target="_blank"><img src="/Music/xuan2006/qc_xuan2006_green.gif" border="0"><br>Nhạc tuyển mừng Xuân 2006</a>';
	}
	setTimeout('change_adsl()', 3000);
}


var queryArray = new Array();
var queryCount = 0;
var queryRunning = 0;
var temp;
var queryRunningStatus;
function addQuery(q)
{
	queryCount += 1;
	queryArray[queryCount] = q;
}
function runQuery()
{
	if( queryCount > 0 && queryRunning==0 )
	{
		window.status = ' Process query #' + queryCount;
		queryRunning = 1;
		eval(queryArray[queryCount]);
	}
	if(queryCount == 0) 
	{
		window.status = 'Loading 100% complete.';
//		window.status = 'nhacSO hân hoan chúc mừng sinh nhật anh Phùng Tiến Công (2/11). Chúc anh vui vẻ, thành công và hạnh phúc...';
		
		//-- Fix div height
		//

		var leftHeight 		= document.getElementById('leftBox').clientHeight;
		var centerHeight 	= document.getElementById('centerBox').clientHeight;
		var rightHeight 	= document.getElementById('rightBox').clientHeight;

		var max = leftHeight;
		if( max < centerHeight ) max = centerHeight;
		if( max < rightHeight ) max = rightHeight;
				
		document.getElementById('leftBox').style.height = max + 'px';
		document.getElementById('centerBox').style.height = max + 'px';
		document.getElementById('rightBox').style.height = max + 'px';

		
		clearTimeout(queryRunningStatus);
	}
	else
		queryRunningStatus = setTimeout('runQuery()', 1000);
}
/**********************************************/

var dang_nghe_thu;
function nghe_thu(id)
{
	return false;
	if( dang_nghe_thu ) findObj(dang_nghe_thu).src = '/Images/listen.gif';
	findObj(id).src = '/Images/buffering.gif';

	dang_nghe_thu = id;	
	
	//-- Parse id to get from text to number
	//
	var s = id.split('_'); id = s[s.length-1];
	findObj('listenDiv').src = '';
	findObj('listenDiv').src = '/Music/nghe_thu.asp?id=' + id + "&imgId=" + dang_nghe_thu;
}
/**********************************************/
function truebody()
{
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}
//---------------------------------------------------------------------------------------------------------------
	var split_1	= '|'; //-- Ngăn cách giữa các cặp giá trị tạo nên một bài hát
	var split_2	= '~'; //-- Ngăn cách giữa tên bài hát và ID bài hát
	var playlistWindow = null;

	/*------------------------------------------------------\
	|	Add song to playlist								|
	|	Code by mrdotcom@gmail.com							|
	\------------------------------------------------------*/
	var playlistRowHeight = 20;
	function playlistAdd(song_id, song_name)
	{
		//-- Srote via cookie
		//
		c = __cookie.getSubValue(c_name);

		if(!c) c = "";
		else
		{
			//-- Kiem tra xem bai hat nay da co trong playlist chua
			//
			cc = c.split(split_1);

			for(i = 0; i < cc.length; i++)
			{
				if(cc[i])
				{
					s = cc[i].split(split_2);
					if( s[0] == song_id )
					{
						alert('Bài này đã có trong playlist rồi');
						return false;
					}
				}
			}
		}
		
		c = c + split_1 + song_id + split_2 + song_name;
		__cookie.setSubValue(c_name, c);
		var pl = findObj('playlist');
		
		alert('Bài hát '+song_name+' đã được thêm vào danh sách nhạc phẩm của bạn');
	}

	/*------------------------------------------------------\
	|	Hide playlist window								|
	|	Code by mrdotcom@gmail.com							|
	\------------------------------------------------------*/
	function playlistHide()
	{
		dd.elements.playlistTitle.hide(); 
		__cookie.setSubValue('__playlistOn', null);	
	}

	/*------------------------------------------------------\
	|	Show playlist window								|
	|	Code by mrdotcom@gmail.com							|
	\------------------------------------------------------*/
	
	var win=null;
	function NewWindow(mypage,myname,w,h,scroll,pos)
	{
		if(pos=="random"){LeftPosition=(screen.width)?Math.floor(Math.random()*(screen.width-w)):100;TopPosition=(screen.height)?Math.floor(Math.random()*((screen.height-h)-75)):100;}
		if(pos=="center"){LeftPosition=(screen.width)?(screen.width-w)/2:100;TopPosition=(screen.height)?(screen.height-h)/2:100;}
		else if((pos!="center" && pos!="random") || pos==null){LeftPosition=0;TopPosition=20}
		settings='width='+w+',height='+h+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no,resizable=no';
		
		return window.open(mypage,myname,settings);
	}
	
	function showPlaylist()
	{
		c = __cookie.getSubValue(c_name);
		if(c)
		{
			win = NewWindow('/Include/playlist.htm','mywin','238','400','yes','center');
			win.focus();
		}
		else
		{
			alert("Trong danh sách của bạn hiện chưa có nhạc phẩm nào cả.");
		}
	}
			
	/*------------------------------------------------------\
	|	Empty playlist										|
	|	Code by mrdotcom@gmail.com							|
	\------------------------------------------------------*/
	function emptyPlaylist()
	{
		if( confirm('Bạn có chắc chắn muốn xoá không?') )
		{
			__cookie.setSubValue(c_name, null);
			alert('Danh sách các bài hát trong playlist đã được xoá toàn bộ!');
		}
	}
	
	/*------------------------------------------------------\
	|														|
	\------------------------------------------------------*/
	var ok = 1; var dragTrue;
	function playlistDragMe(id)
	{
		var x1=dd.elements.playlist.x, y1=dd.elements.playlist.y, x2=x1+dd.elements.playlist.w, y2=y1+dd.elements.playlist.h;

		var x = event.clientX;
		var y = event.clientY;

		var item = document.getElementById(id);
		var dragBox = document.getElementById('dragBox');
		var playlist = document.getElementById('playlist');
				
		dragBox.innerHTML = item.innerHTML;
		
		dragBox.style.filter = "Alpha(opacity=90)";
		dragBox.style.top = y + 'px';
		dragBox.style.left = x + 'px';
		
		if( (x>=x1) && (x<=x2) && (y>=y1) && (y<=y2) )
		{
			dragTrue = 1;
			if(ok)
			{
				playlist.saveHTML = playlist.innerHTML;
				playlist.innerHTML = '<div style="background-color: yellow; font-weight: normal; font-size: 11px; padding: 2px">' + item.innerHTML + '</div>' + playlist.innerHTML;
				ok = 0;
			}
		}
		else
		{
			dragTrue = 0;
			if(!ok) playlist.innerHTML = playlist.saveHTML;
			ok = 1;
		}
		
		// window.status = "x="+x+"; y="+y+"; x1="+x1+"; y1 = "+y1+"; x2="+x2+"; y2="+y2;
	}
	
	function playlistDropMe(id, title)
	{
		var dragBox = document.getElementById('dragBox');
		var playlist = document.getElementById('playlist');
		
		if(playlist.saveHTML) playlist.innerHTML = playlist.saveHTML;
		dragBox.style.left = '-1000px';		
		if(dragTrue) playlistAdd(id, title);
	}
	
	
	
	var cur_star; 
	var max_star;
	var star_url = '/Images/star.gif';
	var star_o_url = '/Images/star_o.gif';
	function ratingShowResult(x, y)
	{
		if( x && y )
		{
			cur_star = x;
			max_star = y;
			var s = '';
			
			for(var i=1; i<=x; i++)
			{
				s += ('<img src="' + star_o_url + '" onMouseOver="ratingChoose(' + i + ')" onMouseOut="ratingShowResult()" id="star_' + i + '" onClick="ratingShowResult('+ i +', '+ y +')">');
			}
			for(var i=x+1; i<=y; i++)
			{
				s += ('<img src="' + star_url + '" onMouseOver="ratingChoose(' + i + ')" onMouseOut="ratingShowResult()" id="star_' + i + '" onClick="ratingShowResult('+ i +', '+ y +')">');
			}
			document.getElementById('songRating').innerHTML = s;
		}
		else
		{
			ratingShowResult(cur_star, max_star);
		}
	}
	function ratingChoose(number)
	{
		var o;
		for(var i=1; i<=max_star; i++)
		{
			o = document.getElementById('star_' + i);
			if(o.src != star_url) o.src = star_url;
		}		
		for(i=1; i<=number; i++)
		{
			o = document.getElementById('star_' + i);
			if(o.src != star_o_url) o.src = star_o_url;
		}		
	}
	
	
function addDivHeight(epsilon)
{
/*	findObj('leftBox').style.height 	= findObj('leftBox').clientHeight + epsilon + 'px';
	findObj('centerBox').style.height 	= findObj('centerBox').clientHeight + epsilon + 'px';
	findObj('rightBox').style.height 	= findObj('rightBox').clientHeight + epsilon + 'px';
*/
}

function musicListenInNewWindow(url)
{
	var win2 = NewWindow('/Include/listenInNewWindow.htm?' + url,'mywin2','300','100','yes','center');	
	win2.focus();
}

var listenAlbumWin;

function url_decode(s)
{
	s = s.split('%20');
	var ss = '';
	for(var i=0; i<s.length; i++) ss += (s[i] + ' ');
	return ss;
}
function playAlbum(id, title, image)
{
	listenAlbumWin = NewWindow('/Include/listenAlbum.htm?'+id+'|'+url_decode(title)+'|'+image,'listenAlbum','300','400','yes','center');
	listenAlbumWin.focus();
}
function ns_bookmarksite(title, url){
if (document.all)
window.external.AddFavorite(url, title);
else if (window.sidebar)
window.sidebar.addPanel(title, url, "")
}

function sendToFriend(title, namekey)
{
	sendToFriendWin = NewWindow('/Include/sendToFriend.htm?'+title+'|'+namekey,'sendToFriendWindow', '240','340','no','center');
	sendToFriendWin.focus();
}

function fixDivHeight2()
{
	
}


function showClock(id, key)
{
	findObj('nuoi_sao').innerHTML = '<img src="/Music/games/nuoi_sao/artist/'+id+'.gif"><li><a href="javascript:delClock('+id+', \''+key+'\')">Loại bỏ đồ vật này</a></li><li><a href="javascript:sendClock('+id+', \''+key+'\')">Tặng điểm cho "Sao"</a></li>';
	findObj('nuoi_sao').style.padding = '4px';
	findObj('nuoi_sao').style.backgroundColor = '#fff';
}
function delClock(id, key)
{
	if(confirm('Bạn có chắc chắn muốn loại bỏ đồ vật này khỏi cuộc chơi không???'))
	{
		self.location='?id='+id+'&key='+key+'&act=del';
	}
}
function sendClock(id, key)
{
	if(confirm('Bạn có muốn tặng đồ vật này cho "Sao" của bạn không? Nếu chấp thuận, số điểm của sao sẽ tăng lên 500 và đồ vật này sẽ bị loại khỏi cuộc chơi.'))
	{
		var e = prompt('Địa chỉ email của bạn là gì? ', '');
		var n = prompt('Bạn tên là gì? ', '');
		var f = prompt('Bạn là fans của ca sĩ nào? ', '');
		self.location='?id='+id+'&key='+key+'&act=send&info=' + e + '|' + n + '|' + f;
	}
}

function areYouLucky(s)
{
	var l = self.location + ''; l = l.split('?');
	if(l[1] != 'lucky') return false;

	var a = s;
	var k = 0;

	for(var i=0; i<a.length; i++)
	{
		k += a.charCodeAt(i);
	}


	do
	{
		a = k + ""; k = 0;
		for(var i=0; i<a.length; i++)
		{
			k += a.charCodeAt(i) - 48;
		}
	}
	while( k >= 10 );

	var m = new Array(10);
	m[0] = 'thích "đè đầu cưỡi cổ", có tính hay gây gổ nhưng... thành đạt';
	m[1] = 'biết giao tiếp, khéo léo, cởi mở, nhưng dễ bị phụ thuộc';
	m[2] = 'yêu đời, thích cảm giác mạnh và có tính độc lập';
	m[3] = 'tính tình cẩn thận, chắc chắn, hăng hái, có tính kỉ luật, thích ở nhà mà ko phiêu lưu';
	m[4] = 'thích tự do, thích tìm cảm giác mới, thích hưởng thụ';
	m[5] = 'rất có tinh thần trách nhiệm (wow, những vị cha mẹ gương mẫu đây!), rất thích quan tâm đến những người xung quanh';
	m[6] = 'là các nhà tư tưởng, hiểu biết, hóm hỉnh, thoải mái, biết lắng nghe và thích phân tích nhưng thường không thực tế';
	m[7] = 'tính cách mạnh mẽ, nhiệt tình, tháo vát';
	m[8] = 'là người tốt bụng, hào phóng và cao thượng'; 

	alert("Hình như có một người đang nhìn trộm bạn kìa!!!\nĐây là một bài hát mà bạn ngẫu nhiên nghe được, nó mang số "+k+"\n\n\nSố này tượng trưng cho một người " + m[k-1] + ". Có thể người đang nhìn trộm bạn thuộc tuýp người đó.");
}

/*=================IPTV====================*/
function CreateSlideAds(theObj, x, y)
{
	myBrowser = new xBrowser();
	slideAds = new xLayerFromObj(theObj);
	slideAds.baseX = x;
	slideAds.baseY = y;
	slideAds.x = x;
	slideAds.y = y;
	slideAds.moveTo(x,y);
	slideAds.show();
	setInterval('aniSlideAds()', 20);
	
}

function aniSlideAds()
{
	var b = slideAds;
	var targetX;
	var targetY;
	if(blAdsLeft) {
		targetX = 0;
	} else {
		targetX = document.body.clientWidth + document.body.scrollLeft - 118;
	}

	if(document.body.scrollTop - 4 < document.body.clientHeight + document.body.scrollTop - arr_AdHeight[0] - 50) {
		targetY = document.body.scrollTop - 4;
	} else {
		targetY = document.body.clientHeight + document.body.scrollTop - arr_AdHeight[0] - 50;
	}
	var dx = (targetX - b.x)/8;
	var dy = (targetY - b.y)/8;
	b.x += dx;
	b.y += dy;
	b.moveTo(b.x, b.y);
	DivSetVisible(b.x, b.y);
}
/*=================//IPTV====================*/

function onOffDiv(id)
{
	if(findObj(id).style.display!='none')
	{
		findObj(id).style.display='none';
	}
	else
		findObj(id).style.display='block';
}		
