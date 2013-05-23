<script
    type="text/javascript"
    src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=AIzaSyAhZzsbIXbUZd-qBypkpZdVTIiDnsYuhk4"
>
</script>

<script type="text/javascript">
    // START GOOGLE MAPS CODE
    function addEvent(o,t,fn){
        if(o.addEventListener){   // NS/MOZ DOMs evt
            o.addEventListener(t,fn, false);
            return true;
        }else if(o.attachEvent){  // IEs DOMs evt
            var _addEvnRt = o.attachEvent("on" + t, fn);
            return _addEvnRt;
        }else if(domapi.isIE5Mac){ // IEs/IE5/51+ MacOS
            o["on"+t] = fn;
        }else
            throw new Error("HANDLER_NO_ATTACH");
    };

    function loadMap(){
        var address = "4 Richmond Mews London W1D 3DH";
        var map = new GMap2(document.getElementById("mapCanvas"));
        var geocoder = new GClientGeocoder();
            geocoder.getLatLng(
            address,
            function(point) {
                if (!point) {
                    alert(address + " not found");
                } else {
                    map.setCenter(point, 13);
                    var marker = new GMarker(point);
                    map.addOverlay(marker);
                    marker.openInfoWindowHtml(address);
                }
            }
        );

        map.setUIToDefault();
    };

    addEvent( window, "load",   loadMap );
    addEvent( window, "unload", GUnload );

    // END GOOGLE MAPS CODE
</script>





<div id="bodyWrapper">

	<div id="leftCol"><img src="../styles/images/rsvp/london-logo.png" width="539" height="537"></div>
	
	<div id="rightCol">
	<div id="rightColInner">
	

<!-- <h2 class="ucase" style="font-size:22px;margin-top:0px">Venue</h2> -->

<div style="margin-top:0px">
    <img src="../styles/images/rsvp/venue.png"  border="0"/>
</div>

<div id="address">
    <strong>The Soho Hotel</strong><br />
    4 Richmond Mews London W1D 3DH<br />
    Main: +44 20 7559 3000
</div>

<div id="mapContainer">
    <div id="mapCanvas"/>
</div>



	</div>
	
</div>
</div>


















































