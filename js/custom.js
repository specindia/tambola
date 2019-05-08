$i=0;
$(".checkable_div").click(function(){
	$i++;
	$el=$(this).find("input");
	$el.prop("checked", !$el.prop("checked"));
	$(this).toggleClass("number_ticked");
	$claimButton=$(this).closest('form').find('.claim_prize');
	if($i>=1){
		$claimButton.remove();
	}
});

if($('#svgContainer').length){
	var svgContainer = document.getElementById("svgContainer");
	var animItem = bodymovin.loadAnimation({
		wrapper: svgContainer,
		animType: "svg",
		loop: true,
		path: "data.json"
	});
}