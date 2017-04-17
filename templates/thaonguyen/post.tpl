<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr valign="top">
    <td width="99%">
    <!-- BEGIN post -->
	<div class="divContent">
	<div class="title">{post.title}</div>
    <!-- BEGIN intro -->
	<p>{post.intro.intro}</p>
    <!-- END intro -->
    <!-- BEGIN content -->
	<p>{post.content.content}</p>
    <!-- END content -->
    </div>
    <!-- END post -->
    
    <!-- BEGIN photo -->
	<div id="divPhotoMore_{photo.idpost}">
    <table width="100%" bgcolor="#ececec" border="0" cellpadding="0" cellspacing="10">
    <!-- BEGIN row -->
    <tr valign="top">
        <!-- BEGIN col -->
        <!-- BEGIN space -->
        <td><img src="images/spacer.gif" border="0" width="10" height="1" /></td>
        <!-- END space -->
        <td width="{photo.row.col.cellwidth}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td><div class="imgBorder"><a href="{photo.row.col.image}" rel="lightbox" title="{photo.row.col.title_jv}"><img src="{photo.row.col.thumb}" rel="{photo.row.col.image}" border="0" width="{photo.row.col.width}" title="{photo.row.col.title_jv}" /></a></div></td>
            </tr>
            <tr>
                <td style="padding:5px 0px 10px 0px">
                <b>{photo.row.col.title}</b>
                <!-- BEGIN intro -->
                <p>{photo.row.col.intro.intro}
                <!-- END intro -->
                </td>
            </tr>
            </table>
        </td>
        <!-- END col -->
    </tr>
    <!-- END row -->
    </table>
    </div>
    <!-- BEGIN slide -->
    <script type="text/javascript">
        $(function() {
            $('#divPhotoMore_{photo.slide.idpost} a').lightBox();
        });
    </script>
    <!-- END slide -->
    <!-- END photo -->
    
    
    <!-- BEGIN postlist -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <!-- BEGIN row -->
    <tr valign="top">
        <!-- BEGIN col -->
        <!-- BEGIN space -->
        <td><img src="images/spacer.gif" border="0" width="18" height="1" /></td>
        <!-- END space -->
        <td width="{postlist.row.col.width}">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <!-- BEGIN imagetop -->
            <tr valign="top">
                <td style="padding-bottom:5px"><a href="{postlist.row.col.imagetop.link}" title="{postlist.row.col.imagetop.title_jv}"><img class="imgBorder" src="{postlist.row.col.imagetop.image}" border="0" width="{postlist.row.col.imagetop.width}" alt="{postlist.row.col.imagetop.title_jv}"/></a></td>
            </tr>
            <!-- END imagetop -->
            <tr valign="top">
                <td>
                    <p><a class="index" href="{postlist.row.col.link}"><b>{postlist.row.col.title}</b></a>
                    <!-- BEGIN intro -->
                    <br>{postlist.row.col.intro.intro}
                    <!-- END intro -->
                    <!-- BEGIN more -->
                    <p align="right" style="margin-top:0px"><a href="{postlist.row.col.more.link}">{postlist.row.col.more.text_more}</a></p>
                    <!-- END more -->
                </td>
            </tr>
            </table>
        </td>
        <!-- END col -->
    </tr>
    <tr><td height="10"></td></tr>
    <!-- END row -->
    </table>
    <!-- END postlist -->
    
    <!-- BEGIN pagenav -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td class="dotline" height="1"></td>
    </tr>
    <tr valign="bottom">
        <td class="page" nowrap align="right" style="padding:5px 0px">
            <!-- BEGIN page -->
            <!-- BEGIN line -->
            &nbsp; | &nbsp;
            <!-- END line -->
            <a class="page" href="{pagenav.page.link}">{pagenav.page.text}</a>
            <!-- END page -->
        </td>
    </tr>
    </table>
    <!-- END pagenav -->
    
    <!-- BEGIN otherpost -->
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top:20px">
    <tr>
        <td class="dotline" height="1"></td>
    </tr>
    <tr valign="bottom">
        <td style="padding:5px 0px">
            <p>{otherpost.text_other}</p>
            <!-- BEGIN row -->
            <div class="leftrow"><b>∙</b> <a class="leftlink" href="{otherpost.row.link}"><b>{otherpost.row.text}</b></a></div>
            <!-- END row -->
        </td>
    </tr>
    </table>
    <!-- END otherpost -->

    </td>
    <!-- BEGIN image -->
    <td><img src="images/spacer.gif" border="0" width="15" height="1" /></td>
    <td align="right"><img src="{image.image}" border="0" width="{image.width}"/></td>
    <!-- END image -->
</tr>
</table>