		<table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
        	<td width="60%">
            <div class="title">{title}</div>
            
            <!-- BEGIN address -->
            <p><b class="index">{address.company_name}</b>
            <br>{address.text_address}: {address.company_address}
            <br>{address.text_telephone}: {address.company_telephone} - {address.text_fax}: {address.company_fax}
            <br>{address.text_email}: <a href="mailto:{address.company_email}">{address.company_email}</a> - <a href="mailto:{address.company_officemail}">{address.company_officemail}</a>
            <br>{address.text_website}: <a href="http://{address.company_website}">{address.company_website}</a>
            <p><b>{address.text_factory}</b>
            <br>{address.text_address}: {address.company_factoryaddr}
            <br>{address.text_telephone}: {address.company_factorytel} - {address.text_fax}: {address.company_factoryfax}
            </p>
            <!-- END address -->

            <!-- BEGIN message -->
            <p align="jusitfy">{message.text}</p>
            <!-- END message -->

			<!-- BEGIN form -->
			<form name="frmContact" action="{form.action}" method="post" onSubmit="CheckContact(frmContact, '{form.text_save}'); return false">
			<input type="hidden" name="m" value="{form.module}">
			<input type="hidden" name="f" value="{form.file}">
			<input type="hidden" name="act" value="submit">
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr height="25">
				<td nowrap>{form.text_yourname} <span class="red">*</span></td>
				<td>:</td>
				<td align="right"><input class="textbox" type="text" name="yourname" value="{form.yourname}" style="width:230px" maxlength="128"></td>
			</tr>
			<tr height="25">
				<td nowrap>{form.text_company} <span class="red">*</span></td>
				<td>:</td>
				<td align="right"><input class="textbox" type="text" name="company" value="{form.company}" style="width:230px" maxlength="128"></td>
			</tr>
			<tr height="25">
				<td nowrap>{form.text_address} <span class="red">*</span></td>
				<td>:</td>
				<td align="right"><input class="textbox" type="text" name="address" value="{form.address}" style="width:230px" maxlength="128"></td>
			</tr>
			<tr height="25">
				<td nowrap>{form.text_email} <span class="red">*</span></td>
				<td>:</td>
				<td align="right"><input class="textbox" type="text" name="email" value="{form.email}" style="width:230px" maxlength="128"></td>
			</tr>
            <tr height="25">
            	<td nowrap>{form.text_content} <span class="red">*</span></td>
                <td>:</td>
   				<td align="right"><textarea class="textbox" name="content" style="width:230px; height:110px">{form.content}</textarea></td>
            </tr>
			<tr height="25">
				<td nowrap>{form.text_imagerandom} <span class="red">*</span></td>
				<td>:</td>
				<td nowrap align="right">
                	<table border="0" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td align="right"><img src="includes/imagerandom.php" border="0"></td>
                        <td width="5"></td>
                        <td><input class="textbox" type="text" name="numberrandom" value="" size="10" maxlength="6"></td>
                        <td width="5"></td>
						<td align="right"><input class="button" type="submit" value="{form.text_submit}"></td>
                    </tr>
                    </table>
                </td>
				<td></td>
            </tr>
			</table>
			</form>
			<!-- END form -->


            </td>
            <td><img src="images/spacer.gif" border="0" width="20" height="1" /></td>
            <td width="40%">
                <div id="divMap" style="width:330px; height:500px; border:1px #999999 solid"></div>
                <div id="divLatLng" style="height:20px"></div>
    
                <!-- BEGIN map -->
                <script type="text/javascript" src="http://maps.google.com/maps?file=api&amp;v=2&amp;key={map.key}"></script>
                <script type="text/javascript">
                //<![CDATA[
                function load() {
                    if (GBrowserIsCompatible()) {
                        var map = new GMap2(document.getElementById("divMap"), {size: new GSize(330,500)} );
                        map.setCenter(new GLatLng({map.lat},{map.long}), 16, G_NORMAL_MAP);
                        var mapControl = new GMapTypeControl();
                        map.addControl(mapControl);
                        map.addControl(new GLargeMapControl());
						<!-- BEGIN noedit -->
                        var marker = new GMarker(map.getCenter());
						<!-- END noedit -->
						<!-- BEGIN edit -->
    					var marker = new GMarker(map.getCenter(), {draggable: true});
    					GEvent.addListener(marker, "dragend", function() {
    						var center = marker.getLatLng();
    						var div = document.getElementById("divLatLng")
							div.innerHTML = center.lat() + ", " + center.lng();
    					});
						<!-- END edit -->
                        map.addOverlay(marker);
                    }
                }
                //]]>
                window.onload=load;
                </script>
                <!-- END map -->
			</td>
        </tr>
        </table>