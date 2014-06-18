<script>
function hide(obj) {

    var el = document.getElementById(obj);

        el.style.display = 'none';

}
</script>
<div class="row">
	<div id='hideme' class="col-lg-12" style="width:97.5%; margin-top:25px; margin-left:15px;">
		<div class="alert alert-dismissable alert-danger" style="text-align:center; text-transform:uppercase; font-weight:bold; background-color:#53A053;">
			<button style="color:white" onClick="hide('hideme')" class="close" data-dismiss="alert" type="button">
				×
			</button>
			<span style="color:white">Bravo, action correctement accomplie !</span>
		</div>
	</div>
</div>