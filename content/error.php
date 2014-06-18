<script>
function hide(obj) {

    var el = document.getElementById(obj);

        el.style.display = 'none';

}
</script>
<div class="row">
	<div id='hideme' class="col-lg-12" style="width:97.5%; margin-top:25px; margin-left:15px;">
		<div class="alert alert-dismissable alert-danger" style="text-align:center; text-transform:uppercase; font-weight:bold; background-color:#D5004E;">
			<button style="color:white" onClick="hide('hideme')" class="close" data-dismiss="alert" type="button">
				×
			</button>
			<span style="color:white">Une erreur est intervenue</span>
		</div>
	</div>
</div>